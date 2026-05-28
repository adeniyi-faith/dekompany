<?php
/**
 * De Kompany Admin — HTML Footer & JavaScript Engine (Close)
 * ─────────────────────────────────────────────────────────────────────────────
 * Location : /wp/admin/footer.php
 * Purpose  : Closes the page shell opened by header.php, outputs all modals,
 *            the toast container, and the complete JavaScript engine that
 *            powers every admin feature.
 *
 * Included by : admin.php  (require_once __DIR__ . '/footer.php'  — last line)
 *
 * Depends on  : auth.php must have been included earlier (via header.php),
 *               so that $admin_name is already defined.
 * ─────────────────────────────────────────────────────────────────────────────
 */
?>

    </div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<!-- ════════════════ MODALS ════════════════ -->

<!-- AI Prompt Modal -->
<div class="modal-bg" id="modal-prompt">
    <div class="modal">
        <div class="modal-head">
            <div class="modal-title" id="prompt-modal-title">Create AI Prompt</div>
            <button class="modal-close" onclick="closeModal('modal-prompt')"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="prompt-id" value="0">
            <div style="background:var(--panel2);border:1px solid var(--border);border-radius:8px;padding:12px;margin-bottom:16px;">
                <div style="font-size:13px;color:var(--text2);">
                    💡 <strong>What is this?</strong> The text you write below becomes the AI's "brain" — it defines the personality, tone, and rules your chatbot follows.
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Which chatbot is this for?</label>
                    <select class="form-select" id="prompt-sector">
                        <option value="academic">Academic Coach</option>
                        <option value="business">Business Advisor</option>
                        <option value="concierge">Front Desk (Concierge)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Give this prompt a name</label>
                    <input class="form-input" id="prompt-label" placeholder="e.g. Friendly Academic Coach">
                    <div class="form-hint">Just for your reference — visitors don't see this.</div>
                </div>
            </div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">AI Engine</label>
                    <select class="form-select" id="prompt-model">
                        <option value="gemini-2.5-flash">Gemini 2.5 Flash (Recommended)</option>
                        <option value="gemini-2.5-flash-lite">Gemini 2.5 Flash Lite (Faster)</option>
                        <option value="gemini-2.0-flash">Gemini 2.0 Flash</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Creativity Level</label>
                    <input class="form-input" type="number" id="prompt-temp" min="0" max="1" step="0.1" value="0.7">
                    <div class="form-hint">0 = consistent · 1 = creative</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Max Response Length</label>
                    <input class="form-input" type="number" id="prompt-tokens" value="300" min="50" max="2000">
                    <div class="form-hint">300 is a good default.</div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">AI Instructions <span style="font-weight:400;color:var(--text3);">— what should the AI say and how should it behave?</span></label>
                <textarea class="form-textarea" id="prompt-system" style="min-height:180px;"
                    placeholder="Example: You are a friendly Academic Coach for De Kompany. Help students with their studies. Be warm, supportive, and keep replies to 2-3 sentences."></textarea>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;font-weight:600;color:var(--text2);">
                    <input type="checkbox" id="prompt-active" checked style="width:16px;height:16px;">
                    Make this the active prompt (used on the live website)
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
    <div class="modal" style="max-width:480px;">
        <div class="modal-head">
            <div class="modal-title">Update Contact</div>
            <button class="modal-close" onclick="closeModal('modal-lead')"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="lead-edit-id">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Contact Status</label>
                    <select class="form-select" id="lead-edit-status">
                        <option value="new">🆕 New — not yet contacted</option>
                        <option value="contacted">📞 Contacted — reached out</option>
                        <option value="converted">✅ Converted — became a client</option>
                        <option value="archived">🗄️ Archived — not relevant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input class="form-input" id="lead-edit-phone" placeholder="+234…">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Your Notes</label>
                <textarea class="form-textarea" id="lead-edit-notes" style="min-height:90px;" placeholder="Add any private notes about this contact…"></textarea>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeModal('modal-lead')">Cancel</button>
            <button class="btn btn-primary" onclick="saveLead()"><i class="fa-solid fa-save"></i> Save Changes</button>
        </div>
    </div>
</div>

