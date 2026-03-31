<a href="/admin/companies" class="admin-back">← Retour à la liste</a>
<h1 class="admin-page-title" style="margin-bottom:20px">Modifier une entreprise</h1>
<div class="admin-form-centered"><div class="admin-form-wrap" style="max-width:600px">
    <div class="admin-form-card">
        <form method="post" action="/admin/companies/update" class="admin-form">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <input type="hidden" name="id" value="<?= (int)$company['id'] ?>">
            <div class="admin-form-group">
                <label class="admin-form-label">Nom <span>*</span></label>
                <input type="text" name="name" class="admin-form-input" value="<?= htmlspecialchars($company['name']) ?>" required minlength="2" maxlength="160">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Description</label>
                <textarea name="description" class="admin-form-textarea"><?= htmlspecialchars($company['description'] ?? '') ?></textarea>
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Email de contact</label>
                <input type="email" name="email" class="admin-form-input" value="<?= htmlspecialchars($company['email_contact'] ?? '') ?>">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Téléphone</label>
                <input type="text" name="phone" class="admin-form-input" value="<?= htmlspecialchars($company['phone_contact'] ?? '') ?>">
            </div>
            <button type="submit" class="admin-form-submit">Enregistrer</button>
        </form>
    </div>
</div>
</div>