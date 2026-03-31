<?php

final class HomeController extends Controller
{
    public function index(): void
    {
        $totalOffers    = (int) DB::pdo()->query("SELECT COUNT(*) FROM offers WHERE is_active=1")->fetchColumn();
        $totalCompanies = (int) DB::pdo()->query("SELECT COUNT(*) FROM companies WHERE is_active=1")->fetchColumn();
        $avgSalary      = (float) DB::pdo()->query("SELECT COALESCE(AVG(salary), 0) FROM offers WHERE salary IS NOT NULL AND is_active=1")->fetchColumn();
        $totalWishlists = (int) DB::pdo()->query("SELECT COUNT(*) FROM wishlists")->fetchColumn();

        $latestOffers = DB::pdo()->query("
            SELECT o.id, o.title, o.salary, o.start_date, c.name AS company_name
            FROM offers o
            LEFT JOIN companies c ON c.id = o.company_id
            WHERE o.is_active = 1
            ORDER BY o.id DESC
            LIMIT 3
        ")->fetchAll();

        $this->view('home/index', [
            'pageTitle'      => 'CESI Stages — Trouvez votre stage',
            'totalOffers'    => $totalOffers,
            'totalCompanies' => $totalCompanies,
            'avgSalary'      => $avgSalary,
            'totalWishlists' => $totalWishlists,
            'latestOffers'   => $latestOffers,
        ]);
    }

    public function legalNotice(): void
    {
        $this->view('home/mentions-legales', [
            'pageTitle' => 'Mentions légales',
        ]);
    }
}