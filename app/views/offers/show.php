<?php if (!$offer): ?>
    <div style="text-align:center;padding:60px 20px">
        <h2 style="color:#161b26;margin-bottom:12px">Offre introuvable</h2>
        <p style="color:#667085;margin-bottom:20px">L'offre demandée n'existe pas ou a été supprimée.</p>
        <a href="/offers" class="btn btn-primary">← Retour aux offres</a>
    </div>
<?php else: ?>

<?php
$user      = $_SESSION['user'] ?? null;
$userId    = (int)($user['id'] ?? 0);
$isStudent = ($user['role'] ?? '') === 'STUDENT';
$isFavorite = ($isStudent && $userId > 0) ? Wishlist::has($userId, (int)$offer['id']) : false;
$alreadyApplied = false;
if ($isStudent && $userId > 0) {
    $studentId = Student::idByUserId($userId);
    $alreadyApplied = $studentId ? Application::alreadyApplied($studentId, (int)$offer['id']) : false;
}
?>

<div class="offer-detail-wrap">

    <!-- COLONNE PRINCIPALE -->
    <div class="offer-detail-main">

        <a href="/offers" class="offer-detail-back">← Retour aux offres</a>

        <div class="offer-detail-card">
            <div class="offer-detail-header">
                <div>
                    <div class="offer-detail-company">
                        <?php if (!empty($offer['company_id'])): ?>
                            <a href="/companies/show?id=<?= (int)$offer['company_id'] ?>" class="offer-detail-company-link">
                                <?= htmlspecialchars($offer['company_name'] ?? '') ?>
                            </a>
                        <?php else: ?>
                            <?= htmlspecialchars($offer['company_name'] ?? '') ?>
                        <?php endif; ?>
                    </div>
                    <h1 class="offer-detail-title"><?= htmlspecialchars($offer['title']) ?></h1>
                </div>

                <?php if ($isStudent): ?>
                    <form method="post" action="/wishlist/toggle" style="margin:0">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                        <input type="hidden" name="offer_id" value="<?= (int)$offer['id'] ?>">
                        <button type="submit" class="offer-fav-btn <?= $isFavorite ? 'is-fav' : '' ?>" title="<?= $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>">
                            <?= $isFavorite ? '♥' : '♡' ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- CHIPS INFO -->
            <div class="offer-detail-chips">
                <?php if (!empty($offer['salary'])): ?>
                    <span class="offer-detail-chip chip-green">💶 <?= number_format((float)$offer['salary'], 0, ',', ' ') ?> €/mois</span>
                <?php endif; ?>
                <?php if (!empty($offer['start_date'])): ?>
                    <span class="offer-detail-chip chip-blue">📅 Début : <?= date('d/m/Y', strtotime($offer['start_date'])) ?></span>
                <?php endif; ?>
                <?php if (!empty($offer['end_date'])): ?>
                    <span class="offer-detail-chip chip-blue">🏁 Fin : <?= date('d/m/Y', strtotime($offer['end_date'])) ?></span>
                <?php endif; ?>
                <?php if (isset($offer['applications_count'])): ?>
                    <span class="offer-detail-chip chip-gray">👥 <?= (int)$offer['applications_count'] ?> candidature<?= (int)$offer['applications_count'] > 1 ? 's' : '' ?></span>
                <?php endif; ?>
            </div>

            <!-- DESCRIPTION -->
            <?php if (!empty($offer['description'])): ?>
                <div class="offer-detail-desc">
                    <h2 class="offer-detail-section-title">Description du poste</h2>
                    <div class="offer-detail-desc-text"><?= nl2br(htmlspecialchars($offer['description'])) ?></div>
                </div>
            <?php endif; ?>

            <!-- CANDIDATURE -->
            <?php if ($isStudent): ?>
                <div class="offer-detail-apply">
                    <?php if ($alreadyApplied): ?>
                        <div class="already-applied-notice">
                            ✅ Vous avez déjà postulé à cette offre.
                            <a href="/my-applications">Voir mes candidatures →</a>
                        </div>
                    <?php else: ?>
                        <h2 class="offer-detail-section-title">Postuler à cette offre</h2>
                        <form method="post" action="/apply" enctype="multipart/form-data" class="apply-form">
                            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                            <input type="hidden" name="offer_id" value="<?= (int)$offer['id'] ?>">
                            <div class="apply-field">
                                <label for="lm_text" class="apply-label">Lettre de motivation <span class="required">*</span></label>
                                <textarea id="lm_text" name="lm_text" class="apply-textarea" rows="6" required placeholder="Présentez-vous et expliquez pourquoi vous êtes intéressé par cette offre..."></textarea>
                            </div>
                            <div class="apply-field">
                                <label for="cv" class="apply-label">CV (PDF, optionnel)</label>
                                <input type="file" id="cv" name="cv" accept=".pdf" class="apply-file">
                            </div>
                            <button type="submit" class="apply-submit" id="applyBtn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            Envoyer ma candidature
                        </button>
                        </form>
