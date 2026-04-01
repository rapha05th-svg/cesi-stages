<?php $base = ''; ?>

<!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
<section class="hp-hero">
    <div class="hp-hero-bg">
        <canvas id="hp-particles"></canvas>
        <div class="hp-hero-blob hp-blob-1"></div>
        <div class="hp-hero-blob hp-blob-2"></div>
        <div class="hp-hero-blob hp-blob-3"></div>
        <div class="hp-hero-grid"></div>
    </div>
    <div class="hp-hero-inner">
        <div class="hp-hero-left">
            <span class="hp-badge">✦ Plateforme officielle CESI</span>
            <h1 class="hp-hero-title">
                Trouve ton stage<br>
                <span class="hp-title-accent" id="hp-typewriter"></span><span class="hp-cursor">|</span>
            </h1>
            <p class="hp-hero-desc">
                Explore les offres de stage, découvre les entreprises partenaires, gère tes candidatures et construis ta shortlist — tout en un seul endroit.
            </p>
            <div class="hp-hero-actions">
                <a href="/offers" class="hp-btn-primary">
                    <span>Explorer les offres</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="/companies" class="hp-btn-ghost">Voir les entreprises</a>
            </div>
            <div class="hp-hero-trust">
                <div class="hp-trust-avatars">
                    <div class="hp-avatar" style="background:#d71920">É</div>
                    <div class="hp-avatar" style="background:#374151">P</div>
                    <div class="hp-avatar" style="background:#1d4ed8">A</div>
                </div>
                <span>Étudiants, pilotes et admins réunis sur la même plateforme</span>
            </div>
        </div>
        <div class="hp-hero-right">
            <div class="hp-mockup">
                <div class="hp-mockup-bar">
                    <span></span><span></span><span></span>
                    <div class="hp-mockup-title">CESI Stages — Offres</div>
                </div>
                <div class="hp-mockup-body">
                    <div class="hp-mockup-row hp-mockup-row--active">
                        <div class="hp-mockup-dot" style="background:#d71920"></div>
                        <div class="hp-mockup-info">
                            <div class="hp-mockup-name">Développeur Full-Stack</div>
                            <div class="hp-mockup-sub">Thales · Paris</div>
                        </div>
                        <div class="hp-mockup-badge">1 200 €</div>
                    </div>
                    <div class="hp-mockup-row">
                        <div class="hp-mockup-dot" style="background:#3b82f6"></div>
                        <div class="hp-mockup-info">
                            <div class="hp-mockup-name">Data Analyst</div>
                            <div class="hp-mockup-sub">Airbus · Toulouse</div>
                        </div>
                        <div class="hp-mockup-badge">900 €</div>
                    </div>
                    <div class="hp-mockup-row">
                        <div class="hp-mockup-dot" style="background:#10b981"></div>
                        <div class="hp-mockup-info">
                            <div class="hp-mockup-name">Chef de projet IT</div>
                            <div class="hp-mockup-sub">SNCF · Lyon</div>
                        </div>
                        <div class="hp-mockup-badge">1 000 €</div>
                    </div>
                    <div class="hp-mockup-row">
                        <div class="hp-mockup-dot" style="background:#f59e0b"></div>
                        <div class="hp-mockup-info">
                            <div class="hp-mockup-name">UX Designer</div>
                            <div class="hp-mockup-sub">Capgemini · Remote</div>
                        </div>
                        <div class="hp-mockup-badge">850 €</div>
                    </div>
                    <div class="hp-mockup-footer">
                        <span>4 offres sur 38 affichées</span>
                        <div class="hp-mockup-dots">
                            <span class="on"></span><span></span><span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════
     STATS
