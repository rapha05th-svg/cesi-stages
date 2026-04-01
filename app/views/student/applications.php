<div class="myapps-header">
    <h1>Mes candidatures</h1>
    <p class="myapps-sub"><?= count($apps) ?> candidature<?= count($apps) > 1 ? 's' : '' ?> envoyée<?= count($apps) > 1 ? 's' : '' ?></p>
</div>

<?php if (empty($apps)): ?>
    <div class="myapps-empty">
        <div class="myapps-empty-icon">📄</div>
        <p>Vous n'avez encore postulé à aucune offre.</p>
        <a href="/offers" class="myapps-browse-btn">Voir les offres disponibles</a>
    </div>
<?php else: ?>
    <div class="myapps-list">
        <?php foreach ($apps as $app): ?>
            <div class="myapps-card">

                <div class="myapps-card-top">
                    <div class="myapps-offer-info">
                        <a href="/offers/show?id=<?= (int)$app['offer_id'] ?>" class="myapps-offer-title">
                            <?= htmlspecialchars($app['title']) ?>
                        </a>
                        <span class="myapps-company"><?= htmlspecialchars($app['company_name']) ?></span>
                    </div>
                    <span class="myapps-date">
                        Postulé le <?= date('d/m/Y', strtotime($app['created_at'])) ?>
                    </span>
                </div>

                <div class="myapps-docs">
                    <?php if (!empty($app['cover_letter_text'])): ?>
                        <details class="myapps-doc">
                            <summary class="myapps-doc-toggle">Lettre de motivation</summary>
                            <div class="myapps-doc-content">
                                <?= nl2br(htmlspecialchars($app['cover_letter_text'])) ?>
                            </div>
                        </details>
                    <?php endif; ?>

                    <?php if (!empty($app['cv_path'])): ?>
                        <a href="/cv?file=<?= htmlspecialchars(basename($app['cv_path'])) ?>"
                           target="_blank"
                           class="myapps-cv-link">
                            📎 Voir mon CV
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.myapps-header { margin-bottom: 24px; }
.myapps-header h1 { font-size: 1.5rem; font-weight: 900; color: #161b26; margin-bottom: 4px; }
.myapps-sub { color: #667085; font-size: 0.95rem; }

.myapps-empty { text-align: center; padding: 60px 20px; }
.myapps-empty-icon { font-size: 3rem; margin-bottom: 16px; }
.myapps-empty p { color: #667085; margin-bottom: 16px; }
.myapps-browse-btn { display: inline-block; padding: 10px 24px; background: #d71920; color: #fff; border-radius: 10px; text-decoration: none; font-weight: 700; }
.myapps-browse-btn:hover { background: #b5141a; }

.myapps-list { display: flex; flex-direction: column; gap: 14px; }

.myapps-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 20px 24px; box-shadow: 0 2px 8px rgba(15,23,42,0.04); }

.myapps-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 14px; }

.myapps-offer-info { flex: 1; }
.myapps-offer-title { font-weight: 700; color: #161b26; text-decoration: none; font-size: 1rem; display: block; margin-bottom: 4px; }
.myapps-offer-title:hover { color: #d71920; }
.myapps-company { font-size: 0.85rem; color: #667085; }
.myapps-date { font-size: 0.82rem; color: #667085; white-space: nowrap; background: #f9fafb; padding: 4px 10px; border-radius: 20px; border: 1px solid #e5e7eb; }

.myapps-docs { border-top: 1px solid #f3f4f6; padding-top: 14px; display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-start; }

.myapps-doc { flex: 1; min-width: 220px; }
.myapps-doc-toggle { cursor: pointer; font-weight: 600; font-size: 0.9rem; color: #161b26; list-style: none; padding: 6px 12px; background: #f3f4f6; border-radius: 8px; display: inline-block; }
.myapps-doc-toggle:hover { background: #e5e7eb; }
.myapps-doc-content { margin-top: 10px; padding: 12px 14px; background: #f9fafb; border-radius: 8px; font-size: 0.88rem; color: #374151; line-height: 1.6; white-space: pre-wrap; }

.myapps-cv-link { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #fef2f2; color: #d71920; border-radius: 8px; font-weight: 600; font-size: 0.88rem; text-decoration: none; border: 1px solid #fecaca; }
.myapps-cv-link:hover { background: #fee2e2; }

[data-theme="dark"] .myapps-header h1    { color: var(--dk-text); }
[data-theme="dark"] .myapps-sub          { color: var(--dk-muted); }
[data-theme="dark"] .myapps-card         { background: var(--dk-surface); border-color: var(--dk-border); }
[data-theme="dark"] .myapps-offer-title  { color: var(--dk-text); }
[data-theme="dark"] .myapps-offer-title:hover { color: #ff6b6b; }
[data-theme="dark"] .myapps-company      { color: var(--dk-muted); }
[data-theme="dark"] .myapps-date         { color: var(--dk-muted); background: var(--dk-surface2); border-color: var(--dk-border); }
[data-theme="dark"] .myapps-docs         { border-top-color: var(--dk-border); }
[data-theme="dark"] .myapps-doc-toggle   { background: var(--dk-surface2); color: var(--dk-text); }
[data-theme="dark"] .myapps-doc-toggle:hover { background: var(--dk-border); }
[data-theme="dark"] .myapps-doc-content  { background: var(--dk-bg); color: #adbac7; }
[data-theme="dark"] .myapps-cv-link      { background: rgba(215,25,32,0.1); border-color: rgba(215,25,32,0.25); color: #ff6b6b; }
[data-theme="dark"] .myapps-cv-link:hover { background: rgba(215,25,32,0.18); }
</style>