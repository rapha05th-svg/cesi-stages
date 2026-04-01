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
                <div class="company-card-header">
                    <div class="company-card-avatar">
                        <?= strtoupper(substr($company['name'], 0, 2)) ?>
                    </div>
                    <div class="company-card-info">
                        <a href="/companies/show?id=<?= (int)$company['id'] ?>" class="company-card-name">
                            <?= htmlspecialchars($company['name']) ?>
                        </a>
                        <div class="company-card-stars">
                            <?php $avg = round((float)($company['avg_rating'] ?? 0)); ?>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="<?= $i <= $avg ? 'star-on' : 'star-off' ?>">★</span>
                            <?php endfor; ?>
                            <?php if (!empty($company['avg_rating'])): ?>
                                <span class="star-val"><?= number_format((float)$company['avg_rating'], 1) ?>/5</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="company-card-body">
                    <p class="company-card-desc">
                        <?= !empty($company['description'])
                            ? htmlspecialchars(mb_strimwidth($company['description'], 0, 110, '…'))
                            : '<span style="color:#d1d5db;font-style:italic">Aucune description disponible.</span>' ?>
                    </p>
                </div>

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
/* ── BARRE DE RECHERCHE ──────────────────────────────────── */
.companies-search-bar { margin-bottom: 26px; }
.companies-search-form {
    display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
    background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
    padding: 12px 16px; box-shadow: 0 1px 4px rgba(15,23,42,0.04);
}
.search-input {
    flex: 1; min-width: 200px;
    padding: 9px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px;
    font-size: 0.9rem; outline: none; background: #f9fafb;
    transition: border-color 0.15s, background 0.15s; font-family: inherit;
}
.search-input:focus { border-color: #d71920; background: #fff; }
.btn-search {
    padding: 9px 22px; background: #d71920; color: #fff;
    border: none; border-radius: 10px; font-weight: 700; cursor: pointer;
    font-size: 0.88rem; box-shadow: 0 2px 8px rgba(215,25,32,0.2);
    transition: background 0.15s;
}
.btn-search:hover { background: #b5141a; transform: none; box-shadow: none; }
.btn-reset {
    padding: 9px 14px; background: #f3f4f6; color: #6b7280;
    border-radius: 10px; text-decoration: none; font-size: 0.85rem; font-weight: 500;
}
.btn-reset:hover { background: #e5e7eb; text-decoration: none; }
.search-count { font-size: 0.85rem; color: #9ca3af; margin: 6px 0 0; }

/* ── GRILLE ──────────────────────────────────────────────── */
.companies-empty {
    text-align: center; padding: 60px 20px; color: #9ca3af;
    background: #fff; border: 1px solid #e5e7eb; border-radius: 16px;
    font-style: italic;
}
.companies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    gap: 18px; margin-bottom: 28px;
}

/* ── CARTE ENTREPRISE ────────────────────────────────────── */
.company-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 18px;
    padding: 0;
    display: flex; flex-direction: column;
    box-shadow: 0 2px 10px rgba(15,23,42,0.05);
    transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    overflow: hidden;
}
.company-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(215,25,32,0.10);
    border-color: #fca5a5;
}

.company-card-header {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    padding: 20px 20px 16px;
    display: flex; align-items: center; gap: 14px;
}
.company-card-avatar {
    width: 48px; height: 48px; border-radius: 14px;
    background: linear-gradient(135deg, #d71920 0%, #ff4d55 100%);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-weight: 900; font-size: 1rem; flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(215,25,32,0.35);
    letter-spacing: -0.02em;
}
.company-card-info { flex: 1; min-width: 0; }
.company-card-name {
    font-weight: 800; color: #fff; text-decoration: none;
    font-size: 0.97rem; display: block;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    letter-spacing: -0.01em;
}
.company-card-name:hover { color: #fca5a5; text-decoration: none; }
.company-card-stars { display: flex; align-items: center; gap: 2px; margin-top: 5px; }
.star-on { color: #fbbf24; font-size: 0.82rem; }
.star-off { color: rgba(255,255,255,0.2); font-size: 0.82rem; }
.star-val { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-left: 5px; }

.company-card-body { padding: 16px 20px; flex: 1; }
.company-card-desc {
    font-size: 0.84rem; color: #6b7280; line-height: 1.55; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}

.company-card-footer {
    padding: 12px 20px 16px;
    display: flex; align-items: center;
    justify-content: space-between; gap: 10px;
    border-top: 1px solid #f3f4f6;
}
.company-card-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 8px 16px; background: #d71920; color: #fff;
    border-radius: 8px; font-weight: 700; text-decoration: none;
    font-size: 0.82rem; transition: background 0.15s;
}
.company-card-btn:hover { background: #b5141a; text-decoration: none; }
.company-fav-btn {
    background: none; border: 1.5px solid #e5e7eb;
    width: 34px; height: 34px; border-radius: 8px;
    font-size: 1rem; cursor: pointer; color: #d1d5db;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s; padding: 0; box-shadow: none;
}
.company-fav-btn:hover { border-color: #d71920; color: #d71920; transform: none; box-shadow: none; }

/* ── PAGINATION ──────────────────────────────────────────── */
.offers-pagination {
    display: flex; gap: 6px; justify-content: center; margin-top: 8px; flex-wrap: wrap;
}
.page-link {
    min-width: 38px; height: 38px; padding: 0 10px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1.5px solid #e5e7eb; border-radius: 8px;
    color: #374151; text-decoration: none; font-size: 0.88rem; font-weight: 600;
    transition: all 0.15s;
}
.page-link:hover { border-color: #d71920; color: #d71920; text-decoration: none; }
.page-link.active { background: #d71920; color: #fff; border-color: #d71920; }
</style>