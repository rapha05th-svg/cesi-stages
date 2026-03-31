<a href="/admin/pilots" class="admin-back">← Retour à la liste</a>
<h1 class="admin-page-title" style="margin-bottom:20px">Créer un pilote</h1>
<div class="admin-form-centered"><div class="admin-form-wrap">
    <div class="admin-form-card">
        <form method="post" action="/admin/pilots/store" class="admin-form">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <div class="admin-form-group">
                <label class="admin-form-label">Prénom <span>*</span></label>
                <input type="text" name="firstname" class="admin-form-input" required minlength="2" placeholder="Ex: Thomas">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Nom <span>*</span></label>
                <input type="text" name="lastname" class="admin-form-input" required minlength="2" placeholder="Ex: Leroy">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Email <span>*</span></label>
                <input type="email" name="email" class="admin-form-input" required placeholder="thomas.leroy@cesi.fr">
            </div>
            <button type="submit" class="admin-form-submit">Créer le pilote</button>
        </form>
    </div>
</div>
</div>