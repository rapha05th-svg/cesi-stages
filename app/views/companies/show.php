<?php
$avg      = round((float)($company['avg_rating'] ?? 0));
$user     = $_SESSION['user'] ?? null;
$isStudent = ($user['role'] ?? '') === 'STUDENT';
$offersCount = count($company['offers'] ?? []);
$appsCount   = (int)($company['applications_count'] ?? 0);
?>

<a href="/companies" class="offer-detail-back">← Retour aux entreprises</a>

<!-- HERO ENTREPRISE -->
<div class="co-hero">
    <div class="co-hero-avatar">
        <?= mb_strtoupper(mb_substr($company['name'], 0, 2)) ?>
    </div>
    <div class="co-hero-info">
        <h1 class="co-hero-name"><?= htmlspecialchars($company['name']) ?></h1>

        <!-- Étoiles -->
        <div class="co-hero-stars">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="co-star <?= $i <= $avg ? 'co-star--on' : '' ?>">★</span>
            <?php endfor; ?>
            <span class="co-hero-rating"><?= number_format((float)($company['avg_rating'] ?? 0), 1, ',', ' ') ?>/5</span>
        </div>

        <!-- Badges -->
        <div class="co-hero-chips">
            <?php if (!empty($company['email_contact'])): ?>
                <span class="co-chip">✉ <?= htmlspecialchars($company['email_contact']) ?></span>
            <?php endif; ?>
            <?php if (!empty($company['phone_contact'])): ?>
                <span class="co-chip">✆ <?= htmlspecialchars($company['phone_contact']) ?></span>
            <?php endif; ?>
            <span class="co-chip co-chip--offer"><?= $offersCount ?> offre<?= $offersCount > 1 ? 's' : '' ?> active<?= $offersCount > 1 ? 's' : '' ?></span>
            <span class="co-chip"><?= $appsCount ?> candidature<?= $appsCount > 1 ? 's' : '' ?></span>
        </div>
    </div>

    <?php if ($isStudent): ?>
        <form method="post" action="/favorite-companies/toggle" class="co-fav-form">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <input type="hidden" name="company_id" value="<?= (int)$company['id'] ?>">
            <button type="submit" class="co-fav-btn <?= !empty($isFavorite) ? 'is-fav' : '' ?>" title="<?= !empty($isFavorite) ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>">
                <?= !empty($isFavorite) ? '♥' : '♡' ?>
            </button>
        </form>
    <?php endif; ?>
</div>

