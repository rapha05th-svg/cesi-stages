<?php $base = App::config()['app']['base_path'] ?? ''; ?>

<h2>Gestion des étudiants</h2>

<p><a href="<?= htmlspecialchars($base) ?>/admin">← Retour dashboard</a></p>
<p><a href="<?= htmlspecialchars($base) ?>/admin/students/create">Créer un étudiant</a></p>

<form method="get" action="<?= htmlspecialchars($base) ?>/admin/students">
    <input type="text" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Rechercher un étudiant">
    <button type="submit">Rechercher</button>
</form>

<?php if (empty($students)): ?>
    <p>Aucun étudiant trouvé.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
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
                    <td><?= (int) $student['id'] ?></td>
                    <td><?= htmlspecialchars($student['lastname']) ?></td>
                    <td><?= htmlspecialchars($student['firstname']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td>
                        <?= !empty($student['pilot_firstname']) || !empty($student['pilot_lastname'])
                            ? htmlspecialchars(trim(($student['pilot_firstname'] ?? '') . ' ' . ($student['pilot_lastname'] ?? '')))
                            : 'Aucun' ?>
                    </td>
                    <td>
                        <a href="<?= htmlspecialchars($base) ?>/admin/students/edit?id=<?= (int) $student['id'] ?>">Modifier</a>
                        |
                        <a href="<?= htmlspecialchars($base) ?>/admin/users/reset-password?user_id=<?= (int) $student['user_id'] ?>">Réinitialiser mot de passe</a>
                        |
                        <form method="post" action="<?= htmlspecialchars($base) ?>/admin/students/delete" style="display:inline;">
                            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                            <input type="hidden" name="id" value="<?= (int) $student['id'] ?>">
                            <input type="hidden" name="user_id" value="<?= (int) $student['user_id'] ?>">
                            <button type="submit" onclick="return confirm('Confirmer la suppression ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>