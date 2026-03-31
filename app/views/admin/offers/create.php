<a href="/admin/offers" class="admin-back">← Retour à la liste</a>
<h1 class="admin-page-title" style="margin-bottom:20px">Créer une offre</h1>
<div class="admin-form-centered">
  <div class="admin-form-wrap">
    <div class="admin-form-card">
      <form method="post" action="/admin/offers/store" class="admin-form">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
        <div class="admin-form-group">
          <label class="admin-form-label">Titre <span>*</span></label>
          <input type="text" name="title" class="admin-form-input" required minlength="3" maxlength="180" placeholder="Ex: Stage développeur PHP">
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Description</label>
          <textarea name="description" class="admin-form-textarea" placeholder="Décrivez le stage..."></textarea>
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Entreprise <span>*</span></label>
          <select name="company_id" class="admin-form-select" required>
            <option value="">-- Choisir une entreprise --</option>
            <?php foreach ($companies as $company): ?>
              <?php if (!empty($company['is_active'])): ?>
                <option value="<?= (int)$company['id'] ?>"><?= htmlspecialchars($company['name']) ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Rémunération (€/mois)</label>
          <input type="number" name="salary" class="admin-form-input" min="0" max="99999" step="1" placeholder="Ex: 600">
          <span class="admin-form-hint">Laisser vide si non précisée</span>
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Date de début</label>
          <input type="date" name="start_date" class="admin-form-input">
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Date de fin</label>
          <input type="date" name="end_date" class="admin-form-input">
        </div>
        <button type="submit" class="admin-form-submit">Créer l'offre</button>
      </form>
    </div>
  </div>
</div>