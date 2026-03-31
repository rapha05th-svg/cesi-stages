<?php
$slides = [
    [
        'id'    => 'total',
        'title' => 'Offres disponibles',
        'value' => (int)$totalOffers,
        'unit'  => 'offres actives',
        'icon'  => 'total',
    ],
    [
        'id'    => 'avg',
        'title' => 'Candidatures moyennes',
        'value' => number_format((float)$avgApps, 1),
        'unit'  => 'candidatures par offre',
        'icon'  => 'avg',
    ],
    [
        'id'    => 'top',
        'title' => 'Top wishlist',
        'value' => null,
        'unit'  => null,
        'icon'  => 'top',
        'list'  => $top,
    ],
    [
        'id'    => 'dist',
        'title' => 'Répartition par durée',
        'value' => null,
        'unit'  => null,
        'icon'  => 'dist',
        'list'  => $dist,
    ],
];
?>

<div class="stats-header">
    <h1 class="stats-title">Statistiques des offres</h1>
    <p class="stats-sub">Vue d'ensemble de la plateforme</p>
</div>

<div class="stats-carousel-wrap">
    <button class="stats-nav stats-nav-prev" id="statsPrev" aria-label="Précédent">&#8249;</button>

    <div class="stats-track" id="statsTrack">
        <?php foreach ($slides as $i => $slide): ?>
        <div class="stats-slide <?= $i === 0 ? 'active' : '' ?>" data-index="<?= $i ?>">

            <div class="stats-card">
                <div class="stats-card-icon icon-<?= $slide['icon'] ?>">
                    <?php if ($slide['icon'] === 'total'): ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    <?php elseif ($slide['icon'] === 'avg'): ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <?php elseif ($slide['icon'] === 'top'): ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    <?php endif; ?>
                </div>

                <h2 class="stats-card-title"><?= htmlspecialchars($slide['title']) ?></h2>

                <?php if ($slide['value'] !== null): ?>
                    <div class="stats-card-value"><?= $slide['value'] ?></div>
                    <div class="stats-card-unit"><?= htmlspecialchars($slide['unit']) ?></div>
                <?php elseif ($slide['icon'] === 'top'): ?>
                    <?php if (empty($slide['list'])): ?>
                        <p class="stats-empty">Aucune donnée disponible.</p>
                    <?php else: ?>
                        <ol class="stats-list">
                            <?php foreach ($slide['list'] as $rank => $t): ?>
                                <li class="stats-list-item">
                                    <span class="stats-rank"><?= $rank + 1 ?></span>
                                    <span class="stats-list-label"><?= htmlspecialchars($t['title']) ?></span>
                                    <span class="stats-badge"><?= (int)$t['wish_count'] ?> &#9829;</span>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if (empty($slide['list'])): ?>
                        <p class="stats-empty">Aucune donnée disponible.</p>
                    <?php else: ?>
                        <div class="stats-bars">
                            <?php
                            $max = max(array_column($slide['list'], 'n'));
                            foreach ($slide['list'] as $d):
                                $pct = $max > 0 ? round(($d['n'] / $max) * 100) : 0;
                            ?>
                                <div class="stats-bar-row">
                                    <span class="stats-bar-label"><?= htmlspecialchars($d['bucket']) ?></span>
                                    <div class="stats-bar-track">
                                        <div class="stats-bar-fill" style="width:<?= $pct ?>%"></div>
                                    </div>
                                    <span class="stats-bar-count"><?= (int)$d['n'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

    <button class="stats-nav stats-nav-next" id="statsNext" aria-label="Suivant">&#8250;</button>
</div>

<div class="stats-dots" id="statsDots">
    <?php foreach ($slides as $i => $slide): ?>
        <button class="stats-dot <?= $i === 0 ? 'active' : '' ?>" data-index="<?= $i ?>" aria-label="Slide <?= $i + 1 ?>"></button>
    <?php endforeach; ?>
</div>

<style>
.stats-header { text-align: center; margin-bottom: 32px; }
.stats-title { font-size: 1.6rem; font-weight: 900; color: #161b26; margin-bottom: 6px; }
.stats-sub { color: #667085; font-size: 1rem; }

.stats-carousel-wrap { display: flex; align-items: center; gap: 16px; }

.stats-nav {
    width: 44px; height: 44px; border-radius: 50%;
    border: 1px solid #e5e7eb; background: #fff;
    font-size: 1.6rem; cursor: pointer; color: #d71920;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: background 0.15s;
}
.stats-nav:hover { background: #fef2f2; }

.stats-track { flex: 1; overflow: hidden; position: relative; min-height: 320px; }

.stats-slide {
    display: none;
    animation: fadeIn 0.3s ease;
}
.stats-slide.active { display: block; }

@keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

.stats-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 36px 32px;
    text-align: center;
    box-shadow: 0 4px 24px rgba(15,23,42,0.06);
}

.stats-card-icon {
    width: 64px; height: 64px; border-radius: 16px;
    margin: 0 auto 20px;
    display: flex; align-items: center; justify-content: center;
    background: #fef2f2;
    color: #d71920;
}
.stats-card-icon svg { width: 32px; height: 32px; }

.stats-card-title { font-size: 1.1rem; font-weight: 700; color: #667085; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.85rem; }
.stats-card-value { font-size: 4rem; font-weight: 900; color: #d71920; line-height: 1; }
.stats-card-unit { font-size: 0.95rem; color: #667085; margin-top: 8px; }

.stats-empty { color: #667085; font-style: italic; }

.stats-list { list-style: none; text-align: left; margin-top: 8px; }
.stats-list-item { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
.stats-list-item:last-child { border-bottom: none; }
.stats-rank { width: 28px; height: 28px; border-radius: 50%; background: #d71920; color: #fff; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.stats-list-label { flex: 1; font-size: 0.95rem; color: #161b26; }
.stats-badge { background: #fef2f2; color: #d71920; font-weight: 700; font-size: 0.85rem; padding: 3px 10px; border-radius: 20px; }

.stats-bars { text-align: left; margin-top: 8px; }
.stats-bar-row { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
.stats-bar-label { width: 130px; font-size: 0.88rem; color: #667085; flex-shrink: 0; }
.stats-bar-track { flex: 1; height: 12px; background: #f3f4f6; border-radius: 99px; overflow: hidden; }
.stats-bar-fill { height: 100%; background: #d71920; border-radius: 99px; transition: width 0.6s ease; }
.stats-bar-count { width: 32px; text-align: right; font-weight: 700; font-size: 0.9rem; color: #161b26; }

.stats-dots { display: flex; justify-content: center; gap: 8px; margin-top: 20px; }
.stats-dot { width: 10px; height: 10px; border-radius: 50%; border: none; background: #e5e7eb; cursor: pointer; padding: 0; transition: background 0.2s; }
.stats-dot.active { background: #d71920; width: 24px; border-radius: 5px; }
</style>

<script>
(function() {
    const slides = document.querySelectorAll('.stats-slide');
    const dots   = document.querySelectorAll('.stats-dot');
    let current  = 0;

    function goTo(n) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    document.getElementById('statsPrev').addEventListener('click', () => goTo(current - 1));
    document.getElementById('statsNext').addEventListener('click', () => goTo(current + 1));
    dots.forEach(d => d.addEventListener('click', () => goTo(+d.dataset.index)));

    setInterval(() => goTo(current + 1), 5000);
})();
</script>