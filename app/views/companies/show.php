<a href="/companies" class="offer-detail-back">← Retour aux entreprises</a>

<?php
$avg = round((float)($company['avg_rating'] ?? 0));
$user = $_SESSION['user'] ?? null;
$isStudent = ($user['role'] ?? '') === 'STUDENT';
?>

<div class="offer-detail-wrap">

    <!-- COLONNE PRINCIPALE -->
    <div class="offer-detail-main">
        <div class="offer-detail-card">

            <div class="offer-detail-header">
                <div>
                    <h1 class="offer-detail-title"><?= htmlspecialchars($company['name']) ?></h1>
                    <div class="company-rating-display">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span style="color:<?= $i <= $avg ? '#d71920' : '#e5e7eb' ?>;font-size:1.1rem">★</span>
                        <?php endfor; ?>
                        <span style="font-size:0.88rem;color:#667085;margin-left:4px"><?= number_format((float)($company['avg_rating'] ?? 0), 1, ',', ' ') ?>/5</span>
                    </div>
                </div>
                <?php if ($isStudent): ?>
                    <form method="post" action="/favorite-companies/toggle" style="margin:0">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                        <input type="hidden" name="company_id" value="<?= (int)$company['id'] ?>">
                        <button type="submit" class="offer-fav-btn <?= !empty($isFavorite) ? 'is-fav' : '' ?>">
                            <?= !empty($isFavorite) ? '♥' : '♡' ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <div class="offer-detail-chips">
                <?php if (!empty($company['email_contact'])): ?>
                    <span class="offer-detail-chip chip-gray">✉ <?= htmlspecialchars($company['email_contact']) ?></span>
                <?php endif; ?>
                <?php if (!empty($company['phone_contact'])): ?>
                    <span class="offer-detail-chip chip-gray">✆ <?= htmlspecialchars($company['phone_contact']) ?></span>
                <?php endif; ?>
                <span class="offer-detail-chip chip-gray">👥 <?= (int)($company['applications_count'] ?? 0) ?> candidature<?= ($company['applications_count'] ?? 0) > 1 ? 's' : '' ?></span>
            </div>

            <?php if (!empty($company['description'])): ?>
                <div class="offer-detail-desc">
                    <h2 class="offer-detail-section-title">À propos</h2>
                    <div class="offer-detail-desc-text"><?= nl2br(htmlspecialchars($company['description'])) ?></div>
                </div>
            <?php endif; ?>

            <!-- OFFRES -->
            <div style="margin-top:24px">
                <h2 class="offer-detail-section-title">Offres de stage disponibles</h2>
                <?php if (!empty($company['offers'])): ?>
                    <div style="display:flex;flex-direction:column;gap:8px">
                        <?php foreach ($company['offers'] as $offer): ?>
                            <a href="/offers/show?id=<?= (int)$offer['id'] ?>" style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;text-decoration:none;color:#161b26;font-weight:500;font-size:0.95rem;transition:border-color 0.15s">
                                <span><?= htmlspecialchars($offer['title']) ?></span>
                                <span style="color:#d71920;font-weight:700">→</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color:#667085;font-style:italic">Aucune offre active pour cette entreprise.</p>
                <?php endif; ?>
            </div>

            <!-- NOTATION -->
            <?php if ($isStudent): ?>
                <div class="offer-detail-apply">
                    <h2 class="offer-detail-section-title"><?= $myRating !== null ? 'Modifier ma note' : 'Noter cette entreprise' ?></h2>
                    <form method="post" action="/companies/rate" class="no-validate">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                        <input type="hidden" name="company_id" value="<?= (int)$company['id'] ?>">
                        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <label style="cursor:pointer">
                                    <input type="radio" name="rating" value="<?= $i ?>" <?= ((int)($myRating ?? 0) === $i) ? 'checked' : '' ?> required style="display:none">
                                    <span style="display:inline-block;padding:7px 14px;border-radius:8px;background:<?= ((int)($myRating ?? 0) === $i) ? '#d71920' : '#f3f4f6' ?>;color:<?= ((int)($myRating ?? 0) === $i) ? '#fff' : '#374151' ?>;font-weight:600;font-size:0.9rem"><?= $i ?>★</span>
                                </label>
                            <?php endfor; ?>
                            <button type="submit" style="padding:8px 18px;background:#d71920;color:#fff;border:none;border-radius:8px;font-weight:700;cursor:pointer">Envoyer</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

        </div>
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
                    <span class="offer-side-value"><?= (int)($company['applications_count'] ?? 0) ?></span>
                </div>
                <div class="offer-side-row">
                    <span class="offer-side-label">Offres actives</span>
                    <span class="offer-side-value"><?= count($company['offers'] ?? []) ?></span>
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