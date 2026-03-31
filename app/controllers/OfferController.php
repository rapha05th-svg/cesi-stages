<?php

class OfferController
{
    public function list(): void
    {
        $q         = trim($_GET['q'] ?? '');
        $companyId = (int)($_GET['company_id'] ?? 0);
        $sort      = in_array($_GET['sort'] ?? '', ['popular', 'oldest', 'newest']) ? $_GET['sort'] : 'newest';
        $page      = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage   = 7;
        $offset    = ($page - 1) * $perPage;

        $salaryMin  = (int)($_GET['salary_min'] ?? 0);
        $offers     = Offer::search($q, $companyId, $sort, $perPage, $offset, $salaryMin);
        $total      = Offer::countSearch($q, $companyId);
        $totalPages = (int) ceil($total / $perPage);

        $companies = DB::pdo()->query("SELECT id, name FROM companies ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

        View::render('offers/list', [
            'pageTitle'       => 'Offres de stage | CESI Stages',
            'pageDescription' => 'Parcourez toutes les offres de stage disponibles sur la plateforme CESI Stages. Filtrez par entreprise, mot-clé ou popularité.',
            'pageKeywords'    => 'offres de stage, stage, CESI, entreprises, candidature, emploi',
            'offers'      => $offers,
            'companies'   => $companies,
            'salaryMin'   => $salaryMin,
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'q'           => $q,
            'companyId'   => $companyId,
            'sort'        => $sort,
            'total'       => $total,
        ]);
    }

    public function show(): void
    {
        $id    = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $offer = Offer::find($id);

        if (!$offer) {
            http_response_code(404);
            echo 'Offre introuvable';
            return;
        }

        View::render('offers/show', [
            'pageTitle'       => ($offer['title'] ?? 'Offre') . ' | CESI Stages',
            'pageDescription' => 'Stage : ' . ($offer['title'] ?? '') . ' chez ' . ($offer['company_name'] ?? '') . '. Postulez directement sur CESI Stages.',
            'pageKeywords'    => 'stage, ' . ($offer['title'] ?? '') . ', ' . ($offer['company_name'] ?? '') . ', offre de stage, CESI',
            'offer'     => $offer,
        ]);
    }
}