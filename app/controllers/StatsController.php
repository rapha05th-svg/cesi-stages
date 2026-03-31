<?php
final class StatsController extends Controller {
  public function index(): void {
    $totalOffers = (int)DB::pdo()->query("SELECT COUNT(*) FROM offers WHERE is_active=1")->fetchColumn();

    $avgApps = (float)DB::pdo()->query("
      SELECT IFNULL(AVG(cnt),0) FROM (
        SELECT o.id, COUNT(a.id) cnt
        FROM offers o
        LEFT JOIN applications a ON a.offer_id=o.id
        WHERE o.is_active=1
        GROUP BY o.id
      ) t
    ")->fetchColumn();

    $top = DB::pdo()->query("
      SELECT o.id, o.title, c.name company_name, COUNT(w.offer_id) wish_count
      FROM wishlists w
      JOIN offers o ON o.id=w.offer_id
      JOIN companies c ON c.id=o.company_id
      GROUP BY o.id
      ORDER BY wish_count DESC
      LIMIT 5
    ")->fetchAll();

    $dist = DB::pdo()->query("
      SELECT
        DATE_FORMAT(created_at, '%m/%Y') as bucket,
        COUNT(*) as n
      FROM offers
      WHERE is_active=1
      GROUP BY bucket
      ORDER BY MIN(created_at) DESC
      LIMIT 6
    ")->fetchAll();

    $this->view('stats/stats', [
      'pageTitle'       => 'Statistiques des offres | CESI Stages',
      'pageDescription' => 'Consultez les statistiques de la plateforme CESI Stages : nombre d\'offres, candidatures, top wishlist et répartition par durée.',
      'pageKeywords'    => 'statistiques, offres de stage, CESI, candidatures, wishlist, indicateurs',
      'totalOffers' => $totalOffers,
      'avgApps'     => $avgApps,
      'top'         => $top,
      'dist'        => $dist,
    ]);
  }
}