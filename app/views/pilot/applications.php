<?php $pageTitle = 'Candidatures de mes étudiants'; ?>

<div class="pilot-header">
    <h1>Candidatures de mes étudiants</h1>
    <p class="pilot-sub"><?= count($apps) ?> candidature<?= count($apps) > 1 ? 's' : '' ?> au total</p>
</div>

<?php if (empty($apps)): ?>
    <div class="pilot-empty">
        <p>Aucune candidature trouvée pour vos étudiants.</p>
    </div>
<?php else: ?>
    <div class="pilot-apps-list">
        <?php foreach ($apps as $app): ?>
            <div class="pilot-app-card">

                <div class="pilot-app-top">
                    <div class="pilot-student-info">
                        <div class="pilot-avatar">
                            <?= strtoupper(substr($app['firstname'], 0, 1) . substr($app['lastname'], 0, 1)) ?>
                        </div>
                        <div>
                            <div class="pilot-student-name">
                                <?= htmlspecialchars($app['firstname'] . ' ' . $app['lastname']) ?>
                            </div>
                            <div class="pilot-app-date">
                                Postulé le <?= date('d/m/Y', strtotime($app['created_at'])) ?>
                            </div>
                        </div>
                    </div>

                    <div class="pilot-offer-info">
                        <a href="/offers/show?id=<?= (int)$app['offer_id'] ?>" class="pilot-offer-title">
                            <?= htmlspecialchars($app['title']) ?>
                        </a>
                        <div class="pilot-company-name">
                            <?= htmlspecialchars($app['company_name']) ?>
                        </div>
                    </div>
                </div>

                <div class="pilot-app-docs">
                    <?php if (!empty($app['cover_letter_text'])): ?>
                        <details class="pilot-doc-block">
                            <summary class="pilot-doc-toggle">Lettre de motivation</summary>
                            <div class="pilot-doc-content">
                                <?= nl2br(htmlspecialchars($app['cover_letter_text'])) ?>
                            </div>
                        </details>
                    <?php endif; ?>

                    <?php if (!empty($app['cv_path'])): ?>
                        <a href="/cv?file=<?= htmlspecialchars(basename($app['cv_path'])) ?>"
                           target="_blank"
                           class="pilot-cv-link">
                            Voir le CV (PDF)
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.pilot-header { margin-bottom: 24px; }
.pilot-header h1 { font-size: 1.5rem; font-weight: 900; color: #161b26; margin-bottom: 4px; }
.pilot-sub { color: #667085; font-size: 0.95rem; }
.pilot-empty { text-align: center; padding: 40px; color: #667085; }

.pilot-apps-list { display: flex; flex-direction: column; gap: 16px; }

.pilot-app-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 20px 24px;
    box-shadow: 0 2px 8px rgba(15,23,42,0.04);
}

.pilot-app-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.pilot-student-info { display: flex; align-items: center; gap: 12px; }

.pilot-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: #d71920; color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 0.9rem; flex-shrink: 0;
}

.pilot-student-name { font-weight: 700; color: #161b26; font-size: 1rem; }
.pilot-app-date { font-size: 0.82rem; color: #667085; margin-top: 2px; }

.pilot-offer-info { text-align: right; }
.pilot-offer-title { font-weight: 700; color: #d71920; text-decoration: none; font-size: 0.95rem; display: block; }
.pilot-offer-title:hover { text-decoration: underline; }
.pilot-company-name { font-size: 0.85rem; color: #667085; margin-top: 3px; }

.pilot-app-docs { border-top: 1px solid #f3f4f6; padding-top: 14px; display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-start; }

.pilot-doc-block { flex: 1; min-width: 250px; }
.pilot-doc-toggle {
    cursor: pointer; font-weight: 600; font-size: 0.9rem;
    color: #161b26; list-style: none; padding: 6px 12px;
    background: #f3f4f6; border-radius: 8px; display: inline-block;
}
.pilot-doc-toggle:hover { background: #e5e7eb; }
.pilot-doc-content {
    margin-top: 10px; padding: 12px 14px;
    background: #f9fafb; border-radius: 8px;
    font-size: 0.88rem; color: #374151; line-height: 1.6;
    white-space: pre-wrap;
}

.pilot-cv-link {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; background: #fef2f2;
    color: #d71920; border-radius: 8px;
    font-weight: 600; font-size: 0.88rem; text-decoration: none;
    border: 1px solid #fecaca;
}
.pilot-cv-link:hover { background: #fee2e2; }

[data-theme="dark"] .pilot-header h1   { color: var(--dk-text); }
[data-theme="dark"] .pilot-sub         { color: var(--dk-muted); }
[data-theme="dark"] .pilot-empty       { color: var(--dk-muted); }
[data-theme="dark"] .pilot-app-card    { background: var(--dk-surface); border-color: var(--dk-border); }
[data-theme="dark"] .pilot-student-name { color: var(--dk-text); }
[data-theme="dark"] .pilot-app-date    { color: var(--dk-muted); }
[data-theme="dark"] .pilot-company-name { color: var(--dk-muted); }
[data-theme="dark"] .pilot-app-docs    { border-top-color: var(--dk-border); }
[data-theme="dark"] .pilot-doc-toggle  { background: var(--dk-surface2); color: var(--dk-text); }
[data-theme="dark"] .pilot-doc-toggle:hover { background: var(--dk-border); }
[data-theme="dark"] .pilot-doc-content { background: var(--dk-bg); color: #adbac7; }
[data-theme="dark"] .pilot-cv-link     { background: rgba(215,25,32,0.1); border-color: rgba(215,25,32,0.25); color: #ff6b6b; }
[data-theme="dark"] .pilot-cv-link:hover { background: rgba(215,25,32,0.18); }
</style>