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

<!-- Données PHP pour Chart.js -->
<div id="stats-data"
    data-total="<?= (int)$totalOffers ?>"
    data-avg="<?= number_format((float)$avgApps, 1, '.', '') ?>"
    data-top='<?= json_encode(array_map(fn($t) => ['label' => $t['title'], 'value' => (int)$t['wish_count']], array_slice($top, 0, 5))) ?>'
    data-dist='<?= json_encode(array_map(fn($d) => ['label' => $d['bucket'], 'value' => (int)$d['n']], $dist ?? [])) ?>'
    style="display:none">
</div>

<div class="stats-grid">

    <!-- KPI 1 -->
    <div class="stat-kpi">
        <div class="stat-kpi-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
        </div>
        <div class="stat-kpi-val" data-target="<?= (int)$totalOffers ?>">0</div>
        <div class="stat-kpi-label">Offres actives</div>
    </div>

    <!-- KPI 2 -->
    <div class="stat-kpi">
        <div class="stat-kpi-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="stat-kpi-val"><?= number_format((float)$avgApps, 1) ?></div>
        <div class="stat-kpi-label">Candidatures / offre</div>
    </div>

    <!-- KPI 3 -->
    <div class="stat-kpi">
        <div class="stat-kpi-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div class="stat-kpi-val" data-target="<?= count($top ?? []) ?>"><?= count($top ?? []) ?></div>
        <div class="stat-kpi-label">Offres en wishlist</div>
    </div>

    <!-- KPI 4 -->
    <div class="stat-kpi">
        <div class="stat-kpi-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        </div>
        <div class="stat-kpi-val" data-target="<?= count($dist ?? []) ?>"><?= count($dist ?? []) ?></div>
        <div class="stat-kpi-label">Tranches de durée</div>
    </div>

</div>

<div class="stats-charts-grid">

    <!-- Chart : Top wishlist (barres horizontales) -->
    <div class="stats-chart-card">
        <h3 class="stats-chart-title">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Top offres en wishlist
        </h3>
        <?php if (empty($top)): ?>
            <p class="stats-empty">Aucune donnée disponible.</p>
        <?php else: ?>
            <canvas id="chartTop" height="220"></canvas>
        <?php endif; ?>
    </div>

    <!-- Chart : Répartition durée (doughnut) -->
    <div class="stats-chart-card">
        <h3 class="stats-chart-title">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Répartition par durée
        </h3>
        <?php if (empty($dist)): ?>
            <p class="stats-empty">Aucune donnée disponible.</p>
        <?php else: ?>
            <canvas id="chartDist" height="220"></canvas>
        <?php endif; ?>
    </div>

</div>

