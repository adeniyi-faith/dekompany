<?php
/**
 * De Kompany Admin — HTML Header & Shell (Open)
 * ─────────────────────────────────────────────────────────────────────────────
 * Location : /wp/admin/header.php
 * Purpose  : Outputs everything from <!DOCTYPE html> through the open
 *            <div class="content"> tag — the full page shell with sidebar,
 *            topbar, all CSS, and Google Font / icon CDN links.
 *
 * Included by : admin.php  (require_once __DIR__ . '/header.php')
 *
 * Depends on  : auth.php must already be included (auth.php is included at
 *               the top of admin.php before this file).
 * ─────────────────────────────────────────────────────────────────────────────
 */

// Resolve current-user display info (auth.php already validated the session)
$current_user = wp_get_current_user();
$first_name   = explode(' ', $current_user->display_name)[0];
$admin_name   = esc_js($current_user->display_name);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
<title>De Kompany — Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════════════════════════
   COLOUR THEMES
═══════════════════════════════════════════════════════════════ */
:root, html[data-theme="business"] {
    --bg:        #f8f9fb;
    --bg2:       #ffffff;
    --panel:     #ffffff;
    --panel2:    #f1f4f9;
    --sidebar:   #111827;
    --sidebar2:  #1f2937;
    --border:    #e5e9f0;
    --border2:   #d1d9e6;
    --primary:   #1a56db;
    --primary2:  #3b72f7;
    --accent:    #e8b84b;
    --accent2:   #f5d07a;
    --green:     #059669;
    --red:       #dc2626;
    --orange:    #d97706;
    --text:      #111827;
    --text2:     #4b5563;
    --text3:     #9ca3af;
    --textinv:   #f9fafb;
    --nav-active-bg:    rgba(26,86,219,0.1);
    --nav-active-text:  #1a56db;
    --nav-active-bar:   #1a56db;
    --nav-hover-bg:     rgba(255,255,255,0.07);
    --radius:    10px;
    --shadow:    0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-lg: 0 10px 25px rgba(0,0,0,0.12);
}
html[data-theme="academic"] {
    --bg:        #050a18;
    --bg2:       #080f24;
    --panel:     #0c1530;
    --panel2:    #0f1a38;
    --sidebar:   #080f24;
    --sidebar2:  #0c1530;
    --border:    #1a2a5e;
    --border2:   #243070;
    --primary:   #3b72f7;
    --primary2:  #5b8eff;
    --accent:    #e8b84b;
    --accent2:   #f5d07a;
    --green:     #22c984;
    --red:       #f05a5a;
    --orange:    #f5a442;
    --text:      #e2e8f0;
    --text2:     #8da0bf;
    --text3:     #5570a0;
    --textinv:   #111827;
    --nav-active-bg:    rgba(59,114,247,0.18);
    --nav-active-text:  #fff;
    --nav-active-bar:   #3b72f7;
    --nav-hover-bg:     rgba(255,255,255,0.04);
    --shadow:    0 1px 3px rgba(0,0,0,0.4);
    --shadow-lg: 0 10px 25px rgba(0,0,0,0.5);
}

/* ── RESET ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { height: 100%; }
body {
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    color: var(--text);
    font-size: 14px;
    height: 100%;
}

/* ── APP SHELL ── */
.app { display: flex; height: 100svh; overflow: hidden; }

/* ══════════════════════════════════════════════════════
   SIDEBAR
══════════════════════════════════════════════════════ */
.sidebar {
    width: 240px;
    background: var(--sidebar);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    overflow-y: auto;
    transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
    z-index: 200;
}

@media (max-width: 767px) {
    .sidebar {
        position: fixed;
        top: 0; left: 0; bottom: 0;
        transform: translateX(-100%);
    }
    .sidebar.open { transform: translateX(0); }
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.55);
        z-index: 199;
    }
    .sidebar-overlay.open { display: block; }
}

