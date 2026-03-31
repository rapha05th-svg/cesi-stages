<div class="favco-header anim-fade-up">
    <h1>Mes entreprises favorites</h1>
    <p class="favco-sub"><?= count($companies) ?> entreprise<?= count($companies) > 1 ? 's' : '' ?> sauvegardée<?= count($companies) > 1 ? 's' : '' ?></p>
</div>

<?php if (empty($companies)): ?>
    <div class="favco-empty anim-fade-up">
        <div class="favco-empty-icon">🏢</div>
        <p>Aucune entreprise dans vos favoris.</p>
        <a href="/companies" class="favco-browse-btn">Parcourir les entreprises</a>
    </div>
<?php else: ?>
    <div class="favco-grid anim-fade-up">
        <?php foreach ($companies as $i => $company): ?>
            <div class="favco-card anim-fade-up anim-delay-<?= min($i + 1, 5) ?>">

                <div class="favco-card-top">
                    <div class="favco-avatar">
                        <?= strtoupper(substr($company['name'], 0, 2)) ?>
                    </div>
                    <div class="favco-info">
                        <a href="/companies/show?id=<?= (int)$company['id'] ?>" class="favco-name">
                            <?= htmlspecialchars($company['name']) ?>
                        </a>
                        <?php if (!empty($company['email_contact'])): ?>
                            <span class="favco-meta">✉ <?= htmlspecialchars($company['email_contact']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($company['phone_contact'])): ?>
                            <span class="favco-meta">✆ <?= htmlspecialchars($company['phone_contact']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($company['description'])): ?>
                    <p class="favco-desc">
                        <?= htmlspecialchars(mb_strimwidth($company['description'], 0, 120, '...')) ?>
                    </p>
                <?php endif; ?>

                <div class="favco-card-footer">
                    <a href="/companies/show?id=<?= (int)$company['id'] ?>" class="favco-btn-see">
                        Voir les offres →
                    </a>
                    <form method="post" action="/favorite-companies/toggle" style="margin:0">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                        <input type="hidden" name="company_id" value="<?= (int)$company['id'] ?>">
                        <button type="submit" class="favco-btn-remove" title="Retirer des favoris">✕</button>
                    </form>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.favco-header { margin-bottom: 24px; }
.favco-header h1 { font-size: 1.5rem; font-weight: 900; color: #161b26; margin-bottom: 4px; }
.favco-sub { color: #667085; font-size: 0.95rem; }

.favco-empty { text-align: center; padding: 60px 20px; }
.favco-empty-icon { font-size: 3rem; margin-bottom: 16px; }
.favco-empty p { color: #667085; margin-bottom: 16px; }
.favco-browse-btn { display: inline-block; padding: 10px 24px; background: #d71920; color: #fff; border-radius: 10px; text-decoration: none; font-weight: 700; }
.favco-browse-btn:hover { background: #b5141a; }

.favco-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }

.favco-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 2px 8px rgba(15,23,42,0.04); transition: border-color 0.15s, transform 0.2s, box-shadow 0.2s; }
.favco-card:hover { border-color: #d71920; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(15,23,42,0.08); }

.favco-card-top { display: flex; align-items: flex-start; gap: 12px; }
.favco-avatar { width: 44px; height: 44px; border-radius: 12px; background: #d71920; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; flex-shrink: 0; }
.favco-info { flex: 1; }
.favco-name { font-weight: 700; color: #161b26; text-decoration: none; font-size: 1rem; display: block; margin-bottom: 4px; }
.favco-name:hover { color: #d71920; }
.favco-meta { display: block; font-size: 0.8rem; color: #667085; margin-top: 2px; }

.favco-desc { font-size: 0.85rem; color: #667085; line-height: 1.5; flex: 1; }

.favco-card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: auto; padding-top: 10px; border-top: 1px solid #f3f4f6; }
.favco-btn-see { color: #d71920; font-weight: 700; text-decoration: none; font-size: 0.88rem; }
.favco-btn-see:hover { text-decoration: underline; }
.favco-btn-remove { width: 32px; height: 32px; border-radius: 50%; border: 1px solid #fecaca; background: #fef2f2; color: #d71920; font-weight: 700; cursor: pointer; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; }
.favco-btn-remove:hover { background: #fee2e2; }
</style>