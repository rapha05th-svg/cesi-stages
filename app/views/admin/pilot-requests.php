<?php
$typeLabels = [
    'company' => 'Entreprise',
    'student' => 'Étudiant',
    'offer'   => 'Offre de stage',
];
$actionLabels = [
    'create' => 'Créer',
    'edit'   => 'Modifier',
];
$statusColors = [
    'pending'  => ['bg' => '#FAEEDA', 'color' => '#BA7517', 'label' => 'En attente'],
    'approved' => ['bg' => '#EAF3DE', 'color' => '#27500A', 'label' => 'Approuvée'],
    'rejected' => ['bg' => '#fef2f2', 'color' => '#d71920', 'label' => 'Refusée'],
];

$pending  = array_filter($requests, fn($r) => $r['status'] === 'pending');
$archived = array_filter($requests, fn($r) => $r['status'] !== 'pending');
?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px">
    <div>
        <h1 class="admin-page-title" style="margin:0 0 4px">Demandes des pilotes</h1>
        <p style="color:#667085;margin:0;font-size:0.95rem">
            <?= count($pending) ?> demande<?= count($pending) > 1 ? 's' : '' ?> en attente
        </p>
    </div>
    <a href="/admin" class="admin-back" style="margin:0">← Retour au dashboard</a>
</div>

<!-- EN ATTENTE -->
<?php if (empty($pending)): ?>
    <div style="text-align:center;padding:40px;background:#fff;border:1px solid #e5e7eb;border-radius:14px;color:#9ca3af;font-style:italic;margin-bottom:24px">
        Aucune demande en attente.
    </div>
<?php else: ?>
    <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:32px">
        <?php foreach ($pending as $r): ?>
            <div class="preq-card preq-card--pending">
                <div class="preq-top">
                    <div class="preq-pilot">
                        <div class="preq-avatar">
                            <?= strtoupper(substr($r['firstname'], 0, 1) . substr($r['lastname'], 0, 1)) ?>
                        </div>
                        <div>
                            <div class="preq-pilot-name"><?= htmlspecialchars($r['firstname'] . ' ' . $r['lastname']) ?></div>
                            <div class="preq-date"><?= date('d/m/Y à H:i', strtotime($r['created_at'])) ?></div>
                        </div>
                    </div>
                    <span class="preq-type-badge">
                        <?= htmlspecialchars($actionLabels[$r['action']] ?? $r['action']) ?>
                        <?= htmlspecialchars(strtolower($typeLabels[$r['type']] ?? $r['type'])) ?>
                    </span>
                </div>

                <?php if (!empty($r['message'])): ?>
                    <p class="preq-message"><?= nl2br(htmlspecialchars($r['message'])) ?></p>
                <?php endif; ?>

                <!-- Actions -->
                <div class="preq-actions">
                    <!-- Approuver -->
                    <form method="post" action="/admin/pilot-requests/approve" class="preq-action-form">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                        <input type="hidden" name="request_id" value="<?= (int)$r['id'] ?>">
                        <input type="text" name="admin_comment" class="preq-comment-input" placeholder="Commentaire (optionnel)">
                        <button type="submit" class="preq-btn preq-btn--approve">Approuver</button>
                    </form>
                    <!-- Refuser -->
                    <form method="post" action="/admin/pilot-requests/reject" class="preq-action-form">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                        <input type="hidden" name="request_id" value="<?= (int)$r['id'] ?>">
                        <input type="text" name="admin_comment" class="preq-comment-input" placeholder="Raison du refus (optionnel)">
                        <button type="submit" class="preq-btn preq-btn--reject">Refuser</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- ARCHIVÉES -->