<div class="offer-detail-wrap" style="margin-top:24px">

    <!-- COLONNE PRINCIPALE -->
    <div class="offer-detail-main">

        <!-- À propos -->
        <?php if (!empty($company['description'])): ?>
        <div class="co-card">
            <h2 class="co-section-title">À propos</h2>
            <p class="co-desc"><?= nl2br(htmlspecialchars($company['description'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Offres -->
        <div class="co-card">
            <h2 class="co-section-title">Offres de stage disponibles</h2>
            <?php if (!empty($company['offers'])): ?>
                <div class="co-offers-list">
                    <?php foreach ($company['offers'] as $offer): ?>
                        <a href="/offers/show?id=<?= (int)$offer['id'] ?>" class="co-offer-row">
                            <span><?= htmlspecialchars($offer['title']) ?></span>
                            <span class="co-offer-arrow">→</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="co-empty">Aucune offre active pour cette entreprise.</p>
            <?php endif; ?>
        </div>

        <!-- Notation -->
        <?php if ($isStudent): ?>
        <div class="co-card">
            <h2 class="co-section-title"><?= $myRating !== null ? 'Modifier ma note' : 'Noter cette entreprise' ?></h2>
            <form method="post" action="/companies/rate" class="no-validate">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                <input type="hidden" name="company_id" value="<?= (int)$company['id'] ?>">
                <div class="co-rating-row">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label class="co-rating-label">
                            <input type="radio" name="rating" value="<?= $i ?>" <?= ((int)($myRating ?? 0) === $i) ? 'checked' : '' ?> required style="display:none">
                            <span class="co-rating-btn <?= ((int)($myRating ?? 0) === $i) ? 'co-rating-btn--active' : '' ?>"><?= $i ?>★</span>
                        </label>
                    <?php endfor; ?>
                    <button type="submit" class="co-rating-submit">Envoyer</button>
                </div>
            </form>
        </div>
        <?php endif; ?>

    </div>

    <!-- COLONNE LATÉRALE -->
    <div class="offer-detail-side">
        <div class="offer-side-card">
            <h3 class="offer-side-title">Informations</h3>
            <div class="offer-side-rows">
                <div class="offer-side-row">
                    <span class="offer-side-label">Note moyenne</span>
                    <span class="offer-side-value"><?= number_format((float)($company['avg_rating'] ?? 0), 1, ',', ' ') ?> / 5</span>
                </div>
                <div class="offer-side-row">
                    <span class="offer-side-label">Candidatures reçues</span>
                    <span class="offer-side-value"><?= $appsCount ?></span>
                </div>
                <div class="offer-side-row">
                    <span class="offer-side-label">Offres actives</span>
                    <span class="offer-side-value"><?= $offersCount ?></span>
                </div>
                <?php if (!empty($company['email_contact'])): ?>
                <div class="offer-side-row">
                    <span class="offer-side-label">Email</span>
                    <span class="offer-side-value" style="word-break:break-all"><?= htmlspecialchars($company['email_contact']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($company['phone_contact'])): ?>
                <div class="offer-side-row">
                    <span class="offer-side-label">Téléphone</span>
                    <span class="offer-side-value"><?= htmlspecialchars($company['phone_contact']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<script>
(function () {
    document.querySelectorAll('.co-rating-row input[type="radio"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const row = this.closest('.co-rating-row');
            row.querySelectorAll('.co-rating-btn').forEach(function (btn) {
                btn.classList.remove('co-rating-btn--active');
            });
            this.closest('label').querySelector('.co-rating-btn').classList.add('co-rating-btn--active');
        });
    });
})();
</script>

<style>
/* ── HERO ─────────────────────────────────────────────────── */
.co-hero {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 28px 32px;
    box-shadow: 0 2px 12px rgba(15,23,42,0.05);
    margin-bottom: 4px;
}
.co-hero-avatar {
    width: 64px; height: 64px;
    border-radius: 16px;
    background: linear-gradient(135deg, #d71920 0%, #ff6b6b 100%);
    color: #fff;
    font-size: 1.3rem;
    font-weight: 900;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    letter-spacing: -0.02em;
}
.co-hero-info { flex: 1; min-width: 0; }
.co-hero-name { font-size: 1.7rem; font-weight: 900; color: #161b26; margin: 0 0 8px; line-height: 1.2; }

.co-hero-stars { display: flex; align-items: center; gap: 3px; margin-bottom: 12px; }
.co-star { font-size: 1.1rem; color: #e5e7eb; }
.co-star--on { color: #d71920; }
.co-hero-rating { font-size: 0.85rem; color: #667085; margin-left: 6px; }

.co-hero-chips { display: flex; flex-wrap: wrap; gap: 8px; }
.co-chip { font-size: 0.8rem; padding: 4px 12px; border-radius: 20px; background: #f3f4f6; color: #374151; font-weight: 500; }
.co-chip--offer { background: #EAF3DE; color: #27500A; }

/* ── BOUTON FAVORI ───────────────────────────────────────── */
.co-fav-form { margin: 0; flex-shrink: 0; }
.co-fav-btn {
    width: 46px; height: 46px;
    border-radius: 12px;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    font-size: 1.4rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
    color: #d1d5db;
}
.co-fav-btn:hover { border-color: #d71920; background: #fef2f2; color: #d71920; box-shadow: none; transform: none; }
.co-fav-btn.is-fav { background: #fef2f2; border-color: #fecaca; color: #d71920; }

/* ── CARDS ───────────────────────────────────────────────── */
.co-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 16px;
    box-shadow: 0 1px 6px rgba(15,23,42,0.04);
}
.co-section-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #374151;
    margin: 0 0 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f3f4f6;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.co-desc { color: #4b5563; line-height: 1.65; margin: 0; }
.co-empty { color: #9ca3af; font-style: italic; margin: 0; }

/* ── OFFRES ──────────────────────────────────────────────── */
.co-offers-list { display: flex; flex-direction: column; gap: 8px; }
.co-offer-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 16px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    text-decoration: none;
    color: #161b26;
    font-weight: 500;
    font-size: 0.93rem;
    transition: border-color 0.15s, background 0.15s;
}
.co-offer-row:hover { border-color: #d71920; background: #fff; }
.co-offer-arrow { color: #d71920; font-weight: 700; }

/* ── NOTATION ────────────────────────────────────────────── */
.co-rating-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.co-rating-label { cursor: pointer; }
.co-rating-btn {
    display: inline-block;
    padding: 7px 14px;
    border-radius: 8px;
    background: #f3f4f6;
    color: #374151;
    font-weight: 600;
    font-size: 0.9rem;
    transition: background 0.15s;
}
.co-rating-btn--active { background: #d71920; color: #fff; }
.co-rating-submit {
    padding: 8px 18px;
    background: #d71920;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
}
.co-rating-submit:hover { background: #b5141a; box-shadow: none; transform: none; }
</style>
