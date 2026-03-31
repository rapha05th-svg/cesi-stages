<?php
$pageTitle = $pageTitle ?? 'Plateforme CESI Stages';
$pageDescription = $pageDescription ?? 'Plateforme de gestion des stages CESI';
$pageKeywords = $pageKeywords ?? 'stages, CESI, entreprises, offres';

$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$path = parse_url($requestUri, PHP_URL_PATH) ?: '';

function nav_active(string $path, string $target, bool $exact = false): string
{
    if ($exact) {
        return $path === $target ? 'active' : '';
    }

    return str_starts_with($path, $target) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($pageKeywords) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Web4All — CESI Stages">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:site_name" content="CESI Stages">
    <meta property="og:locale" content="fr_FR">

    <!-- Canonical -->
    <link rel="canonical" href="http://www.cesi-stages.local<?= htmlspecialchars(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/') ?>">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#d71920">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="CESI Stages">
    <link rel="apple-touch-icon" href="/images/icon-192.svg">

    <link rel="stylesheet" href="/css/base.css?v=1">
    <link rel="stylesheet" href="/css/layout.css?v=1">
    <link rel="stylesheet" href="/css/components.css?v=1">
    <link rel="stylesheet" href="/css/pages.css?v=1">
    <link rel="stylesheet" href="/css/responsive.css?v=1">
    <link rel="stylesheet" href="/css/admin.css?v=1">
    <style>
        .input-error { border-color: #d71920 !important; background: #fff5f5 !important; }
        .validation-error { display: block; color: #d71920; font-size: 0.82rem; margin-top: 4px; font-weight: 500; }
    </style>
</head>
<body>

<header class="site-header">
    <div class="container header-top">
        <a href="/" class="brand">
            <div class="brand-logo" aria-hidden="true">
                <div class="logo-futur">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div class="brand-text">
                <span class="brand-title">CESI Stages</span>
                <span class="brand-subtitle">Plateforme de gestion des stages</span>
            </div>
        </a>

        <div class="header-logo-center">
            <a href="/">
                <img src="/images/logo-cesi-stages.svg"
                     alt="CESI Stages">
            </a>
        </div>

        <div class="header-right">
            <?php if (class_exists('Auth') && Auth::check()): ?>
                <?php $user = $_SESSION['user'] ?? null; ?>
                <div class="header-user">
                    <span class="user-badge">
                        <?= htmlspecialchars($user['email'] ?? '') ?>
                        <small><?= htmlspecialchars($user['role'] ?? '') ?></small>
                    </span>
                </div>
            <?php endif; ?>

            <button
                type="button"
                class="burger-btn"
                id="burgerBtn"
                aria-label="Ouvrir le menu"
                aria-expanded="false"
                aria-controls="mainNav"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <div class="header-nav-wrap">
        <div class="container">
            <nav class="main-nav" id="mainNav">
                <a href="/" class="<?= nav_active($path, '/', true) ?>">Accueil</a>
                <a href="/offers" class="<?= nav_active($path, '/offers') ?>">Offres</a>
                <a href="/companies" class="<?= nav_active($path, '/companies') ?>">Entreprises</a>
                <a href="/stats" class="<?= nav_active($path, '/stats') ?>">Statistiques</a>

                <?php if (class_exists('Auth') && Auth::check()): ?>
                    <?php $user = $_SESSION['user'] ?? null; ?>

                    <?php if (($user['role'] ?? '') === 'ADMIN'): ?>
                        <a href="/admin" class="<?= nav_active($path, '/admin') ?>">Administration</a>
                    <?php endif; ?>

                    <?php if (($user['role'] ?? '') === 'PILOT'): ?>
                        <a href="/pilot/applications" class="<?= nav_active($path, '/pilot') ?>">Candidatures élèves</a>
                    <?php endif; ?>

                    <?php if (($user['role'] ?? '') === 'STUDENT'): ?>
                    <a href="/my-applications" class="<?= nav_active($path, '/my-applications') ?>">Mes candidatures</a>
                        <a href="/wishlist" class="<?= nav_active($path, '/wishlist') ?>">Wishlist</a>
                        <a href="/favorite-companies" class="<?= nav_active($path, '/favorite-companies') ?>">Entreprises favorites</a>
                    <?php endif; ?>

                    <a href="/change-password" class="<?= nav_active($path, '/change-password') ?>">Mot de passe</a>

                    <form method="post" action="/logout" class="logout-form">
                        <?php if (class_exists('Csrf')): ?>
                            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                        <?php endif; ?>
                        <button type="submit" class="btn btn-light">Déconnexion</button>
                    </form>
                <?php else: ?>
                    <a href="/login" class="<?= nav_active($path, '/login') ?>">Connexion</a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>

<main class="page-main">
    <div class="container">
        <?php require __DIR__ . '/partials/flash.php'; ?>

        <div class="content-card">
            <?php require $GLOBALS['templateFile']; ?>
        </div>
    </div>
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <p>© <?= date('Y') ?> CESI Stages — Plateforme de gestion des stages</p>
        <a href="/mentions-legales">Mentions légales</a>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const burgerBtn = document.getElementById('burgerBtn');
    const mainNav = document.getElementById('mainNav');

    if (!burgerBtn || !mainNav) return;

    burgerBtn.addEventListener('click', function () {
        const isOpen = mainNav.classList.toggle('is-open');
        burgerBtn.classList.toggle('is-active', isOpen);
        burgerBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
});
</script>

    <script src="/js/validation.js"></script>
</body>
</html>