<?php if (!empty($archived)): ?>
    <h2 style="font-size:0.9rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:12px">
        Demandes traitées
    </h2>
    <div style="display:flex;flex-direction:column;gap:10px">
        <?php foreach ($archived as $r): ?>
            <?php $sc = $statusColors[$r['status']] ?? $statusColors['pending']; ?>
            <div class="preq-card preq-card--archived">
                <div class="preq-top">
                    <div class="preq-pilot">
                        <div class="preq-avatar preq-avatar--sm">
                            <?= strtoupper(substr($r['firstname'], 0, 1) . substr($r['lastname'], 0, 1)) ?>
                        </div>
                        <div>
                            <div class="preq-pilot-name"><?= htmlspecialchars($r['firstname'] . ' ' . $r['lastname']) ?></div>
                            <div class="preq-date"><?= date('d/m/Y', strtotime($r['created_at'])) ?></div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px">
                        <span class="preq-type-badge" style="background:#f3f4f6;color:#6b7280">
                            <?= htmlspecialchars($actionLabels[$r['action']] ?? $r['action']) ?>
                            <?= htmlspecialchars(strtolower($typeLabels[$r['type']] ?? $r['type'])) ?>
                        </span>
                        <span class="preq-status-badge" style="background:<?= $sc['bg'] ?>;color:<?= $sc['color'] ?>">
                            <?= $sc['label'] ?>
                        </span>
                    </div>
                </div>
                <?php if (!empty($r['message'])): ?>
                    <p class="preq-message" style="color:#9ca3af"><?= nl2br(htmlspecialchars($r['message'])) ?></p>
                <?php endif; ?>
                <?php if (!empty($r['admin_comment'])): ?>
                    <div class="preq-admin-reply">
                        <span class="preq-admin-label">Votre réponse :</span>
                        <?= nl2br(htmlspecialchars($r['admin_comment'])) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.preq-card {
    background:#fff; border:1px solid #e5e7eb; border-radius:14px;
    padding:20px 24px; box-shadow:0 2px 8px rgba(15,23,42,0.04);
}
.preq-card--pending { border-left:4px solid #d71920; }
.preq-card--archived { opacity:0.85; }

.preq-top { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:12px; flex-wrap:wrap; }
.preq-pilot { display:flex; align-items:center; gap:12px; }
.preq-avatar {
    width:40px; height:40px; border-radius:50%;
    background:#d71920; color:#fff;
    display:flex; align-items:center; justify-content:center;
    font-weight:800; font-size:0.88rem; flex-shrink:0;
}
.preq-avatar--sm { width:32px; height:32px; font-size:0.78rem; }
.preq-pilot-name { font-weight:700; color:#161b26; font-size:0.95rem; }
.preq-date { font-size:0.78rem; color:#9ca3af; margin-top:2px; }

.preq-type-badge { font-size:0.82rem; font-weight:700; padding:4px 12px; border-radius:20px; background:#fef2f2; color:#d71920; }
.preq-status-badge { font-size:0.78rem; font-weight:700; padding:4px 12px; border-radius:20px; }

.preq-message { color:#4b5563; font-size:0.88rem; margin:0 0 14px; line-height:1.5; }

.preq-actions { display:flex; flex-direction:column; gap:10px; }
.preq-action-form { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
.preq-comment-input {
    flex:1; min-width:200px; padding:8px 12px;
    border:1px solid #e5e7eb; border-radius:8px;
    font-size:0.85rem; color:#374151;
}
.preq-comment-input:focus { outline:none; border-color:#d71920; }
.preq-btn {
    padding:8px 18px; border:none; border-radius:8px;
    font-weight:700; font-size:0.85rem; cursor:pointer;
    white-space:nowrap; flex-shrink:0;
    transition:background 0.15s; box-shadow:none; transform:none;
}
.preq-btn--approve { background:#EAF3DE; color:#27500A; }
.preq-btn--approve:hover { background:#d4edba; transform:none; box-shadow:none; }
.preq-btn--reject { background:#fef2f2; color:#d71920; }
.preq-btn--reject:hover { background:#fee2e2; transform:none; box-shadow:none; }

.preq-admin-reply { background:#f9fafb; border-left:3px solid #e5e7eb; border-radius:0 8px 8px 0; padding:8px 12px; font-size:0.84rem; color:#374151; margin-top:6px; }
.preq-admin-label { font-weight:700; display:block; margin-bottom:3px; color:#667085; font-size:0.78rem; text-transform:uppercase; }
</style>
