<?php $base = App::config()['app']['base_path'] ?? ''; ?>

<h2>Entreprises</h2>

<form method="get" action="<?= htmlspecialchars($base) ?>/companies" style="margin-bottom:20px;">
    <input type="text" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Rechercher une entreprise">
    <button type="submit" class="btn-small btn-secondary">Rechercher</button>
</form>

<?php if (empty($companies)): ?>
    <p>Aucune entreprise trouvée.</p>
<?php else: ?>

    <?php foreach ($companies as $company): ?>
        <div class="company-row">

            <h3><?= htmlspecialchars($company['name']) ?></h3>

            <p class="text-muted">
                <?= htmlspecialchars($company['description'] ?? '') ?>
            </p>

            <p>
                <strong>Note :</strong>
                <?= $company['avg_rating'] !== null
                    ? number_format($company['avg_rating'], 1) . ' / 5'
                    : 'N/A' ?>
            </p>

            <div class="company-actions">

                <form method="post" action="<?= htmlspecialchars($base) ?>/favorite-companies/toggle">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                    <input type="hidden" name="company_id" value="<?= (int) $company['id'] ?>">

                    <button type="submit" class="btn-small btn-favorite">
                        💗 Favori
                    </button>
                </form>

                <a href="<?= htmlspecialchars($base) ?>/companies/show?id=<?= (int) $company['id'] ?>"
                   class="btn-small btn-secondary">
                    Voir
                </a>

            </div>

        </div>
    <?php endforeach; ?>

    <?php if (isset($p) && $p->pages() > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $p->pages(); $i++): ?>
                <a
                    href="<?= htmlspecialchars($base) ?>/companies?q=<?= urlencode($q ?? '') ?>&page=<?= $i ?>"
                    class="<?= $i == ($p->page ?? 1) ? 'active' : '' ?>"
                >
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

<?php endif; ?>