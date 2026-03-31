<?php

final class CompanyController extends Controller
{
    public function list(): void
    {
        $q = trim($_GET['q'] ?? '');
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $per = 8;
        $total = Company::count($q);
        $p = new Paginator($page, $per, $total);

        $companies = Company::search($q, $p->perPage, $p->offset());

        $this->view('companies/list', [
            'pageTitle'       => 'Entreprises partenaires | CESI Stages',
            'pageDescription' => 'Découvrez toutes les entreprises partenaires de la plateforme CESI Stages, consultez leurs offres de stage et leurs évaluations.',
            'pageKeywords'    => 'entreprises, stages, partenaires, CESI, offres, évaluations',
            'companies' => $companies,
            'q' => $q,
            'p' => $p,
        ]);
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $company = Company::find($id);

        if (!$company) {
            http_response_code(404);
            echo 'Not found';
            return;
        }

        $isFavorite = false;
        $myRating = null;

        if (Auth::check() && in_array(Auth::role(), ['ETUDIANT', 'STUDENT'], true)) {
            $student = Student::findByUserId((int) Auth::id());
            $studentId = $student['id'] ?? 0;

            if ($studentId > 0) {
                $isFavorite = CompanyFavorite::has($studentId, $id);
                $myRating = CompanyRating::getByAuthorAndCompany($studentId, $id);
            }
        }

        $this->view('companies/show', [
            'pageTitle'       => ($company['name'] ?? 'Entreprise') . ' | CESI Stages',
            'pageDescription' => 'Découvrez l\'entreprise ' . ($company['name'] ?? '') . ' sur CESI Stages : offres de stage, évaluations et informations de contact.',
            'pageKeywords'    => 'stage, ' . ($company['name'] ?? '') . ', entreprise, offre, CESI, candidature',
            'company' => $company,
            'isFavorite' => $isFavorite,
            'myRating' => $myRating,
        ]);
    }

    public function rate(): void
    {
        Csrf::check();
        $this->requireRole(['ETUDIANT', 'STUDENT']);

        $companyId = (int) ($_POST['company_id'] ?? 0);
        $rating = (int) ($_POST['rating'] ?? 0);

        $student = Student::findByUserId((int) Auth::id());
        $studentId = $student['id'] ?? 0;

        if ($companyId <= 0 || $studentId <= 0 || $rating < 1 || $rating > 5) {
            $this->flash('error', 'Note invalide.');
            $this->redirect('/companies');
            return;
        }

        $company = Company::find($companyId);
        if (!$company) {
            http_response_code(404);
            echo 'Entreprise introuvable.';
            return;
        }

        CompanyRating::upsert($studentId, $companyId, $rating);

        $this->flash('success', 'Votre note a bien été enregistrée.');
        $this->redirect('/companies/show?id=' . $companyId);
    }
}