<!-- Presentation Modal (Visual Builder) -->
<div class="modal-bg" id="modal-presentation">
    <div class="modal" style="max-width:900px;">
        <div class="modal-head">
            <div class="modal-title" id="pres-modal-title">New Client Page</div>
            <button class="modal-close" onclick="closeModal('modal-presentation')"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="pres-id" value="0">
            <div style="background:var(--panel2);border:1px solid var(--border);border-radius:8px;padding:12px;margin-bottom:16px;">
                <div style="font-size:13px;color:var(--text2);">
                    📄 Use the visual editor below to design the page. What you see is roughly what the client will see.
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Page Title</label>
                    <input class="form-input" id="pres-title" placeholder="e.g. Proposal for Acme Corp" oninput="autoSlug()">
                </div>
                <div class="form-group">
                    <label class="form-label">Page URL</label>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="font-size:11px;color:var(--text3);white-space:nowrap;">/presentation.php?slug=</span>
                        <input class="form-input" id="pres-slug" placeholder="acme-corp-proposal">
                    </div>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Client Name</label>
                    <input class="form-input" id="pres-client" placeholder="Acme Corporation">
                </div>
                <div class="form-group">
                    <label class="form-label">Theme</label>
                    <select class="form-select" id="pres-sector" onchange="updatePresPreview()">
                        <option value="business">Business (Light & Professional)</option>
                        <option value="academic">Academic (Dark & Elegant)</option>
                    </select>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Main Headline</label>
                    <input class="form-input" id="pres-headline" placeholder="Structured Intelligence for Your Next Chapter" oninput="updatePresPreview()">
                </div>
                <div class="form-group">
                    <label class="form-label">Sub-Headline</label>
                    <input class="form-input" id="pres-subheadline" placeholder="This proposal outlines De Kompany's approach…" oninput="updatePresPreview()">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Password Protection <span style="font-weight:400;color:var(--text3);">(optional)</span></label>
                <input class="form-input" id="pres-password" placeholder="Leave blank for no password">
            </div>
            <div class="form-group" style="display:flex;align-items:center;gap:10px;">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;font-weight:600;color:var(--text2);">
                    <input type="checkbox" id="pres-published" style="width:16px;height:16px;">
                    Publish this page (make it live)
                </label>
            </div>
            <hr class="section-divider">
            <div class="form-group">
                <label class="form-label" style="margin-bottom:10px;">Page Content</label>
                <div class="ve-toolbar">
                    <select onchange="veFormat(this.value);this.value=''" style="height:30px;border:1px solid var(--border2);border-radius:5px;background:var(--bg);color:var(--text);font-size:12px;padding:0 6px;">
                        <option value="">Paragraph</option>
                        <option value="h1">Heading 1</option>
                        <option value="h2">Heading 2</option>
                        <option value="h3">Heading 3</option>
                        <option value="blockquote">Quote</option>
                    </select>
                    <div class="ve-sep"></div>
                    <button class="ve-btn" onclick="veExec('bold')" title="Bold"><b>B</b></button>
                    <button class="ve-btn" onclick="veExec('italic')" title="Italic"><i>I</i></button>
                    <button class="ve-btn" onclick="veExec('underline')" title="Underline"><u>U</u></button>
                    <div class="ve-sep"></div>
                    <button class="ve-btn" onclick="veExec('insertUnorderedList')" title="Bullet List"><i class="fa-solid fa-list-ul fa-xs"></i></button>
                    <button class="ve-btn" onclick="veExec('insertOrderedList')" title="Numbered List"><i class="fa-solid fa-list-ol fa-xs"></i></button>
                    <div class="ve-sep"></div>
                    <button class="ve-btn" onclick="veInsertLink()" title="Insert Link"><i class="fa-solid fa-link fa-xs"></i></button>
                    <button class="ve-btn" onclick="veInsertImage()" title="Insert Image"><i class="fa-solid fa-image fa-xs"></i></button>
                    <button class="ve-btn" onclick="veInsertButton()" title="Insert CTA Button"><i class="fa-solid fa-hand-pointer fa-xs"></i></button>
                    <div class="ve-sep"></div>
                    <div style="display:flex;gap:3px;">
                        <div class="ve-color-swatch" style="background:#111827;" title="Dark" onclick="veExec('foreColor','#111827')"></div>
                        <div class="ve-color-swatch" style="background:#1a56db;" title="Blue" onclick="veExec('foreColor','#1a56db')"></div>
                        <div class="ve-color-swatch" style="background:#e8b84b;" title="Gold" onclick="veExec('foreColor','#e8b84b')"></div>
                        <div class="ve-color-swatch" style="background:#059669;" title="Green" onclick="veExec('foreColor','#059669')"></div>
                        <div class="ve-color-swatch" style="background:#dc2626;" title="Red" onclick="veExec('foreColor','#dc2626')"></div>
                        <input type="color" title="Custom" onchange="veExec('foreColor',this.value)" style="width:18px;height:18px;border:1.5px solid var(--border2);border-radius:3px;padding:0;cursor:pointer;background:none;">
                    </div>
                    <div class="ve-sep"></div>
                    <button class="ve-btn" onclick="veExec('removeFormat')" title="Clear Formatting" style="font-size:10px;">✕</button>
                </div>
                <div class="ve-editor" id="ve-editor" contenteditable="true" oninput="syncEditorToJson()"></div>
                <input type="hidden" id="pres-sections">
            </div>
            <div id="pres-preview-wrap" style="display:none;margin-top:14px;">
                <div class="preview-pane">
                    <div class="preview-pane-bar">
                        <div class="preview-dot" style="background:#ef4444;"></div>
                        <div class="preview-dot" style="background:#f59e0b;"></div>
                        <div class="preview-dot" style="background:#10b981;"></div>
                        <span style="font-size:11px;color:var(--text3);margin-left:6px;" id="preview-url-bar">dekompany.com/presentation.php?slug=…</span>
                    </div>
                    <div class="preview-content">
                        <h2 id="preview-headline" style="font-size:20px;font-weight:700;margin-bottom:6px;"></h2>
                        <p id="preview-subheadline" style="color:var(--text3);margin-bottom:16px;"></p>
                        <div id="preview-body"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeModal('modal-presentation')">Cancel</button>
            <button class="btn btn-ghost" onclick="togglePreview()"><i class="fa-solid fa-eye"></i> Preview</button>
            <button class="btn btn-gold" onclick="savePresentation()"><i class="fa-solid fa-save"></i> Save Page</button>
        </div>
    </div>
</div>

<!-- Media Preview Modal -->
<div class="modal-bg" id="modal-media-preview">
    <div class="modal" style="max-width:480px;">
        <div class="modal-head">
            <div class="modal-title" id="media-preview-name">File Preview</div>
            <button class="modal-close" onclick="closeModal('modal-media-preview')"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body" style="text-align:center;">
            <img id="media-preview-img" src="" style="max-width:100%;max-height:260px;border-radius:8px;display:none;">
            <div id="media-preview-url" style="margin-top:14px;"></div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="copyMediaUrl()"><i class="fa-solid fa-copy"></i> Copy URL</button>
            <button class="btn btn-danger btn-sm" onclick="deleteMedia()"><i class="fa-solid fa-trash"></i> Delete</button>
        </div>
    </div>
</div>

<div class="toast-container" id="toast-container"></div>

<script>
/* ════════════════════════════════════════════════════
   DE KOMPANY ADMIN — JAVASCRIPT ENGINE
   Admin: <?php echo esc_js($admin_name); ?>
════════════════════════════════════════════════════ */

