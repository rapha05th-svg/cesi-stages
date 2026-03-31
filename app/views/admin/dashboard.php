<div class="dash-header">
    <h1>Dashboard administrateur</h1>
    <p class="dash-sub">Vue d'ensemble de la plateforme</p>
</div>

<!-- STATS GRID -->
<div class="dash-stats-grid">
    <a href="/admin/companies" class="dash-stat-card">
        <div class="dash-stat-icon" style="background:#fef2f2;color:#d71920;">🏢</div>
        <div class="dash-stat-value"><?= (int)$companiesCount ?></div>
        <div class="dash-stat-label">Entreprises</div>
    </a>
    <a href="/admin/offers" class="dash-stat-card">
        <div class="dash-stat-icon" style="background:#EAF3DE;color:#3B6D11;">📋</div>
        <div class="dash-stat-value"><?= (int)$offersCount ?></div>
        <div class="dash-stat-label">Offres actives</div>
    </a>
    <a href="/admin/students" class="dash-stat-card">
        <div class="dash-stat-icon" style="background:#E6F1FB;color:#185FA5;">👨‍🎓</div>
        <div class="dash-stat-value"><?= (int)$studentsCount ?></div>
        <div class="dash-stat-label">Étudiants</div>
    </a>
    <a href="/admin/pilots" class="dash-stat-card">
        <div class="dash-stat-icon" style="background:#EEEDFE;color:#3C3489;">👨‍✈️</div>
        <div class="dash-stat-value"><?= (int)$pilotsCount ?></div>
        <div class="dash-stat-label">Pilotes</div>
    </a>
    <div class="dash-stat-card" style="cursor:default">
        <div class="dash-stat-icon" style="background:#FAEEDA;color:#BA7517;">📄</div>
        <div class="dash-stat-value"><?= (int)$applicationsCount ?></div>
        <div class="dash-stat-label">Candidatures</div>
    </div>
    <div class="dash-stat-card" style="cursor:default">
        <div class="dash-stat-icon" style="background:#f0fdf4;color:#15803d;">💶</div>
        <div class="dash-stat-value"><?= number_format((float)$avgSalary, 0, ',', ' ') ?>€</div>
        <div class="dash-stat-label">Salaire moyen</div>
    </div>
    <div class="dash-stat-card" style="cursor:default">
        <div class="dash-stat-icon" style="background:#fdf4ff;color:#9333ea;">♡</div>
        <div class="dash-stat-value"><?= (int)$wishlistsCount ?></div>
        <div class="dash-stat-label">Wishlists</div>
    </div>
</div>

<div class="dash-grid-2">

    <!-- TOP ENTREPRISES -->
    <div class="dash-section">
        <h2 class="dash-section-title">Top entreprises par candidatures</h2>
        <?php if (empty($topCompanies)): ?>
            <p class="dash-empty">Aucune donnée disponible.</p>
        <?php else: ?>
            <div class="dash-top-list">
                <?php foreach ($topCompanies as $rank => $company): ?>
                    <div class="dash-top-item">
                        <span class="dash-top-rank"><?= $rank + 1 ?></span>
                        <a href="/companies/show?id=<?= (int)$company['id'] ?>" class="dash-top-name">
                            <?= htmlspecialchars($company['name']) ?>
                        </a>
                        <span class="dash-top-count"><?= (int)$company['applications_count'] ?> candidature<?= $company['applications_count'] > 1 ? 's' : '' ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- DERNIÈRES CANDIDATURES -->
    <div class="dash-section">
        <h2 class="dash-section-title">Dernières candidatures</h2>
        <?php if (empty($recentApps)): ?>
            <p class="dash-empty">Aucune candidature récente.</p>
        <?php else: ?>
            <div class="dash-top-list">
                <?php foreach ($recentApps as $app): ?>
                    <div class="dash-top-item">
                        <div style="flex:1;min-width:0">
                            <div style="font-weight:600;font-size:0.88rem;color:#161b26;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($app['firstname'] . ' ' . $app['lastname']) ?></div>
                            <div style="font-size:0.78rem;color:#667085;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($app['offer_title']) ?></div>
                        </div>
                        <span style="font-size:0.75rem;color:#9ca3af;flex-shrink:0"><?= date('d/m', strtotime($app['created_at'])) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- ACCÈS RAPIDES -->
<div class="dash-section">
    <h2 class="dash-section-title">Accès rapides</h2>
    <div class="dash-quick-links">
        <a href="/admin/companies/create" class="dash-quick-btn">+ Entreprise</a>
        <a href="/admin/offers/create" class="dash-quick-btn">+ Offre</a>
        <a href="/admin/students/create" class="dash-quick-btn">+ Étudiant</a>
        <a href="/admin/pilots/create" class="dash-quick-btn">+ Pilote</a>
        <a href="/stats" class="dash-quick-btn dash-quick-btn-secondary">Voir les stats</a>
    </div>
</div>

<style>
.dash-header { margin-bottom: 28px; }
.dash-header h1 { font-size: 1.5rem; font-weight: 900; color: #161b26; margin-bottom: 4px; }
.dash-sub { color: #667085; }

.dash-stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 14px; margin-bottom: 28px; }
.dash-stat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 18px 20px; text-decoration: none; display: flex; flex-direction: column; gap: 8px; transition: border-color 0.15s, box-shadow 0.15s; box-shadow: 0 2px 6px rgba(15,23,42,0.04); }
.dash-stat-card:hover { border-color: #d71920; box-shadow: 0 4px 16px rgba(215,25,32,0.08); }
.dash-stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
.dash-stat-value { font-size: 1.8rem; font-weight: 900; color: #161b26; line-height: 1; }
.dash-stat-label { font-size: 0.82rem; color: #667085; font-weight: 500; }

.dash-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }
@media (max-width: 768px) { .dash-grid-2 { grid-template-columns: 1fr; } }

.dash-section { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 20px 24px; box-shadow: 0 2px 6px rgba(15,23,42,0.04); margin-bottom: 20px; }
.dash-section-title { font-size: 0.9rem; font-weight: 700; color: #374151; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid #f3f4f6; }
.dash-empty { color: #9ca3af; font-style: italic; font-size: 0.9rem; }

.dash-top-list { display: flex; flex-direction: column; gap: 10px; }
.dash-top-item { display: flex; align-items: center; gap: 12px; padding: 8px 0; border-bottom: 1px solid #f9fafb; }
.dash-top-item:last-child { border-bottom: none; }
.dash-top-rank { width: 24px; height: 24px; border-radius: 50%; background: #f3f4f6; color: #667085; font-size: 0.78rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.dash-top-name { flex: 1; color: #161b26; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
.dash-top-name:hover { color: #d71920; }
.dash-top-count { font-size: 0.8rem; color: #667085; white-space: nowrap; }

.dash-quick-links { display: flex; gap: 10px; flex-wrap: wrap; }
.dash-quick-btn { padding: 10px 20px; background: #d71920; color: #fff; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 0.9rem; }
.dash-quick-btn:hover { background: #b5141a; text-decoration: none; }
.dash-quick-btn-secondary { background: #f3f4f6; color: #374151; }
.dash-quick-btn-secondary:hover { background: #e5e7eb; }
</style>