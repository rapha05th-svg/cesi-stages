<?php

final class WishlistController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();

        $user = $_SESSION['user'] ?? null;
        $userId = (int)($user['id'] ?? 0);

        $offers = Wishlist::getOffersByUser($userId);

        $this->view('wishlist/index', [
            'offers' => $offers,
        ]);
    }

    public function add(): void
    {
        $this->requireLogin();

        if (class_exists('Csrf')) {
            Csrf::check();
        }

        $user = $_SESSION['user'] ?? null;
        $userId = (int)($user['id'] ?? 0);
        $offerId = (int)($_POST['offer_id'] ?? 0);

        if ($userId <= 0 || $offerId <= 0) {
            $this->flash('error', 'Ajout aux favoris impossible.');
            $this->redirect('/offers');
            return;
        }

        Wishlist::addOffer($userId, $offerId);

        $this->flash('success', 'Offre ajoutée aux favoris.');
        $this->redirect('/wishlist');
    }

    public function toggle(): void
    {
        $this->requireLogin();

        if (class_exists('Csrf')) {
            Csrf::check();
        }

        $user = $_SESSION['user'] ?? null;
        $userId = (int)($user['id'] ?? 0);
        $offerId = (int)($_POST['offer_id'] ?? 0);

        if ($userId <= 0 || $offerId <= 0) {
            $this->flash('error', 'Action impossible.');
            $this->redirect('/offers');
            return;
        }

        Wishlist::toggleOffer($userId, $offerId);

        $this->redirect('/wishlist');
    }
}