const API        = './api.php';
const ADMIN_NAME = '<?php echo esc_js($admin_name); ?>';

let allLeads         = [];
let allSessions      = [];
let selectedMediaId  = null;
let selectedMediaUrl = '';
let previewOpen      = false;
let activeSessionId  = null;   // currently viewed session
let takeoverActive   = false;  // is admin currently in takeover for active session
let lastLogId        = 0;      // for polling new messages in detail view
let chatPollInterval = null;   // Tracker for the polling loop

/* ── MOBILE SIDEBAR ── */
function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebar-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ── THEME SWITCHER ── */
function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('dkhq-theme', theme);
    document.getElementById('theme-btn-business').classList.toggle('active', theme === 'business');
    document.getElementById('theme-btn-academic').classList.toggle('active', theme === 'academic');
}
(function() {
    const saved = localStorage.getItem('dkhq-theme') || 'business';
    setTheme(saved);
})();

/* ── NAVIGATION ── */
function showPage(name) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('page-' + name).classList.add('active');
    document.querySelectorAll('.nav-item').forEach(n => {
        if (n.getAttribute('onclick')?.includes("'" + name + "'")) n.classList.add('active');
    });
    const titles = {
        dashboard:'Overview', prompts:'AI Personality',
        chatlogs:'Conversations', leads:'Contact Leads',
        presentations:'Client Pages', toggles:'Show / Hide Sections', media:'Images & Files'
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

/* ── API HELPER ── */
async function api(action, params={}, method='GET') {
    const isGet = method === 'GET';
    const url   = API + '?action=' + action + (isGet ? '&' + new URLSearchParams(params) : '');
    const opts  = { method };
    if (!isGet) {
        const fd = new FormData();
        Object.entries(params).forEach(([k,v]) => fd.append(k,v));
        opts.body = fd;
    }
    const r = await fetch(url, opts);
    return r.json();
}

/* ── TOAST NOTIFICATIONS ── */
function toast(msg, type='success') {
    const t = document.createElement('div');
    t.className = 'toast ' + type;
    t.innerHTML = `<i class="fa-solid ${type==='success'?'fa-circle-check':'fa-circle-exclamation'}" style="color:${type==='success'?'var(--green)':'var(--red)'}"></i> ${msg}`;
    document.getElementById('toast-container').appendChild(t);
    setTimeout(() => t.remove(), 3500);
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

/* ════ DASHBOARD ════ */
async function loadDashboard() {
    const s = await api('get_stats');
    document.getElementById('stat-new-leads').textContent    = s.new_leads;
    document.getElementById('stat-sessions').textContent     = s.total_sessions;
    document.getElementById('stat-messages').textContent     = s.total_messages;
    document.getElementById('stat-presentations').textContent= s.presentations;
    document.getElementById('stat-takeovers').textContent    = s.live_takeovers ?? '0';
    document.getElementById('stat-academic').textContent     = s.academic_msgs;
    document.getElementById('stat-business').textContent     = s.business_msgs;
    document.getElementById('badge-leads').textContent       = s.new_leads;
    document.getElementById('badge-logs').textContent        = s.total_sessions;

    const lb = document.querySelector('#dash-leads-table tbody');
    lb.innerHTML = s.recent_leads?.length ? s.recent_leads.map(l => `
        <tr>
            <td><div style="font-weight:600;color:var(--text);">${esc(l.name||'Anonymous')}</div><div class="mono">${esc(l.email||'—')}</div></td>
            <td><span class="badge-pill badge-${l.sector}">${l.sector}</span></td>
            <td><span class="badge-pill badge-${l.status}">${l.status}</span></td>
        </tr>`).join('') : '<tr><td colspan="3" style="text-align:center;color:var(--text3);padding:20px;">No contacts yet</td></tr>';

    const sb = document.querySelector('#dash-sessions-table tbody');
    sb.innerHTML = s.recent_sessions?.length ? s.recent_sessions.map(sess => `
        <tr style="cursor:pointer;" onclick="showPage('chatlogs');setTimeout(()=>loadSessionById('${sess.session_id}'),400);">
            <td class="mono">${sess.session_id.substr(0,10)}…</td>
            <td><span class="badge-pill badge-${sess.sector}">${sess.sector}</span></td>
            <td>${sess.msgs}</td>
            <td class="mono">${fmtDate(sess.started)}</td>
        </tr>`).join('') : '<tr><td colspan="4" style="text-align:center;color:var(--text3);padding:20px;">No chats yet</td></tr>';
}

/* ════ AI PROMPTS ════ */
async function loadPrompts() {
    const rows = await api('get_prompts');
    const list = document.getElementById('prompts-list');
    list.innerHTML = rows.length ? rows.map(p => `
        <div class="prompt-card ${p.is_active==1?'':'opacity-50'}" onclick="editPrompt(${p.id})">
            <div class="prompt-sector ${p.sector}">${p.sector==='academic'?'Academic':p.sector==='business'?'Business':'Concierge'}</div>
            <div class="prompt-label">${esc(p.prompt_label)}</div>
            <div class="prompt-preview">${esc(p.system_prompt)}</div>
            <div style="margin-top:8px;display:flex;gap:5px;flex-wrap:wrap;">
                <span class="tag">${esc(p.ai_model)}</span>
                <span class="tag">creativity: ${p.temperature}</span>
                ${p.is_active==1?'<span class="tag" style="color:var(--green);border-color:var(--green);">● Live</span>':'<span class="tag">inactive</span>'}
            </div>
        </div>`).join('') : '<div class="empty-state"><i class="fa-solid fa-robot"></i><h3>No prompts yet</h3><p>Create your first AI personality above.</p></div>';
}

async function editPrompt(id) {
    const rows = await api('get_prompts');
    const p = rows.find(r => r.id == id);
    if (!p) return;
    document.getElementById('prompt-modal-title').textContent = 'Edit AI Prompt';
    document.getElementById('prompt-id').value     = p.id;
    document.getElementById('prompt-sector').value = p.sector;
    document.getElementById('prompt-label').value  = p.prompt_label;
    document.getElementById('prompt-model').value  = p.ai_model;
    document.getElementById('prompt-temp').value   = p.temperature;
    document.getElementById('prompt-tokens').value = p.max_tokens;
    document.getElementById('prompt-system').value = p.system_prompt;
    document.getElementById('prompt-active').checked = p.is_active == 1;
    openModal('modal-prompt');
}

function openPromptModal() {
    document.getElementById('prompt-modal-title').textContent = 'Create AI Prompt';
    document.getElementById('prompt-id').value = 0;
    ['prompt-label','prompt-system'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('prompt-sector').value = 'academic';
    document.getElementById('prompt-model').value  = 'gemini-2.5-flash';
    document.getElementById('prompt-temp').value   = 0.7;
    document.getElementById('prompt-tokens').value = 300;
    document.getElementById('prompt-active').checked = true;
    openModal('modal-prompt');
}

async function savePrompt() {
    const id = document.getElementById('prompt-id').value;
    const r  = await api('save_prompt', {
        id,
        sector:        document.getElementById('prompt-sector').value,
        prompt_label:  document.getElementById('prompt-label').value,
        ai_model:      document.getElementById('prompt-model').value,
        temperature:   document.getElementById('prompt-temp').value,
        max_tokens:    document.getElementById('prompt-tokens').value,
        system_prompt: document.getElementById('prompt-system').value,
        is_active:     document.getElementById('prompt-active').checked ? 1 : 0,
    }, 'POST');
    if (r.ok) { toast(r.msg||'Saved!'); closeModal('modal-prompt'); loadPrompts(); }
    else toast(r.msg || 'Something went wrong', 'error');
}

/* ════ CONVERSATIONS (Chat Logs) ════ */
async function loadSessions() {
    const sector = document.getElementById('log-sector-filter').value;
    const pane   = document.getElementById('sessions-pane');
    pane.innerHTML = '<div class="text-muted" style="text-align:center;padding:24px;">Loading…</div>';
    const data = await api('get_sessions', { sector });
    allSessions = data;
    filterLogs();
}

function filterLogs() {
    const q      = document.getElementById('log-search').value.toLowerCase();
    const sector = document.getElementById('log-sector-filter').value;
    renderSessions(allSessions.filter(s => {
        const matchesQ      = (s.first_msg||'').toLowerCase().includes(q) || s.session_id.includes(q);
        const matchesSector = sector === '' || s.sector === sector;
        return matchesQ && matchesSector;
    }));
}

function renderSessions(sessions) {
    const pane = document.getElementById('sessions-pane');
    if (!sessions || !sessions.length) {
        pane.innerHTML = '<div class="empty-state"><i class="fa-solid fa-comments"></i><h3>No conversations yet</h3><p>Chats from your website will appear here.</p></div>';
        return;
    }
    pane.innerHTML = sessions.map(s => {
        const isLive = Number(s.is_takeover) === 1;
        return `
        <div class="session-item" id="sess-item-${s.session_id}" onclick="loadSessionDetail('${s.session_id}', this)">
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;flex-wrap:wrap;">
                <span class="badge-pill badge-${s.sector}" style="font-size:10px;">${s.sector}</span>
                ${isLive ? '<span class="badge-pill badge-live" style="font-size:10px;"><span class="live-dot" style="width:6px;height:6px;margin-right:3px;"></span>Live</span>' : ''}
                <span class="text-muted">${s.msg_count} msgs</span>
                <span class="text-muted" style="margin-left:auto;">${fmtDate(s.started)}</span>
            </div>
            <div class="session-preview">${esc(s.first_msg||'—')}</div>
        </div>`;
    }).join('');

    if (activeSessionId) {
        const el = document.getElementById('sess-item-' + activeSessionId);
        if (el) el.classList.add('active');
    }
}

/* ── MOBILE DETAIL CLOSE ── */
function closeMobileDetail() {
    document.querySelector('.conv-layout').classList.remove('mobile-detail-active');
    activeSessionId = null;
    if (chatPollInterval) clearInterval(chatPollInterval);
}

async function loadSessionById(sessionId) {
    const el = document.getElementById('sess-item-' + sessionId);
    if (el) loadSessionDetail(sessionId, el);
}

async function loadSessionDetail(sessionId, el) {
    document.querySelectorAll('.session-item').forEach(i => i.classList.remove('active'));
    if (el) el.classList.add('active');

    document.querySelector('.conv-layout').classList.add('mobile-detail-active');

    activeSessionId = sessionId;
    lastLogId = 0;

    if (chatPollInterval) clearInterval(chatPollInterval);

    const msgs   = await api('get_session_detail', { session_id: sessionId });
    const status = await api('get_takeover_status', { session_id: sessionId });

    takeoverActive = (status.is_active === true || Number(status.is_active) === 1);

    if (msgs.length) lastLogId = Number(msgs[msgs.length - 1].id);

    const pane = document.getElementById('chat-detail-pane');
    pane.innerHTML = `
        <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap;flex-shrink:0;background:var(--panel);position:sticky;top:0;z-index:10;">
            <div style="display:flex;align-items:center;">
                <button class="btn btn-ghost btn-sm mobile-back-btn" onclick="closeMobileDetail()" style="margin-right:12px;padding:6px 10px;"><i class="fa-solid fa-arrow-left"></i></button>
                <div>
                    <div style="font-weight:700;color:var(--text);font-size:15px;">Conversation Transcript</div>
                    <div class="mono" style="font-size:11px;margin-top:2px;">${sessionId}</div>
                </div>
            </div>
            <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                <span class="badge-pill badge-${msgs[0]?.sector||'business'}">${msgs[0]?.sector||''}</span>
            </div>
        </div>

        <div class="chat-wrap" id="chat-transcript">
            ${renderMessages(msgs)}
        </div>

        <div class="takeover-bar" id="takeover-bar">
            <!-- Populated dynamically via updateTakeoverUI() -->
        </div>
    `;

    updateTakeoverUI();
    scrollTranscript();

    chatPollInterval = setInterval(() => pollNewMessages(sessionId), 1000);
}

/* ── POLLING ── */
async function pollNewMessages(sessionId) {
    if (!activeSessionId || activeSessionId !== sessionId) return;

    const msgs = await api('get_session_detail', { session_id: sessionId });
    if (!msgs || !msgs.length) return;

    const latestId       = Number(msgs[msgs.length - 1].id);
    const status         = await api('get_takeover_status', { session_id: sessionId });
    const currentTakeover = (status.is_active === true || Number(status.is_active) === 1);

    if (latestId > lastLogId) {
        lastLogId = latestId;
        const transcript = document.getElementById('chat-transcript');
        if (transcript) {
            transcript.innerHTML = renderMessages(msgs);
            scrollTranscript();
        }
    }

    if (currentTakeover !== takeoverActive) {
        takeoverActive = currentTakeover;
        updateTakeoverUI();
    }
}

function updateTakeoverUI() {
    const bar = document.getElementById('takeover-bar');
    if (!bar) return;

    if (takeoverActive) {
        bar.classList.add('is-live');
        bar.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;width:100%;">
                <span style="font-size:12px;color:var(--green);font-weight:700;display:flex;align-items:center;gap:6px;">
                    <span class="live-dot" style="width:8px;height:8px;"></span> Live Mode Active
                </span>
                <button class="btn btn-ghost btn-xs" onclick="endTakeover()" style="color:var(--red);border-color:rgba(220,38,38,0.2);background:rgba(220,38,38,0.05);">
                    <i class="fa-solid fa-times"></i> End Takeover
                </button>
            </div>
            <div class="takeover-input-wrap">
                <textarea class="takeover-textarea" id="takeover-msg" rows="1" placeholder="Type your reply to the visitor..." oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,120)+'px';" onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendTakeoverMessage();}"></textarea>
                <button class="btn btn-success" style="border-radius:50%;width:40px;height:40px;padding:0;display:flex;align-items:center;justify-content:center;flex-shrink:0;" onclick="sendTakeoverMessage()">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>`;
    } else {
        bar.classList.remove('is-live');
        bar.innerHTML = `
            <div style="display:flex;align-items:center;justify-content:space-between;width:100%;">
                <span style="font-size:13px;color:var(--text2);font-weight:500;"><i class="fa-solid fa-robot" style="margin-right:6px;"></i> AI is currently managing this chat</span>
                <button class="btn btn-primary btn-sm" onclick="startTakeover()" style="box-shadow:0 4px 12px rgba(26,86,219,0.2);">
                    <i class="fa-solid fa-user-shield"></i> Take Over Live
                </button>
            </div>`;
    }
}

function renderMessages(msgs) {
    if (!msgs || !msgs.length) return '<div class="empty-state"><i class="fa-solid fa-comments"></i><h3>No messages</h3></div>';
    return msgs.map(m => {
        if (m.sender === 'user') {
            return `<div class="chat-user-wrap"><div class="chat-bubble bubble-user">${esc(m.message)}<div style="font-size:10px;opacity:.45;margin-top:4px;">${fmtDate(m.created_at)} · Visitor</div></div></div>`;
        } else if (m.sender === 'admin') {
            return `<div class="chat-admin-wrap"><div class="chat-bubble bubble-admin"><span style="font-size:10px;font-weight:700;color:var(--green);display:block;margin-bottom:3px;">🧑‍💼 Human Agent</span>${esc(m.message)}<div style="font-size:10px;opacity:.45;margin-top:4px;">${fmtDate(m.created_at)}</div></div></div>`;
        } else {
            return `<div class="chat-bot-wrap"><div class="chat-bubble bubble-bot">${esc(m.message)}<div style="font-size:10px;opacity:.45;margin-top:4px;">${fmtDate(m.created_at)} · AI</div></div></div>`;
        }
    }).join('');
}

function scrollTranscript() {
    const t = document.getElementById('chat-transcript');
    if (t) t.scrollTop = t.scrollHeight;
}

/* ── TAKEOVER CONTROL ── */
async function startTakeover() {
    if (!activeSessionId) return;
    const r = await api('start_takeover', { session_id: activeSessionId }, 'POST');
    if (r.ok) { takeoverActive = true; updateTakeoverUI(); toast('You are now live in this conversation.'); }
}

async function sendTakeoverMessage() {
    const input = document.getElementById('takeover-msg');
    if (!input) return;
    const msg = input.value.trim();
    if (!msg) return;
    input.value = '';
    input.style.height = 'auto';

    const r = await api('send_takeover_message', {
        session_id: activeSessionId,
        message:    msg,
        admin_name: ADMIN_NAME,
    }, 'POST');

    if (r.ok) pollNewMessages(activeSessionId);
    else toast('Failed to send message', 'error');
}

async function endTakeover() {
    if (!activeSessionId) return;
    await api('end_takeover', { session_id: activeSessionId }, 'POST');
    takeoverActive = false;
    updateTakeoverUI();
    toast('Conversation handed back to AI.');
}

/* ════ CONTACT LEADS ════ */
async function loadLeads() {
    const sector = document.getElementById('lead-sector-filter').value;
    const status = document.getElementById('lead-status-filter').value;
    const data   = await api('get_leads', { sector, status });
    allLeads     = data;
    renderLeads(data);
    document.getElementById('lead-count').textContent = data.length + ' contact' + (data.length===1?'':'s');
}

function filterLeads() {
    const q = document.getElementById('lead-search').value.toLowerCase();
    renderLeads(allLeads.filter(l =>
        (l.name||'').toLowerCase().includes(q) ||
        (l.email||'').toLowerCase().includes(q) ||
        (l.first_query||'').toLowerCase().includes(q)
    ));
}

const STATUS_LABELS = { new:'🆕 New', contacted:'📞 Contacted', converted:'✅ Converted', archived:'🗄️ Archived' };

function renderLeads(leads) {
    const isMobile = window.innerWidth < 768;
    document.getElementById('leads-card-list').style.display  = isMobile ? 'block' : 'none';
    document.getElementById('leads-table-wrap').style.display = isMobile ? 'none'  : 'block';

    if (!leads.length) {
        const emptyHtml = '<div class="empty-state"><i class="fa-solid fa-users"></i><h3>No contacts yet</h3><p>Contacts are captured automatically from your website chat.</p></div>';
        document.getElementById('leads-card-list').innerHTML = emptyHtml;
        document.querySelector('#leads-table tbody').innerHTML = `<tr><td colspan="6">${emptyHtml}</td></tr>`;
        return;
    }

    document.getElementById('leads-card-list').innerHTML = leads.map(l => `
        <div class="card-row">
            <div class="card-row-title">${esc(l.name||'Anonymous')}</div>
            <div class="card-row-sub">${esc(l.email||'—')} ${l.phone ? '· ' + esc(l.phone) : ''}</div>
            <div class="card-row-meta">
                <span class="badge-pill badge-${l.sector}">${l.sector}</span>
                <span class="badge-pill badge-${l.status}">${STATUS_LABELS[l.status]||l.status}</span>
                <span class="text-muted">${fmtDate(l.created_at)}</span>
            </div>
            ${l.first_query ? `<div style="font-size:12px;color:var(--text3);margin-top:6px;">${esc(l.first_query.substr(0,100))}${l.first_query.length>100?'…':''}</div>` : ''}
            <div class="card-row-actions">
                <button class="btn btn-ghost btn-sm" onclick="openLeadEdit(${l.id},'${esc(l.status)}',\`${esc(l.notes||'')}\`,'${esc(l.phone||'')}')">
                    <i class="fa-solid fa-pen"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteLead(${l.id})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>`).join('');

    document.querySelector('#leads-table tbody').innerHTML = leads.map(l => `
        <tr>
            <td>
                <div style="font-weight:600;color:var(--text);">${esc(l.name||'Anonymous')}</div>
                <div class="mono">${esc(l.email||'—')}</div>
                ${l.phone ? `<div class="mono">${esc(l.phone)}</div>` : ''}
            </td>
            <td><span class="badge-pill badge-${l.sector}">${l.sector}</span></td>
            <td style="max-width:200px;font-size:12px;color:var(--text2);">${esc((l.first_query||'').substr(0,80))}${(l.first_query||'').length>80?'…':''}</td>
            <td><span class="badge-pill badge-${l.status}">${STATUS_LABELS[l.status]||l.status}</span></td>
            <td class="mono">${fmtDate(l.created_at)}</td>
            <td>
                <div style="display:flex;gap:5px;">
                    <button class="btn btn-ghost btn-xs" onclick="openLeadEdit(${l.id},'${esc(l.status)}',\`${esc(l.notes||'')}\`,'${esc(l.phone||'')}')">
                        <i class="fa-solid fa-pen"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-xs" onclick="deleteLead(${l.id})">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>`).join('');
}

function openLeadEdit(id, status, notes, phone) {
    document.getElementById('lead-edit-id').value     = id;
    document.getElementById('lead-edit-status').value = status;
    document.getElementById('lead-edit-notes').value  = notes;
    document.getElementById('lead-edit-phone').value  = phone;
    openModal('modal-lead');
}

async function saveLead() {
    const r = await api('update_lead', {
        id:     document.getElementById('lead-edit-id').value,
        status: document.getElementById('lead-edit-status').value,
        notes:  document.getElementById('lead-edit-notes').value,
        phone:  document.getElementById('lead-edit-phone').value,
    }, 'POST');
    if (r.ok) { toast('Contact updated!'); closeModal('modal-lead'); loadLeads(); }
    else toast('Error updating contact', 'error');
}

async function deleteLead(id) {
    if (!confirm('Remove this contact? This cannot be undone.')) return;
    const r = await api('delete_lead', { id }, 'POST');
    if (r.ok) { toast('Contact removed'); loadLeads(); }
}

/* ════ SECTION TOGGLES ════ */
async function loadToggles() {
    const rows = await api('get_toggles');
    renderToggles(rows.filter(r => r.sector==='academic'), 'toggles-academic');
    renderToggles(rows.filter(r => r.sector==='business'), 'toggles-business');
}

function renderToggles(rows, containerId) {
    const el = document.getElementById(containerId);
    if (!rows.length) { el.innerHTML = '<p class="text-muted">No sections set up yet.</p>'; return; }
    el.innerHTML = rows.map(r => `
        <div class="toggle-row">
            <div class="toggle-info">
                <h4>${esc(r.section_label)}</h4>
                <p>ID: #${esc(r.section_key)}</p>
            </div>
            <label class="switch">
                <input type="checkbox" ${r.is_visible==1?'checked':''} onchange="toggleSection('${r.sector}','${r.section_key}',this.checked)">
                <span class="slider"></span>
            </label>
        </div>`).join('');
}

async function toggleSection(sector, key, visible) {
    const r = await api('toggle_section', { sector, section_key: key, is_visible: visible?1:0 }, 'POST');
    if (r.ok) toast(`Section ${visible?'shown':'hidden'} on website`);
}

async function addToggle() {
    const sector = document.getElementById('new-toggle-sector').value;
    const key    = document.getElementById('new-toggle-key').value.trim();
    const label  = document.getElementById('new-toggle-label').value.trim();
    if (!key||!label) { toast('Please fill in both fields', 'error'); return; }
    const r = await api('add_toggle', { sector, section_key: key, section_label: label }, 'POST');
    if (r.ok) {
        toast('Section added!');
        loadToggles();
        document.getElementById('new-toggle-key').value   = '';
        document.getElementById('new-toggle-label').value = '';
    }
}

/* ════ MEDIA ════ */
async function loadMedia() {
    const rows = await api('get_media');
    const grid = document.getElementById('media-grid');
    document.getElementById('media-count').textContent = rows.length + ' file' + (rows.length===1?'':'s');
    if (!rows.length) {
        grid.innerHTML = '<div style="grid-column:1/-1;" class="empty-state"><i class="fa-solid fa-images"></i><h3>No files yet</h3><p>Upload images or PDFs above.</p></div>';
        return;
    }
    grid.innerHTML = rows.map(m => `
        <div class="media-item" onclick="previewMedia(${m.id},'${esc(m.file_url)}','${esc(m.filename)}')">
            ${m.file_type&&m.file_type.startsWith('image/')
                ? `<img class="media-thumb" src="${esc(m.file_url)}" alt="${esc(m.alt_text||m.filename)}" loading="lazy">`
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
    document.getElementById('media-preview-url').innerHTML = `
        <input class="form-input" value="${esc(url)}" readonly onclick="this.select()" style="text-align:center;font-size:12px;">
        <div class="form-hint" style="margin-top:6px;">Tap the URL above to select it, then copy.</div>`;
    openModal('modal-media-preview');
}

function copyMediaUrl() {
    navigator.clipboard.writeText(selectedMediaUrl).then(() => toast('URL copied to clipboard!'));
}

async function deleteMedia() {
    if (!confirm('Delete this file permanently?')) return;
    const r = await api('delete_media', { id: selectedMediaId }, 'POST');
    if (r.ok) { toast('File deleted'); closeModal('modal-media-preview'); loadMedia(); }
}

async function uploadFiles(files) {
    for (const file of files) {
        const fd = new FormData();
        fd.append('action', 'upload_media');
        fd.append('file', file);
        fd.append('alt_text', '');
        const r = await fetch(API, { method:'POST', body:fd });
        const d = await r.json();
        if (d.ok) toast('✅ Uploaded: ' + file.name);
        else toast('❌ Failed: ' + (d.msg||'unknown error'), 'error');
    }
    loadMedia();
}

const dz = document.getElementById('drop-zone');
dz.addEventListener('dragover',  e => { e.preventDefault(); dz.classList.add('drag'); });
dz.addEventListener('dragleave', ()=> dz.classList.remove('drag'));
dz.addEventListener('drop',      e => { e.preventDefault(); dz.classList.remove('drag'); uploadFiles(e.dataTransfer.files); });

/* ════ CLIENT PAGES (Presentations) ════ */
async function loadPresentations() {
    const rows = await api('get_presentations');
    const tb   = document.querySelector('#pres-table tbody');
    if (!rows.length) {
        tb.innerHTML = '<tr><td colspan="7"><div class="empty-state"><i class="fa-solid fa-file-lines"></i><h3>No client pages yet</h3><p>Create your first page above.</p></div></td></tr>';
        return;
    }
    tb.innerHTML = rows.map(p => `
        <tr>
            <td style="font-weight:600;color:var(--text);">${esc(p.title)}</td>
            <td>${esc(p.client_name||'—')}</td>
            <td><span class="badge-pill badge-${p.sector}">${p.sector}</span></td>
            <td>${p.is_published
                ? '<span class="badge-pill badge-converted">✅ Published</span>'
                : '<span class="badge-pill badge-archived">🗄️ Draft</span>'}</td>
            <td>${p.view_count}</td>
            <td class="mono">${fmtDate(p.created_at)}</td>
            <td>
                <div style="display:flex;gap:5px;">
                    <a href="../presentation.php?slug=${esc(p.slug)}" target="_blank" class="btn btn-ghost btn-xs"><i class="fa-solid fa-eye"></i></a>
                    <button class="btn btn-primary btn-xs" onclick="editPresentation(${p.id})"><i class="fa-solid fa-pen"></i> Edit</button>
                    <button class="btn btn-danger btn-xs" onclick="deletePresentation(${p.id})"><i class="fa-solid fa-trash"></i></button>
                </div>
            </td>
        </tr>`).join('');
}

function openPresentationModal() {
    document.getElementById('pres-modal-title').textContent = 'New Client Page';
    document.getElementById('pres-id').value = 0;
    ['pres-title','pres-slug','pres-client','pres-headline','pres-subheadline','pres-password'].forEach(id => document.getElementById(id).value='');
    document.getElementById('pres-sector').value = 'business';
    document.getElementById('pres-published').checked = false;
    document.getElementById('ve-editor').innerHTML = `<h2>Our Understanding</h2><p>We understand your needs...</p><h2>What We Offer</h2><ul><li>Brand Strategy</li><li>Documentation</li><li>Corporate Writing</li></ul><h2>Ready to Begin?</h2><p>Let's schedule a consultation and build this together.</p>`;
    document.getElementById('pres-preview-wrap').style.display = 'none';
    previewOpen = false;
    syncEditorToJson();
    openModal('modal-presentation');
}

async function editPresentation(id) {
    const p = await api('get_presentation', { id });
    document.getElementById('pres-modal-title').textContent = 'Edit Client Page';
    document.getElementById('pres-id').value          = p.id;
    document.getElementById('pres-title').value       = p.title;
    document.getElementById('pres-slug').value        = p.slug;
    document.getElementById('pres-client').value      = p.client_name;
    document.getElementById('pres-sector').value      = p.sector;
    document.getElementById('pres-headline').value    = p.hero_headline;
    document.getElementById('pres-subheadline').value = p.hero_subheadline;
    document.getElementById('pres-password').value    = p.password_protected||'';
    document.getElementById('pres-published').checked = p.is_published==1;
    try {
        const sections = JSON.parse(p.sections||'[]');
        document.getElementById('ve-editor').innerHTML = sectionsToHtml(sections);
    } catch(_) {
        document.getElementById('ve-editor').innerHTML = p.sections || '';
    }
    document.getElementById('pres-sections').value = p.sections;
    document.getElementById('pres-preview-wrap').style.display = 'none';
    previewOpen = false;
    openModal('modal-presentation');
}

function sectionsToHtml(sections) {
    if (!Array.isArray(sections)) return '';
    return sections.map(s => {
        if (s.type==='html')  return s.content || '';
        if (s.type==='text')  return `<h2>${s.heading||''}</h2><p>${s.body||''}</p>`;
        if (s.type==='list')  return `<h2>${s.heading||''}</h2><ul>${(s.items||[]).map(i=>`<li>${i}</li>`).join('')}</ul>`;
        if (s.type==='cta')   return `<h2>${s.heading||''}</h2><p>${s.body||''}</p><p><a href="${s.link||'#'}">[${s.button||'Click Here'}]</a></p>`;
        return '';
    }).join('');
}

async function savePresentation() {
    syncEditorToJson();
    const id = document.getElementById('pres-id').value;
    const r  = await api('save_presentation', {
        id,
        slug:               document.getElementById('pres-slug').value,
        title:              document.getElementById('pres-title').value,
        client_name:        document.getElementById('pres-client').value,
        sector:             document.getElementById('pres-sector').value,
        hero_headline:      document.getElementById('pres-headline').value,
        hero_subheadline:   document.getElementById('pres-subheadline').value,
        sections:           document.getElementById('pres-sections').value,
        theme:              document.getElementById('pres-sector').value,
        is_published:       document.getElementById('pres-published').checked ? 1 : 0,
        password_protected: document.getElementById('pres-password').value,
    }, 'POST');
    if (r.ok) { toast(r.msg||'Page saved!'); closeModal('modal-presentation'); loadPresentations(); }
    else toast(r.msg||'Error saving page', 'error');
}

async function deletePresentation(id) {
    if (!confirm('Delete this client page? This cannot be undone.')) return;
    const r = await api('delete_presentation', { id }, 'POST');
    if (r.ok) { toast('Page deleted'); loadPresentations(); }
}

function autoSlug() {
    const title = document.getElementById('pres-title').value;
    document.getElementById('pres-slug').value = title.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
    document.getElementById('preview-url-bar').textContent = 'dekompany.com/presentation.php?slug=' + document.getElementById('pres-slug').value;
    updatePresPreview();
}

/* ── VISUAL EDITOR ── */
function veExec(cmd, val=null) {
    document.getElementById('ve-editor').focus();
    document.execCommand(cmd, false, val);
    syncEditorToJson();
}
function veFormat(tag) {
    if (!tag) return;
    document.getElementById('ve-editor').focus();
    document.execCommand('formatBlock', false, tag);
    syncEditorToJson();
}
function veInsertLink() {
    const url = prompt('Enter the link URL:', 'https://');
    if (url) veExec('createLink', url);
}
function veInsertImage() {
    const url = prompt('Enter the image URL (upload to Media Library first and paste URL):');
    if (url) veExec('insertHTML', `<img src="${url}" alt="" style="max-width:100%;border-radius:6px;margin:8px 0;">`);
    syncEditorToJson();
}
function veInsertButton() {
    const label = prompt('Button text:', 'Book a Call');
    const url   = prompt('Button link:', 'https://wa.me/234912704');
    if (label && url) {
        veExec('insertHTML', `<p><a href="${url}" style="display:inline-block;padding:10px 24px;background:#e8b84b;color:#000;font-weight:700;border-radius:8px;text-decoration:none;margin:8px 0;">${label}</a></p>`);
    }
    syncEditorToJson();
}
function syncEditorToJson() {
    const html = document.getElementById('ve-editor').innerHTML;
    const sections = JSON.stringify([{ type: 'html', content: html }]);
    document.getElementById('pres-sections').value = sections;
    updatePresPreview();
}
function togglePreview() {
    previewOpen = !previewOpen;
    document.getElementById('pres-preview-wrap').style.display = previewOpen ? 'block' : 'none';
    if (previewOpen) updatePresPreview();
}
function updatePresPreview() {
    document.getElementById('preview-headline').textContent    = document.getElementById('pres-headline').value   || 'Your Headline';
    document.getElementById('preview-subheadline').textContent = document.getElementById('pres-subheadline').value || 'Your sub-headline';
    document.getElementById('preview-body').innerHTML          = document.getElementById('ve-editor').innerHTML;
    document.getElementById('preview-url-bar').textContent     = 'dekompany.com/presentation.php?slug=' + (document.getElementById('pres-slug').value || '…');
}

/* ── UTILS ── */
function esc(str) {
    if (!str) return '';
    // Strip escaped quotes (magic quotes compatibility), then HTML-encode
    let cleanStr = String(str).replace(/\\(['\"\\])/g, '$1');
    return cleanStr.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

function fmtDate(d) {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'2-digit',hour:'2-digit',minute:'2-digit'});
}

/* ── Responsive: re-render leads on resize ── */
window.addEventListener('resize', () => {
    if (allLeads.length) renderLeads(allLeads);
});

// Init — load dashboard on first paint
loadDashboard();
</script>
</body>
</html>