<style>
.stats-header { text-align: center; margin-bottom: 32px; }
.stats-title  { font-size: 1.6rem; font-weight: 900; color: #161b26; margin-bottom: 6px; }
.stats-sub    { color: #667085; font-size: 1rem; }

/* KPI row */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
.stat-kpi {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 24px 20px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(15,23,42,0.05);
    transition: transform 0.2s, box-shadow 0.2s;
}
.stat-kpi:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(215,25,32,0.1); }
.stat-kpi-icon {
    width: 46px; height: 46px; border-radius: 12px;
    background: #fef2f2; color: #d71920;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
}
.stat-kpi-val   { font-size: 2.4rem; font-weight: 900; color: #d71920; line-height: 1; letter-spacing: -0.03em; }
.stat-kpi-label { font-size: 0.78rem; font-weight: 600; color: #667085; text-transform: uppercase; letter-spacing: 0.06em; margin-top: 6px; }

/* Charts grid */
.stats-charts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.stats-chart-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 24px 28px;
    box-shadow: 0 2px 12px rgba(15,23,42,0.05);
}
.stats-chart-title {
    display: flex; align-items: center; gap: 8px;
    font-size: 0.9rem; font-weight: 700; color: #374151;
    text-transform: uppercase; letter-spacing: 0.05em;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f3f4f6;
}
.stats-empty { color: #9ca3af; font-style: italic; text-align: center; padding: 40px 0; }

/* Dark mode */
[data-theme="dark"] .stat-kpi          { background: var(--dk-surface); border-color: var(--dk-border); }
[data-theme="dark"] .stat-kpi-icon     { background: rgba(215,25,32,0.12); }
[data-theme="dark"] .stat-kpi-label    { color: var(--dk-muted); }
[data-theme="dark"] .stats-chart-card  { background: var(--dk-surface); border-color: var(--dk-border); }
[data-theme="dark"] .stats-chart-title { color: var(--dk-muted); border-bottom-color: var(--dk-border); }
[data-theme="dark"] .stats-title       { color: var(--dk-text); }
[data-theme="dark"] .stats-sub         { color: var(--dk-muted); }

@media (max-width: 900px) {
    .stats-grid { grid-template-columns: 1fr 1fr; }
    .stats-charts-grid { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .stats-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const el   = document.getElementById('stats-data');
    const top  = JSON.parse(el.dataset.top  || '[]');
    const dist = JSON.parse(el.dataset.dist || '[]');
    const dark = document.documentElement.getAttribute('data-theme') === 'dark';

    const textColor   = dark ? '#7d8590' : '#6b7280';
    const gridColor   = dark ? '#30363d' : '#f3f4f6';
    const cardBg      = dark ? '#161b22' : '#fff';

    Chart.defaults.font.family = "'Inter', Arial, sans-serif";
    Chart.defaults.color = textColor;

    /* ── Chart Top wishlist (barres horizontales) ── */
    const ctxTop = document.getElementById('chartTop');
    if (ctxTop && top.length) {
        new Chart(ctxTop, {
            type: 'bar',
            data: {
                labels: top.map(t => t.label.length > 28 ? t.label.slice(0, 28) + '…' : t.label),
                datasets: [{
                    label: 'Favoris',
                    data: top.map(t => t.value),
                    backgroundColor: top.map((_, i) => i === 0 ? '#d71920' : 'rgba(215,25,32,0.' + (8 - i) + ')'),
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: { label: ctx => ' ' + ctx.raw + ' favoris' }
                    }
                },
                scales: {
                    x: { grid: { color: gridColor }, ticks: { color: textColor, stepSize: 1 } },
                    y: { grid: { display: false }, ticks: { color: textColor } }
                }
            }
        });
    }

    /* ── Chart Répartition durée (doughnut) ── */
    const ctxDist = document.getElementById('chartDist');
    if (ctxDist && dist.length) {
        const palette = ['#d71920','#ff4d55','#ff8a8f','#ffc5c7','#ffe0e1'];
        new Chart(ctxDist, {
            type: 'doughnut',
            data: {
                labels: dist.map(d => d.label),
                datasets: [{
                    data: dist.map(d => d.value),
                    backgroundColor: dist.map((_, i) => palette[i % palette.length]),
                    borderColor: cardBg,
                    borderWidth: 3,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: textColor, padding: 16, usePointStyle: true, pointStyle: 'circle' }
                    },
                    tooltip: {
                        callbacks: { label: ctx => ' ' + ctx.label + ' : ' + ctx.raw + ' offre' + (ctx.raw > 1 ? 's' : '') }
                    }
                }
            }
        });
    }

    /* ── Compteurs KPI animés ── */
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            const el = e.target;
            const target = parseInt(el.dataset.target, 10);
            if (!target) return;
            let n = 0;
            const step = Math.ceil(target / 40);
            const t = setInterval(() => {
                n = Math.min(n + step, target);
                el.textContent = n;
                if (n >= target) clearInterval(t);
            }, 20);
            obs.unobserve(el);
        });
    }, { threshold: 0.4 });
    document.querySelectorAll('.stat-kpi-val[data-target]').forEach(el => obs.observe(el));
})();
</script>