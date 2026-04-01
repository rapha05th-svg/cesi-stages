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
<html lang="fr" data-theme=""><?php /* theme set by JS */ ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($pageKeywords) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Web4All — CESI Stages">

    <!-- Typographie Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

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

    <link rel="stylesheet" href="/css/base.css?v=8">
    <link rel="stylesheet" href="/css/layout.css?v=5">
    <link rel="stylesheet" href="/css/components.css?v=2">
    <link rel="stylesheet" href="/css/pages.css?v=2">
    <link rel="stylesheet" href="/css/responsive.css?v=2">
    <link rel="stylesheet" href="/css/admin.css?v=2">
    <style>
        .input-error { border-color: #d71920 !important; background: #fff5f5 !important; }
        .validation-error { display: block; color: #d71920; font-size: 0.82rem; margin-top: 4px; font-weight: 500; }

        /* Scrollbar discrète */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

        /* Transitions de page */
        .content-card { animation: fadeInUp 0.3s ease both; }

        /* ── Dark mode toggle ── */
        .dark-toggle {
            width: 40px; height: 40px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: #374151;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
            flex-shrink: 0;
            box-shadow: none;
            padding: 0;
        }
        .dark-toggle:hover { background: #f3f4f6; border-color: #d71920; color: #d71920; transform: none; box-shadow: none; }
        .dark-icon-sun { display: none; }
        [data-theme="dark"] .dark-icon-moon { display: none; }
        [data-theme="dark"] .dark-icon-sun { display: block; }
        [data-theme="dark"] .dark-toggle { background: #1e2433; border-color: #2d3748; color: #f1f5f9; }
        [data-theme="dark"] .dark-toggle:hover { border-color: #d71920; color: #d71920; }

        /* ── Toasts ── */
        #toast-container {
            position: fixed; bottom: 24px; right: 24px;
            display: flex; flex-direction: column; gap: 10px;
            z-index: 9999; pointer-events: none;
        }
        .toast {
            display: flex; align-items: center; gap: 12px;
            min-width: 280px; max-width: 380px;
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 0.88rem; font-weight: 600;
            border: 1px solid transparent;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            pointer-events: all;
            transform: translateX(120%);
            opacity: 0;
            transition: transform 0.35s cubic-bezier(.22,1,.36,1), opacity 0.35s ease;
        }
        .toast.toast-show { transform: translateX(0); opacity: 1; }
        .toast.toast-hide { transform: translateX(120%); opacity: 0; }
        .toast-success { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .toast-error   { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
        .toast-info    { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
        .toast-dev     { background: #fffbeb; color: #92400e; border-color: #fcd34d; font-size: 0.78rem; }
        .toast-icon    { flex-shrink: 0; }
        .toast-msg     { flex: 1; line-height: 1.4; }
        .toast-close   { flex-shrink: 0; background: none; border: none; cursor: pointer; font-size: 1.1rem; color: inherit; opacity: 0.5; padding: 0; line-height: 1; box-shadow: none; transform: none; }
        .toast-close:hover { opacity: 1; transform: none; box-shadow: none; }
        [data-theme="dark"] .toast-success { background: #064e3b; color: #6ee7b7; border-color: #065f46; }
        [data-theme="dark"] .toast-error   { background: #450a0a; color: #fca5a5; border-color: #7f1d1d; }
        [data-theme="dark"] .toast-info    { background: #1e3a5f; color: #93c5fd; border-color: #1e40af; }

        /* ── Scroll to top ── */
        #scrollTop {
            position: fixed; bottom: 24px; left: 24px;
            width: 42px; height: 42px;
            border-radius: 12px;
            background: #d71920; color: #fff;
            border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 16px rgba(215,25,32,0.35);
            opacity: 0; transform: translateY(12px);
            transition: opacity 0.25s, transform 0.25s;
            pointer-events: none;
            z-index: 9998;
            padding: 0;
        }
        #scrollTop.visible { opacity: 1; transform: translateY(0); pointer-events: all; }
        #scrollTop:hover { background: #b5141a; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(215,25,32,0.4); }
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
            <button class="dark-toggle" id="darkToggle" aria-label="Basculer le thème" title="Mode sombre">
                <svg class="dark-icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                <svg class="dark-icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
            </button>
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
                        <a href="/pilot/applications" class="<?= nav_active($path, '/pilot/applications') ?>">Candidatures élèves</a>
                        <a href="/pilot/requests" class="<?= nav_active($path, '/pilot/requests') ?>">Mes demandes</a>
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

<!-- Scroll to top -->
<button id="scrollTop" aria-label="Retour en haut" title="Retour en haut">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<footer class="site-footer">
    <div class="container footer-inner">
        <p>© <?= date('Y') ?> CESI Stages — Plateforme de gestion des stages</p>
        <a href="/mentions-legales">Mentions légales</a>
    </div>
</footer>

<script>
/* ── Dark mode ── */
(function () {
    const saved = localStorage.getItem('theme') || '';
    document.documentElement.setAttribute('data-theme', saved);
})();

document.addEventListener('DOMContentLoaded', function () {
    /* Burger */
    const burgerBtn = document.getElementById('burgerBtn');
    const mainNav   = document.getElementById('mainNav');
    if (burgerBtn && mainNav) {
        burgerBtn.addEventListener('click', function () {
            const isOpen = mainNav.classList.toggle('is-open');
            burgerBtn.classList.toggle('is-active', isOpen);
            burgerBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    /* Dark toggle */
    const darkBtn = document.getElementById('darkToggle');
    if (darkBtn) {
        darkBtn.addEventListener('click', function () {
            const current = document.documentElement.getAttribute('data-theme');
            const next    = current === 'dark' ? '' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });
    }

    /* Scroll to top */
    const scrollBtn = document.getElementById('scrollTop');
    if (scrollBtn) {
        window.addEventListener('scroll', function () {
            scrollBtn.classList.toggle('visible', window.scrollY > 320);
        }, { passive: true });
        scrollBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});
</script>

    <script src="/js/validation.js"></script>

<script>
/* ── Barre de progression ── */
(function () {
    const bar = document.createElement('div');
    bar.id = 'nprogress';
    bar.style.cssText = 'position:fixed;top:0;left:0;height:3px;width:0%;background:linear-gradient(90deg,#d71920,#ff6b6b);z-index:99999;transition:width 0.25s ease;border-radius:0 2px 2px 0;box-shadow:0 0 8px rgba(215,25,32,0.5)';
    document.body.appendChild(bar);

    let timer;
    function start() {
        clearTimeout(timer);
        let w = 0;
        bar.style.width = '0%';
        bar.style.opacity = '1';
        const grow = () => {
            w = w < 80 ? w + Math.random() * 8 : w + 0.5;
            if (w > 95) w = 95;
            bar.style.width = w + '%';
            timer = setTimeout(grow, 200);
        };
        grow();
    }
    function done() {
        clearTimeout(timer);
        bar.style.width = '100%';
        setTimeout(() => { bar.style.opacity = '0'; bar.style.width = '0%'; }, 350);
    }

    document.querySelectorAll('a[href]').forEach(function (a) {
        const href = a.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('mailto') || href.startsWith('javascript') || a.target === '_blank') return;
        a.addEventListener('click', function (e) {
            if (e.ctrlKey || e.metaKey || e.shiftKey) return;
            start();
        });
    });

    document.querySelectorAll('form').forEach(function (f) {
        f.addEventListener('submit', start);
    });

    window.addEventListener('pageshow', done);
    done();
})();

/* ── Raccourci / pour focus recherche ── */
document.addEventListener('keydown', function (e) {
    if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
        e.preventDefault();
        const search = document.querySelector('.filter-input, .search-input, input[type="search"], input[type="text"]');
        if (search) { search.focus(); search.select(); }
    }
    if (e.key === 'Escape') {
        const focused = document.activeElement;
        if (focused && (focused.tagName === 'INPUT' || focused.tagName === 'TEXTAREA')) focused.blur();
    }
});

/* ── Transitions de page ── */
document.addEventListener('DOMContentLoaded', function () {
    document.body.style.opacity = '1';
});
document.querySelectorAll('a[href]').forEach(function (a) {
    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('mailto') || a.target === '_blank') return;
    a.addEventListener('click', function (e) {
        if (e.ctrlKey || e.metaKey || e.shiftKey) return;
    });
});
</script>

<style>
body { transition: opacity 0.18s ease; }
</style>

</body>
</html>