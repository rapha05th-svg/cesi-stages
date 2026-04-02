<div class="login-wrap">
    <div class="login-card">

        <div class="login-logo">
            <div class="login-logo-icon">
                <div class="logo-futur">
                    <span></span><span></span><span></span>
                </div>
            </div>
            <div class="login-logo-text">
                <span class="login-logo-title">CESI Stages</span>
                <span class="login-logo-sub">Plateforme de gestion des stages</span>
            </div>
        </div>

        <h1 class="login-title">Connexion</h1>
        <p class="login-sub">Accédez à votre espace personnel</p>

        <form method="post" action="/login" class="login-form">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">

            <div class="login-field">
                <label class="login-label" for="email">Adresse email</label>
                <input type="email" id="email" name="email" class="login-input" required placeholder="votre@email.fr" autocomplete="email">
            </div>

            <div class="login-field">
                <label class="login-label" for="password">Mot de passe</label>
                <div class="login-password-wrap">
                    <input type="password" id="password" name="password" class="login-input" required placeholder="••••••••" autocomplete="current-password">
                    <button type="button" class="login-eye" onclick="togglePwd()" aria-label="Afficher le mot de passe">👁</button>
                </div>
            </div>

            <button type="submit" class="login-submit">Se connecter</button>

            <div style="text-align:center;margin-top:4px;">
                <a href="/forgot-password" style="font-size:0.82rem;color:#667085;text-decoration:none;">
                    Mot de passe oublié ?
                </a>
            </div>
        </form>

        <div class="login-roles">
            <span class="login-role">Admin</span>
            <span class="login-role">Pilote</span>
            <span class="login-role">Étudiant</span>
        </div>

    </div>
</div>

<style>
.login-wrap { display: flex; justify-content: center; align-items: center; min-height: 60vh; }
.login-card { width: 100%; max-width: 440px; background: #fff; border: 1px solid #e5e7eb; border-radius: 24px; padding: 40px 36px; box-shadow: 0 4px 32px rgba(15,23,42,0.08); }

.login-logo { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; justify-content: center; }
.login-logo-icon { width: 46px; height: 46px; border-radius: 14px; background: #fff; border: 1px solid rgba(215,25,32,0.14); box-shadow: 0 8px 20px rgba(15,23,42,0.08); display: flex; align-items: center; justify-content: center; }
.login-logo-title { display: block; font-size: 1.1rem; font-weight: 900; color: #161b26; }
.login-logo-sub { display: block; font-size: 0.78rem; color: #667085; }

.login-title { font-size: 1.4rem; font-weight: 900; color: #161b26; text-align: center; margin-bottom: 6px; }
.login-sub { color: #667085; text-align: center; font-size: 0.9rem; margin-bottom: 28px; }

.login-form { display: flex; flex-direction: column; gap: 18px; }
.login-field { display: flex; flex-direction: column; gap: 6px; }
.login-label { font-weight: 600; font-size: 0.88rem; color: #374151; }
.login-input { padding: 12px 14px; border: 1px solid #e5e7eb; border-radius: 12px; font-size: 0.95rem; outline: none; transition: border-color 0.15s; width: 100%; box-sizing: border-box; }
.login-input:focus { border-color: #d71920; }

.login-password-wrap { position: relative; }
.login-password-wrap .login-input { padding-right: 44px; }
.login-eye { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none !important; border: none !important; cursor: pointer; font-size: 1rem; padding: 0; box-shadow: none !important; color: #9ca3af; width: auto; height: auto; border-radius: 0; }
.login-eye:hover { transform: translateY(-50%) !important; box-shadow: none !important; background: none !important; }

.login-submit { padding: 13px; background: #d71920; color: #fff; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; margin-top: 4px; }
.login-submit:hover { background: #b5141a; transform: none; box-shadow: none; }

.login-roles { display: flex; justify-content: center; gap: 8px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #f3f4f6; }
.login-role { padding: 4px 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 0.78rem; color: #667085; }
</style>

<script>
function togglePwd() {
    const input = document.getElementById('password');
    const btn = document.querySelector('.login-eye');
    if (input.type === 'password') { input.type = 'text'; btn.textContent = '🙈'; }
    else { input.type = 'password'; btn.textContent = '👁'; }
}
</script>