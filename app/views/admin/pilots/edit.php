<a href="/admin/pilots" class="admin-back">← Retour à la liste</a>
<h1 class="admin-page-title" style="margin-bottom:20px">Modifier un pilote</h1>
<div class="admin-form-centered">
  <div class="admin-form-wrap">
    <div class="admin-form-card">
      <form method="post" action="/admin/pilots/update" class="admin-form">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
        <input type="hidden" name="id" value="<?= (int)$pilot['id'] ?>">
        <input type="hidden" name="user_id" value="<?= (int)$pilot['user_id'] ?>">
        <div class="admin-form-group">
          <label class="admin-form-label">Prénom <span>*</span></label>
          <input type="text" name="firstname" class="admin-form-input" value="<?= htmlspecialchars($pilot['firstname']) ?>" required minlength="2">
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Nom <span>*</span></label>
          <input type="text" name="lastname" class="admin-form-input" value="<?= htmlspecialchars($pilot['lastname']) ?>" required minlength="2">
        </div>
        <div class="admin-form-group">
          <label class="admin-form-label">Email <span>*</span></label>
          <input type="email" name="email" class="admin-form-input" value="<?= htmlspecialchars($pilot['email']) ?>" required>
        </div>
        <button type="submit" class="admin-form-submit">Enregistrer</button>
      </form>
    </div>
  </div>
</div>