══════════════════════════════════════════ -->
<section class="hp-stats" data-reveal>
    <div class="hp-stats-grid">
        <div class="hp-stat-item">
            <strong class="hp-stat-num" data-target="<?= (int)($totalOffers ?? 0) ?>"><?= (int)($totalOffers ?? 0) ?></strong>
            <span class="hp-stat-plus">+</span>
            <p>Offres de stage actives</p>
        </div>
        <div class="hp-stat-divider"></div>
        <div class="hp-stat-item">
            <strong class="hp-stat-num" data-target="<?= (int)($totalCompanies ?? 0) ?>"><?= (int)($totalCompanies ?? 0) ?></strong>
            <span class="hp-stat-plus">+</span>
            <p>Entreprises partenaires</p>
        </div>
        <div class="hp-stat-divider"></div>
        <div class="hp-stat-item">
            <strong class="hp-stat-num"><?= isset($avgSalary) && $avgSalary > 0 ? number_format($avgSalary, 0, ',', ' ') : '—' ?></strong>
            <?php if (isset($avgSalary) && $avgSalary > 0): ?><span class="hp-stat-unit">€/mois</span><?php endif; ?>
            <p>Rémunération moyenne</p>
        </div>
        <div class="hp-stat-divider"></div>
        <div class="hp-stat-item">
            <strong class="hp-stat-num" data-target="<?= (int)($totalWishlists ?? 0) ?>"><?= (int)($totalWishlists ?? 0) ?></strong>
            <span class="hp-stat-plus">+</span>
            <p>Offres en wishlist</p>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════
     COMMENT ÇA MARCHE
══════════════════════════════════════════ -->
<section class="hp-section hp-how" data-reveal>
    <div class="hp-section-head">
        <span class="hp-kicker">Simple &amp; rapide</span>
        <h2>Comment ça marche ?</h2>
        <p>Trois étapes suffisent pour trouver et postuler à ton stage idéal.</p>
    </div>
    <div class="hp-how-grid">
        <div class="hp-how-step">
            <div class="hp-how-num">01</div>
            <div class="hp-how-icon">🔍</div>
            <h3>Explore les offres</h3>
            <p>Parcours les offres de stage publiées par les entreprises partenaires CESI.</p>
        </div>
        <div class="hp-how-arrow">→</div>
        <div class="hp-how-step">
            <div class="hp-how-num">02</div>
            <div class="hp-how-icon">⭐</div>
            <h3>Sauvegarde tes favoris</h3>
            <p>Ajoute les offres et entreprises qui t'intéressent à ta wishlist personnelle.</p>
        </div>
        <div class="hp-how-arrow">→</div>
        <div class="hp-how-step">
            <div class="hp-how-num">03</div>
            <div class="hp-how-icon">🚀</div>
            <h3>Postule &amp; suis</h3>
            <p>Candidature envoyée ? Suis son avancement directement depuis ton espace.</p>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════
     DERNIÈRES OFFRES
══════════════════════════════════════════ -->
<?php if (!empty($latestOffers)): ?>
<section class="hp-section hp-offers" data-reveal>
    <div class="hp-section-head hp-section-head--row">
        <div>
            <span class="hp-kicker">Nouveautés</span>
            <h2>Dernières offres publiées</h2>
        </div>
        <a href="/offers" class="hp-btn-ghost">Voir toutes les offres →</a>
    </div>
    <div class="hp-offers-grid">
        <?php foreach ($latestOffers as $i => $offer): ?>
        <a href="/offers/show?id=<?= (int)$offer['id'] ?>" class="hp-offer-card">
            <div class="hp-offer-card-top">
                <div class="hp-offer-avatar"><?= strtoupper(substr($offer['company_name'] ?? 'E', 0, 2)) ?></div>
                <div class="hp-offer-meta">
                    <span class="hp-offer-company"><?= htmlspecialchars($offer['company_name'] ?? 'Entreprise') ?></span>
                </div>
                <div class="hp-offer-arrow">→</div>
            </div>
            <h3 class="hp-offer-title"><?= htmlspecialchars($offer['title']) ?></h3>
            <div class="hp-offer-chips">
                <?php if (!empty($offer['salary'])): ?>
                    <span class="hp-chip hp-chip-green">💶 <?= number_format((float)$offer['salary'], 0, ',', ' ') ?> €/mois</span>
                <?php endif; ?>
                <?php if (!empty($offer['start_date'])): ?>
                    <span class="hp-chip hp-chip-blue">📅 <?= date('d/m/Y', strtotime($offer['start_date'])) ?></span>
                <?php endif; ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ══════════════════════════════════════════
     POURQUOI CESI STAGES
