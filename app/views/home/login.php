<h1>Connexion</h1>
<form method="post" action="<?= (App::config()['app']['base_path'] ?? '') ?>/login" class="card form">
  <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
  <label>Email
    <input required type="email" name="email" placeholder="etu@demo.local">
  </label>
  <label>Mot de passe
    <input required type="password" name="password" placeholder="Password123!">
  </label>
  <button class="btn" type="submit">Se connecter</button>
  <p class="muted">Comptes demo : admin@demo.local / pilot@demo.local / etu@demo.local</p>
</form>
