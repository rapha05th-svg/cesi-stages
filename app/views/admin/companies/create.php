<a href="/admin/companies" class="admin-back">← Retour à la liste</a>
<h1 class="admin-page-title" style="margin-bottom:20px">Créer une entreprise</h1>
<div class="admin-form-centered"><div class="admin-form-wrap" style="max-width:600px">
    <div class="admin-form-card">
        <form method="post" action="/admin/companies/store" class="admin-form">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <div class="admin-form-group">
                <label class="admin-form-label">Nom <span>*</span></label>
                <input type="text" name="name" class="admin-form-input" required minlength="2" maxlength="160" placeholder="Ex: Capgemini">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Description</label>
                <textarea name="description" class="admin-form-textarea" placeholder="Décrivez l'activité de l'entreprise..."></textarea>
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Email de contact</label>
                <input type="email" name="email" class="admin-form-input" placeholder="contact@entreprise.fr">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Téléphone</label>
                <input type="text" name="phone" class="admin-form-input" placeholder="01 23 45 67 89">
            </div>
            <button type="submit" class="admin-form-submit">Créer l'entreprise</button>
        </form>
    </div>
</div>
</div>