══════════════════════════════════════════ -->
<section class="hp-section hp-why" data-reveal>
    <div class="hp-section-head">
        <span class="hp-kicker">Nos atouts</span>
        <h2>Pourquoi utiliser CESI Stages ?</h2>
        <p>Une plateforme pensée pour les étudiants, les pilotes et les administrateurs.</p>
    </div>
    <div class="hp-why-grid">
        <div class="hp-why-card">
            <div class="hp-why-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg>
            </div>
            <h3>Recherche ciblée</h3>
            <p>Filtre par mot-clé, entreprise, rémunération ou date de début pour trouver exactement ce que tu cherches.</p>
        </div>
        <div class="hp-why-card">
            <div class="hp-why-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <h3>Entreprises détaillées</h3>
            <p>Notes, avis, description et liste complète des offres disponibles pour chaque entreprise.</p>
        </div>
        <div class="hp-why-card">
            <div class="hp-why-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
            </div>
            <h3>Wishlist intelligente</h3>
            <p>Sauvegarde tes offres et entreprises préférées pour les retrouver en un clic.</p>
        </div>
        <div class="hp-why-card">
            <div class="hp-why-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <h3>Statistiques claires</h3>
            <p>Analyse les tendances du marché des stages grâce aux statistiques de la plateforme.</p>
        </div>
        <div class="hp-why-card">
            <div class="hp-why-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h3>Accès sécurisé</h3>
            <p>Chaque rôle — étudiant, pilote, admin — dispose d'un espace dédié et sécurisé.</p>
        </div>
        <div class="hp-why-card">
            <div class="hp-why-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <h3>Suivi en temps réel</h3>
            <p>Candidatures envoyées, en cours ou acceptées : tout est visible directement sur ta page.</p>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════
     CTA FINAL
══════════════════════════════════════════ -->
<section class="hp-cta">
    <div class="hp-cta-bg">
        <div class="hp-cta-blob"></div>
    </div>
    <div class="hp-cta-inner">
        <span class="hp-kicker" style="color:#ffd6d9">Prêt à commencer ?</span>
        <h2>Lance ta recherche de stage dès maintenant</h2>
        <p>Des dizaines d'offres t'attendent. Crée ta wishlist, compare les entreprises et postule en toute sérénité.</p>
        <div class="hp-cta-actions">
            <a href="/offers" class="hp-btn-white">
                <span>Voir les offres</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="/my-applications" class="hp-btn-outline-white">Mes candidatures</a>
            <?php else: ?>
                <a href="/login" class="hp-btn-outline-white">Se connecter</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
/* ══════════════════════════════════════════
   VARIABLES
══════════════════════════════════════════ */
:root {
    --hp-red: #d71920;
    --hp-dark: #0f172a;
    --hp-gray: #6b7280;
    --hp-border: #e5e7eb;
}

/* ══════════════════════════════════════════
   HERO
══════════════════════════════════════════ */
.hp-hero {
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    background: linear-gradient(135deg, #0a0f1e 0%, #141b2d 50%, #1a0608 100%);
    margin-bottom: 32px;
    padding: 70px 56px;
}
.hp-hero-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
    background-size: 48px 48px;
    mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
}
#hp-particles {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}
.hp-hero-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
}
.hp-hero-blob {
    position: absolute;
    border-radius: 999px;
    filter: blur(60px);
}
.hp-blob-1 {
    width: 400px; height: 400px;
    background: rgba(215,25,32,0.25);
    top: -100px; right: -80px;
    animation: blobFloat 6s ease-in-out infinite;
}
.hp-blob-2 {
    width: 280px; height: 280px;
    background: rgba(215,25,32,0.12);
    bottom: -60px; left: 40%;
    animation: blobFloat 8s ease-in-out infinite 1s;
}
.hp-blob-3 {
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.04);
    top: 40px; left: -40px;
    animation: blobFloat 7s ease-in-out infinite 2s;
}
@keyframes blobFloat {
    0%,100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-20px) scale(1.05); }
}

.hp-hero-inner {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 48px;
    align-items: center;
}

