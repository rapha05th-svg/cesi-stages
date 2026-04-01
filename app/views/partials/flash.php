<?php
$flash = $_SESSION['flash'] ?? [];
unset($_SESSION['flash']);
if (!empty($flash)):
?>
<div id="toast-container"></div>
<script>
(function(){
    const toasts = <?= json_encode($flash) ?>;
    const icons = {
        success: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>',
        error:   '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        info:    '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
        dev:     '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
    };
    const container = document.getElementById('toast-container');
    toasts.forEach(function(f, i) {
        const t = document.createElement('div');
        t.className = 'toast toast-' + f.type;
        t.innerHTML = '<span class="toast-icon">' + (icons[f.type] || icons.info) + '</span>'
                    + '<span class="toast-msg">' + (f.type === 'dev' ? f.msg : f.msg.replace(/</g,'&lt;')) + '</span>'
                    + '<button class="toast-close" onclick="this.parentElement.remove()">×</button>';
        container.appendChild(t);
        setTimeout(function(){ t.classList.add('toast-show'); }, 80 + i * 120);
        setTimeout(function(){ t.classList.add('toast-hide'); setTimeout(function(){ t.remove(); }, 400); }, 4500 + i * 120);
    });
})();
</script>
<?php endif; ?>
