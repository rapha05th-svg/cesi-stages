<a href="/admin" class="admin-back">← Retour dashboard</a>

<div class="admin-page-header">
    <h1 class="admin-page-title">Gestion des pilotes</h1>
    <a href="/admin/pilots/create" class="admin-btn-create">+ Nouveau pilote</a>
</div>

<form method="get" action="/admin/pilots" class="admin-search-form no-validate">
    <input type="text" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Rechercher un pilote..." class="admin-search-input">
    <button type="submit" class="admin-search-btn">Rechercher</button>
</form>

<?php if (empty($pilots)): ?>
    <div class="admin-table-wrap"><p class="admin-empty">Aucun pilote trouvé.</p></div>
<?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pilots as $pilot): ?>
                <tr>
                    <td style="color:#9ca3af"><?= (int)$pilot['id'] ?></td>
                    <td><strong><?= htmlspecialchars($pilot['lastname']) ?></strong></td>
                    <td><?= htmlspecialchars($pilot['firstname']) ?></td>
                    <td><?= htmlspecialchars($pilot['email']) ?></td>
                    <td>
                        <div class="admin-actions">
                            <a href="/admin/pilots/edit?id=<?= (int)$pilot['id'] ?>" class="admin-btn-edit">Modifier</a>
                            <a href="/admin/users/reset-password?user_id=<?= (int)$pilot['user_id'] ?>" class="admin-btn-reset">Réinitialiser mdp</a>
                            <form method="post" action="/admin/pilots/delete" class="no-validate" style="margin:0">
                                <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                <input type="hidden" name="id" value="<?= (int)$pilot['id'] ?>">
                                <input type="hidden" name="user_id" value="<?= (int)$pilot['user_id'] ?>">
                                <button type="submit" class="admin-btn-delete" onclick="return confirm('Supprimer ce pilote ?')">Supprimer</button>
                            </form>
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