<a href="/admin" class="admin-back">← Retour dashboard</a>

<div class="admin-page-header">
    <h1 class="admin-page-title">Gestion des entreprises</h1>
    <a href="/admin/companies/create" class="admin-btn-create">+ Nouvelle entreprise</a>
</div>

<form method="get" action="/admin/companies" class="admin-search-form no-validate">
    <input type="text" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Rechercher une entreprise..." class="admin-search-input">
    <button type="submit" class="admin-search-btn">Rechercher</button>
</form>

<?php if (empty($companies)): ?>
    <div class="admin-table-wrap"><p class="admin-empty">Aucune entreprise trouvée.</p></div>
<?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($companies as $company): ?>
                <tr>
                    <td style="color:#9ca3af"><?= (int)$company['id'] ?></td>
                    <td><strong><?= htmlspecialchars($company['name']) ?></strong></td>
                    <td><?= htmlspecialchars($company['email'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($company['phone'] ?? '—') ?></td>
                    <td><?= !empty($company['is_active']) ? '<span class="badge-active">Active</span>' : '<span class="badge-inactive">Inactive</span>' ?></td>
                    <td>
                        <div class="admin-actions">
                            <a href="/admin/companies/edit?id=<?= (int)$company['id'] ?>" class="admin-btn-edit">Modifier</a>
                            <?php if (!empty($company['is_active'])): ?>
                                <form method="post" action="/admin/companies/delete" class="no-validate" style="margin:0">
                                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                    <input type="hidden" name="id" value="<?= (int)$company['id'] ?>">
                                    <button type="submit" class="admin-btn-delete" onclick="return confirm('Désactiver cette entreprise ?')">Supprimer</button>
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