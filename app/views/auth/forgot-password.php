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

        <div style="text-align:center;margin-top:20px;padding-top:20px;border-top:1px solid #f3f4f6;">
            <a href="/login" style="font-size:0.85rem;color:#667085;text-decoration:none;">
                &larr; Retour à la connexion
            </a>
        </div>

    </div>
</div>