.hp-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 999px;
    background: rgba(215,25,32,0.2);
    border: 1px solid rgba(215,25,32,0.35);
    color: #fca5a5;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.hp-hero-title {
    font-size: 3rem;
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    letter-spacing: -0.03em;
    margin-bottom: 18px;
}
.hp-title-accent {
    background: linear-gradient(90deg, #ff6b6b, #d71920, #ff4d55);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    background-size: 200% auto;
    animation: gradientShift 3s ease infinite;
}
@keyframes gradientShift {
    0% { background-position: 0% center; }
    50% { background-position: 100% center; }
    100% { background-position: 0% center; }
}
.hp-cursor {
    display: inline-block;
    color: #d71920;
    -webkit-text-fill-color: #d71920;
    animation: blink 0.9s step-end infinite;
    font-weight: 900;
    margin-left: 2px;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }

.hp-hero-desc {
    font-size: 1.05rem;
    color: rgba(255,255,255,0.7);
    line-height: 1.65;
    max-width: 520px;
    margin-bottom: 32px;
}

.hp-hero-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 32px;
}

.hp-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background: #d71920;
    color: #fff;
    border-radius: 12px;
    font-weight: 800;
    font-size: 0.95rem;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(215,25,32,0.4);
    transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
}
.hp-btn-primary:hover {
    background: #b5141a;
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(215,25,32,0.5);
    text-decoration: none;
    color: #fff;
}

.hp-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 14px 24px;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.85);
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.92rem;
    text-decoration: none;
    transition: background 0.15s, border-color 0.15s;
}
.hp-btn-ghost:hover {
    background: rgba(255,255,255,0.14);
    border-color: rgba(255,255,255,0.3);
    text-decoration: none;
    color: #fff;
}

.hp-hero-trust {
    display: flex;
    align-items: center;
    gap: 12px;
}
.hp-trust-avatars {
    display: flex;
}
.hp-avatar {
    width: 32px;
    height: 32px;
    border-radius: 999px;
    border: 2px solid rgba(255,255,255,0.15);
    color: #fff;
    font-weight: 800;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: -8px;
}
.hp-avatar:first-child { margin-left: 0; }
.hp-hero-trust span {
    font-size: 0.82rem;
    color: rgba(255,255,255,0.5);
    max-width: 220px;
    line-height: 1.4;
}

