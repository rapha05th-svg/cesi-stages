<?php $base = App::config()['app']['base_path'] ?? ''; ?>

<h2>Réinitialiser le mot de passe</h2>

<p><a href="<?= htmlspecialchars($base) ?>/admin">← Retour dashboard</a></p>

<p>
    <strong>Email :</strong>
    <?= htmlspecialchars($targetUser['email'] ?? '') ?>
</p>

<p>
    <strong>Rôle :</strong>
    <?= htmlspecialchars($targetUser['role'] ?? '') ?>
</p>

<form method="post" action="<?= htmlspecialchars($base) ?>/admin/users/reset-password">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
    <input type="hidden" name="user_id" value="<?= (int) ($targetUser['id'] ?? 0) ?>">

    <div style="margin-bottom: 16px;">
        <label for="new_password">Nouveau mot de passe</label><br>
        <div style="display:flex; gap:8px; align-items:center; margin-top:4px;">
            <input type="password" id="new_password" name="new_password" required minlength="8" style="padding:8px; min-width:260px;">
            <button type="button" onclick="togglePassword('new_password', this)">👁</button>
        </div>
    </div>

    <div style="margin-bottom: 16px;">
        <label for="confirm_password">Confirmer le nouveau mot de passe</label><br>
        <div style="display:flex; gap:8px; align-items:center; margin-top:4px;">
            <input type="password" id="confirm_password" name="confirm_password" required minlength="8" style="padding:8px; min-width:260px;">
            <button type="button" onclick="togglePassword('confirm_password', this)">👁</button>
        </div>
    </div>

    <button type="submit">Réinitialiser le mot de passe</button>
</form>

<script>
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);

    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = '🙈';
    } else {
        input.type = 'password';
        button.textContent = '👁';
    }
}
</script>