<script>
(function () {
    const form = document.querySelector('.apply-form');
    if (!form) return;
    form.addEventListener('submit', function () {
        /* Confetti léger */
        const colors = ['#d71920','#ff6b6b','#fff','#fbbf24','#34d399'];
        for (let i = 0; i < 80; i++) {
            const el = document.createElement('div');
            const size = Math.random() * 8 + 4;
            el.style.cssText = [
                'position:fixed',
                'left:' + (Math.random() * 100) + 'vw',
                'top:-10px',
                'width:' + size + 'px',
                'height:' + size + 'px',
                'background:' + colors[Math.floor(Math.random() * colors.length)],
                'border-radius:' + (Math.random() > 0.5 ? '50%' : '2px'),
                'opacity:1',
                'z-index:99999',
                'pointer-events:none',
                'transform:rotate(' + (Math.random() * 360) + 'deg)',
                'animation:cfetti ' + (Math.random() * 1.5 + 1) + 's ease-in forwards ' + (Math.random() * 0.4) + 's'
            ].join(';');
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 3000);
        }
    });
})();
</script>
<style>
@keyframes cfetti {
    0%   { transform: translateY(0) rotate(0deg); opacity: 1; }
    100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
}
.apply-submit { display: inline-flex; align-items: center; gap: 8px; }
</style>
                    <?php endif; ?>
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
                    <span class="offer-side-label">Entreprise</span>
                    <span class="offer-side-value">
                        <?php if (!empty($offer['company_id'])): ?>
                            <a href="/companies/show?id=<?= (int)$offer['company_id'] ?>" class="offer-detail-company-link">
                                <?= htmlspecialchars($offer['company_name'] ?? '—') ?>
                            </a>
                        <?php else: ?>
                            <?= htmlspecialchars($offer['company_name'] ?? '—') ?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="offer-side-row">
                    <span class="offer-side-label">Rémunération</span>
                    <span class="offer-side-value">
                        <?= isset($offer['salary']) && $offer['salary'] !== null
                            ? number_format((float)$offer['salary'], 0, ',', ' ') . ' €/mois'
                            : 'Non précisée' ?>
                    </span>
                </div>
                <?php if (!empty($offer['start_date'])): ?>
                <div class="offer-side-row">
                    <span class="offer-side-label">Date de début</span>
                    <span class="offer-side-value"><?= date('d/m/Y', strtotime($offer['start_date'])) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($offer['end_date'])): ?>
                <div class="offer-side-row">
                    <span class="offer-side-label">Date de fin</span>
                    <span class="offer-side-value"><?= date('d/m/Y', strtotime($offer['end_date'])) ?></span>
                </div>
                <?php endif; ?>
                <div class="offer-side-row">
                    <span class="offer-side-label">Publiée le</span>
                    <span class="offer-side-value"><?= !empty($offer['created_at']) ? date('d/m/Y', strtotime($offer['created_at'])) : '—' ?></span>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
.offer-detail-wrap { display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: start; }
.offer-detail-back { color: #667085; text-decoration: none; font-size: 0.88rem; display: inline-block; margin-bottom: 16px; }
.offer-detail-back:hover { color: #d71920; }

.offer-detail-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 20px; padding: 28px 32px; box-shadow: 0 2px 12px rgba(15,23,42,0.05); }
.offer-detail-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 16px; }
.offer-detail-company { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
.offer-detail-company-link { color: #d71920; text-decoration: none; }
.offer-detail-company-link:hover { text-decoration: underline; }
.offer-detail-title { font-size: 1.6rem; font-weight: 900; color: #161b26; line-height: 1.2; }

.offer-fav-btn { width: 42px; height: 42px; border-radius: 12px; border: 1px solid #e5e7eb; background: #fff; font-size: 1.3rem; cursor: pointer; flex-shrink: 0; display: flex; align-items: center; justify-content: center; transition: all 0.15s; color: #d1d5db; }
.offer-fav-btn:hover { border-color: #d71920; background: #fef2f2; color: #d71920; transform: none; box-shadow: none; }
.offer-fav-btn.is-fav { background: #fef2f2; border-color: #fecaca; color: #d71920; }

.offer-detail-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px; }
.offer-detail-chip { font-size: 0.82rem; padding: 5px 12px; border-radius: 20px; font-weight: 500; }
.chip-green { background: #EAF3DE; color: #27500A; }
.chip-blue { background: #E6F1FB; color: #185FA5; }
.chip-gray { background: #f3f4f6; color: #374151; }

.offer-detail-section-title { font-size: 1rem; font-weight: 700; color: #374151; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #f3f4f6; }
.offer-detail-desc { margin-bottom: 28px; }
.offer-detail-desc-text { color: #374151; line-height: 1.7; font-size: 0.95rem; }

.offer-detail-apply { padding-top: 24px; border-top: 1px solid #f3f4f6; }
.already-applied-notice { background: #EAF3DE; border: 1px solid #C0DD97; border-radius: 12px; padding: 14px 18px; color: #27500A; font-weight: 600; display: flex; align-items: center; gap: 10px; }
.already-applied-notice a { color: #3B6D11; }

.apply-form { display: flex; flex-direction: column; gap: 16px; }
.apply-field { display: flex; flex-direction: column; gap: 6px; }
.apply-label { font-weight: 600; font-size: 0.9rem; color: #374151; }
.required { color: #d71920; }
.apply-textarea { padding: 12px 14px; border: 1px solid #e5e7eb; border-radius: 10px; font-size: 0.95rem; resize: vertical; font-family: inherit; outline: none; }
.apply-textarea:focus { border-color: #d71920; }
.apply-file { font-size: 0.9rem; color: #374151; }
.apply-submit { align-self: flex-start; padding: 12px 28px; background: #d71920; color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; }
.apply-submit:hover { background: #b5141a; transform: none; }

.offer-side-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(15,23,42,0.04); position: sticky; top: 100px; }
.offer-side-title { font-size: 0.85rem; font-weight: 700; color: #667085; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; }
.offer-side-rows { display: flex; flex-direction: column; gap: 12px; }
.offer-side-row { display: flex; flex-direction: column; gap: 2px; }
.offer-side-label { font-size: 0.78rem; color: #9ca3af; font-weight: 500; }
.offer-side-value { font-size: 0.9rem; color: #161b26; font-weight: 600; }

@media (max-width: 768px) {
    .offer-detail-wrap { grid-template-columns: 1fr; }
    .offer-detail-side { order: -1; }
    .offer-side-card { position: static; }
}
</style>

<?php endif; ?>