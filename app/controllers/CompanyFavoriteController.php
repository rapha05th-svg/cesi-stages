<?php

final class CompanyFavoriteController extends Controller
{
    public function index(): void
    {
        $this->requireRole(['ETUDIANT', 'STUDENT']);

        $studentUserId = Student::idByUserId((int) Auth::id());
        if (!$studentUserId) {
            http_response_code(403);
            echo 'Aucun étudiant lié à cet utilisateur.';
            return;
        }

        $companies = CompanyFavorite::forStudent($studentUserId);

        $this->view('student/company_favorites', [
            'companies' => $companies,
        ]);
    }

    public function toggle(): void
    {
        Csrf::check();
        $this->requireRole(['ETUDIANT', 'STUDENT']);

        $companyId = (int) ($_POST['company_id'] ?? 0);
        if ($companyId <= 0) {
            $this->redirect('/companies');
            return;
        }

        $studentUserId = Student::idByUserId((int) Auth::id());
        if (!$studentUserId) {
            http_response_code(403);
            echo 'Aucun étudiant lié à cet utilisateur.';
            return;
        }

        CompanyFavorite::toggle($studentUserId, $companyId);
        $this->redirect('/favorite-companies');
    }
}