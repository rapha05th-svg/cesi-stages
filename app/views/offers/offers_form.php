<h1><?= $mode==='create' ? 'Créer' : 'Modifier' ?> offre</h1>

<form class="card form" method="post" action="<?= (App::config()['app']['base_path'] ?? '') ?>/admin/offers/<?= $mode==='create' ? 'create' : 'edit' ?>">
  <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
  <?php if ($mode==='edit'): ?>
    <input type="hidden" name="id" value="<?= (int)$offer['id'] ?>">
  <?php endif; ?>

  <label>Entreprise
    <select name="company_id" required>
      <option value="">--</option>
      <?php foreach($companies as $c): ?>
        <option value="<?= (int)$c['id'] ?>" <?= (isset($offer['company_id']) && (int)$offer['company_id']===(int)$c['id']) ? 'selected':'' ?>>
          <?= htmlspecialchars($c['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>

  <label>Titre
    <input required name="title" value="<?= htmlspecialchars($offer['title'] ?? '') ?>">
  </label>

  <label>Description
    <textarea required name="description" minlength="20"><?= htmlspecialchars($offer['description'] ?? '') ?></textarea>
  </label>

  <label>Base rémunération
    <input name="remuneration_base" value="<?= htmlspecialchars($offer['remuneration_base'] ?? '') ?>">
  </label>

  <label>Date offre
    <input type="date" name="offer_date" value="<?= htmlspecialchars($offer['offer_date'] ?? date('Y-m-d')) ?>">
  </label>

  <label>Durée (semaines)
    <input type="number" name="duration_weeks" min="1" max="52" value="<?= htmlspecialchars($offer['duration_weeks'] ?? '') ?>">
  </label>

  <fieldset class="card">
    <legend>Compétences</legend>
    <div class="grid">
      <?php foreach($skills as $s): ?>
        <label class="chipbox">
          <input type="checkbox" name="skills[]" value="<?= (int)$s['id'] ?>" <?= in_array((int)$s['id'], $selected, true) ? 'checked':'' ?>>
          <?= htmlspecialchars($s['label']) ?>
        </label>
      <?php endforeach; ?>
    </div>
  </fieldset>

  <button class="btn" type="submit">Enregistrer</button>
</form>

<?php if ($mode==='edit'): ?>
  <form method="post" action="<?= (App::config()['app']['base_path'] ?? '') ?>/admin/offers/delete" onsubmit="return confirm('Supprimer (désactiver) ?')">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
    <input type="hidden" name="id" value="<?= (int)$offer['id'] ?>">
    <button class="btn danger" type="submit">Supprimer</button>
  </form>
<?php endif; ?>
