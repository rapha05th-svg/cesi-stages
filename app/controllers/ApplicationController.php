<?php

final class ApplicationController extends Controller
{
    public function apply(): void
    {
        Csrf::check();
        $this->requireRole(['ETUDIANT', 'STUDENT']);

        $offerId = (int) ($_POST['offer_id'] ?? 0);
        $letter = trim($_POST['lm_text'] ?? '');

        if ($offerId <= 0 || $letter === '') {
            $this->flash('error', 'Formulaire incomplet.');
            $this->redirect('/offers');
            return;
        }

        $studentId = Student::idByUserId((int) Auth::id());

        if (!$studentId) {
            http_response_code(403);
            echo 'Aucun étudiant lié à cet utilisateur.';
            return;
        }

        if (Application::alreadyApplied($studentId, $offerId)) {
            $this->flash('error', 'Vous avez déjà postulé à cette offre.');
            $this->redirect('/offers/show?id=' . $offerId);
            return;
        }

        $cvPath = null;
        if (!empty($_FILES['cv']['tmp_name'])) {
            $cvPath = $this->storePdf($_FILES['cv'], 'cv');
            if ($cvPath === null) {
                $this->flash('error', 'Le CV doit être un fichier PDF valide.');
                $this->redirect('/offers/show?id=' . $offerId);
                return;
            }
        }

        Application::create($studentId, $offerId, $cvPath, $letter);
        $this->flash('success', 'Candidature envoyée avec succès.');
        $this->redirect('/my-applications');
    }

    public function mine(): void
    {
        $this->requireRole(['ETUDIANT', 'STUDENT']);

        $studentId = Student::idByUserId((int) Auth::id());
        if (!$studentId) {
            http_response_code(403);
            echo 'Aucun étudiant lié à cet utilisateur.';
            return;
        }

        $apps = Application::forStudent($studentId);
        $this->view('student/applications', [
            'pageTitle'       => 'Mes candidatures | CESI Stages',
            'pageDescription' => 'Retrouvez toutes vos candidatures envoyées sur CESI Stages avec vos lettres de motivation et CV.',
            'pageKeywords'    => 'candidatures, stage, CESI Stages, lettre de motivation, CV',
            'apps' => $apps,
        ]);
    }

    private function storePdf(array $file, string $folder): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $mime = mime_content_type($file['tmp_name']) ?: '';
        if ($mime !== 'application/pdf') {
            return null;
        }

        $targetDir = dirname(__DIR__, 2) . '/public/uploads/' . $folder;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $filename = bin2hex(random_bytes(16)) . '.pdf';
        $targetPath = $targetDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return null;
        }

        return '/uploads/' . $folder . '/' . $filename;
    }

    public function serveCv(): void
    {
        $this->requireLogin();

        $file = basename($_GET['file'] ?? '');
        if ($file === '') {
            http_response_code(400);
            echo 'Fichier non spécifié.';
            return;
        }

        $path = dirname(__DIR__, 2) . '/public/uploads/cv/' . $file;

        if (!file_exists($path)) {
            http_response_code(404);
            echo 'Fichier introuvable.';
            return;
        }

        // Vérifier que l'étudiant accède uniquement à son propre CV
        $user = $_SESSION['user'] ?? null;
        $role = $user['role'] ?? '';

        if ($role === 'STUDENT') {
            $studentId = Student::idByUserId((int)($user['id'] ?? 0));
            $apps = $studentId ? Application::forStudent($studentId) : [];
            $allowed = false;
            foreach ($apps as $app) {
                if (!empty($app['cv_path']) && basename($app['cv_path']) === $file) {
                    $allowed = true;
                    break;
                }
            }
            if (!$allowed) {
                http_response_code(403);
                echo 'Accès refusé.';
                return;
            }
        }
        // PILOT et ADMIN peuvent voir tous les CVs

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $file . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

}