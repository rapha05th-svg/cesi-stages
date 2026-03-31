<?php
$flash = $_SESSION['flash'] ?? [];
unset($_SESSION['flash']);
foreach ($flash as $f):
?>
  <div class="flash <?= htmlspecialchars($f['type']) ?>">
    <?php if ($f['type'] === 'dev'): ?>
      <?= $f['msg'] ?>
    <?php else: ?>
      <?= htmlspecialchars($f['msg']) ?>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
