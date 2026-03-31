<div class="companies-search-bar">
    <form method="get" action="/companies" class="companies-search-form">
        <input
            type="text"
            name="q"
            value="<?= htmlspecialchars($q ?? '') ?>"
            placeholder="Rechercher une entreprise..."
            class="search-input"
        >
        <button type="submit" class="btn-search">Rechercher</button>
        <?php if (!empty($q)): ?>
            <a href="/companies" class="btn-reset">Réinitialiser</a>
        <?php endif; ?>
    </form>
    <?php if (!empty($q)): ?>
        <p class="search-count"><?= $p->total ?? 0 ?> résultat<?= ($p->total ?? 0) > 1 ? 's' : '' ?> pour "<?= htmlspecialchars($q) ?>"</p>
    <?php endif; ?>
</div>

<?php if (empty($companies)): ?>
    <div class="companies-empty">
        <p>Aucune entreprise trouvée.</p>
        <a href="/companies" class="btn btn-primary">Voir toutes les entreprises</a>
    </div>
<?php else: ?>
    <div class="companies-grid">
        <?php foreach ($companies as $company): ?>
            <div class="company-card">
                <div class="company-card-top">
                    <div class="company-card-avatar">
                        <?= strtoupper(substr($company['name'], 0, 2)) ?>
                    </div>
                    <div class="company-card-info">
                        <a href="/companies/show?id=<?= (int)$company['id'] ?>" class="company-card-name">
                            <?= htmlspecialchars($company['name']) ?>
                        </a>
                        <?php if (!empty($company['avg_rating'])): ?>
                            <div class="company-card-stars">
                                <?php $avg = round((float)$company['avg_rating']); ?>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="<?= $i <= $avg ? 'star-on' : 'star-off' ?>">★</span>
                                <?php endfor; ?>
                                <span class="star-val"><?= number_format((float)$company['avg_rating'], 1) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($company['description'])): ?>
                    <p class="company-card-desc">
                        <?= htmlspecialchars(mb_strimwidth($company['description'], 0, 100, '...')) ?>
                    </p>
                <?php endif; ?>

                <div class="company-card-footer">
                    <a href="/companies/show?id=<?= (int)$company['id'] ?>" class="company-card-btn">
                        Voir les offres →
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <form method="post" action="/favorite-companies/toggle" style="margin:0">
                            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                            <input type="hidden" name="company_id" value="<?= (int)$company['id'] ?>">
                            <button type="submit" class="company-fav-btn">♡</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($p) && $p->pages() > 1): ?>
        <div class="offers-pagination">
            <?php for ($i = 1; $i <= $p->pages(); $i++): ?>
                <a href="/companies?q=<?= urlencode($q ?? '') ?>&page=<?= $i ?>"
                   class="page-link <?= $i == $p->page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<style>
.companies-search-bar { margin-bottom: 24px; }
.companies-search-form { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 8px; }
.search-input { flex: 1; min-width: 200px; padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 10px; font-size: 0.95rem; outline: none; }
.search-input:focus { border-color: #d71920; }
.btn-search { padding: 10px 22px; background: #d71920; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; }
.btn-search:hover { background: #b5141a; }
.btn-reset { padding: 10px 16px; background: #f3f4f6; color: #667085; border-radius: 10px; text-decoration: none; font-size: 0.9rem; }
.search-count { font-size: 0.88rem; color: #667085; }
.companies-empty { text-align: center; padding: 40px; color: #667085; }

.companies-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; margin-bottom: 24px; }

.company-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 18px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 2px 8px rgba(15,23,42,0.04); transition: border-color 0.15s; }
.company-card:hover { border-color: #d71920; }

.company-card-top { display: flex; align-items: center; gap: 12px; }
.company-card-avatar { width: 44px; height: 44px; border-radius: 12px; background: #d71920; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; flex-shrink: 0; }
.company-card-name { font-weight: 700; color: #161b26; text-decoration: none; font-size: 1rem; display: block; }
.company-card-name:hover { color: #d71920; }
.company-card-stars { display: flex; align-items: center; gap: 2px; margin-top: 3px; }
.star-on { color: #d71920; font-size: 0.85rem; }
.star-off { color: #e5e7eb; font-size: 0.85rem; }
.star-val { font-size: 0.78rem; color: #667085; margin-left: 4px; }

.company-card-desc { font-size: 0.85rem; color: #667085; line-height: 1.5; flex: 1; }

.company-card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
.company-card-btn { color: #d71920; font-weight: 700; text-decoration: none; font-size: 0.88rem; }
.company-card-btn:hover { text-decoration: underline; }
.company-fav-btn { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #d71920; padding: 0; }
</style>