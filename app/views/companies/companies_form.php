<h1><?= $mode==='create' ? 'Créer' : 'Modifier' ?> entreprise</h1>
<form class="card form" method="post" action="<?= (App::config()['app']['base_path'] ?? '') ?>/admin/companies/<?= $mode==='create' ? 'create' : 'edit' ?>">
  <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
  <?php if ($mode==='edit'): ?>
    <input type="hidden" name="id" value="<?= (int)$company['id'] ?>">
  <?php endif; ?>

  <label>Nom
    <input required name="name" value="<?= htmlspecialchars($company['name'] ?? '') ?>">
  </label>

  <label>Description
    <textarea name="description"><?= htmlspecialchars($company['description'] ?? '') ?></textarea>
  </label>

  <label>Email contact
    <input type="email" name="email_contact" value="<?= htmlspecialchars($company['email_contact'] ?? '') ?>">
  </label>

  <label>Téléphone
    <input name="phone_contact" value="<?= htmlspecialchars($company['phone_contact'] ?? '') ?>">
  </label>

  <button class="btn" type="submit">Enregistrer</button>
</form>

<?php if ($mode==='edit'): ?>
  <form method="post" action="<?= (App::config()['app']['base_path'] ?? '') ?>/admin/companies/delete" onsubmit="return confirm('Supprimer (désactiver) ?')">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
    <input type="hidden" name="id" value="<?= (int)$company['id'] ?>">
    <button class="btn danger" type="submit">Supprimer</button>
  </form>
<?php endif; ?>
