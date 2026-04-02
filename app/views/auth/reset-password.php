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

        <div class="fp-back">
            <a href="/login" class="fp-back-link">&larr; Retour à la connexion</a>
        </div>

    </div>
</div>

<style>
.login-wrap { display: flex; justify-content: center; align-items: center; min-height: 60vh; }
.login-card { width: 100%; max-width: 440px; background: #fff; border: 1px solid #e5e7eb; border-radius: 24px; padding: 40px 36px; box-shadow: 0 4px 32px rgba(15,23,42,0.08); }
.login-title { font-size: 1.4rem; font-weight: 900; color: #d71920; margin-bottom: 6px; }
.login-sub { color: #667085; font-size: 0.9rem; margin-bottom: 28px; }
.login-form { display: flex; flex-direction: column; gap: 18px; }
.login-field { display: flex; flex-direction: column; gap: 6px; }
.login-label { font-weight: 600; font-size: 0.88rem; color: #374151; }
.login-input { padding: 12px 14px; border: 1px solid #e5e7eb; border-radius: 12px; font-size: 0.95rem; outline: none; transition: border-color 0.15s; width: 100%; box-sizing: border-box; background: #fff; }
.login-input:focus { border-color: #d71920; }
.login-password-wrap { position: relative; }
.login-password-wrap .login-input { padding-right: 44px; }
.login-eye { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none !important; border: none !important; cursor: pointer; font-size: 1rem; padding: 0; box-shadow: none !important; color: #9ca3af; width: auto; height: auto; border-radius: 0; }
.login-eye:hover { transform: translateY(-50%) !important; box-shadow: none !important; background: none !important; }
.login-submit { padding: 13px; background: #d71920; color: #fff; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; margin-top: 4px; }
.login-submit:hover { background: #b5141a; transform: none; box-shadow: none; }
.fp-back { text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #f3f4f6; }
.fp-back-link { font-size: 0.85rem; color: #667085; text-decoration: none; }
.fp-back-link:hover { color: #d71920; }

[data-theme="dark"] .login-card { background: var(--dk-surface); border-color: var(--dk-border); }
[data-theme="dark"] .login-title { color: #d71920; }
[data-theme="dark"] .login-sub { color: var(--dk-muted); }
[data-theme="dark"] .login-label { color: var(--dk-muted); }
[data-theme="dark"] .login-input { background: var(--dk-bg); border-color: var(--dk-border); color: var(--dk-text); }
[data-theme="dark"] .fp-back { border-top-color: var(--dk-border); }
[data-theme="dark"] .fp-back-link { color: var(--dk-muted); }
</style>

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
