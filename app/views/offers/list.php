<div class="offers-page-header anim-fade-up">
    <h1>Offres de stage</h1>
    <p class="offers-page-sub"><?= (int)($total ?? 0) ?> offre<?= ($total ?? 0) > 1 ? 's' : '' ?> disponible<?= ($total ?? 0) > 1 ? 's' : '' ?></p>
</div>

<div class="offers-filters anim-fade-up anim-delay-1">
    <form method="get" action="/offers" class="offers-filter-form">

        <div class="filter-group">
            <input
                type="text"
                name="q"
                value="<?= htmlspecialchars($q ?? '') ?>"
                placeholder="Rechercher par titre ou description..."
                class="filter-input filter-input-wide"
            >
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
.offers-page-header { margin-bottom: 20px; }
.offers-page-header h1 { font-size: 1.5rem; font-weight: 900; color: #161b26; margin-bottom: 4px; }
.offers-page-sub { color: #667085; font-size: 0.9rem; }

.offers-filters { margin-bottom: 20px; }
.offers-filter-form { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
.filter-group { display: flex; }
.filter-input { padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; outline: none; background: #fff; }
.filter-input:focus { border-color: #d71920; }
.filter-input-wide { min-width: 240px; flex: 1; }
.filter-select { padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; background: #fff; cursor: pointer; outline: none; }
.filter-select:focus { border-color: #d71920; }
.filter-btn-submit { padding: 10px 22px; background: #d71920; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 0.9rem; white-space: nowrap; }
.filter-btn-submit:hover { background: #b5141a; transform: none; }
.filter-btn-reset { padding: 10px 14px; background: #f3f4f6; color: #667085; border-radius: 10px; text-decoration: none; font-size: 0.88rem; white-space: nowrap; }
.filter-btn-reset:hover { background: #e5e7eb; }

.offers-empty { text-align: center; padding: 40px; color: #667085; }

.offer-item-clean { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 16px 20px; background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; margin-bottom: 10px; box-shadow: 0 2px 6px rgba(15,23,42,0.04); }
.offer-item-clean:hover { border-color: #d71920; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(15,23,42,0.08); }
.offer-item-main { flex: 1; }
.offer-link-clean { font-weight: 700; color: #161b26; text-decoration: none; font-size: 1rem; display: block; margin-bottom: 3px; }
.offer-link-clean:hover { color: #d71920; }
.offer-company-clean { font-size: 0.85rem; color: #667085; font-weight: 600; }
.offer-item-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 5px; }
.offer-meta-chip { font-size: 0.78rem; padding: 3px 9px; border-radius: 20px; background: #f3f4f6; color: #374151; white-space: nowrap; }
.offer-salary { background: #EAF3DE; color: #27500A; }
.offer-date-chip { background: #E6F1FB; color: #185FA5; }

.offer-item-right { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
.offer-apps-badge { font-size: 0.8rem; color: #667085; background: #f3f4f6; padding: 3px 8px; border-radius: 20px; }
.offer-date { font-size: 0.8rem; color: #9ca3af; white-space: nowrap; }
.btn-see-offer { padding: 7px 16px; background: #d71920; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 0.85rem; white-space: nowrap; }
.btn-see-offer:hover { background: #b5141a; text-decoration: none; }

.offers-pagination { display: flex; gap: 6px; justify-content: center; margin-top: 24px; flex-wrap: wrap; }
.page-link { padding: 8px 14px; border: 1px solid #e5e7eb; border-radius: 8px; color: #374151; text-decoration: none; font-size: 0.9rem; }
.page-link:hover { border-color: #d71920; color: #d71920; }
.page-link.active { background: #d71920; color: #fff; border-color: #d71920; }
</style>