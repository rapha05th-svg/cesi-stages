<?php
$base = App::config()['app']['base_path'] ?? '';

$typeLabels = [
    'company' => 'Entreprise',
    'student' => 'Étudiant',
    'offer'   => 'Offre de stage',
];
$actionLabels = [
    'create' => 'Créer',
    'edit'   => 'Modifier',
];
$statusLabels = [
    'pending'  => 'En attente',
    'approved' => 'Approuvée',
    'rejected' => 'Refusée',
];
$statusColors = [
    'pending'  => ['bg' => '#FAEEDA', 'color' => '#BA7517'],
    'approved' => ['bg' => '#EAF3DE', 'color' => '#27500A'],
    'rejected' => ['bg' => '#fef2f2', 'color' => '#d71920'],
];
?>

<div class="req-header">
    <div>
        <h1 class="req-title">Mes demandes</h1>
        <p class="req-sub">Demandez à l'administrateur de créer ou modifier des ressources.</p>
    </div>
</div>

<!-- FORMULAIRE NOUVELLE DEMANDE -->
<div class="req-form-card">
    <h2 class="req-form-title">Nouvelle demande</h2>
    <form method="post" action="<?= $base ?>/pilot/requests/store" class="req-form">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">

        <div class="req-form-row">
            <div class="req-form-group">
                <label class="req-form-label">Je souhaite</label>
                <select name="action" class="req-form-select" required>
                    <option value="">-- Action --</option>
                    <option value="create">Créer</option>
                    <option value="edit">Modifier</option>
                </select>
            </div>
            <div class="req-form-group">
                <label class="req-form-label">Concernant</label>
                <select name="type" class="req-form-select" required>
                    <option value="">-- Type --</option>
                    <option value="company">une entreprise</option>
                    <option value="student">un étudiant</option>
                    <option value="offer">une offre de stage</option>
                </select>
            </div>
        </div>

        <div class="req-form-group" style="margin-top:12px">
            <label class="req-form-label">Message (précisez ce que vous souhaitez faire)</label>
            <textarea name="message" class="req-form-textarea" rows="3" placeholder="Ex : Je souhaite créer l'entreprise Airbus pour le stage de Lucas Martin..."></textarea>
        </div>

        <button type="submit" class="req-form-submit">Envoyer la demande</button>
    </form>
</div>

<!-- LISTE DES DEMANDES -->
<div style="margin-top:24px">
    <h2 class="req-list-title">Historique des demandes</h2>

    <?php if (empty($requests)): ?>
        <div class="req-empty">Aucune demande pour le moment.</div>
    <?php else: ?>
        <div class="req-list">
            <?php foreach ($requests as $r): ?>
                <?php
                $sc = $statusColors[$r['status']] ?? $statusColors['pending'];
                ?>
                <div class="req-card">
                    <div class="req-card-top">
                        <div class="req-card-main">
                            <span class="req-action-badge">
                                <?= htmlspecialchars($actionLabels[$r['action']] ?? $r['action']) ?>
                                <?= htmlspecialchars(strtolower($typeLabels[$r['type']] ?? $r['type'])) ?>
                            </span>
                            <span class="req-date"><?= date('d/m/Y à H:i', strtotime($r['created_at'])) ?></span>
                        </div>
                        <span class="req-status-badge" style="background:<?= $sc['bg'] ?>;color:<?= $sc['color'] ?>">
                            <?= htmlspecialchars($statusLabels[$r['status']] ?? $r['status']) ?>
                        </span>
                    </div>

                    <?php if (!empty($r['message'])): ?>
                        <p class="req-message"><?= nl2br(htmlspecialchars($r['message'])) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($r['admin_comment'])): ?>
                        <div class="req-admin-comment">
                            <span class="req-admin-label">Réponse de l'admin :</span>
                            <?= nl2br(htmlspecialchars($r['admin_comment'])) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.req-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; }
.req-title { font-size:1.5rem; font-weight:900; color:#161b26; margin:0 0 4px; }
.req-sub { color:#667085; font-size:0.95rem; margin:0; }

.req-form-card { background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:24px 28px; box-shadow:0 2px 8px rgba(15,23,42,0.04); }
.req-form-title { font-size:1rem; font-weight:700; color:#374151; margin:0 0 16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; }
.req-form { display:flex; flex-direction:column; gap:0; }
.req-form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.req-form-group { display:flex; flex-direction:column; gap:5px; }
.req-form-label { font-size:0.85rem; font-weight:600; color:#374151; }
.req-form-select, .req-form-textarea {
    padding:10px 12px; border:1px solid #e5e7eb; border-radius:10px;
    font-size:0.9rem; color:#161b26; background:#fff;
    transition:border-color 0.15s; width:100%; box-sizing:border-box;
}
.req-form-select:focus, .req-form-textarea:focus { outline:none; border-color:#d71920; }
.req-form-textarea { resize:vertical; font-family:inherit; }
.req-form-submit {
    margin-top:16px; padding:11px 24px; background:#d71920; color:#fff;
    border:none; border-radius:10px; font-weight:700; font-size:0.95rem;
    cursor:pointer; align-self:flex-start; transition:background 0.15s;
}
.req-form-submit:hover { background:#b5141a; transform:none; box-shadow:none; }

.req-list-title { font-size:0.95rem; font-weight:700; color:#374151; margin-bottom:14px; text-transform:uppercase; letter-spacing:0.04em; }
.req-empty { text-align:center; padding:32px; color:#9ca3af; font-style:italic; background:#fff; border:1px solid #e5e7eb; border-radius:12px; }
.req-list { display:flex; flex-direction:column; gap:12px; }

.req-card { background:#fff; border:1px solid #e5e7eb; border-radius:14px; padding:18px 22px; box-shadow:0 1px 4px rgba(15,23,42,0.04); }
.req-card-top { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:10px; flex-wrap:wrap; }
.req-card-main { display:flex; align-items:center; gap:12px; }
.req-action-badge { font-weight:700; font-size:0.92rem; color:#161b26; }
.req-date { font-size:0.78rem; color:#9ca3af; }
.req-status-badge { font-size:0.78rem; font-weight:700; padding:4px 12px; border-radius:20px; white-space:nowrap; }
.req-message { color:#4b5563; font-size:0.88rem; margin:0 0 8px; line-height:1.5; }
.req-admin-comment { background:#f9fafb; border-left:3px solid #d71920; border-radius:0 8px 8px 0; padding:10px 14px; font-size:0.85rem; color:#374151; }
.req-admin-label { font-weight:700; display:block; margin-bottom:4px; color:#d71920; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.04em; }
</style>
