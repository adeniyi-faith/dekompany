<?php
/**
 * De Kompany Admin — Main Dashboard Orchestrator
 * ─────────────────────────────────────────────────────────────────────────────
 * Location : /wp/admin/admin.php
 * Purpose  : The single entry-point for the admin dashboard. It is intentionally
 *            thin — its only job is to include the other three files in order
 *            and output the inner page sections between the header and footer.
 *
 * Load order:
 *   1. auth.php   — boots WordPress, gates non-admins, defines helpers
 *   2. header.php — emits <!DOCTYPE html> … <div class="content">  (OPEN)
 *   3. [page sections below]
 *   4. footer.php — closes </div> … </html>, all modals, full JS engine
 * ─────────────────────────────────────────────────────────────────────────────
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/header.php';

// $first_name is already set inside header.php from the WP current user.
// We just re-read it here for the greeting text.
$greeting_name = esc_html(explode(' ', wp_get_current_user()->display_name)[0]);
?>

        <!-- ════════ DASHBOARD ════════ -->
        <div class="page active" id="page-dashboard">
            <div style="margin-bottom:16px;">
                <h2 style="font-size:18px;font-weight:700;color:var(--text);">
                    Good day, <?php echo $greeting_name; ?>! 👋
                </h2>
                <p style="color:var(--text3);font-size:13px;margin-top:3px;">
                    Here's what's happening across your platform today.
                </p>
            </div>

            <div class="stats-grid">
                <div class="stat-card gold">
                    <div class="stat-label">New Contacts</div>
                    <div class="stat-value" id="stat-new-leads">—</div>
                    <div class="stat-sub">Waiting to contact</div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-label">Total Chats</div>
                    <div class="stat-value" id="stat-sessions">—</div>
                    <div class="stat-sub">Conversations</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-label">Messages</div>
                    <div class="stat-value" id="stat-messages">—</div>
                    <div class="stat-sub">All departments</div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-label">Client Pages</div>
                    <div class="stat-value" id="stat-presentations">—</div>
                    <div class="stat-sub">Presentations</div>
                </div>
                <div class="stat-card live">
                    <div class="stat-label" style="display:flex;align-items:center;gap:5px;"><span class="live-dot"></span> Live Takeovers</div>
                    <div class="stat-value" id="stat-takeovers">—</div>
                    <div class="stat-sub">Admin-controlled</div>
                </div>
            </div>

            <div class="dash-grid">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="fa-solid fa-users"></i> Recent Contacts</div>
                        <button class="btn btn-ghost btn-sm" onclick="showPage('leads')">See All</button>
                    </div>
                    <div class="table-wrap">
                        <table class="data-table" id="dash-leads-table">
                            <thead><tr><th>Name / Email</th><th>Dept</th><th>Status</th></tr></thead>
                            <tbody><tr><td colspan="3" style="text-align:center;color:var(--text3);padding:24px;">Loading…</td></tr></tbody>
                        </table>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="fa-solid fa-comments"></i> Recent Chats</div>
                        <button class="btn btn-ghost btn-sm" onclick="showPage('chatlogs')">See All</button>
                    </div>
                    <div class="table-wrap">
                        <table class="data-table" id="dash-sessions-table">
                            <thead><tr><th>Session</th><th>Dept</th><th>Msgs</th><th>When</th></tr></thead>
                            <tbody><tr><td colspan="4" style="text-align:center;color:var(--text3);padding:24px;">Loading…</td></tr></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title"><i class="fa-solid fa-chart-bar"></i> Chat Activity by Department</div>
                </div>
                <div class="panel-body" style="display:flex;gap:32px;flex-wrap:wrap;">
                    <div>
                        <div class="stat-label" style="margin-bottom:4px;">Academic</div>
                        <div style="font-size:26px;font-weight:800;color:#7c3aed;" id="stat-academic">—</div>
                        <div class="text-muted">messages sent</div>
                    </div>
                    <div>
                        <div class="stat-label" style="margin-bottom:4px;">Business</div>
                        <div style="font-size:26px;font-weight:800;color:var(--primary);" id="stat-business">—</div>
                        <div class="text-muted">messages sent</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════ AI PERSONALITY (Prompts) ════════ -->
        <div class="page" id="page-prompts">
            <div class="panel" style="margin-bottom:14px;">
                <div class="panel-body">
                    <div style="display:flex;align-items:flex-start;gap:12px;">
                        <div style="font-size:26px;">🤖</div>
                        <div>
                            <div style="font-weight:700;font-size:15px;color:var(--text);">AI Personality Manager</div>
                            <div style="color:var(--text3);font-size:13px;margin-top:3px;">
                                Control how your AI speaks to visitors. Each department can have its own personality. Changes go live immediately.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="prompts-layout">
                <div>
                    <button class="btn btn-gold w-full mb-3" onclick="openPromptModal()">
                        <i class="fa-solid fa-plus"></i> New AI Prompt
                    </button>
                    <div id="prompts-list">
                        <div class="text-muted" style="text-align:center;padding:24px;">Loading…</div>
                    </div>
                </div>
                <div id="prompt-editor-panel">
                    <div class="empty-state">
                        <i class="fa-solid fa-robot"></i>
                        <h3>Pick a prompt to edit</h3>
                        <p>Click one on the left, or create a new one.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════ CONVERSATIONS (Chat Logs) ════════ -->
        <div class="page" id="page-chatlogs">
            <div class="panel" style="margin-bottom:14px;">
                <div class="panel-body" style="padding:10px 14px;">
                    <div class="filter-bar">
                        <div class="search-wrap">
                            <i class="fa-solid fa-search" style="color:var(--text3);font-size:12px;flex-shrink:0;"></i>
                            <input type="text" id="log-search" placeholder="Search conversations…" oninput="filterLogs()">
                        </div>
                        <select class="form-select filter-bar select" style="width:140px;" id="log-sector-filter" onchange="loadSessions()">
                            <option value="">All Depts</option>
                            <option value="academic">Academic</option>
                            <option value="business">Business</option>
                            <option value="concierge">Concierge</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="conv-layout">
                <div id="sessions-pane">
                    <div class="text-muted" style="text-align:center;padding:24px;">Loading…</div>
                </div>
                <div id="chat-detail-pane">
                    <div class="empty-state">
                        <i class="fa-solid fa-comment-dots"></i>
                        <h3>Select a conversation</h3>
                        <p>Tap any chat on the left to view the transcript and take over.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════ CONTACT LEADS ════════ -->
        <div class="page" id="page-leads">
            <div class="panel" style="margin-bottom:14px;">
                <div class="panel-body" style="padding:10px 14px;">
                    <div class="filter-bar">
                        <div class="search-wrap">
                            <i class="fa-solid fa-search" style="color:var(--text3);font-size:12px;flex-shrink:0;"></i>
                            <input type="text" placeholder="Search contacts…" id="lead-search" oninput="filterLeads()">
                        </div>
                        <select class="form-select" style="width:130px;" id="lead-sector-filter" onchange="loadLeads()">
                            <option value="">All Depts</option>
                            <option value="academic">Academic</option>
                            <option value="business">Business</option>
                        </select>
                        <select class="form-select" style="width:130px;" id="lead-status-filter" onchange="loadLeads()">
                            <option value="">All Status</option>
                            <option value="new">New</option>
                            <option value="contacted">Contacted</option>
                            <option value="converted">Converted</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title"><i class="fa-solid fa-users"></i> All Contacts</div>
                    <span class="text-muted" id="lead-count">Loading…</span>
                </div>
                <div id="leads-card-list" class="panel-body" style="display:none;"></div>
                <div class="table-wrap" id="leads-table-wrap">
                    <table class="data-table" id="leads-table">
                        <thead>
                            <tr>
                                <th>Name & Contact</th>
                                <th>Dept</th>
                                <th>What they asked</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="6" style="text-align:center;color:var(--text3);padding:32px;">Loading…</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ════════ SHOW/HIDE SECTIONS ════════ -->
        <div class="page" id="page-toggles">
            <div class="panel" style="margin-bottom:14px;">
                <div class="panel-body">
                    <div style="display:flex;gap:12px;align-items:flex-start;">
                        <div style="font-size:24px;">🎛️</div>
                        <div>
                            <div style="font-weight:700;color:var(--text);">Show / Hide Website Sections</div>
                            <div style="color:var(--text3);font-size:13px;margin-top:3px;">
                                Toggle any section on or off on your website. Changes are live immediately.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="toggles-grid">
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="fa-solid fa-graduation-cap"></i> Academic Sections</div>
                    </div>
                    <div class="panel-body" id="toggles-academic">Loading…</div>
                </div>
                <div class="panel">
                    <div class="panel-head">
                        <div class="panel-title"><i class="fa-solid fa-briefcase"></i> Business Sections</div>
                    </div>
                    <div class="panel-body" id="toggles-business">Loading…</div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title"><i class="fa-solid fa-plus"></i> Add a New Section Toggle</div>
                </div>
                <div class="panel-body">
                    <div class="form-grid-3">
                        <div class="form-group">
                            <label class="form-label">Which Website?</label>
                            <select class="form-select" id="new-toggle-sector">
                                <option value="academic">Academic</option>
                                <option value="business">Business</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Section ID (from your HTML)</label>
                            <input class="form-input" id="new-toggle-key" placeholder="e.g. student-lounge">
                            <div class="form-hint">The `id` attribute on the HTML element you want to control.</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Friendly Name</label>
                            <input class="form-input" id="new-toggle-label" placeholder="e.g. Student Lounge">
                        </div>
                    </div>
                    <button class="btn btn-primary" onclick="addToggle()">
                        <i class="fa-solid fa-plus"></i> Add Section
                    </button>
                </div>
            </div>
        </div>

        <!-- ════════ IMAGES & FILES (Media) ════════ -->
        <div class="page" id="page-media">
            <div class="panel mb-3">
                <div class="panel-body">
                    <div class="drop-zone" id="drop-zone" onclick="document.getElementById('media-upload-input').click()">
                        <i class="fa-solid fa-cloud-arrow-up" style="display:block;"></i>
                        <p style="margin-top:6px;font-weight:600;">Tap to upload, or drag &amp; drop files</p>
                        <p style="font-size:11px;margin-top:4px;">JPEG, PNG, WebP, SVG, PDF — max 5MB each</p>
                    </div>
                    <input type="file" id="media-upload-input" style="display:none;" multiple accept="image/*,.pdf" onchange="uploadFiles(this.files)">
                </div>
            </div>
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title"><i class="fa-solid fa-images"></i> Your Uploaded Files</div>
                    <span class="text-muted" id="media-count">Loading…</span>
                </div>
                <div class="panel-body">
                    <div class="media-grid" id="media-grid">
                        <div class="text-muted" style="grid-column:1/-1;text-align:center;padding:32px;">Loading…</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════ CLIENT PAGES (Presentations) ════════ -->
        <div class="page" id="page-presentations">
            <div class="panel" style="margin-bottom:14px;">
                <div class="panel-body">
                    <div style="display:flex;gap:12px;align-items:center;justify-content:space-between;flex-wrap:wrap;">
                        <div style="display:flex;gap:12px;align-items:flex-start;">
                            <div style="font-size:24px;">📄</div>
                            <div>
                                <div style="font-weight:700;color:var(--text);">Client Presentation Pages</div>
                                <div style="color:var(--text3);font-size:13px;margin-top:3px;">
                                    Build beautiful pages to share with clients. Each page gets its own link.
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-gold" onclick="openPresentationModal()">
                            <i class="fa-solid fa-plus"></i> New Client Page
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="table-wrap">
                    <table class="data-table" id="pres-table">
                        <thead>
                            <tr><th>Page Title</th><th>Client</th><th>Dept</th><th>Status</th><th>Views</th><th>Created</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="7" style="text-align:center;color:var(--text3);padding:32px;">Loading…</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php require_once __DIR__ . '/footer.php'; ?>
