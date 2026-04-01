<div class="offers-page-header anim-fade-up">
    <h1>Offres de stage</h1>
    <p class="offers-page-sub"><?= (int)($total ?? 0) ?> offre<?= ($total ?? 0) > 1 ? 's' : '' ?> disponible<?= ($total ?? 0) > 1 ? 's' : '' ?></p>
</div>

<div class="offers-filters anim-fade-up anim-delay-1">
    <form method="get" action="/offers" class="offers-filter-form">

        <div class="filter-group">
            <div class="filter-search-wrap">
                <input
                    type="text"
                    name="q"
                    id="searchInput"
                    value="<?= htmlspecialchars($q ?? '') ?>"
                    placeholder="Rechercher par titre ou description..."
                    class="filter-input filter-input-wide"
                >
                <kbd class="filter-kbd">/</kbd>
            </div>
        </div>

        <div class="filter-group">
            <select name="company_id" class="filter-select">
                <option value="0">Toutes les entreprises</option>
                <?php foreach ($companies as $c): ?>
                    <option value="<?= (int)$c['id'] ?>" <?= ((int)($companyId ?? 0) === (int)$c['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <select name="sort" class="filter-select">
                <option value="newest" <?= ($sort ?? 'newest') === 'newest' ? 'selected' : '' ?>>Plus récentes</option>
                <option value="oldest" <?= ($sort ?? '') === 'oldest' ? 'selected' : '' ?>>Plus anciennes</option>
                <option value="popular" <?= ($sort ?? '') === 'popular' ? 'selected' : '' ?>>Plus populaires</option>
            </select>
        </div>

        <div class="filter-group">
            <select name="salary_min" class="filter-select">
                <option value="0">Toute rémunération</option>
                <option value="500" <?= ((int)($salaryMin ?? 0) === 500) ? 'selected' : '' ?>>500€+ /mois</option>
                <option value="700" <?= ((int)($salaryMin ?? 0) === 700) ? 'selected' : '' ?>>700€+ /mois</option>
                <option value="900" <?= ((int)($salaryMin ?? 0) === 900) ? 'selected' : '' ?>>900€+ /mois</option>
                <option value="1200" <?= ((int)($salaryMin ?? 0) === 1200) ? 'selected' : '' ?>>1200€+ /mois</option>
            </select>
        </div>

        <button type="submit" class="filter-btn-submit">Filtrer</button>

        <?php if (!empty($q) || !empty($companyId) || ($sort ?? 'newest') !== 'newest' || !empty($salaryMin)): ?>
            <a href="/offers" class="filter-btn-reset">✕ Réinitialiser</a>
        <?php endif; ?>

    </form>
</div>

<?php if (empty($offers)): ?>
    <div class="offers-empty anim-fade-up">
        <p>Aucune offre ne correspond à votre recherche.</p>
        <a href="/offers" class="btn btn-primary">Voir toutes les offres</a>
    </div>
<?php else: ?>
    <div class="offers-list-clean">
        <?php foreach ($offers as $i => $offer): ?>
            <div class="offer-item-clean anim-fade-up anim-delay-<?= min($i + 1, 5) ?>">
                <div class="offer-item-main">
                    <a href="/offers/show?id=<?= (int)$offer['id'] ?>" class="offer-link-clean">
                        <?= htmlspecialchars($offer['title']) ?>
                    </a>
                    <div class="offer-item-meta">
                        <span class="offer-company-clean"><?= htmlspecialchars($offer['company_name'] ?? 'Entreprise inconnue') ?></span>
                        <?php if (!empty($offer['salary'])): ?>
                            <span class="offer-meta-chip offer-salary">💶 <?= number_format((float)$offer['salary'], 0, ',', ' ') ?> €/mois</span>
                        <?php endif; ?>
                        <?php if (!empty($offer['start_date'])): ?>
                            <span class="offer-meta-chip offer-date-chip">📅 Dès le <?= date('d/m/Y', strtotime($offer['start_date'])) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($offer['apps_count'])): ?>
                            <span class="offer-meta-chip">👥 <?= (int)$offer['apps_count'] ?> candidature<?= (int)$offer['apps_count'] > 1 ? 's' : '' ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="offer-item-right">
                    <a href="/offers/show?id=<?= (int)$offer['id'] ?>" class="btn-see-offer">Voir →</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (($totalPages ?? 1) > 1): ?>
        <div class="offers-pagination">
            <?php
            $params = [];
            if (!empty($q)) $params['q'] = $q;
            if (!empty($companyId)) $params['company_id'] = $companyId;
            if (!empty($sort) && $sort !== 'newest') $params['sort'] = $sort;

            for ($i = 1; $i <= $totalPages; $i++):
                $params['page'] = $i;
                $url = '/offers?' . http_build_query($params);
            ?>
                <a href="<?= htmlspecialchars($url) ?>"
                   class="page-link <?= ($i === ($currentPage ?? 1)) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<style>
/* ── SEARCH WRAP ─────────────────────────────────────────── */
.filter-search-wrap { position: relative; display: flex; align-items: center; }
.filter-search-wrap .filter-input { padding-right: 36px; }
.filter-kbd {
    position: absolute; right: 10px;
    font-size: 0.7rem; font-weight: 700;
    padding: 2px 6px; border-radius: 5px;
    background: #f3f4f6; color: #9ca3af;
    border: 1px solid #e5e7eb;
    pointer-events: none;
    font-family: inherit;
    transition: opacity 0.2s;
}
.filter-search-wrap:focus-within .filter-kbd { opacity: 0; }
[data-theme="dark"] .filter-kbd { background: var(--dk-surface2); color: var(--dk-muted); border-color: var(--dk-border); }

/* ── EN-TÊTE ─────────────────────────────────────────────── */
.offers-page-header { margin-bottom: 24px; }
.offers-page-header h1 { font-size: 1.7rem; font-weight: 900; color: #111827; margin: 0 0 4px; letter-spacing: -0.02em; }
.offers-page-sub { color: #6b7280; font-size: 0.9rem; margin: 0; }

/* ── FILTRES ─────────────────────────────────────────────── */
.offers-filters {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 22px;
    box-shadow: 0 1px 4px rgba(15,23,42,0.04);
}
.offers-filter-form { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
.filter-group { display: flex; }
.filter-input, .filter-select {
    padding: 9px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.88rem;
    background: #f9fafb;
    outline: none;
    transition: border-color 0.15s, background 0.15s;
    font-family: inherit;
    color: #111827;
}
.filter-input:focus, .filter-select:focus { border-color: #d71920; background: #fff; }
.filter-input-wide { min-width: 220px; }
.filter-select { cursor: pointer; }
.filter-btn-submit {
    padding: 9px 22px; background: #d71920; color: #fff;
    border: none; border-radius: 10px; font-weight: 700;
    cursor: pointer; font-size: 0.88rem; white-space: nowrap;
    box-shadow: 0 2px 8px rgba(215,25,32,0.2);
}
.filter-btn-submit:hover { background: #b5141a; transform: none; box-shadow: 0 4px 12px rgba(215,25,32,0.3); }
.filter-btn-reset {
    padding: 9px 14px; background: #f3f4f6; color: #6b7280;
    border-radius: 10px; text-decoration: none; font-size: 0.85rem;
    white-space: nowrap; font-weight: 500;
}
.filter-btn-reset:hover { background: #e5e7eb; color: #374151; text-decoration: none; }

/* ── LISTE DES OFFRES ────────────────────────────────────── */
.offers-empty {
    text-align: center; padding: 60px 20px; color: #9ca3af;
    background: #fff; border: 1px solid #e5e7eb; border-radius: 16px;
    font-style: italic;
}

.offer-item-clean {
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; padding: 18px 22px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-left: 4px solid #e5e7eb;
    border-radius: 14px;
    margin-bottom: 10px;
    box-shadow: 0 1px 4px rgba(15,23,42,0.04);
    transition: border-color 0.15s, box-shadow 0.15s, transform 0.15s;
    text-decoration: none;
}
.offer-item-clean:hover {
    border-color: #d71920;
    border-left-color: #d71920;
    transform: translateX(3px);
    box-shadow: 0 4px 16px rgba(215,25,32,0.08);
}
.offer-item-main { flex: 1; min-width: 0; }
.offer-link-clean {
    font-weight: 700; color: #111827; text-decoration: none;
    font-size: 0.98rem; display: block; margin-bottom: 4px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.offer-item-clean:hover .offer-link-clean { color: #d71920; }
.offer-company-clean {
    font-size: 0.8rem; color: #d71920; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.04em;
}
.offer-item-meta { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-top: 6px; }
.offer-meta-chip {
    font-size: 0.75rem; padding: 3px 10px; border-radius: 20px;
    font-weight: 600; white-space: nowrap;
    background: #f3f4f6; color: #4b5563;
}
.offer-salary { background: #ecfdf5; color: #065f46; }
.offer-date-chip { background: #eff6ff; color: #1e40af; }
.offer-apps-chip { background: #f5f3ff; color: #5b21b6; }

.offer-item-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.btn-see-offer {
    padding: 8px 18px; background: #111827; color: #fff;
    border-radius: 8px; text-decoration: none; font-weight: 700;
    font-size: 0.82rem; white-space: nowrap; letter-spacing: 0.01em;
    transition: background 0.15s;
}
.btn-see-offer:hover { background: #d71920; text-decoration: none; }

/* ── PAGINATION ──────────────────────────────────────────── */
.offers-pagination {
    display: flex; gap: 6px; justify-content: center;
    margin-top: 28px; flex-wrap: wrap;
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