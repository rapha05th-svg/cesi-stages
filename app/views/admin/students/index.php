<a href="/admin" class="admin-back">← Retour dashboard</a>

<div class="admin-page-header">
    <h1 class="admin-page-title">Gestion des étudiants</h1>
    <a href="/admin/students/create" class="admin-btn-create">+ Nouvel étudiant</a>
</div>

<form method="get" action="/admin/students" class="admin-search-form no-validate">
    <input type="text" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Rechercher un étudiant..." class="admin-search-input">
    <button type="submit" class="admin-search-btn">Rechercher</button>
</form>

<?php if (empty($students)): ?>
    <div class="admin-table-wrap"><p class="admin-empty">Aucun étudiant trouvé.</p></div>
<?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Pilote</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td style="color:#9ca3af"><?= (int)$student['id'] ?></td>
                    <td><strong><?= htmlspecialchars($student['lastname']) ?></strong></td>
                    <td><?= htmlspecialchars($student['firstname']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td>
                        <?= !empty($student['pilot_firstname']) || !empty($student['pilot_lastname'])
                            ? htmlspecialchars(trim(($student['pilot_firstname'] ?? '') . ' ' . ($student['pilot_lastname'] ?? '')))
                            : '<span style="color:#9ca3af">Aucun</span>' ?>
                    </td>
                    <td>
                        <div class="admin-actions">
                            <a href="/admin/students/edit?id=<?= (int)$student['id'] ?>" class="admin-btn-edit">Modifier</a>
                            <a href="/admin/users/reset-password?user_id=<?= (int)$student['user_id'] ?>" class="admin-btn-reset">Réinitialiser mdp</a>
                            <form method="post" action="/admin/students/delete" class="no-validate" style="margin:0">
                                <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                <input type="hidden" name="id" value="<?= (int)$student['id'] ?>">
                                <input type="hidden" name="user_id" value="<?= (int)$student['user_id'] ?>">
                                <button type="submit" class="admin-btn-delete" onclick="return confirm('Supprimer cet étudiant ?')">Supprimer</button>
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