<?php $base = ''; ?>

<h1>Liste des offres</h1>

<?php if (empty($offers)): ?>
    <p>Aucune offre disponible.</p>
<?php else: ?>
    <div class="offers-list-clean">
        <?php foreach ($offers as $offer): ?>
            <div class="offer-item-clean">
                <div class="offer-item-main">
                    <a href="<?= htmlspecialchars($base) ?>/offers/show?id=<?= (int) $offer['id'] ?>" class="offer-link-clean">
                        <?= htmlspecialchars($offer['title']) ?>
                    </a>
                    <span class="offer-company-clean"> - <?= htmlspecialchars($offer['company_name'] ?? '') ?></span>
                </div>

                <a href="<?= htmlspecialchars($base) ?>/offers/show?id=<?= (int) $offer['id'] ?>" class="btn-see-offer">
                    Voir l'offre
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($totalPages) && $totalPages > 1): ?>
        <div class="offers-pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= htmlspecialchars($base) ?>/offers?page=<?= $i ?>" class="page-link"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>