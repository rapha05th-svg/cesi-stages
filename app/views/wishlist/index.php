<div class="wish-header">
    <h1>Ma wishlist</h1>
    <p class="wish-sub"><?= count($offers) ?> offre<?= count($offers) > 1 ? 's' : '' ?> sauvegardée<?= count($offers) > 1 ? 's' : '' ?></p>
</div>

<?php if (empty($offers)): ?>
    <div class="wish-empty">
        <div class="wish-empty-icon">♡</div>
        <p>Aucune offre dans votre wishlist.</p>
        <a href="/offers" class="wish-browse-btn">Parcourir les offres</a>
    </div>
<?php else: ?>
    <div class="wish-list">
        <?php foreach ($offers as $offer): ?>
            <div class="wish-card">
                <div class="wish-card-main">
                    <a href="/offers/show?id=<?= (int)$offer['id'] ?>" class="wish-card-title">
                        <?= htmlspecialchars($offer['title']) ?>
                    </a>
                    <span class="wish-card-company">
                        <?= htmlspecialchars($offer['company_name'] ?? 'Entreprise inconnue') ?>
                    </span>
                </div>
                <div class="wish-card-actions">
                    <a href="/offers/show?id=<?= (int)$offer['id'] ?>" class="wish-btn-see">Voir l'offre →</a>
                    <form method="post" action="/wishlist/toggle" style="margin:0">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                        <input type="hidden" name="offer_id" value="<?= (int)$offer['id'] ?>">
                        <button type="submit" class="wish-btn-remove" title="Retirer de la wishlist">✕</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.wish-header { margin-bottom: 24px; }
.wish-header h1 { font-size: 1.5rem; font-weight: 900; color: #161b26; margin-bottom: 4px; }
.wish-sub { color: #667085; font-size: 0.95rem; }

.wish-empty { text-align: center; padding: 60px 20px; }
.wish-empty-icon { font-size: 3rem; color: #e5e7eb; margin-bottom: 16px; }
.wish-empty p { color: #667085; margin-bottom: 16px; }
.wish-browse-btn { display: inline-block; padding: 10px 24px; background: #d71920; color: #fff; border-radius: 10px; text-decoration: none; font-weight: 700; }
.wish-browse-btn:hover { background: #b5141a; }

.wish-list { display: flex; flex-direction: column; gap: 10px; }

.wish-card { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 16px 20px; background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; box-shadow: 0 2px 6px rgba(15,23,42,0.04); transition: border-color 0.15s; }
.wish-card:hover { border-color: #d71920; }

.wish-card-main { flex: 1; }
.wish-card-title { font-weight: 700; color: #161b26; text-decoration: none; font-size: 1rem; display: block; margin-bottom: 4px; }
.wish-card-title:hover { color: #d71920; }
.wish-card-company { font-size: 0.85rem; color: #667085; }

.wish-card-actions { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.wish-btn-see { color: #d71920; font-weight: 700; text-decoration: none; font-size: 0.88rem; white-space: nowrap; }
.wish-btn-see:hover { text-decoration: underline; }
.wish-btn-remove { width: 32px; height: 32px; border-radius: 50%; border: 1px solid #fecaca; background: #fef2f2; color: #d71920; font-weight: 700; cursor: pointer; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; }
.wish-btn-remove:hover { background: #fee2e2; }
</style>