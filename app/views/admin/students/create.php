<a href="/admin/students" class="admin-back">← Retour à la liste</a>
<h1 class="admin-page-title" style="margin-bottom:20px">Créer un étudiant</h1>
<div class="admin-form-centered"><div class="admin-form-wrap">
    <div class="admin-form-card">
        <form method="post" action="/admin/students/store" class="admin-form">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <div class="admin-form-group">
                <label class="admin-form-label">Prénom <span>*</span></label>
                <input type="text" name="firstname" class="admin-form-input" required minlength="2" placeholder="Ex: Lucas">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Nom <span>*</span></label>
                <input type="text" name="lastname" class="admin-form-input" required minlength="2" placeholder="Ex: Martin">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Email <span>*</span></label>
                <input type="email" name="email" class="admin-form-input" required placeholder="lucas.martin@cesi.fr">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Pilote</label>
                <select name="pilot_id" class="admin-form-select">
                    <option value="">-- Aucun pilote --</option>
                    <?php foreach ($pilots as $pilot): ?>
                        <option value="<?= (int)$pilot['id'] ?>"><?= htmlspecialchars($pilot['firstname'] . ' ' . $pilot['lastname']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="admin-form-submit">Créer l'étudiant</button>
        </form>
    </div>
</div>
</div>