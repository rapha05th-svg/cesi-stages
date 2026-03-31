<a href="/admin" class="admin-back">← Retour dashboard</a>

<div class="admin-page-header">
    <h1 class="admin-page-title">Gestion des offres</h1>
    <a href="/admin/offers/create" class="admin-btn-create">+ Nouvelle offre</a>
</div>

<form method="get" action="/admin/offers" class="admin-search-form no-validate">
    <input type="text" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Rechercher une offre..." class="admin-search-input">
    <button type="submit" class="admin-search-btn">Rechercher</button>
</form>

<?php if (empty($offers)): ?>
    <div class="admin-table-wrap"><p class="admin-empty">Aucune offre trouvée.</p></div>
<?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Entreprise</th>
                    <th>Rémunération</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($offers as $offer): ?>
                <tr>
                    <td style="color:#9ca3af"><?= (int)$offer['id'] ?></td>
                    <td><strong><?= htmlspecialchars($offer['title']) ?></strong></td>
                    <td><?= htmlspecialchars($offer['company_name'] ?? '—') ?></td>
                    <td><?= isset($offer['salary']) && $offer['salary'] !== null ? number_format((float)$offer['salary'], 0, ',', ' ') . ' €/mois' : '—' ?></td>
                    <td><?= !empty($offer['is_active']) ? '<span class="badge-active">Active</span>' : '<span class="badge-inactive">Inactive</span>' ?></td>
                    <td>
                        <div class="admin-actions">
                            <a href="/admin/offers/edit?id=<?= (int)$offer['id'] ?>" class="admin-btn-edit">Modifier</a>
                            <?php if (!empty($offer['is_active'])): ?>
                                <form method="post" action="/admin/offers/delete" class="no-validate" style="margin:0">
                                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                    <input type="hidden" name="id" value="<?= (int)$offer['id'] ?>">
                                    <button type="submit" class="admin-btn-delete" onclick="return confirm('Désactiver cette offre ?')">Supprimer</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php if (isset($totalPages) && $totalPages > 1): ?>
    <div class="admin-pagination">
        <span class="admin-pagination-info">
            <?= isset($total) ? $total : 0 ?> résultat<?= (isset($total) && $total > 1) ? 's' : '' ?>
        </span>
        <div class="admin-pagination-links">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?q=<?= urlencode(isset($q) ? $q : '') ?>&page=<?= $i ?>"
                   class="admin-page-btn <?= $i === (isset($currentPage) ? $currentPage : 1) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
<?php endif; ?>
<?php endif; ?>