.sidebar-brand {
    padding: 20px 16px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.07);
    display: flex; align-items: center; gap: 12px;
}
.brand-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, var(--accent), #b8860b);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; color: #000; flex-shrink: 0;
}
.brand-name { font-weight: 700; font-size: 14px; color: #fff; }
.brand-sub  { font-size: 10px; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: .08em; margin-top: 1px; }

.nav-group { padding: 16px 8px 4px; }
.nav-label { font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: .1em; padding: 0 8px; margin-bottom: 4px; }
.nav-item  {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 10px; border-radius: 8px;
    font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.55);
    cursor: pointer; transition: all .15s; position: relative;
    user-select: none; min-height: 44px;
}
.nav-item:hover  { background: var(--nav-hover-bg); color: #fff; }
.nav-item.active { background: var(--nav-active-bg); color: var(--nav-active-text); border-left: 2px solid var(--nav-active-bar); padding-left: 8px; }
.nav-item i { width: 17px; text-align: center; font-size: 13px; flex-shrink: 0; }
.nav-badge { margin-left: auto; background: var(--red); color: white; border-radius: 999px; font-size: 10px; font-weight: 700; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; padding: 0 4px; }

.sidebar-footer { margin-top: auto; padding: 14px; border-top: 1px solid rgba(255,255,255,0.07); }
.user-chip { display: flex; align-items: center; gap: 10px; }
.user-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: white; flex-shrink: 0; }
.user-name { font-size: 13px; font-weight: 600; color: #fff; }
.user-role { font-size: 11px; color: rgba(255,255,255,0.35); }

.theme-switcher { display: flex; gap: 6px; margin-top: 10px; }
.theme-btn {
    flex: 1; padding: 7px 4px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.12);
    font-size: 11px; font-weight: 600; cursor: pointer; text-align: center;
    color: rgba(255,255,255,0.5); background: transparent; transition: all .15s;
    min-height: 36px;
}
.theme-btn.active { background: var(--accent); color: #000; border-color: var(--accent); }
.theme-btn:hover:not(.active) { color: #fff; border-color: rgba(255,255,255,0.3); }

/* ── MAIN ── */
.main { flex: 1; display: flex; flex-direction: column; overflow: hidden; min-width: 0; }

/* ── TOPBAR ── */
.topbar {
    height: 56px;
    background: var(--bg2);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center;
    padding: 0 16px; gap: 10px; flex-shrink: 0;
    box-shadow: var(--shadow);
}
.topbar-hamburger {
    display: none;
    width: 40px; height: 40px; border-radius: 8px;
    background: transparent; border: none; color: var(--text2);
    font-size: 18px; cursor: pointer; align-items: center; justify-content: center;
    flex-shrink: 0;
}
@media (max-width: 767px) { .topbar-hamburger { display: flex; } }
.topbar-title { font-size: 16px; font-weight: 700; color: var(--text); flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.topbar-sub   { font-size: 12px; color: var(--text3); }

/* ── CONTENT ── */
.content { flex: 1; overflow-y: auto; padding: 16px; background: var(--bg); -webkit-overflow-scrolling: touch; }
@media (min-width: 768px) { .content { padding: 24px; } }
.page { display: none; }
.page.active { display: block; animation: fadeUp .25s ease; }
@keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

/* ── BUTTONS ── */
.btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; transition: all .15s; font-family: inherit; min-height: 40px; }
.btn-primary { background: var(--primary); color: white; }
.btn-primary:hover { background: var(--primary2); }
.btn-gold    { background: var(--accent); color: #000; }
.btn-gold:hover { background: var(--accent2); }
.btn-ghost   { background: transparent; color: var(--text2); border: 1px solid var(--border2); }
.btn-ghost:hover { background: var(--panel2); color: var(--text); }
.btn-danger  { background: var(--red); color: white; }
.btn-danger:hover { opacity:.85; }
.btn-success { background: var(--green); color: white; }
.btn-sm      { padding: 6px 12px; font-size: 12px; min-height: 34px; }
.btn-xs      { padding: 4px 9px; font-size: 11px; min-height: 30px; }

/* ── STAT CARDS ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 16px;
}
@media (min-width: 640px) { .stats-grid { grid-template-columns: repeat(3, 1fr); gap: 12px; } }
@media (min-width: 1024px) { .stats-grid { grid-template-columns: repeat(5, 1fr); gap: 14px; margin-bottom: 24px; } }

.stat-card {
    background: var(--panel); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 14px;
    position: relative; overflow: hidden;
    box-shadow: var(--shadow);
}
@media (min-width: 768px) { .stat-card { padding: 18px; } }
.stat-card::after { content:''; position:absolute; top:0;left:0;right:0;height:3px; }
.stat-card.gold::after   { background: var(--accent); }
.stat-card.blue::after   { background: var(--primary); }
.stat-card.green::after  { background: var(--green); }
.stat-card.purple::after { background: #7c3aed; }
.stat-card.orange::after { background: var(--orange); }
.stat-card.live::after   { background: var(--red); }
.stat-label { font-size: 10px; color: var(--text3); text-transform: uppercase; letter-spacing: .07em; margin-bottom: 6px; font-weight: 600; }
.stat-value { font-size: 24px; font-weight: 800; color: var(--text); line-height: 1; }
@media (min-width: 768px) { .stat-value { font-size: 30px; } }
.stat-sub   { font-size: 11px; color: var(--text3); margin-top: 4px; }

/* ── PANELS ── */
.panel { background: var(--panel); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 14px; box-shadow: var(--shadow); }
@media (min-width: 768px) { .panel { margin-bottom: 18px; } }
.panel-head { padding: 12px 14px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap; }
@media (min-width: 768px) { .panel-head { padding: 14px 18px; } }
.panel-title { font-size: 13px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px; }
.panel-title i { color: var(--accent); }
.panel-body { padding: 14px; }
@media (min-width: 768px) { .panel-body { padding: 18px; } }

/* ── TABLES ── */
.table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.data-table { width: 100%; border-collapse: collapse; font-size: 12px; min-width: 480px; }
@media (min-width: 768px) { .data-table { font-size: 13px; } }
.data-table th { text-align: left; padding: 9px 12px; font-size: 10px; font-weight: 600; color: var(--text3); text-transform: uppercase; letter-spacing: .07em; border-bottom: 1px solid var(--border); background: var(--panel2); white-space: nowrap; }
.data-table td { padding: 10px 12px; border-bottom: 1px solid var(--border); color: var(--text2); vertical-align: top; }
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: var(--panel2); }
.mono { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 11px; color: var(--text3); }

/* ── MOBILE CARD ROWS ── */
.card-list { display: flex; flex-direction: column; gap: 10px; }
.card-row {
    background: var(--panel);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 14px;
    cursor: pointer;
    transition: border-color .15s;
}
.card-row:hover { border-color: var(--primary); }
.card-row-title { font-weight: 700; color: var(--text); font-size: 14px; margin-bottom: 4px; }
.card-row-sub   { font-size: 12px; color: var(--text3); margin-bottom: 8px; }
.card-row-meta  { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }
.card-row-actions { display: flex; gap: 6px; margin-top: 10px; }

/* ── STATUS BADGES ── */
.badge-pill { display: inline-block; padding: 3px 9px; border-radius: 999px; font-size: 11px; font-weight: 600; white-space: nowrap; }
.badge-new        { background: rgba(26,86,219,.12); color: var(--primary); }
.badge-contacted  { background: rgba(232,184,75,.15); color: #92640a; }
.badge-converted  { background: rgba(5,150,105,.12); color: var(--green); }
.badge-archived   { background: rgba(156,163,175,.15); color: var(--text3); }
.badge-academic   { background: rgba(124,58,237,.12); color: #7c3aed; }
.badge-business   { background: rgba(26,86,219,.12); color: var(--primary); }
.badge-concierge  { background: rgba(232,184,75,.15); color: #92640a; }
.badge-live       { background: rgba(220,38,38,.15); color: var(--red); animation: pulse-badge 2s infinite; }
html[data-theme="academic"] .badge-contacted { color: var(--accent2); }
@keyframes pulse-badge { 0%,100%{opacity:1} 50%{opacity:.6} }

/* ── FORMS ── */
.form-group { margin-bottom: 14px; }
.form-label { display: block; font-size: 12px; font-weight: 600; color: var(--text2); margin-bottom: 5px; }
.form-hint  { font-size: 11px; color: var(--text3); margin-top: 4px; }
.form-input, .form-select, .form-textarea {
    width: 100%; background: var(--bg); border: 1.5px solid var(--border2); border-radius: 8px;
    color: var(--text); font-family: inherit; font-size: 14px; padding: 10px 13px; transition: border .15s;
}
.form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: var(--primary); }
.form-textarea { min-height: 120px; resize: vertical; line-height: 1.6; }
.form-grid   { display: grid; grid-template-columns: 1fr; gap: 12px; }
@media (min-width: 640px) { .form-grid { grid-template-columns: 1fr 1fr; } }
.form-grid-3 { display: grid; grid-template-columns: 1fr; gap: 12px; }
@media (min-width: 640px) { .form-grid-3 { grid-template-columns: 1fr 1fr; } }
@media (min-width: 900px)  { .form-grid-3 { grid-template-columns: 1fr 1fr 1fr; } }

/* ── TOGGLE SWITCHES ── */
.toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 13px 0; border-bottom: 1px solid var(--border); gap: 10px; }
.toggle-row:last-child { border-bottom: none; }
.toggle-info h4 { font-size: 14px; font-weight: 600; color: var(--text); }
.toggle-info p  { font-size: 12px; color: var(--text3); margin-top: 2px; }
.switch { position: relative; width: 46px; height: 25px; flex-shrink: 0; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; inset: 0; background: var(--border2); border-radius: 999px; transition: .3s; }
.slider::before { content:''; position:absolute; width:19px;height:19px;left:3px;bottom:3px;background:white;border-radius:50%;transition:.3s; }
input:checked + .slider { background: var(--green); }
input:checked + .slider::before { transform: translateX(21px); }

/* ── CHAT BUBBLES ── */
.chat-wrap { display:flex;flex-direction:column;gap:8px;padding:14px;overflow-y:auto; flex: 1; }
.chat-user-wrap  { display:flex;justify-content:flex-end; }
.chat-bot-wrap   { display:flex;justify-content:flex-start; }
.chat-admin-wrap { display:flex;justify-content:flex-start; }
.chat-bubble { padding:9px 14px;border-radius:12px;font-size:13px;line-height:1.5;max-width:85%; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
.bubble-user  { background:rgba(26,86,219,.15);color:var(--text);border-radius:12px 12px 4px 12px; }
.bubble-bot   { background:var(--panel2);color:var(--text2);border-radius:12px 12px 12px 4px; }
.bubble-admin { background:rgba(5,150,105,.15);color:var(--text);border-radius:12px 12px 12px 4px;border:1px solid rgba(5,150,105,.3); }

/* ── CONVERSATIONS LAYOUT (MOBILE RESPONSIVE & FULL SCREEN) ── */
.conv-layout {
    display: flex;
    flex-direction: column;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    background: var(--panel);
    height: calc(100svh - 160px);
}
#sessions-pane { flex: 1; overflow-y: auto; display: block; border-bottom: 1px solid var(--border); }
#chat-detail-pane { flex: 1; overflow-y: auto; display: none; flex-direction: column; background: var(--bg); position: relative; }

/* The Mobile Trigger Class */
.conv-layout.mobile-detail-active #sessions-pane { display: none; }
.conv-layout.mobile-detail-active #chat-detail-pane { display: flex; }

/* Desktop adjustments */
@media (min-width: 768px) {
    .conv-layout { display: grid; grid-template-columns: 320px 1fr; flex-direction: row; }
    #sessions-pane { display: block !important; border-bottom: none; border-right: 1px solid var(--border); }
    #chat-detail-pane { display: flex !important; }
}

/* Make it full width on mobile to feel like a native app */
@media (max-width: 767px) {
    .conv-layout {
        height: calc(100svh - 130px);
        margin: -16px; /* Pull to the absolute edges of the screen */
        border-radius: 0;
        border-left: none; border-right: none; border-bottom: none;
    }
}
.mobile-back-btn { display: none; margin-right: 8px; }
@media (max-width: 767px) { .mobile-back-btn { display: inline-flex; } }

/* ── TAKEOVER UI ── */
.takeover-bar {
    background: var(--panel);
    border-top: 1px solid var(--border);
    padding: 12px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex-shrink: 0;
    transition: all 0.3s ease;
    position: sticky;
    bottom: 0;
    width: 100%;
}
.takeover-bar.is-live { background: rgba(5,150,105,.08); border-top: 1px solid rgba(5,150,105,.2); }
.takeover-input-wrap { display: flex; align-items: flex-end; gap: 8px; background: var(--bg); border: 1.5px solid var(--border2); border-radius: 18px; padding: 8px 8px 8px 16px; width: 100%; transition: all 0.2s; }
.takeover-input-wrap:focus-within { border-color: var(--green); background: var(--panel); box-shadow: 0 4px 15px rgba(5, 150, 105, 0.08); }
.takeover-textarea { flex: 1; border: none; background: transparent; outline: none; resize: none; max-height: 120px; font-family: inherit; font-size: 14px; color: var(--text); padding: 8px 0; line-height: 1.5; }

/* ── PROMPT CARDS ── */
.prompt-card { background:var(--panel2);border:1.5px solid var(--border);border-radius:var(--radius);padding:14px;margin-bottom:10px;cursor:pointer;transition:all .15s; }
.prompt-card:hover { border-color:var(--primary); }
.prompt-card.active { border-color:var(--accent); }
.prompt-sector { display:inline-block;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:2px 8px;border-radius:999px;margin-bottom:6px; }
.prompt-sector.academic  { background:rgba(124,58,237,.12);color:#7c3aed; }
.prompt-sector.business  { background:rgba(26,86,219,.12);color:var(--primary); }
.prompt-sector.concierge { background:rgba(232,184,75,.15);color:#92640a; }
.prompt-label   { font-size:14px;font-weight:700;color:var(--text);margin-bottom:4px; }
.prompt-preview { font-size:12px;color:var(--text3);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }

/* ── AI PROMPTS LAYOUT ── */
.prompts-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
}
@media (min-width: 768px) {
    .prompts-layout { grid-template-columns: 260px 1fr; gap: 18px; }
}

/* ── SESSIONS ── */
.session-item { padding:12px 14px;border-bottom:1px solid var(--border);cursor:pointer;transition:background .12s;min-height:64px; }
.session-item:hover  { background:var(--panel2); }
.session-item.active { background:rgba(26,86,219,.08);border-left:3px solid var(--primary); }
.session-preview { font-size:12px;color:var(--text3);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-top:4px; }

/* ── MEDIA ── */
.media-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:10px; }
.media-item { background:var(--panel2);border:1.5px solid var(--border);border-radius:var(--radius);overflow:hidden;cursor:pointer;transition:border .15s; }
.media-item:hover { border-color:var(--primary); }
.media-thumb { width:100%;height:90px;object-fit:cover;display:block; }
.media-thumb-icon { width:100%;height:90px;display:flex;align-items:center;justify-content:center;font-size:28px;color:var(--text3);background:var(--panel2); }
.media-meta { padding:7px 8px; }
.media-name { font-size:10px;color:var(--text3);white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }

.drop-zone { border:2px dashed var(--border2);border-radius:var(--radius);padding:32px 20px;text-align:center;cursor:pointer;transition:all .2s; }
.drop-zone:hover,.drop-zone.drag { border-color:var(--primary);background:rgba(26,86,219,.04); }
.drop-zone i { font-size:26px;color:var(--text3);margin-bottom:8px; }
.drop-zone p { color:var(--text3);font-size:13px; }

/* ── MODAL ── */
.modal-bg { position:fixed;inset:0;background:rgba(0,0,0,.55);backdrop-filter:blur(4px);z-index:500;display:none;align-items:flex-end;justify-content:center;padding:0; }
.modal-bg.open { display:flex; }
@media (min-width: 640px) {
    .modal-bg { align-items: center; padding: 16px; }
}
.modal {
    background:var(--panel);border:1px solid var(--border2);
    width:100%;
    max-height: 95svh; overflow-y:auto;
    border-radius: 16px 16px 0 0;
    box-shadow:var(--shadow-lg);
}
@media (min-width: 640px) {
    .modal { max-width:720px; border-radius: 14px; max-height: 93vh; }
}
.modal-head { padding:16px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:var(--panel);z-index:1; }
.modal-title { font-size:16px;font-weight:700;color:var(--text); }
.modal-close { width:34px;height:34px;border-radius:50%;background:var(--panel2);border:none;color:var(--text2);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px; }
.modal-body { padding:18px; }
.modal-foot { padding:12px 18px;border-top:1px solid var(--border);display:flex;gap:8px;justify-content:flex-end;position:sticky;bottom:0;background:var(--panel);flex-wrap:wrap; }

/* ── TOAST ── */
.toast-container { position:fixed;bottom:20px;right:16px;z-index:9999;display:flex;flex-direction:column;gap:8px; }
.toast { background:var(--panel);border:1px solid var(--border2);border-radius:10px;padding:11px 16px;font-size:13px;color:var(--text);display:flex;align-items:center;gap:10px;animation:toastIn .3s ease;min-width:200px;max-width:calc(100vw - 32px);box-shadow:var(--shadow-lg); }
.toast.success { border-left:3px solid var(--green); }
.toast.error   { border-left:3px solid var(--red); }
@keyframes toastIn { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:translateX(0)} }

/* ── EMPTY STATE ── */
.empty-state { text-align:center;padding:40px 20px;color:var(--text3); }
.empty-state i { font-size:36px;margin-bottom:12px;opacity:.35;display:block; }
.empty-state h3 { font-size:14px;color:var(--text2);margin-bottom:5px; }
.empty-state p  { font-size:12px; }

/* ── SCROLLBAR ── */
::-webkit-scrollbar { width:4px;height:4px; }
::-webkit-scrollbar-track { background:transparent; }
::-webkit-scrollbar-thumb { background:var(--border2);border-radius:999px; }

/* ── UTILS ── */
.flex { display:flex; } .gap-2{gap:8px;} .gap-3{gap:12px;} .items-center{align-items:center;} .justify-between{justify-content:space-between;} .flex-1{flex:1;} .w-full{width:100%;} .mt-2{margin-top:8px;} .mb-3{margin-bottom:12px;} .text-muted{color:var(--text3);font-size:12px;} .fw-700{font-weight:700;} .tag{display:inline-block;background:var(--panel2);border:1px solid var(--border);color:var(--text3);font-size:11px;padding:2px 7px;border-radius:5px;}
.section-divider { border:none;border-top:1px solid var(--border);margin:16px 0; }

/* ── VISUAL EDITOR ── */
.ve-toolbar {
    display: flex; align-items: center; flex-wrap: wrap; gap: 2px;
    padding: 6px 8px; background: var(--panel2); border: 1.5px solid var(--border2);
    border-bottom: none; border-radius: 8px 8px 0 0;
    overflow-x: auto;
}
.ve-btn {
    width: 32px; height: 32px; border: none; background: transparent; border-radius: 5px;
    cursor: pointer; color: var(--text2); font-size: 13px; display: flex;
    align-items: center; justify-content: center; transition: all .12s; flex-shrink: 0;
}
.ve-btn:hover { background: var(--border); color: var(--text); }
.ve-btn.active { background: var(--primary); color: white; }
.ve-sep { width: 1px; height: 20px; background: var(--border2); margin: 0 4px; flex-shrink: 0; }
.ve-color-swatch { width: 18px; height: 18px; border-radius: 3px; border: 1.5px solid var(--border2); cursor: pointer; flex-shrink: 0; }
.ve-editor {
    min-height: 180px; max-height: 400px;
    padding: 12px; background: var(--bg); border: 1.5px solid var(--border2);
    border-radius: 0 0 8px 8px; color: var(--text);
    overflow-y: auto; line-height: 1.65; font-size: 14px;
    outline: none;
}
.ve-editor:focus { border-color: var(--primary); }
.ve-editor h1 { font-size: 22px; font-weight: 700; margin: 8px 0; }
.ve-editor h2 { font-size: 18px; font-weight: 700; margin: 8px 0; }
.ve-editor h3 { font-size: 15px; font-weight: 700; margin: 6px 0; }
.ve-editor ul, .ve-editor ol { padding-left: 22px; margin: 4px 0; }
.ve-editor blockquote { border-left: 3px solid var(--accent); padding-left: 14px; color: var(--text2); margin: 8px 0; }
.ve-editor img { max-width: 100%; border-radius: 6px; }
.ve-editor a { color: var(--primary); text-decoration: underline; }

.preview-pane { background: var(--panel2); border: 1.5px solid var(--border); border-radius: 10px; overflow: hidden; }
.preview-pane-bar { padding: 8px 14px; background: var(--border); display: flex; gap: 6px; align-items: center; }
.preview-dot { width: 10px; height: 10px; border-radius: 50%; }
.preview-content { padding: 16px; font-size: 13px; line-height: 1.7; }

/* ── DASHBOARD GRID ── */
.dash-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
}
@media (min-width: 768px) {
    .dash-grid { grid-template-columns: 1fr 1fr; gap: 18px; }
}

/* ── TOGGLES GRID ── */
.toggles-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
}
@media (min-width: 768px) {
    .toggles-grid { grid-template-columns: 1fr 1fr; gap: 18px; }
}

/* ── FILTER TOOLBAR ── */
.filter-bar {
    display: flex; gap: 8px; align-items: center; flex-wrap: wrap;
}
.filter-bar .search-wrap {
    display: flex; align-items: center; gap: 8px; flex: 1; min-width: 160px;
    background: var(--bg); border: 1.5px solid var(--border2); border-radius: 8px; padding: 8px 12px;
}
.filter-bar .search-wrap input {
    background: transparent; border: none; outline: none;
    font-family: inherit; font-size: 13px; color: var(--text); flex: 1; min-width: 0;
}
.filter-bar select { min-width: 120px; }

/* ── LIVE INDICATOR ── */
.live-dot {
    display: inline-block;
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--red);
    animation: livePulse 1.5s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes livePulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(0.7)} }
