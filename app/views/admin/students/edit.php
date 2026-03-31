<a href="/admin/students" class="admin-back">← Retour à la liste</a>
<h1 class="admin-page-title" style="margin-bottom:20px">Modifier un étudiant</h1>
<div class="admin-form-centered">
  <div class="admin-form-wrap">
    <div class="admin-form-card">
      <form method="post" action="/admin/students/update" class="admin-form">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
        <input type="hidden" name="id" value="<?= (int)$student['id'] ?>">
        <input type="hidden" name="user_id" value="<?= (int)$student['user_id'] ?>">
        <div class="admin-form-group">
          <label class="admin-form-label">Prénom <span>*</span></label>
          <input type="text" name="firstname" class="admin-form-input" value="<?= htmlspecialchars($student['firstname']) ?>" required minlength="2">
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Nom <span>*</span></label>
          <input type="text" name="lastname" class="admin-form-input" value="<?= htmlspecialchars($student['lastname']) ?>" required minlength="2">
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Email <span>*</span></label>
          <input type="email" name="email" class="admin-form-input" value="<?= htmlspecialchars($student['email']) ?>" required>
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Pilote</label>
          <select name="pilot_id" class="admin-form-select">
            <option value="">-- Aucun pilote --</option>
            <?php foreach ($pilots as $pilot): ?>
              <option value="<?= (int)$pilot['id'] ?>" <?= (int)($student['pilot_id'] ?? 0) === (int)$pilot['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($pilot['firstname'] . ' ' . $pilot['lastname']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="admin-form-submit">Enregistrer</button>
      </form>
    </div>
  </div>
</div>