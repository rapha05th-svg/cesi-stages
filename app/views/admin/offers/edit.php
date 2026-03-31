<a href="/admin/offers" class="admin-back">← Retour à la liste</a>
<h1 class="admin-page-title" style="margin-bottom:20px">Modifier une offre</h1>
<div class="admin-form-centered">
  <div class="admin-form-wrap">
    <div class="admin-form-card">
      <form method="post" action="/admin/offers/update" class="admin-form no-validate">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
        <input type="hidden" name="id" value="<?= (int)$offer['id'] ?>">
        <div class="admin-form-group">
          <label class="admin-form-label">Titre <span>*</span></label>
          <input type="text" name="title" class="admin-form-input" value="<?= htmlspecialchars($offer['title']) ?>" required minlength="3" maxlength="180">
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Description</label>
          <textarea name="description" class="admin-form-textarea"><?= htmlspecialchars($offer['description'] ?? '') ?></textarea>
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Entreprise <span>*</span></label>
          <select name="company_id" class="admin-form-select" required>
            <?php foreach ($companies as $company): ?>
              <?php if (!empty($company['is_active'])): ?>
                <option value="<?= (int)$company['id'] ?>" <?= (int)$company['id'] === (int)$offer['company_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($company['name']) ?>
                </option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Rémunération (€/mois)</label>
          <input type="number" name="salary" class="admin-form-input" min="0" max="99999" step="1"
                 value="<?= $offer['salary'] !== null ? htmlspecialchars((string)$offer['salary']) : '' ?>" placeholder="Ex: 600">
          <span class="admin-form-hint">Laisser vide si non précisée</span>
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Date de début</label>
          <input type="date" name="start_date" class="admin-form-input"
                 value="<?= htmlspecialchars($offer['start_date'] ?? '') ?>">
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Date de fin</label>
          <input type="date" name="end_date" class="admin-form-input"
                 value="<?= htmlspecialchars($offer['end_date'] ?? '') ?>">
        </div>
        <button type="submit" class="admin-form-submit">Enregistrer</button>
      </form>
    </div>
  </div>
</div>