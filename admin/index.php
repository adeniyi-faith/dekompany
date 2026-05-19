<?php
require_once __DIR__ . '/auth.php';
$current_user = wp_get_current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DKHQ Admin — Command Centre</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Syne:wght@400;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
/* ── RESET & BASE ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --bg:        #050a18;
    --bg2:       #080f24;
    --panel:     #0c1530;
    --panel2:    #0f1a38;
    --border:    #1a2a5e;
    --border2:   #243070;
    --gold:      #e8b84b;
    --gold2:     #f5d07a;
    --blue:      #3b72f7;
    --blue2:     #5b8eff;
    --green:     #22c984;
    --red:       #f05a5a;
    --orange:    #f5a442;
    --purple:    #a78bfa;
    --text:      #e2e8f0;
    --text2:     #8da0bf;
    --text3:     #5570a0;
    --mono:      'JetBrains Mono', monospace;
    --sans:      'Space Grotesk', sans-serif;
    --display:   'Syne', sans-serif;
    --sidebar-w: 260px;
    --topbar-h:  64px;
    --radius:    10px;
}

html, body { height: 100%; font-family: var(--sans); background: var(--bg); color: var(--text); overflow: hidden; }

/* ── LAYOUT ── */
.app { display: flex; height: 100vh; }

/* ── SIDEBAR ── */
.sidebar {
    width: var(--sidebar-w);
    background: var(--bg2);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    overflow-y: auto;
}
.sidebar-brand {
    padding: 20px 20px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 12px;
}
.brand-icon {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, var(--gold), #b8860b);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #000;
}
.brand-text { line-height: 1.2; }
.brand-name { font-family: var(--display); font-weight: 700; font-size: 15px; color: white; }
.brand-sub  { font-size: 10px; color: var(--text3); text-transform: uppercase; letter-spacing: .08em; }

.nav-section { padding: 20px 12px 8px; }
.nav-label   { font-size: 10px; font-weight: 600; color: var(--text3); text-transform: uppercase; letter-spacing: .1em; padding: 0 8px; margin-bottom: 6px; }
.nav-item    {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; border-radius: 8px;
    font-size: 13.5px; font-weight: 500; color: var(--text2);
    cursor: pointer; transition: all .15s; position: relative;
    user-select: none;
}
.nav-item:hover  { background: var(--panel); color: var(--text); }
.nav-item.active { background: linear-gradient(90deg, rgba(59,114,247,.18), rgba(59,114,247,.06)); color: white; border-left: 2px solid var(--blue); margin-left: 0; padding-left: 10px; }
.nav-item i      { width: 18px; text-align: center; font-size: 13px; }
.nav-item .badge { margin-left: auto; background: var(--red); color: white; border-radius: 999px; font-size: 10px; font-weight: 700; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; padding: 0 5px; }

.sidebar-footer { margin-top: auto; padding: 16px; border-top: 1px solid var(--border); }
.user-chip { display: flex; align-items: center; gap: 10px; }
.user-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--blue); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: white; }
.user-name  { font-size: 13px; font-weight: 600; color: var(--text); }
.user-role  { font-size: 11px; color: var(--text3); }

/* ── MAIN ── */
.main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

/* ── TOPBAR ── */
.topbar {
    height: var(--topbar-h);
    background: var(--bg2);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center;
    padding: 0 28px; gap: 16px; flex-shrink: 0;
}
.topbar-title { font-family: var(--display); font-size: 18px; font-weight: 700; color: white; flex: 1; }
.topbar-badge { font-size: 11px; background: var(--panel2); color: var(--text3); border: 1px solid var(--border); border-radius: 6px; padding: 3px 10px; font-family: var(--mono); }
.btn { display: inline-flex; align-items: center; gap: 7px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; transition: all .15s; font-family: var(--sans); }
.btn-primary { background: var(--blue); color: white; }
.btn-primary:hover { background: var(--blue2); }
.btn-gold { background: var(--gold); color: #000; }
.btn-gold:hover { background: var(--gold2); }
.btn-ghost { background: transparent; color: var(--text2); border: 1px solid var(--border); }
.btn-ghost:hover { background: var(--panel); color: var(--text); }
.btn-danger { background: var(--red); color: white; }
.btn-sm { padding: 5px 11px; font-size: 12px; }

/* ── CONTENT ── */
.content { flex: 1; overflow-y: auto; padding: 28px; }
.page { display: none; }
.page.active { display: block; animation: fadeUp .3s ease; }
@keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

/* ── STATS GRID ── */
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
.stat-card { background: var(--panel); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; position: relative; overflow: hidden; }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
.stat-card.gold::before  { background: var(--gold); }
.stat-card.blue::before  { background: var(--blue); }
.stat-card.green::before { background: var(--green); }
.stat-card.purple::before { background: var(--purple); }
.stat-card.orange::before { background: var(--orange); }
.stat-label { font-size: 11px; color: var(--text3); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 8px; }
.stat-value { font-family: var(--display); font-size: 32px; font-weight: 800; color: white; line-height: 1; }
.stat-sub   { font-size: 12px; color: var(--text3); margin-top: 4px; }

/* ── PANELS ── */
.panel { background: var(--panel); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 20px; }
.panel-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.panel-title { font-family: var(--display); font-size: 15px; font-weight: 700; color: white; display: flex; align-items: center; gap: 9px; }
.panel-title i { color: var(--gold); }
.panel-body { padding: 20px; }

/* ── TABLES ── */
.data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.data-table th { text-align: left; padding: 10px 14px; font-size: 11px; font-weight: 600; color: var(--text3); text-transform: uppercase; letter-spacing: .08em; border-bottom: 1px solid var(--border); background: var(--bg2); }
.data-table td { padding: 12px 14px; border-bottom: 1px solid var(--border); color: var(--text2); vertical-align: top; }
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: var(--panel2); }
.data-table .mono { font-family: var(--mono); font-size: 11px; color: var(--text3); }

/* ── STATUS BADGES ── */
.badge-pill { display: inline-block; padding: 3px 9px; border-radius: 999px; font-size: 11px; font-weight: 600; }
.badge-new      { background: rgba(59,114,247,.2); color: var(--blue2); }
.badge-contacted { background: rgba(232,184,75,.2); color: var(--gold2); }
.badge-converted { background: rgba(34,201,132,.2); color: var(--green); }
.badge-archived { background: rgba(85,112,160,.2); color: var(--text3); }
.badge-academic { background: rgba(167,139,250,.2); color: var(--purple); }
.badge-business { background: rgba(59,114,247,.2); color: var(--blue2); }

