<?php $base = ''; ?>

<!-- HERO -->
<section class="hero anim-fade-up">
    <div class="hero-content">
        <span class="hero-badge">Plateforme CESI</span>
        <h1>Trouve ton stage<br>efficacement.</h1>
        <p>Une plateforme claire pour repérer les opportunités, suivre tes candidatures et cibler rapidement les entreprises qui comptent vraiment.</p>
        <div class="hero-actions">
            <a href="/offers" class="btn btn-hero">Voir les offres</a>
            <a href="/companies" class="btn btn-ghost">Voir les entreprises</a>
        </div>
    </div>
    <div class="hero-visual">
        <div class="hero-card hero-card-main">
            <h3>Recherche centralisée</h3>
            <p>Offres, entreprises, favoris et candidatures réunis au même endroit.</p>
        </div>
        <div class="hero-card hero-card-accent">
            <h3>Navigation rapide</h3>
            <p>Accède directement aux informations utiles sans perdre de temps.</p>
        </div>
        <div class="hero-glow hero-glow-1"></div>
        <div class="hero-glow hero-glow-2"></div>
    </div>
</section>

<!-- STATS REELLES -->
<section class="stats-section anim-fade-up anim-delay-2">
    <div class="stats-grid">
        <div class="stat-box">
            <strong><?= ($totalOffers ?? 0) ?>+</strong>
            <span>Offres actives</span>
        </div>
        <div class="stat-box">
            <strong><?= ($totalCompanies ?? 0) ?>+</strong>
            <span>Entreprises partenaires</span>
        </div>
        <div class="stat-box">
            <strong><?= isset($avgSalary) && $avgSalary > 0 ? number_format($avgSalary, 0, ',', ' ') . ' €' : '—' ?></strong>
            <span>Rémunération moyenne</span>
        </div>
        <div class="stat-box">
            <strong><?= ($totalWishlists ?? 0) ?>+</strong>
            <span>Offres en wishlist</span>
        </div>
    </div>
</section>

<!-- DERNIÈRES OFFRES -->
<?php if (!empty($latestOffers)): ?>
<section class="latest-offers-section anim-fade-up anim-delay-3">
    <div class="section-heading">
        <span class="section-kicker">Nouveautés</span>
        <h2>Dernières offres publiées</h2>
    </div>
    <div class="latest-offers-grid">
        <?php foreach ($latestOffers as $offer): ?>
            <a href="/offers/show?id=<?= (int)$offer['id'] ?>" class="latest-offer-card">
                <div class="latest-offer-company"><?= htmlspecialchars($offer['company_name'] ?? 'Entreprise') ?></div>
                <div class="latest-offer-title"><?= htmlspecialchars($offer['title']) ?></div>
                <div class="latest-offer-chips">
                    <?php if (!empty($offer['salary'])): ?>
                        <span class="latest-chip chip-green">💶 <?= number_format((float)$offer['salary'], 0, ',', ' ') ?> €/mois</span>
                    <?php endif; ?>
                    <?php if (!empty($offer['start_date'])): ?>
                        <span class="latest-chip chip-blue">📅 <?= date('d/m/Y', strtotime($offer['start_date'])) ?></span>
                    <?php endif; ?>
                </div>
                <div class="latest-offer-cta">Voir l'offre →</div>
            </a>
        <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:20px;">
        <a href="/offers" class="btn btn-ghost">Voir toutes les offres</a>
    </div>
</section>
<?php endif; ?>

<!-- FEATURES -->
<section class="feature-section anim-fade-up anim-delay-4">
    <div class="section-heading">
        <span class="section-kicker">Les points forts</span>
        <h2>Un espace plus clair pour mieux organiser ta recherche</h2>
    </div>
    <div class="feature-grid">
        <article class="feature-card feature-red">
            <div class="feature-icon icon-box"><div class="icon-target"></div></div>
            <h3>Recherche ciblée</h3>
            <p>Filtre les offres par mot-clé ou entreprise pour trouver le stage qui te correspond.</p>
        </article>
        <article class="feature-card feature-white">
            <div class="feature-icon icon-box"><div class="icon-building"></div></div>
            <h3>Entreprises centralisées</h3>
            <p>Retrouve les entreprises, leurs offres, leurs notes et leurs informations utiles.</p>
        </article>
        <article class="feature-card feature-light">
            <div class="feature-icon icon-box"><div class="icon-bookmark"></div></div>
            <h3>Favoris intelligents</h3>
            <p>Garde les meilleures offres et entreprises à portée de clic pour ne rien perdre.</p>
        </article>
        <article class="feature-card feature-white">
            <div class="feature-icon icon-box"><div class="icon-file"></div></div>
            <h3>Suivi des candidatures</h3>
            <p>Consulte l'état de tes candidatures dans un espace unique et lisible.</p>
        </article>
    </div>
</section>

<!-- CTA -->
<section class="cta-banner anim-fade-up anim-delay-5">
    <div class="cta-banner-content">
        <span class="section-kicker">Passe à l'action</span>
        <h2>Commence à construire ta shortlist de stages</h2>
        <p>Explore les offres, compare les entreprises et organise ta recherche de façon beaucoup plus simple.</p>
    </div>
    <div class="cta-banner-actions">
        <a href="/offers" class="btn btn-hero">Accéder aux offres</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/my-applications" class="btn btn-ghost">Mes candidatures</a>
        <?php else: ?>
            <a href="/login" class="btn btn-ghost">Se connecter</a>
        <?php endif; ?>
    </div>
</section>

<style>
.latest-offers-section { margin-bottom: 40px; }
.latest-offers-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 14px; margin-top: 20px; }
.latest-offer-card { display: flex; flex-direction: column; gap: 8px; padding: 20px; background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; text-decoration: none; transition: border-color 0.15s, box-shadow 0.15s; box-shadow: 0 2px 8px rgba(15,23,42,0.04); }
.latest-offer-card:hover { border-color: #d71920; box-shadow: 0 4px 16px rgba(215,25,32,0.08); }
.latest-offer-company { font-size: 0.8rem; font-weight: 600; color: #d71920; text-transform: uppercase; letter-spacing: 0.05em; }
.latest-offer-title { font-size: 1rem; font-weight: 700; color: #161b26; line-height: 1.3; flex: 1; }
.latest-offer-chips { display: flex; gap: 6px; flex-wrap: wrap; margin: 6px 0; }
.latest-chip { font-size: 0.75rem; padding: 2px 8px; border-radius: 20px; }
.chip-green { background: #EAF3DE; color: #27500A; }
.chip-blue { background: #E6F1FB; color: #185FA5; }
.latest-offer-cta { font-size: 0.85rem; font-weight: 700; color: #667085; margin-top: 4px; }
.latest-offer-card:hover .latest-offer-cta { color: #d71920; }
</style>