<?php
$flash = $_SESSION['flash'] ?? [];
unset($_SESSION['flash']);
foreach ($flash as $f):
?>
  <div class="flash <?= htmlspecialchars($f['type']) ?>">
    <?= htmlspecialchars($f['msg']) ?>
  </div>
<?php endforeach; ?>
