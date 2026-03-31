<h1>Candidatures de mes élèves</h1>
<?php if (!$apps): ?>
  <p>Aucune.</p>
<?php else: ?>
  <div class="grid">
    <?php foreach ($apps as $a): ?>
      <div class="card">
        <h2><?= htmlspecialchars($a['firstname'].' '.$a['lastname']) ?> — <?= htmlspecialchars($a['title']) ?></h2>
        <p class="muted"><?= htmlspecialchars($a['email']) ?> | <?= htmlspecialchars($a['company_name']) ?> | <?= htmlspecialchars($a['created_at']) ?></p>
        <p><?= nl2br(htmlspecialchars(mb_strimwidth($a['motivation_text'], 0, 260, '…'))) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
