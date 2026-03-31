<h1>Entreprises</h1>

<form class="row" method="get" action="">
  <input name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Recherche nom / description">
  <button class="btn" type="submit">Rechercher</button>
</form>

<?php if (!$companies): ?>
  <p>Aucune entreprise.</p>
<?php else: ?>
  <div class="grid">
    <?php foreach ($companies as $c): ?>
      <a class="card" href="<?= (App::config()['app']['base_path'] ?? '') ?>/companies/show?id=<?= (int)$c['id'] ?>">
        <h2><?= htmlspecialchars($c['name']) ?></h2>
        <p><?= htmlspecialchars(mb_strimwidth($c['description'] ?? '', 0, 120, '…')) ?></p>
        <p class="muted">Note: <?= $c['avg_rating'] ? number_format((float)$c['avg_rating'], 1) : '—' ?> | Candidatures: <?= (int)$c['total_apps'] ?></p>
      </a>
    <?php endforeach; ?>
  </div>

  <?php $pages = $p->pages(); if ($pages > 1): ?>
    <div class="pagination">
      <?php for($i=1;$i<=$pages;$i++): ?>
        <a class="<?= $i===$p->page ? 'active':'' ?>" href="?q=<?= urlencode($q) ?>&page=<?= $i ?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
<?php endif; ?>