/* Mockup hero */
.hp-hero-right {
    position: relative;
    min-height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hp-mockup {
    width: 100%;
    max-width: 340px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 18px;
    overflow: hidden;
    backdrop-filter: blur(12px);
    box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.06);
    animation: cardFloat 5s ease-in-out infinite;
}
@keyframes cardFloat {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
.hp-mockup-bar {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 12px 16px;
    background: rgba(255,255,255,0.04);
    border-bottom: 1px solid rgba(255,255,255,0.07);
}
.hp-mockup-bar span {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    flex-shrink: 0;
}
.hp-mockup-bar span:first-child { background: #ef4444; }
.hp-mockup-bar span:nth-child(2) { background: #f59e0b; }
.hp-mockup-bar span:nth-child(3) { background: #10b981; }
.hp-mockup-title {
    margin-left: 8px;
    font-size: 0.72rem;
    font-weight: 600;
    color: rgba(255,255,255,0.35);
    letter-spacing: 0.02em;
}
.hp-mockup-body { padding: 12px; }
.hp-mockup-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 10px;
    margin-bottom: 4px;
    transition: background 0.2s;
}
.hp-mockup-row--active {
    background: rgba(215,25,32,0.14);
    border: 1px solid rgba(215,25,32,0.2);
}
.hp-mockup-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.hp-mockup-info { flex: 1; min-width: 0; }
.hp-mockup-name {
    font-size: 0.78rem;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.hp-mockup-sub {
    font-size: 0.68rem;
    color: rgba(255,255,255,0.4);
    margin-top: 1px;
}
.hp-mockup-badge {
    font-size: 0.7rem;
    font-weight: 800;
    color: #d71920;
    background: rgba(215,25,32,0.12);
    padding: 3px 8px;
    border-radius: 20px;
    white-space: nowrap;
}
.hp-mockup-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 12px 4px;
    font-size: 0.68rem;
    color: rgba(255,255,255,0.25);
}
.hp-mockup-dots { display: flex; gap: 4px; }
.hp-mockup-dots span {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
}
.hp-mockup-dots span.on { background: #d71920; }


/* ══════════════════════════════════════════
   STATS
══════════════════════════════════════════ */
.hp-stats {
    background: #fff;
    border: 1px solid var(--hp-border);
    border-radius: 22px;
    padding: 28px 40px;
    margin-bottom: 40px;
    box-shadow: 0 2px 12px rgba(15,23,42,0.05);
}
.hp-stats-grid {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0;
}
.hp-stat-item {
    flex: 1;
    text-align: center;
}
.hp-stat-item strong {
    display: inline;
    font-size: 2.4rem;
    font-weight: 900;
    color: var(--hp-dark);
    letter-spacing: -0.04em;
    line-height: 1;
}
.hp-stat-plus, .hp-stat-unit {
    font-size: 1.4rem;
    font-weight: 900;
    color: var(--hp-red);
    vertical-align: super;
    margin-left: 2px;
}
.hp-stat-item p {
    font-size: 0.82rem;
    color: var(--hp-gray);
    font-weight: 600;
    margin: 6px 0 0;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.hp-stat-divider {
    width: 1px;
    height: 50px;
    background: var(--hp-border);
    flex-shrink: 0;
    margin: 0 20px;
}

/* ══════════════════════════════════════════
   SECTIONS COMMUNES
══════════════════════════════════════════ */
.hp-section {
    margin-bottom: 48px;
}
.hp-section-head {
    text-align: center;
    margin-bottom: 32px;
}
.hp-section-head h2 {
    font-size: 1.9rem;
    font-weight: 900;
    color: var(--hp-dark);
    letter-spacing: -0.03em;
    margin: 0 0 8px;
}
.hp-section-head p {
    color: var(--hp-gray);
    font-size: 1rem;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.6;
}
.hp-section-head--row {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    text-align: left;
    flex-wrap: wrap;
    gap: 12px;
}
.hp-section-head--row h2 { margin: 0; }
.hp-section-head--row .hp-btn-ghost {
    color: var(--hp-gray);
    background: #f3f4f6;
    border-color: var(--hp-border);
    padding: 10px 18px;
    font-size: 0.86rem;
}
.hp-section-head--row .hp-btn-ghost:hover {
    background: #e5e7eb;
    color: var(--hp-dark);
}
.hp-kicker {
    display: inline-block;
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--hp-red);
    margin-bottom: 8px;
}

/* ══════════════════════════════════════════
   COMMENT ÇA MARCHE
══════════════════════════════════════════ */
.hp-how-grid {
    display: flex;
    align-items: center;
    gap: 0;
}
.hp-how-step {
    flex: 1;
    background: #fff;
    border: 1px solid var(--hp-border);
    border-radius: 22px;
    padding: 32px 28px;
    text-align: center;
    position: relative;
    box-shadow: 0 2px 10px rgba(15,23,42,0.04);
    transition: transform 0.2s, box-shadow 0.2s;
}
.hp-how-step:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 28px rgba(215,25,32,0.1);
}
.hp-how-num {
    font-size: 0.7rem;
    font-weight: 900;
    color: var(--hp-red);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 12px;
    opacity: 0.7;
}
.hp-how-icon {
    font-size: 2.4rem;
    margin-bottom: 16px;
}
.hp-how-step h3 {
    font-size: 1rem;
    font-weight: 800;
    color: var(--hp-dark);
    margin-bottom: 8px;
}
.hp-how-step p {
    font-size: 0.86rem;
    color: var(--hp-gray);
    line-height: 1.55;
    margin: 0;
}
.hp-how-arrow {
    font-size: 1.6rem;
    color: #d1d5db;
    padding: 0 12px;
    flex-shrink: 0;
    margin-top: -20px;
}

/* ══════════════════════════════════════════
   OFFRES
══════════════════════════════════════════ */
.hp-offers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
}
.hp-offer-card {
    background: #fff;
    border: 1.5px solid var(--hp-border);
    border-radius: 18px;
    padding: 20px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    gap: 10px;
    box-shadow: 0 2px 8px rgba(15,23,42,0.04);
    transition: border-color 0.15s, box-shadow 0.15s, transform 0.15s;
}
.hp-offer-card:hover {
    border-color: var(--hp-red);
    box-shadow: 0 8px 24px rgba(215,25,32,0.1);
    transform: translateY(-3px);
    text-decoration: none;
}
.hp-offer-card-top {
    display: flex;
    align-items: center;
    gap: 10px;
}
.hp-offer-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #d71920, #ff4d55);
    color: #fff;
    font-weight: 900;
    font-size: 0.78rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.hp-offer-meta { flex: 1; min-width: 0; }
.hp-offer-company {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--hp-red);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.hp-offer-arrow {
    font-size: 1rem;
    color: #d1d5db;
    transition: color 0.15s, transform 0.15s;
}
.hp-offer-card:hover .hp-offer-arrow {
    color: var(--hp-red);
    transform: translateX(4px);
}
.hp-offer-title {
    font-size: 0.96rem;
    font-weight: 700;
    color: var(--hp-dark);
    line-height: 1.35;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.hp-offer-chips { display: flex; gap: 6px; flex-wrap: wrap; }
.hp-chip {
    font-size: 0.73rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    white-space: nowrap;
}
.hp-chip-green { background: #ecfdf5; color: #065f46; }
.hp-chip-blue  { background: #eff6ff; color: #1e40af; }

/* ══════════════════════════════════════════
   POURQUOI
══════════════════════════════════════════ */
.hp-why-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.hp-why-card {
    background: #fff;
    border: 1px solid var(--hp-border);
    border-radius: 20px;
    padding: 28px 24px;
    box-shadow: 0 2px 8px rgba(15,23,42,0.04);
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
}
.hp-why-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(15,23,42,0.08);
    border-color: var(--hp-border);
}
.hp-why-card:hover .hp-why-icon {
    background: var(--hp-red);
    color: #fff;
}
.hp-why-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #f3f4f6;
    color: var(--hp-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    transition: background 0.2s, color 0.2s;
    flex-shrink: 0;
}
.hp-why-card h3 {
    font-size: 1rem;
    font-weight: 800;
    color: var(--hp-dark);
    margin-bottom: 8px;
}
.hp-why-card p {
    font-size: 0.86rem;
    color: var(--hp-gray);
    line-height: 1.55;
    margin: 0;
}

/* ══════════════════════════════════════════
   CTA FINAL
══════════════════════════════════════════ */
.hp-cta {
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #3b0a0d 100%);
    padding: 64px 56px;
    text-align: center;
    margin-bottom: 8px;
}
.hp-cta-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
}
.hp-cta-blob {
    position: absolute;
    width: 500px;
    height: 500px;
    background: rgba(215,25,32,0.2);
    border-radius: 999px;
    filter: blur(80px);
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    animation: blobFloat 6s ease-in-out infinite;
}
.hp-cta-inner {
    position: relative;
    z-index: 2;
    max-width: 620px;
    margin: 0 auto;
}
.hp-cta-inner h2 {
    font-size: 2.2rem;
    font-weight: 900;
    color: #fff;
    letter-spacing: -0.03em;
    margin: 8px 0 16px;
    line-height: 1.15;
}
.hp-cta-inner p {
    color: rgba(255,255,255,0.65);
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 32px;
}
.hp-cta-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
}
.hp-btn-white {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background: #fff;
    color: var(--hp-red);
    border-radius: 12px;
    font-weight: 800;
    font-size: 0.95rem;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.25);
    transition: transform 0.15s, box-shadow 0.15s;
}
.hp-btn-white:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    text-decoration: none;
    color: var(--hp-red);
}
.hp-btn-outline-white {
    display: inline-flex;
    align-items: center;
    padding: 14px 24px;
    background: transparent;
    color: rgba(255,255,255,0.85);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.92rem;
    text-decoration: none;
    transition: background 0.15s, border-color 0.15s;
}
.hp-btn-outline-white:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.4);
    text-decoration: none;
    color: #fff;
}

