<?php $base = App::config()['app']['base_path'] ?? ''; ?>

<h2>Mes favoris</h2>

<?php if (empty($offers)): ?>
    <p>Aucune offre en favori.</p>
<?php else: ?>
    <ul>
        <?php foreach ($offers as $offer): ?>
            <li>
                <a href="<?= htmlspecialchars($base) ?>/offers/show?id=<?= (int) $offer['id'] ?>">
                    <?= htmlspecialchars($offer['title']) ?>
                </a>
                <?php if (!empty($offer['company_name'])): ?>
                    (<?= htmlspecialchars($offer['company_name']) ?>)
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>