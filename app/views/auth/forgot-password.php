<div class="login-wrap">
    <div class="login-card">

        <h1 class="login-title">Mot de passe oublié</h1>
        <p class="login-sub">Saisissez votre adresse e-mail pour recevoir un lien de réinitialisation.</p>

        <form method="post" action="/forgot-password" class="login-form">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">

            <div class="login-field">
                <label class="login-label" for="email">Adresse e-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="login-input"
                    required
                    placeholder="votre@email.fr"
                    autocomplete="email"
                >
            </div>

            <button type="submit" class="login-submit">Envoyer le lien de réinitialisation</button>
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