/* ══════════════════════════════════════════
   SCROLL REVEAL
══════════════════════════════════════════ */
[data-reveal] {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.55s cubic-bezier(.22,1,.36,1), transform 0.55s cubic-bezier(.22,1,.36,1);
}
[data-reveal].is-visible {
    opacity: 1;
    transform: none;
}

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 900px) {
    .hp-hero { padding: 40px 28px; }
    .hp-hero-inner { grid-template-columns: 1fr; }
    .hp-hero-right { display: none; }
    .hp-hero-title { font-size: 2.2rem; }
    .hp-hero-grid { display: none; }
    .hp-stats-grid { flex-wrap: wrap; gap: 16px; }
    .hp-stat-divider { display: none; }
    .hp-stat-item { flex: 0 0 calc(50% - 8px); }
    .hp-stats { padding: 24px; }
    .hp-why-grid { grid-template-columns: 1fr 1fr; }
    .hp-how-grid { flex-direction: column; gap: 12px; }
    .hp-how-arrow { transform: rotate(90deg); padding: 4px 0; }
    .hp-cta { padding: 40px 28px; }
    .hp-cta-inner h2 { font-size: 1.7rem; }
    .hp-section-head--row { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 640px) {
    .hp-hero-title { font-size: 1.8rem; }
    .hp-why-grid { grid-template-columns: 1fr; }
    .hp-offers-grid { grid-template-columns: 1fr; }
    .hp-stat-item { flex: 0 0 100%; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Particules ── */
    const canvas = document.getElementById('hp-particles');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let W, H, particles = [];
        function resize() {
            W = canvas.width = canvas.offsetWidth;
            H = canvas.height = canvas.offsetHeight;
        }
        resize();
        window.addEventListener('resize', resize);
        for (let i = 0; i < 55; i++) {
            particles.push({
                x: Math.random() * W, y: Math.random() * H,
                r: Math.random() * 1.4 + 0.4,
                vx: (Math.random() - 0.5) * 0.3,
                vy: (Math.random() - 0.5) * 0.3,
                a: Math.random() * 0.5 + 0.15
            });
        }
        function draw() {
            ctx.clearRect(0, 0, W, H);
            particles.forEach(function (p) {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(215,25,32,' + p.a + ')';
                ctx.fill();
                p.x += p.vx; p.y += p.vy;
                if (p.x < 0) p.x = W; if (p.x > W) p.x = 0;
                if (p.y < 0) p.y = H; if (p.y > H) p.y = 0;
            });
            requestAnimationFrame(draw);
        }
        draw();
    }

    /* ── Typewriter ── */
    const tw = document.getElementById('hp-typewriter');
    if (tw) {
        const words = ['idéal', 'parfait', 'rêvé'];
        let wi = 0, ci = 0, deleting = false;
        function type() {
            const word = words[wi];
            if (!deleting) {
                tw.textContent = word.slice(0, ++ci);
                if (ci === word.length) { deleting = true; setTimeout(type, 1800); return; }
                setTimeout(type, 90);
            } else {
                tw.textContent = word.slice(0, --ci);
                if (ci === 0) { deleting = false; wi = (wi + 1) % words.length; setTimeout(type, 300); return; }
                setTimeout(type, 50);
            }
        }
        setTimeout(type, 600);
    }

    /* ── Scroll reveal ── */
    const revealObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('is-visible'); revealObs.unobserve(e.target); }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('[data-reveal]').forEach(function (el) { revealObs.observe(el); });

    /* ── Compteur stats ── */
    const nums = document.querySelectorAll('.hp-stat-num[data-target]');
    const cntObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = parseInt(el.dataset.target, 10);
            if (!target) return;
            let start = 0;
            const step = Math.ceil(target / (1200 / 16));
            const timer = setInterval(function () {
                start += step;
                if (start >= target) { el.textContent = target; clearInterval(timer); }
                else { el.textContent = start; }
            }, 16);
            cntObs.unobserve(el);
        });
    }, { threshold: 0.3 });
    nums.forEach(function (n) { cntObs.observe(n); });

});
</script>