/* ── FORMS ── */
.form-group { margin-bottom: 18px; }
.form-label { display: block; font-size: 12px; font-weight: 600; color: var(--text2); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .06em; }
.form-input, .form-select, .form-textarea {
    width: 100%; background: var(--bg); border: 1px solid var(--border2); border-radius: 8px;
    color: var(--text); font-family: var(--sans); font-size: 13.5px; padding: 10px 14px;
    transition: border .15s;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none; border-color: var(--blue);
}
.form-textarea { min-height: 160px; resize: vertical; font-family: var(--mono); font-size: 12.5px; line-height: 1.6; }
.form-grid   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

/* ── PROMPT CARDS ── */
.prompt-card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px; margin-bottom: 14px; cursor: pointer; transition: border .15s; }
.prompt-card:hover  { border-color: var(--border2); }
.prompt-card.active { border-color: var(--blue); }
.prompt-sector { display: inline-block; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; padding: 3px 9px; border-radius: 999px; margin-bottom: 8px; }
.prompt-sector.academic { background: rgba(167,139,250,.2); color: var(--purple); }
.prompt-sector.business { background: rgba(59,114,247,.2); color: var(--blue2); }
.prompt-sector.concierge { background: rgba(232,184,75,.2); color: var(--gold); }
.prompt-label { font-size: 15px; font-weight: 700; color: white; margin-bottom: 6px; }
.prompt-preview { font-size: 12px; color: var(--text3); font-family: var(--mono); line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

/* ── CHAT LOG ── */
.session-list { max-height: 500px; overflow-y: auto; }
.session-item { padding: 12px 16px; border-bottom: 1px solid var(--border); cursor: pointer; transition: background .12s; }
.session-item:hover   { background: var(--panel2); }
.session-item.active  { background: rgba(59,114,247,.1); border-left: 3px solid var(--blue); }
.session-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
.session-preview { font-size: 12px; color: var(--text3); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.chat-bubble { padding: 9px 14px; border-radius: 12px; font-size: 13px; line-height: 1.5; margin-bottom: 8px; max-width: 85%; }
.chat-user { background: rgba(59,114,247,.2); color: var(--text); margin-left: auto; border-radius: 12px 12px 4px 12px; }
.chat-bot  { background: var(--panel2); color: var(--text2); border-radius: 12px 12px 12px 4px; }
.chat-wrap { display: flex; flex-direction: column; max-height: 480px; overflow-y: auto; padding: 16px; gap: 2px; }
.chat-wrap .chat-user { display: flex; justify-content: flex-end; }
.chat-wrap .chat-bot  { display: flex; justify-content: flex-start; }

/* ── TOGGLE SWITCHES ── */
.toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid var(--border); }
.toggle-row:last-child { border-bottom: none; }
.toggle-info h4 { font-size: 14px; font-weight: 600; color: var(--text); }
.toggle-info p  { font-size: 12px; color: var(--text3); margin-top: 2px; font-family: var(--mono); }
.switch { position: relative; width: 48px; height: 26px; flex-shrink: 0; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; inset: 0; background: var(--border2); border-radius: 999px; transition: .3s; }
.slider::before { content: ''; position: absolute; width: 20px; height: 20px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: .3s; }
input:checked + .slider { background: var(--green); }
input:checked + .slider::before { transform: translateX(22px); }

/* ── MEDIA GRID ── */
.media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; }
.media-item { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; cursor: pointer; transition: border .15s; }
.media-item:hover { border-color: var(--blue); }
.media-thumb { width: 100%; height: 110px; object-fit: cover; display: block; background: var(--panel2); }
.media-thumb-icon { width: 100%; height: 110px; display: flex; align-items: center; justify-content: center; font-size: 36px; background: var(--panel2); color: var(--text3); }
.media-meta { padding: 8px; }
.media-name { font-size: 11px; color: var(--text3); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* ── UPLOAD DROP ── */
.drop-zone { border: 2px dashed var(--border2); border-radius: var(--radius); padding: 40px 20px; text-align: center; cursor: pointer; transition: all .2s; }
.drop-zone:hover, .drop-zone.drag { border-color: var(--blue); background: rgba(59,114,247,.05); }
.drop-zone i { font-size: 32px; color: var(--text3); margin-bottom: 10px; }
.drop-zone p { color: var(--text3); font-size: 13px; }

/* ── PRESENTATION BUILDER ── */
.section-block { background: var(--bg2); border: 1px solid var(--border); border-radius: 8px; padding: 16px; margin-bottom: 12px; }
.section-block-head { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
.section-type-label { font-size: 11px; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: .1em; }

/* ── TABS ── */
.tab-bar { display: flex; gap: 4px; border-bottom: 1px solid var(--border); margin-bottom: 20px; }
.tab { padding: 9px 16px; font-size: 13px; font-weight: 600; color: var(--text3); cursor: pointer; border-radius: 8px 8px 0 0; border-bottom: 2px solid transparent; transition: all .15s; }
.tab:hover  { color: var(--text); }
.tab.active { color: var(--gold); border-color: var(--gold); }

/* ── SEARCH ── */
.search-box { display: flex; align-items: center; gap: 10px; background: var(--bg); border: 1px solid var(--border2); border-radius: 8px; padding: 8px 14px; }
.search-box i { color: var(--text3); font-size: 13px; }
.search-box input { background: none; border: none; outline: none; font-family: var(--sans); font-size: 13px; color: var(--text); flex: 1; }

/* ── MODAL ── */
.modal-bg { position: fixed; inset: 0; background: rgba(0,0,0,.7); backdrop-filter: blur(4px); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 20px; }
.modal-bg.open { display: flex; }
.modal { background: var(--panel); border: 1px solid var(--border2); border-radius: 14px; width: 100%; max-width: 700px; max-height: 90vh; overflow-y: auto; }
.modal-head { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.modal-title { font-family: var(--display); font-size: 17px; font-weight: 700; color: white; }
.modal-close { width: 32px; height: 32px; border-radius: 50%; background: var(--panel2); border: none; color: var(--text2); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; }
.modal-body { padding: 24px; }
.modal-foot { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; gap: 10px; justify-content: flex-end; }

/* ── TOAST ── */
.toast-container { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
.toast { background: var(--panel2); border: 1px solid var(--border2); border-radius: 10px; padding: 12px 18px; font-size: 13.5px; color: var(--text); display: flex; align-items: center; gap: 10px; animation: toastIn .3s ease; min-width: 240px; max-width: 360px; }
.toast.success { border-color: var(--green); }
.toast.error   { border-color: var(--red); }
.toast i       { font-size: 15px; }
.toast.success i { color: var(--green); }
.toast.error   i { color: var(--red); }
@keyframes toastIn { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }

/* ── EMPTY STATE ── */
.empty-state { text-align: center; padding: 60px 20px; color: var(--text3); }
.empty-state i { font-size: 48px; margin-bottom: 16px; opacity: .4; }
.empty-state h3 { font-size: 16px; color: var(--text2); margin-bottom: 6px; }
.empty-state p  { font-size: 13px; }

/* ── SCROLLBAR ── */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: var(--bg2); }
::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 999px; }

/* ── UTILITIES ── */
.flex { display: flex; }
.gap-2 { gap: 8px; }
.gap-3 { gap: 12px; }
.items-center { align-items: center; }
.justify-between { justify-content: space-between; }
.flex-1 { flex: 1; }
.text-gold { color: var(--gold); }
.text-muted { color: var(--text3); font-size: 12px; }
.text-sm { font-size: 13px; }
.fw-700 { font-weight: 700; }
.mb-3 { margin-bottom: 12px; }
.mb-4 { margin-bottom: 16px; }
.mb-5 { margin-bottom: 20px; }
.mt-3 { margin-top: 12px; }
.w-full { width: 100%; }
.loading { opacity: .5; pointer-events: none; }
.tag { display: inline-block; background: var(--panel2); border: 1px solid var(--border); color: var(--text3); font-size: 11px; padding: 2px 8px; border-radius: 5px; }

/* ── TWO PANE ── */
.two-pane { display: grid; grid-template-columns: 320px 1fr; gap: 0; height: calc(100vh - var(--topbar-h) - 56px); overflow: hidden; }
.pane-left { border-right: 1px solid var(--border); overflow-y: auto; }
.pane-right { overflow-y: auto; padding: 20px; }
</style>
</head>

<body>
<div class="app">

<!-- ── SIDEBAR ── -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">⚡</div>
        <div class="brand-text">
            <div class="brand-name">DKHQ Admin</div>
            <div class="brand-sub">Command Centre</div>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-label">Overview</div>
        <div class="nav-item active" onclick="showPage('dashboard')">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-label">AI Intelligence</div>
        <div class="nav-item" onclick="showPage('prompts')">
            <i class="fa-solid fa-brain"></i> AI Prompt Manager
        </div>
        <div class="nav-item" onclick="showPage('chatlogs')">
            <i class="fa-solid fa-comments"></i> Chat Log Viewer
            <span class="badge" id="badge-logs">—</span>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-label">Business</div>
        <div class="nav-item" onclick="showPage('leads')">
            <i class="fa-solid fa-users"></i> Lead Capture
            <span class="badge" id="badge-leads">—</span>
        </div>
        <div class="nav-item" onclick="showPage('presentations')">
            <i class="fa-solid fa-file-powerpoint"></i> Client Pages
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-label">Site Control</div>
        <div class="nav-item" onclick="showPage('toggles')">
            <i class="fa-solid fa-toggle-on"></i> Section Toggles
        </div>
        <div class="nav-item" onclick="showPage('media')">
            <i class="fa-solid fa-photo-film"></i> Media Library
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="user-avatar"><?php echo strtoupper(substr($current_user->display_name, 0, 1)); ?></div>
            <div>
                <div class="user-name"><?php echo esc_html($current_user->display_name); ?></div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>
</aside>

<!-- ── MAIN ── -->
<div class="main">
    <div class="topbar">
        <div class="topbar-title" id="page-title">Dashboard</div>
        <span class="topbar-badge" id="page-badge">DKHQ v1.0</span>
        <div id="topbar-actions"></div>
    </div>

    <div class="content">

        <!-- ════════ DASHBOARD ════════ -->
        <div class="page active" id="page-dashboard">
            <div class="stats-grid" id="stats-grid">
                <div class="stat-card gold">
                    <div class="stat-label">New Leads</div>
                    <div class="stat-value" id="stat-new-leads">—</div>
                    <div class="stat-sub">Awaiting contact</div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-label">Chat Sessions</div>
                    <div class="stat-value" id="stat-sessions">—</div>
                    <div class="stat-sub">Total conversations</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-label">Total Messages</div>
                    <div class="stat-value" id="stat-messages">—</div>
                    <div class="stat-sub">Academic + Business</div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-label">Client Pages</div>
                    <div class="stat-value" id="stat-presentations">—</div>
                    <div class="stat-sub">Presentations built</div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-label">Media Files</div>
                    <div class="stat-value" id="stat-media">—</div>
                    <div class="stat-sub">Uploaded assets</div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="fa-solid fa-users"></i> Recent Leads</div>
                        <button class="btn btn-ghost btn-sm" onclick="showPage('leads')">View All</button>
                    </div>
                    <table class="data-table" id="dash-leads-table">
                        <thead><tr><th>Name/Email</th><th>Sector</th><th>Status</th></tr></thead>
                        <tbody><tr><td colspan="3" style="text-align:center;color:var(--text3);padding:24px;">Loading…</td></tr></tbody>
                    </table>
                </div>
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="fa-solid fa-comments"></i> Recent Conversations</div>
                        <button class="btn btn-ghost btn-sm" onclick="showPage('chatlogs')">View All</button>
                    </div>
                    <table class="data-table" id="dash-sessions-table">
                        <thead><tr><th>Session</th><th>Sector</th><th>Msgs</th><th>Time</th></tr></thead>
                        <tbody><tr><td colspan="4" style="text-align:center;color:var(--text3);padding:24px;">Loading…</td></tr></tbody>
                    </table>
                </div>
            </div>

            <div class="panel mt-3" style="margin-top:20px;">
                <div class="panel-head">
                    <div class="panel-title"><i class="fa-solid fa-chart-bar"></i> Chat Activity by Sector</div>
                </div>
                <div class="panel-body">
                    <div style="display:flex;gap:32px;">
                        <div>
                            <div class="stat-label" style="margin-bottom:6px;">Academic</div>
                            <div style="font-size:28px;font-weight:800;color:var(--purple);" id="stat-academic">—</div>
                            <div class="text-muted">messages</div>
                        </div>
                        <div>
                            <div class="stat-label" style="margin-bottom:6px;">Business</div>
                            <div style="font-size:28px;font-weight:800;color:var(--blue2);" id="stat-business">—</div>
                            <div class="text-muted">messages</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════ PROMPTS ════════ -->
        <div class="page" id="page-prompts">
            <div style="display:grid;grid-template-columns:300px 1fr;gap:20px;height:calc(100vh - 120px);">
                <div>
                    <div class="flex gap-2 items-center mb-4">
                        <button class="btn btn-gold btn-sm w-full" onclick="openPromptModal()"><i class="fa-solid fa-plus"></i> New Prompt</button>
                    </div>
                    <div id="prompts-list">
                        <div class="text-muted" style="text-align:center;padding:24px;">Loading…</div>
                    </div>
                </div>
                <div id="prompt-editor-panel">
                    <div class="empty-state">
                        <i class="fa-solid fa-brain"></i>
                        <h3>Select a prompt to edit</h3>
                        <p>Click any prompt on the left, or create a new one.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════ CHAT LOGS ════════ -->
        <div class="page" id="page-chatlogs">
            <div class="flex gap-2 items-center mb-4">
                <div class="search-box flex-1"><i class="fa-solid fa-search"></i><input type="text" id="log-search" placeholder="Search messages…" oninput="filterLogs()"></div>
                <select class="form-select" style="width:160px;" id="log-sector-filter" onchange="loadSessions()">
                    <option value="">All Sectors</option>
                    <option value="academic">Academic</option>
                    <option value="business">Business</option>
                </select>
            </div>
            <div style="display:grid;grid-template-columns:340px 1fr;gap:0;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;height:calc(100vh - 180px);">
                <div style="border-right:1px solid var(--border);overflow-y:auto;" id="sessions-pane">
                    <div class="text-muted" style="text-align:center;padding:24px;">Loading sessions…</div>
                </div>
                <div style="overflow-y:auto;" id="chat-detail-pane">
                    <div class="empty-state">
                        <i class="fa-solid fa-comment-dots"></i>
                        <h3>Select a conversation</h3>
                        <p>Click a session on the left to view the full chat log.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════ LEADS ════════ -->
        <div class="page" id="page-leads">
            <div class="flex gap-2 items-center mb-4">
                <div class="search-box flex-1"><i class="fa-solid fa-search"></i><input type="text" placeholder="Search leads…" id="lead-search" oninput="filterLeads()"></div>
                <select class="form-select" style="width:150px;" id="lead-sector-filter" onchange="loadLeads()">
                    <option value="">All Sectors</option>
                    <option value="academic">Academic</option>
                    <option value="business">Business</option>
                </select>
                <select class="form-select" style="width:150px;" id="lead-status-filter" onchange="loadLeads()">
                    <option value="">All Status</option>
                    <option value="new">New</option>
                    <option value="contacted">Contacted</option>
                    <option value="converted">Converted</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title"><i class="fa-solid fa-users"></i> Leads</div>
                    <span class="text-muted" id="lead-count">Loading…</span>
                </div>
                <table class="data-table" id="leads-table">
                    <thead>
                        <tr>
                            <th>Contact</th>
                            <th>Sector</th>
                            <th>First Query</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody><tr><td colspan="6" style="text-align:center;color:var(--text3);padding:32px;">Loading…</td></tr></tbody>
                </table>
            </div>
        </div>

        <!-- ════════ SECTION TOGGLES ════════ -->
        <div class="page" id="page-toggles">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="fa-solid fa-graduation-cap"></i> Academic Sector</div>
                    </div>
                    <div class="panel-body" id="toggles-academic">Loading…</div>
                </div>
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="fa-solid fa-briefcase"></i> Business Sector</div>
                    </div>
                    <div class="panel-body" id="toggles-business">Loading…</div>
                </div>
            </div>
            <div class="panel" style="margin-top:20px;">
                <div class="panel-head">
                    <div class="panel-title"><i class="fa-solid fa-plus"></i> Add New Toggle</div>
                </div>
                <div class="panel-body">
                    <div class="form-grid-3">
                        <div class="form-group">
                            <label class="form-label">Sector</label>
                            <select class="form-select" id="new-toggle-sector">
                                <option value="academic">Academic</option>
                                <option value="business">Business</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Section Key (HTML id)</label>
                            <input class="form-input" id="new-toggle-key" placeholder="e.g. student-lounge">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Label</label>
                            <input class="form-input" id="new-toggle-label" placeholder="e.g. Student Lounge">
                        </div>
                    </div>
                    <button class="btn btn-primary" onclick="addToggle()"><i class="fa-solid fa-plus"></i> Add Toggle</button>
                </div>
            </div>
        </div>

        <!-- ════════ MEDIA ════════ -->
        <div class="page" id="page-media">
            <div class="panel mb-4">
                <div class="panel-body">
                    <div class="drop-zone" id="drop-zone" onclick="document.getElementById('media-upload-input').click()">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>Click to upload or drag & drop files here</p>
                        <p style="font-size:11px;margin-top:6px;">JPEG, PNG, WebP, SVG, PDF — max 5MB</p>
                    </div>
                    <input type="file" id="media-upload-input" style="display:none;" multiple accept="image/*,.pdf" onchange="uploadFiles(this.files)">
                </div>
            </div>
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title"><i class="fa-solid fa-photo-film"></i> Media Library</div>
                    <span class="text-muted" id="media-count">Loading…</span>
                </div>
                <div class="panel-body">
                    <div class="media-grid" id="media-grid">
                        <div class="text-muted" style="grid-column:1/-1;text-align:center;padding:32px;">Loading…</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════ PRESENTATIONS ════════ -->
        <div class="page" id="page-presentations">
            <div class="flex gap-2 items-center mb-4">
                <button class="btn btn-gold" onclick="openPresentationModal()"><i class="fa-solid fa-plus"></i> New Client Page</button>
            </div>
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title"><i class="fa-solid fa-file-powerpoint"></i> Client Presentation Pages</div>
                </div>
                <table class="data-table" id="pres-table">
                    <thead><tr><th>Title</th><th>Client</th><th>Sector</th><th>Status</th><th>Views</th><th>Created</th><th>Actions</th></tr></thead>
                    <tbody><tr><td colspan="7" style="text-align:center;color:var(--text3);padding:32px;">Loading…</td></tr></tbody>
                </table>
            </div>
        </div>

    </div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<!-- ════ MODALS ════ -->

<!-- Prompt Modal -->
<div class="modal-bg" id="modal-prompt">
    <div class="modal">
        <div class="modal-head">
            <div class="modal-title" id="prompt-modal-title">New AI Prompt</div>
            <button class="modal-close" onclick="closeModal('modal-prompt')"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="prompt-id" value="0">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Sector</label>
                    <select class="form-select" id="prompt-sector">
                        <option value="academic">Academic</option>
                        <option value="business">Business</option>
                        <option value="concierge">Concierge</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Label / Name</label>
                    <input class="form-input" id="prompt-label" placeholder="e.g. Academic Coach">
                </div>
            </div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">AI Model</label>
                    <select class="form-select" id="prompt-model">
                        <option value="gemini-2.5-flash-lite">Gemini 2.5 Flash Lite</option>
                        <option value="gemini-2.0-flash">Gemini 2.0 Flash</option>
                        <option value="gemini-1.5-pro">Gemini 1.5 Pro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Temperature (0–1)</label>
                    <input class="form-input" type="number" id="prompt-temp" min="0" max="1" step="0.1" value="0.7">
                </div>
                <div class="form-group">
                    <label class="form-label">Max Tokens</label>
                    <input class="form-input" type="number" id="prompt-tokens" value="300" min="50" max="2000">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">System Prompt <span class="text-muted">(instructions for the AI)</span></label>
                <textarea class="form-textarea" id="prompt-system" style="min-height:220px;" placeholder="You are a helpful assistant for De Kompany…"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" id="prompt-active" checked style="width:16px;height:16px;">
                    Active (used by frontend)
                </label>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeModal('modal-prompt')">Cancel</button>
            <button class="btn btn-gold" onclick="savePrompt()"><i class="fa-solid fa-save"></i> Save Prompt</button>
        </div>
    </div>
</div>

<!-- Lead Edit Modal -->
<div class="modal-bg" id="modal-lead">
    <div class="modal">
        <div class="modal-head">
            <div class="modal-title">Edit Lead</div>
            <button class="modal-close" onclick="closeModal('modal-lead')"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="lead-edit-id">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="lead-edit-status">
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="converted">Converted</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone (if known)</label>
                    <input class="form-input" id="lead-edit-phone" placeholder="+234…">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Internal Notes</label>
                <textarea class="form-textarea" id="lead-edit-notes" style="min-height:100px;" placeholder="Add notes about this lead…"></textarea>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeModal('modal-lead')">Cancel</button>
            <button class="btn btn-primary" onclick="saveLead()"><i class="fa-solid fa-save"></i> Update</button>
        </div>
    </div>
</div>

<!-- Presentation Modal -->
<div class="modal-bg" id="modal-presentation">
    <div class="modal" style="max-width:860px;">
        <div class="modal-head">
            <div class="modal-title" id="pres-modal-title">New Client Page</div>
            <button class="modal-close" onclick="closeModal('modal-presentation')"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="pres-id" value="0">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Page Title</label>
                    <input class="form-input" id="pres-title" placeholder="e.g. Proposal for Acme Corp" oninput="autoSlug()">
                </div>
                <div class="form-group">
                    <label class="form-label">URL Slug</label>
                    <input class="form-input" id="pres-slug" placeholder="acme-corp-proposal">
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Client Name</label>
                    <input class="form-input" id="pres-client" placeholder="Acme Corporation">
                </div>
                <div class="form-group">
                    <label class="form-label">Sector / Theme</label>
                    <select class="form-select" id="pres-sector">
                        <option value="business">Business (Light)</option>
                        <option value="academic">Academic (Dark Blue)</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Hero Headline</label>
                <input class="form-input" id="pres-headline" placeholder="Structured Intelligence for Your Next Chapter">
            </div>
            <div class="form-group">
                <label class="form-label">Hero Subheadline</label>
                <input class="form-input" id="pres-subheadline" placeholder="This proposal outlines De Kompany's approach…">
            </div>
            <div class="form-group">
                <label class="form-label">Content Sections <span class="text-muted">(JSON array — one block per section)</span></label>
                <textarea class="form-textarea" id="pres-sections" style="min-height:180px;">[
  {"type":"text","heading":"Our Understanding","body":"We understand your business needs…"},
  {"type":"list","heading":"What We Offer","items":["Brand Strategy","Documentation","Corporate Writing"]},
  {"type":"cta","heading":"Ready to Begin?","body":"Schedule a consultation today.","button":"Book a Call","link":"#"}
]</textarea>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Password (optional)</label>
                    <input class="form-input" id="pres-password" placeholder="Leave empty for public">
                </div>
                <div class="form-group" style="display:flex;align-items:center;gap:10px;padding-top:28px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;color:var(--text2);font-size:13px;">
                        <input type="checkbox" id="pres-published" style="width:16px;height:16px;">
                        Published (visible to clients)
                    </label>
                </div>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeModal('modal-presentation')">Cancel</button>
            <button class="btn btn-gold" onclick="savePresentation()"><i class="fa-solid fa-save"></i> Save Page</button>
        </div>
    </div>
</div>

<!-- Media Preview Modal -->
<div class="modal-bg" id="modal-media-preview">
    <div class="modal" style="max-width:500px;">
        <div class="modal-head">
            <div class="modal-title" id="media-preview-name">File Preview</div>
            <button class="modal-close" onclick="closeModal('modal-media-preview')"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body" style="text-align:center;">
            <img id="media-preview-img" src="" style="max-width:100%;max-height:320px;border-radius:8px;display:none;">
            <div id="media-preview-url" style="margin-top:12px;"></div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="copyMediaUrl()"><i class="fa-solid fa-copy"></i> Copy URL</button>
            <button class="btn btn-danger btn-sm" onclick="deleteMedia()"><i class="fa-solid fa-trash"></i> Delete</button>
        </div>
    </div>
</div>

<div class="toast-container" id="toast-container"></div>

<script>
const API = './api.php';
let allLeads = [];
let allSessions = [];
let selectedMediaId = null;
let selectedMediaUrl = '';

// ── NAVIGATION ──
function showPage(name) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('page-' + name).classList.add('active');
    document.querySelectorAll('.nav-item').forEach(n => {
        if (n.getAttribute('onclick')?.includes("'" + name + "'")) n.classList.add('active');
    });
    const titles = {
        dashboard: 'Dashboard', prompts: 'AI Prompt Manager',
        chatlogs: 'Chat Log Viewer', leads: 'Lead Capture',
        presentations: 'Client Pages', toggles: 'Section Toggles', media: 'Media Library'
    };
    document.getElementById('page-title').textContent = titles[name] || name;
    document.getElementById('topbar-actions').innerHTML = '';

    if (name === 'dashboard')     loadDashboard();
    if (name === 'prompts')       loadPrompts();
    if (name === 'chatlogs')      loadSessions();
    if (name === 'leads')         loadLeads();
    if (name === 'toggles')       loadToggles();
    if (name === 'media')         loadMedia();
    if (name === 'presentations') loadPresentations();
}

// ── API HELPER ──
async function api(action, params = {}, method = 'GET') {
    const isGet = method === 'GET';
    const url = API + '?action=' + action + (isGet ? '&' + new URLSearchParams(params) : '');
    const opts = { method };
    if (!isGet) {
        const fd = new FormData();
        Object.entries(params).forEach(([k, v]) => fd.append(k, v));
        opts.body = fd;
    }
    const r = await fetch(url, opts);
    return r.json();
}

// ── TOAST ──
function toast(msg, type = 'success') {
    const t = document.createElement('div');
    t.className = 'toast ' + type;
    t.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i> ${msg}`;
    document.getElementById('toast-container').appendChild(t);
    setTimeout(() => t.remove(), 3500);
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

// ════ DASHBOARD ════
async function loadDashboard() {
    const s = await api('get_stats');
    document.getElementById('stat-new-leads').textContent  = s.new_leads;
    document.getElementById('stat-sessions').textContent   = s.total_sessions;
    document.getElementById('stat-messages').textContent   = s.total_messages;
    document.getElementById('stat-presentations').textContent = s.presentations;
    document.getElementById('stat-media').textContent      = s.media_count;
    document.getElementById('stat-academic').textContent   = s.academic_msgs;
    document.getElementById('stat-business').textContent   = s.business_msgs;
    document.getElementById('badge-leads').textContent     = s.new_leads;
    document.getElementById('badge-logs').textContent      = s.total_sessions;

    // Recent leads
    const lb = document.querySelector('#dash-leads-table tbody');
    lb.innerHTML = s.recent_leads.length ? s.recent_leads.map(l => `
        <tr>
            <td><div style="font-weight:600;color:var(--text);">${l.name||'—'}</div><div class="mono">${l.email||'—'}</div></td>
            <td><span class="badge-pill badge-${l.sector}">${l.sector}</span></td>
            <td><span class="badge-pill badge-${l.status}">${l.status}</span></td>
        </tr>`).join('') : '<tr><td colspan="3" style="text-align:center;color:var(--text3);padding:24px;">No leads yet</td></tr>';

    // Recent sessions
    const sb = document.querySelector('#dash-sessions-table tbody');
    sb.innerHTML = s.recent_sessions.length ? s.recent_sessions.map(sess => `
        <tr>
            <td class="mono">${sess.session_id.substr(0,12)}…</td>
            <td><span class="badge-pill badge-${sess.sector}">${sess.sector}</span></td>
            <td>${sess.msgs}</td>
            <td class="mono">${fmtDate(sess.started)}</td>
        </tr>`).join('') : '<tr><td colspan="4" style="text-align:center;color:var(--text3);padding:24px;">No sessions yet</td></tr>';
}

// ════ PROMPTS ════
async function loadPrompts() {
    const rows = await api('get_prompts');
    const list = document.getElementById('prompts-list');
    list.innerHTML = rows.map(p => `
        <div class="prompt-card ${p.is_active == 1 ? '' : 'opacity-50'}" onclick="editPrompt(${p.id})" data-id="${p.id}">
            <div class="prompt-sector ${p.sector}">${p.sector}</div>
            <div class="prompt-label">${esc(p.prompt_label)}</div>
            <div class="prompt-preview">${esc(p.system_prompt)}</div>
            <div style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap;">
                <span class="tag">${esc(p.ai_model)}</span>
                <span class="tag">temp: ${p.temperature}</span>
                <span class="tag">${p.max_tokens} tokens</span>
                ${p.is_active == 1 ? '<span class="tag" style="color:var(--green);border-color:var(--green);">● ACTIVE</span>' : '<span class="tag" style="color:var(--text3);">inactive</span>'}
            </div>
        </div>`).join('') || '<div class="empty-state"><i class="fa-solid fa-brain"></i><h3>No prompts yet</h3></div>';
}

async function editPrompt(id) {
    const rows = await api('get_prompts');
    const p = rows.find(r => r.id == id);
    if (!p) return;
    document.getElementById('prompt-modal-title').textContent = 'Edit Prompt';
    document.getElementById('prompt-id').value      = p.id;
    document.getElementById('prompt-sector').value  = p.sector;
    document.getElementById('prompt-label').value   = p.prompt_label;
    document.getElementById('prompt-model').value   = p.ai_model;
    document.getElementById('prompt-temp').value    = p.temperature;
    document.getElementById('prompt-tokens').value  = p.max_tokens;
    document.getElementById('prompt-system').value  = p.system_prompt;
    document.getElementById('prompt-active').checked = p.is_active == 1;
    openModal('modal-prompt');
}

function openPromptModal() {
    document.getElementById('prompt-modal-title').textContent = 'New AI Prompt';
    document.getElementById('prompt-id').value = 0;
    ['prompt-label','prompt-system'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('prompt-sector').value = 'academic';
    document.getElementById('prompt-model').value  = 'gemini-2.5-flash-lite';
    document.getElementById('prompt-temp').value   = 0.7;
    document.getElementById('prompt-tokens').value = 300;
    document.getElementById('prompt-active').checked = true;
    openModal('modal-prompt');
}

async function savePrompt() {
    const id = document.getElementById('prompt-id').value;
    const params = {
        id, sector: document.getElementById('prompt-sector').value,
        prompt_label: document.getElementById('prompt-label').value,
        ai_model: document.getElementById('prompt-model').value,
        temperature: document.getElementById('prompt-temp').value,
        max_tokens: document.getElementById('prompt-tokens').value,
        system_prompt: document.getElementById('prompt-system').value,
        is_active: document.getElementById('prompt-active').checked ? 1 : 0,
    };
    const r = await api('save_prompt', params, 'POST');
    if (r.ok) { toast(r.msg); closeModal('modal-prompt'); loadPrompts(); }
    else toast(r.msg || 'Error', 'error');
}

// ════ CHAT LOGS ════
async function loadSessions() {
    const sector = document.getElementById('log-sector-filter').value;
    const pane = document.getElementById('sessions-pane');
    pane.innerHTML = '<div class="text-muted" style="text-align:center;padding:24px;">Loading…</div>';
    const data = await api('get_sessions', { sector });
    allSessions = data;
    renderSessions(data);
}

function renderSessions(sessions) {
    const pane = document.getElementById('sessions-pane');
    if (!sessions.length) {
        pane.innerHTML = '<div class="empty-state"><i class="fa-solid fa-comments"></i><h3>No sessions</h3><p>Chats will appear here.</p></div>';
        return;
    }
    pane.innerHTML = sessions.map(s => `
        <div class="session-item" onclick="loadSessionDetail('${s.session_id}', this)">
            <div class="session-meta">
                <span class="badge-pill badge-${s.sector}" style="font-size:10px;">${s.sector}</span>
                <span class="text-muted">${s.msg_count} msgs</span>
                <span class="text-muted" style="margin-left:auto;">${fmtDate(s.started)}</span>
            </div>
            <div class="session-preview">${esc(s.first_msg || '—')}</div>
        </div>`).join('');
}

function filterLogs() {
    const q = document.getElementById('log-search').value.toLowerCase();
    renderSessions(allSessions.filter(s => (s.first_msg||'').toLowerCase().includes(q) || s.session_id.includes(q)));
}

async function loadSessionDetail(sessionId, el) {
    document.querySelectorAll('.session-item').forEach(i => i.classList.remove('active'));
    if (el) el.classList.add('active');
    const msgs = await api('get_session_detail', { session_id: sessionId });
    const pane = document.getElementById('chat-detail-pane');
    pane.innerHTML = `
        <div style="padding:16px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <div>
                <div style="font-weight:700;color:white;">Session Detail</div>
                <div class="mono text-muted">${sessionId}</div>
            </div>
            <span class="badge-pill badge-${msgs[0]?.sector||'business'}">${msgs[0]?.sector||''}</span>
        </div>
        <div class="chat-wrap">
            ${msgs.map(m => `
                <div class="chat-${m.sender}">
                    <div class="chat-bubble chat-${m.sender}">
                        ${esc(m.message)}
                        <div style="font-size:10px;opacity:.5;margin-top:4px;">${fmtDate(m.created_at)} · ${m.sender}</div>
                    </div>
                </div>`).join('')}
        </div>`;
}

// ════ LEADS ════
async function loadLeads() {
    const sector = document.getElementById('lead-sector-filter').value;
    const status = document.getElementById('lead-status-filter').value;
    const data   = await api('get_leads', { sector, status });
    allLeads     = data;
    renderLeads(data);
    document.getElementById('lead-count').textContent = data.length + ' leads';
}

function filterLeads() {
    const q = document.getElementById('lead-search').value.toLowerCase();
    renderLeads(allLeads.filter(l =>
        (l.name||'').toLowerCase().includes(q) ||
        (l.email||'').toLowerCase().includes(q) ||
        (l.first_query||'').toLowerCase().includes(q)
    ));
}

function renderLeads(leads) {
    const tb = document.querySelector('#leads-table tbody');
    if (!leads.length) {
        tb.innerHTML = '<tr><td colspan="6"><div class="empty-state"><i class="fa-solid fa-users"></i><h3>No leads yet</h3><p>Leads are captured from chat conversations.</p></div></td></tr>';
        return;
    }
    tb.innerHTML = leads.map(l => `
        <tr>
            <td>
                <div style="font-weight:600;color:white;">${esc(l.name||'Anonymous')}</div>
                <div class="mono">${esc(l.email||'—')}</div>
                ${l.phone ? `<div class="mono">${esc(l.phone)}</div>` : ''}
            </td>
            <td><span class="badge-pill badge-${l.sector}">${l.sector}</span></td>
            <td style="max-width:280px;font-size:12px;color:var(--text2);">${esc((l.first_query||'').substr(0,120))}${(l.first_query||'').length>120?'…':''}</td>
            <td><span class="badge-pill badge-${l.status}">${l.status}</span></td>
            <td class="mono">${fmtDate(l.created_at)}</td>
            <td>
                <button class="btn btn-ghost btn-sm" onclick="openLeadEdit(${l.id}, '${esc(l.status)}', \`${esc(l.notes||'')}\`, '${esc(l.phone||'')}')"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" onclick="deleteLead(${l.id})"><i class="fa-solid fa-trash"></i></button>
            </td>
        </tr>`).join('');
}

function openLeadEdit(id, status, notes, phone) {
    document.getElementById('lead-edit-id').value       = id;
    document.getElementById('lead-edit-status').value   = status;
    document.getElementById('lead-edit-notes').value    = notes;
    document.getElementById('lead-edit-phone').value    = phone;
    openModal('modal-lead');
}

async function saveLead() {
    const id     = document.getElementById('lead-edit-id').value;
    const status = document.getElementById('lead-edit-status').value;
    const notes  = document.getElementById('lead-edit-notes').value;
    const phone  = document.getElementById('lead-edit-phone').value;
    const r = await api('update_lead', { id, status, notes, phone }, 'POST');
    if (r.ok) { toast('Lead updated'); closeModal('modal-lead'); loadLeads(); }
    else toast('Error updating lead', 'error');
}

async function deleteLead(id) {
    if (!confirm('Delete this lead?')) return;
    const r = await api('delete_lead', { id }, 'POST');
    if (r.ok) { toast('Lead deleted'); loadLeads(); }
}

// ════ TOGGLES ════
async function loadToggles() {
    const rows = await api('get_toggles');
    renderToggles(rows.filter(r => r.sector === 'academic'), 'toggles-academic');
    renderToggles(rows.filter(r => r.sector === 'business'), 'toggles-business');
}

function renderToggles(rows, containerId) {
    const el = document.getElementById(containerId);
    if (!rows.length) { el.innerHTML = '<p class="text-muted">No sections configured.</p>'; return; }
    el.innerHTML = rows.map(r => `
        <div class="toggle-row">
            <div class="toggle-info">
                <h4>${esc(r.section_label)}</h4>
                <p>#${esc(r.section_key)}</p>
            </div>
            <label class="switch">
                <input type="checkbox" ${r.is_visible == 1 ? 'checked' : ''} onchange="toggleSection('${r.sector}','${r.section_key}', this.checked)">
                <span class="slider"></span>
            </label>
        </div>`).join('');
}

async function toggleSection(sector, key, visible) {
    const r = await api('toggle_section', { sector, section_key: key, is_visible: visible ? 1 : 0 }, 'POST');
    if (r.ok) toast(`Section ${visible ? 'enabled' : 'disabled'}`);
}

async function addToggle() {
    const sector = document.getElementById('new-toggle-sector').value;
    const key    = document.getElementById('new-toggle-key').value.trim();
    const label  = document.getElementById('new-toggle-label').value.trim();
    if (!key || !label) { toast('Fill in all fields', 'error'); return; }
    const r = await api('add_toggle', { sector, section_key: key, section_label: label }, 'POST');
    if (r.ok) { toast('Toggle added'); loadToggles(); ['new-toggle-key','new-toggle-label'].forEach(id => document.getElementById(id).value=''); }
}

// ════ MEDIA ════
async function loadMedia() {
    const rows = await api('get_media');
    const grid = document.getElementById('media-grid');
    document.getElementById('media-count').textContent = rows.length + ' files';
    if (!rows.length) {
        grid.innerHTML = '<div style="grid-column:1/-1;" class="empty-state"><i class="fa-solid fa-photo-film"></i><h3>No media yet</h3><p>Upload files above.</p></div>';
        return;
    }
    grid.innerHTML = rows.map(m => `
        <div class="media-item" onclick="previewMedia(${m.id}, '${esc(m.file_url)}', '${esc(m.filename)}')">
            ${m.file_type && m.file_type.startsWith('image/')
                ? `<img class="media-thumb" src="${esc(m.file_url)}" alt="${esc(m.alt_text||m.filename)}">`
                : `<div class="media-thumb-icon"><i class="fa-solid fa-file-pdf"></i></div>`}
            <div class="media-meta"><div class="media-name">${esc(m.original_name||m.filename)}</div></div>
        </div>`).join('');
}

function previewMedia(id, url, name) {
    selectedMediaId  = id;
    selectedMediaUrl = url;
    document.getElementById('media-preview-name').textContent = name;
    const img = document.getElementById('media-preview-img');
    img.src = url; img.style.display = 'block';
    document.getElementById('media-preview-url').innerHTML = `<input class="form-input" value="${url}" readonly onclick="this.select()">`;
    openModal('modal-media-preview');
}

function copyMediaUrl() {
    navigator.clipboard.writeText(selectedMediaUrl).then(() => toast('URL copied!'));
}

async function deleteMedia() {
    if (!confirm('Delete this file?')) return;
    const r = await api('delete_media', { id: selectedMediaId }, 'POST');
    if (r.ok) { toast('File deleted'); closeModal('modal-media-preview'); loadMedia(); }
}

async function uploadFiles(files) {
    for (const file of files) {
        const fd = new FormData();
        fd.append('action', 'upload_media');
        fd.append('file', file);
        fd.append('alt_text', '');
        const r = await fetch(API, { method: 'POST', body: fd });
        const d = await r.json();
        if (d.ok) toast('Uploaded: ' + file.name);
        else toast('Failed: ' + (d.msg || 'unknown error'), 'error');
    }
    loadMedia();
}

// Drag & Drop
const dz = document.getElementById('drop-zone');
dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('drag'); });
dz.addEventListener('dragleave', () => dz.classList.remove('drag'));
dz.addEventListener('drop', e => { e.preventDefault(); dz.classList.remove('drag'); uploadFiles(e.dataTransfer.files); });

// ════ PRESENTATIONS ════
async function loadPresentations() {
    const rows = await api('get_presentations');
    const tb   = document.querySelector('#pres-table tbody');
    if (!rows.length) {
        tb.innerHTML = '<tr><td colspan="7"><div class="empty-state"><i class="fa-solid fa-file-powerpoint"></i><h3>No presentations yet</h3></div></td></tr>';
        return;
    }
    tb.innerHTML = rows.map(p => `
        <tr>
            <td style="font-weight:600;color:white;">${esc(p.title)}</td>
            <td>${esc(p.client_name||'—')}</td>
            <td><span class="badge-pill badge-${p.sector}">${p.sector}</span></td>
            <td>${p.is_published ? '<span class="badge-pill badge-converted">Published</span>' : '<span class="badge-pill badge-archived">Draft</span>'}</td>
            <td>${p.view_count}</td>
            <td class="mono">${fmtDate(p.created_at)}</td>
            <td style="display:flex;gap:6px;">
                <a href="../presentation.php?slug=${esc(p.slug)}" target="_blank" class="btn btn-ghost btn-sm"><i class="fa-solid fa-external-link"></i></a>
                <button class="btn btn-primary btn-sm" onclick="editPresentation(${p.id})"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" onclick="deletePresentation(${p.id})"><i class="fa-solid fa-trash"></i></button>
            </td>
        </tr>`).join('');
}

function openPresentationModal() {
    document.getElementById('pres-modal-title').textContent = 'New Client Page';
    document.getElementById('pres-id').value = 0;
    ['pres-title','pres-slug','pres-client','pres-headline','pres-subheadline','pres-password'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('pres-sector').value   = 'business';
    document.getElementById('pres-published').checked = false;
    openModal('modal-presentation');
}

async function editPresentation(id) {
    const p = await api('get_presentation', { id });
    document.getElementById('pres-modal-title').textContent = 'Edit Client Page';
    document.getElementById('pres-id').value           = p.id;
    document.getElementById('pres-title').value        = p.title;
    document.getElementById('pres-slug').value         = p.slug;
    document.getElementById('pres-client').value       = p.client_name;
    document.getElementById('pres-sector').value       = p.sector;
    document.getElementById('pres-headline').value     = p.hero_headline;
    document.getElementById('pres-subheadline').value  = p.hero_subheadline;
    document.getElementById('pres-sections').value     = p.sections;
    document.getElementById('pres-password').value     = p.password_protected || '';
    document.getElementById('pres-published').checked  = p.is_published == 1;
    openModal('modal-presentation');
}

async function savePresentation() {
    const id = document.getElementById('pres-id').value;
    const params = {
        id,
        slug:             document.getElementById('pres-slug').value,
        title:            document.getElementById('pres-title').value,
        client_name:      document.getElementById('pres-client').value,
        sector:           document.getElementById('pres-sector').value,
        hero_headline:    document.getElementById('pres-headline').value,
        hero_subheadline: document.getElementById('pres-subheadline').value,
        sections:         document.getElementById('pres-sections').value,
        theme:            document.getElementById('pres-sector').value,
        is_published:     document.getElementById('pres-published').checked ? 1 : 0,
        password_protected: document.getElementById('pres-password').value,
    };
    const r = await api('save_presentation', params, 'POST');
    if (r.ok) { toast(r.msg||'Saved!'); closeModal('modal-presentation'); loadPresentations(); }
    else toast(r.msg||'Error', 'error');
}

async function deletePresentation(id) {
    if (!confirm('Delete this presentation?')) return;
    const r = await api('delete_presentation', { id }, 'POST');
    if (r.ok) { toast('Deleted'); loadPresentations(); }
}

function autoSlug() {
    const title = document.getElementById('pres-title').value;
    document.getElementById('pres-slug').value = title.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
}

// ── UTILS ──
function esc(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}
function fmtDate(d) {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'2-digit', hour:'2-digit', minute:'2-digit' });
}

// Init
loadDashboard();
</script>
</body>
</html>
