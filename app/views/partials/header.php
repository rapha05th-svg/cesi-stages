<header class="topbar">
  <div class="container topbar-inner">
    <a class="brand" href="<?= (App::config()['app']['base_path'] ?? '') ?>/">StageBoard</a>

    <button class="burger" aria-label="Menu" onclick="toggleMenu()">☰</button>

    <nav id="nav" class="nav">
      <a href="<?= (App::config()['app']['base_path'] ?? '') ?>/offers">Offres</a>
      <a href="<?= (App::config()['app']['base_path'] ?? '') ?>/companies">Entreprises</a>
      <a href="<?= (App::config()['app']['base_path'] ?? '') ?>/stats">Stats</a>
      <a href="<?= (App::config()['app']['base_path'] ?? '') ?>/mentions-legales">Mentions</a>

      <?php if (Auth::check() && Auth::role()==='ETUDIANT'): ?>
        <a href="<?= (App::config()['app']['base_path'] ?? '') ?>/wishlist">Wishlist</a>
        <a href="<?= (App::config()['app']['base_path'] ?? '') ?>/my-applications">Mes candidatures</a>
      <?php endif; ?>

      <?php if (Auth::check() && in_array(Auth::role(), ['ADMIN','PILOTE'], true)): ?>
        <a href="<?= (App::config()['app']['base_path'] ?? '') ?>/admin">Admin</a>
      <?php endif; ?>

      <?php if (!Auth::check()): ?>
        <a class="btn" href="<?= (App::config()['app']['base_path'] ?? '') ?>/login">Connexion</a>
      <?php else: ?>
        <form method="post" action="<?= (App::config()['app']['base_path'] ?? '') ?>/logout" class="inline">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
          <button class="btn" type="submit">Déconnexion</button>
        </form>
      <?php endif; ?>
    </nav>
  </div>
</header>
