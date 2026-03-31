<?php
$base  = App::config()['app']['base_path'] ?? '';
$token = htmlspecialchars($token ?? '');
?>
<div class="login-wrap">
    <div class="login-card">

        <h1 class="login-title">Nouveau mot de passe</h1>
        <p class="login-sub">Choisissez un nouveau mot de passe pour votre compte.</p>

        <form method="post" action="<?= $base ?>/reset-password" class="login-form" id="resetForm">
            <input type="hidden" name="_csrf"  value="<?= htmlspecialchars(Csrf::token()) ?>">
            <input type="hidden" name="token"  value="<?= $token ?>">

            <div class="login-field">
                <label class="login-label" for="new_password">Nouveau mot de passe</label>
                <div class="login-password-wrap">
                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        class="login-input"
                        required
                        minlength="8"
                        placeholder="••••••••"
                        autocomplete="new-password"
                    >
                    <button type="button" class="login-eye" onclick="togglePwd('new_password', this)" aria-label="Afficher le mot de passe">👁</button>
                </div>
                <span id="pwd-hint" style="font-size:0.8rem;color:#9ca3af;margin-top:4px;display:block;">
                    Au moins 8 caractères
                </span>
            </div>

            <div class="login-field">
                <label class="login-label" for="confirm_password">Confirmer le mot de passe</label>
                <div class="login-password-wrap">
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        class="login-input"
                        required
                        minlength="8"
                        placeholder="••••••••"
                        autocomplete="new-password"
                    >
                    <button type="button" class="login-eye" onclick="togglePwd('confirm_password', this)" aria-label="Afficher le mot de passe">👁</button>
                </div>
                <span id="confirm-hint" style="font-size:0.8rem;color:#9ca3af;margin-top:4px;display:block;"></span>
            </div>

            <button type="submit" class="login-submit" id="submitBtn">Réinitialiser le mot de passe</button>
        </form>

        <div style="text-align:center;margin-top:20px;padding-top:20px;border-top:1px solid #f3f4f6;">
            <a href="/login" style="font-size:0.85rem;color:#667085;text-decoration:none;">
                &larr; Retour à la connexion
            </a>
        </div>

    </div>
</div>

<script>
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    if (input.type === 'password') { input.type = 'text'; btn.textContent = '🙈'; }
    else { input.type = 'password'; btn.textContent = '👁'; }
}

(function () {
    const newPwd     = document.getElementById('new_password');
    const confirmPwd = document.getElementById('confirm_password');
    const hint       = document.getElementById('confirm-hint');
    const submitBtn  = document.getElementById('submitBtn');

    function validate() {
        if (confirmPwd.value === '') { hint.textContent = ''; return; }
        if (newPwd.value === confirmPwd.value) {
            hint.textContent = 'Les mots de passe correspondent ✓';
            hint.style.color = '#16a34a';
            confirmPwd.classList.remove('input-error');
        } else {
            hint.textContent = 'Les mots de passe ne correspondent pas';
            hint.style.color = '#d71920';
            confirmPwd.classList.add('input-error');
        }
    }

    newPwd.addEventListener('input', validate);
    confirmPwd.addEventListener('input', validate);

    document.getElementById('resetForm').addEventListener('submit', function (e) {
        if (newPwd.value !== confirmPwd.value) {
            e.preventDefault();
            confirmPwd.classList.add('input-error');
            hint.textContent = 'Les mots de passe ne correspondent pas';
            hint.style.color = '#d71920';
        }
    });
})();
</script>