</style>
</head>

<body>
<!-- Sidebar overlay for mobile -->
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

<div class="app">

<!-- ── SIDEBAR ── -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">⚡</div>
        <div class="brand-text">
            <div class="brand-name">De Kompany</div>
            <div class="brand-sub">Admin Panel</div>
        </div>
    </div>

    <div class="nav-group">
        <div class="nav-label">Home</div>
        <div class="nav-item active" onclick="showPage('dashboard');closeSidebar();">
            <i class="fa-solid fa-gauge-high"></i> Overview
        </div>
    </div>

    <div class="nav-group">
        <div class="nav-label">AI & Chat</div>
        <div class="nav-item" onclick="showPage('prompts');closeSidebar();">
            <i class="fa-solid fa-robot"></i> AI Personality
        </div>
        <div class="nav-item" onclick="showPage('chatlogs');closeSidebar();">
            <i class="fa-solid fa-comments"></i> Conversations
            <span class="nav-badge" id="badge-logs">—</span>
        </div>
    </div>

    <div class="nav-group">
        <div class="nav-label">Contacts</div>
        <div class="nav-item" onclick="showPage('leads');closeSidebar();">
            <i class="fa-solid fa-users"></i> Contact Leads
            <span class="nav-badge" id="badge-leads">—</span>
        </div>
    </div>

    <div class="nav-group">
        <div class="nav-label">Content</div>
        <div class="nav-item" onclick="showPage('presentations');closeSidebar();">
            <i class="fa-solid fa-file-lines"></i> Client Pages
        </div>
        <div class="nav-item" onclick="showPage('media');closeSidebar();">
            <i class="fa-solid fa-images"></i> Images & Files
        </div>
        <div class="nav-item" onclick="showPage('toggles');closeSidebar();">
            <i class="fa-solid fa-toggle-on"></i> Show/Hide Sections
        </div>
    </div>

    <div class="sidebar-footer">
        <div style="margin-bottom:12px;">
            <div class="nav-label" style="padding:0;margin-bottom:6px;">Colour Theme</div>
            <div class="theme-switcher">
                <button class="theme-btn active" id="theme-btn-business" onclick="setTheme('business')">💼 Business</button>
                <button class="theme-btn" id="theme-btn-academic" onclick="setTheme('academic')">🎓 Academic</button>
            </div>
        </div>
        <div class="user-chip">
            <div class="user-avatar"><?php echo strtoupper(substr($current_user->display_name, 0, 1)); ?></div>
            <div>
                <div class="user-name"><?php echo esc_html($first_name); ?></div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>
</aside>

<!-- ── MAIN ── -->
<div class="main">
    <div class="topbar">
        <button class="topbar-hamburger" onclick="openSidebar()" aria-label="Open menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="topbar-title" id="page-title">Overview</div>
        <div style="display:flex;gap:8px;" id="topbar-actions"></div>
    </div>

    <div class="content">
<?php
// header.php intentionally leaves <div class="content"> OPEN.
// admin.php outputs all page sections here, then includes footer.php to close it.
