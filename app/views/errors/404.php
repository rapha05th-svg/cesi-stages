<!DOCTYPE html>
<html lang="fr" data-theme="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page introuvable · CESI Stages</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/base.css?v=1">
    <link rel="stylesheet" href="/css/layout.css?v=1">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .err-wrap {
            padding: 40px 24px;
            max-width: 520px;
        }
        .err-code {
            font-size: clamp(6rem, 20vw, 10rem);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.05em;
            background: linear-gradient(135deg, #d71920, #ff6b6b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0;
        }
        .err-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111827;
            margin: 12px 0 12px;
            letter-spacing: -0.02em;
        }
        .err-desc {
            color: #6b7280;
            font-size: 1rem;
            line-height: 1.65;
            margin-bottom: 32px;
        }
        .err-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .err-btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px;
            background: #d71920; color: #fff;
            border-radius: 12px; font-weight: 800; font-size: 0.95rem;
            text-decoration: none;
            box-shadow: 0 4px 18px rgba(215,25,32,0.35);
            transition: background 0.15s, transform 0.15s;
        }
        .err-btn-primary:hover { background: #b5141a; transform: translateY(-2px); text-decoration: none; color: #fff; }
        .err-btn-ghost {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 24px;
            background: #f3f4f6; color: #374151;
            border-radius: 12px; font-weight: 700; font-size: 0.92rem;
            text-decoration: none;
            transition: background 0.15s;
        }
        .err-btn-ghost:hover { background: #e5e7eb; text-decoration: none; color: #111827; }
        .err-visual {
            width: 120px; height: 120px;
            margin: 0 auto 24px;
            border-radius: 28px;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 20px 50px rgba(15,23,42,0.18);
        }
        [data-theme="dark"] .err-title { color: #f1f5f9; }
        [data-theme="dark"] .err-btn-ghost { background: #1e2433; color: #94a3b8; }
        [data-theme="dark"] .err-btn-ghost:hover { background: #2d3748; color: #f1f5f9; }
    </style>
</head>
<body>
<script>(function(){const t=localStorage.getItem('theme')||'';document.documentElement.setAttribute('data-theme',t);})();</script>
<div class="err-wrap">
    <div class="err-visual">
        <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            <line x1="11" y1="8" x2="11" y2="11"/><line x1="11" y1="14" x2="11.01" y2="14"/>
        </svg>
    </div>
    <p class="err-code">404</p>
    <h1 class="err-title">Page introuvable</h1>
    <p class="err-desc">La page que tu cherches n'existe pas ou a été déplacée.<br>Retourne à l'accueil pour continuer ta recherche de stage.</p>
    <div class="err-actions">
        <a href="/" class="err-btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            Retour à l'accueil
        </a>
        <a href="/offers" class="err-btn-ghost">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Voir les offres
        </a>
    </div>
</div>
</body>
</html>
