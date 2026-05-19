<?php
/**
 * De Kompany — Academic Footer (Lead Capture + Chat Logging)
 * Location: /academic/footer.php
 * UI aligned to match header.php and index.php design system.
 */

if (!defined('ABSPATH')) {
    require_once dirname(__DIR__) . '/wp/wp-load.php';
}
global $wpdb;

// ── Fetch active academic prompt from DB ──────────────────────────────────────
$prompt_row = $wpdb->get_row(
    "SELECT * FROM {$wpdb->prefix}dkhq_prompts WHERE sector = 'academic' AND is_active = 1 ORDER BY id DESC LIMIT 1"
);

$system_prompt = $prompt_row
    ? addslashes($prompt_row->system_prompt)
    : "You are an enthusiastic Academic Coach for 'De Kompany'. Keep answers short, helpful, and end with a question to keep the student engaged.";

$ai_model   = $prompt_row ? esc_js($prompt_row->ai_model)     : 'gemini-2.5-flash';
$max_tokens = $prompt_row ? intval($prompt_row->max_tokens)    : 400;
$temperature= $prompt_row ? floatval($prompt_row->temperature) : 0.7;

// ── Gemini key — stored in WP options, NOT hardcoded ─────────────────────────
$gemini_key = get_option('dkhq_gemini_key', '');

// ── THE API ENDPOINT FIX ──────────────────────────────────────────────────────
$admin_api = admin_url('admin-ajax.php');
?>

<!-- ═══════════════════════════════ FOOTER ═══════════════════════════════════ -->
<!-- Design matches header.php: bg-blue-950, border-blue-900, yellow accents  -->
<!-- ═══════════════════════════════════════════════════════════════════════════ -->
<footer id="student-contact" class="mt-20 border-t border-blue-900 pt-12 pb-28 md:pb-16 relative z-10">
    <div class="container mx-auto px-6">

        <!-- Three-column grid — same max-width as nav's container -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 mb-10">

            <!-- Brand col -->
            <div class="flex flex-col gap-4">
                <!-- Logo block matches nav exactly -->
                <div class="flex items-center gap-3">
                    <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg"
                         class="w-10 h-10 rounded-full border border-yellow-500/30"
                         alt="De Kompany">
                    <div class="flex flex-col">
                        <span class="font-serif font-bold text-lg text-white leading-none">De Kompany</span>
                        <span class="text-[10px] text-yellow-400 uppercase tracking-widest">Academic Sector</span>
                    </div>
                </div>
                <p class="text-blue-300 text-sm leading-relaxed max-w-xs">
                    Empowering the next generation of leaders through academic excellence and structured coaching.
                </p>
                <!-- Social icons -->
                <div class="flex gap-4 mt-1">
                    <a href="#" class="text-blue-400 hover:text-yellow-400 transition" aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </a>
                    <a href="#" class="text-blue-400 hover:text-yellow-400 transition" aria-label="Instagram">
                        <i class="fa-brands fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Quick links col -->
            <div>
                <h3 class="font-bold text-white mb-4 uppercase text-xs tracking-widest text-yellow-400">Quick Links</h3>
                <ul class="space-y-3 text-sm text-blue-300">
                    <li><a href="#student-services" class="hover:text-yellow-400 transition-colors">Services</a></li>
                    <li><a href="#student-lounge" class="hover:text-yellow-400 transition-colors">Student Lounge</a></li>
                    <li><a href="services.php" class="hover:text-yellow-400 transition-colors">Explore Resources</a></li>
                    <li>
                        <button onclick="dkToggleChat()"
                            class="hover:text-yellow-400 transition-colors text-left">
                            Ask the Coach
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Contact col -->
            <div>
                <h3 class="font-bold text-white mb-4 uppercase text-xs tracking-widest text-yellow-400">Contact</h3>
                <ul class="space-y-3 text-sm text-blue-300">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-yellow-500/60 text-xs"></i>
                        <span>education@dekompany.com</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-yellow-500/60 text-xs"></i>
                        <span>+234 912 704 0327</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Bottom bar — same style as nav bottom border -->
        <div class="border-t border-blue-900 pt-6 flex flex-col md:flex-row justify-between items-center gap-2 text-xs text-blue-500">
            <span>&copy; <?php echo date('Y'); ?> De Kompany. All rights reserved.</span>
            <span>
                Designed &amp; Developed by
                <a href="https://getonlinestudio.com/" rel="nofollow" target="_blank"
                   class="text-yellow-500 hover:text-white transition-colors">GetOnline Studio</a>.
            </span>
        </div>

    </div>
</footer>
</main>

<!-- ════════════════════════════════════════════════════════════════ -->
<!-- ACADEMIC CHAT WIDGET — Mobile Optimised, Streaming, Bug-Fixed   -->
<!-- ════════════════════════════════════════════════════════════════ -->
<style>
/* Safe-area for iPhone notch / home bar */
.pb-safe-chat { padding-bottom: max(12px, env(safe-area-inset-bottom, 12px)); }

/* Chat container — auto height on mobile (no dead space), floating card on desktop */
#chat-container {
    position: fixed;
    bottom: 0; right: 0;
    width: 100%;
    height: auto;        /* wraps content — kills the empty navy block */
    max-height: 88svh;
    transform: translateY(110%);
    transition: transform 0.32s cubic-bezier(0.4,0,0.2,1);
    z-index: 50;
    display: flex;
    flex-direction: column;
    background: #0d1b39;
    border-top: 1px solid #1e3a6b;
    border-radius: 0;
}
@media (min-width: 640px) {
    #chat-container {
        width: 380px;
        height: 540px;
        max-height: 90svh;
        bottom: 80px;
        right: 16px;
        border: 1px solid #1e3a6b;
        border-radius: 16px;
        box-shadow: 0 24px 60px rgba(0,0,0,0.55);
    }
}
#chat-container.open { transform: translateY(0); }
/* Once in chat mode (messages visible), expand to fill nicely */
#chat-container.chat-active {
    height: clamp(380px, 75svh, 560px);
}

/* Match nav's border-radius pattern */
#chat-header { border-radius: 0; }
@media (min-width: 640px) {
    #chat-header { border-radius: 16px 16px 0 0; }
}

/* Scrollable message area */
#chat-body {
    flex: 1;
    overflow-y: auto;
    overscroll-behavior: contain;
    -webkit-overflow-scrolling: touch;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    scroll-behavior: smooth;
}
#chat-body::-webkit-scrollbar { width: 4px; }
#chat-body::-webkit-scrollbar-thumb { background: #1e3a6b; border-radius: 4px; }

/* Bubbles */
.dk-bubble-bot {
    background: #1a2f5a;
    border: 1px solid #1e3a6b;
    color: #c7d8f5;
    padding: 10px 14px;
    border-radius: 16px 16px 16px 4px;
    font-size: 14px;
    line-height: 1.55;
    max-width: 88%;
    word-break: break-word;
    align-self: flex-start;
}
.dk-bubble-user {
    background: #ca8a04;
    color: #fff;
    padding: 10px 14px;
    border-radius: 16px 16px 4px 16px;
    font-size: 14px;
    line-height: 1.55;
    max-width: 88%;
    word-break: break-word;
    align-self: flex-end;
}

/* Typing dots */
.dk-dots span {
    display: inline-block;
    width: 8px; height: 8px;
    background: #5b8eff;
    border-radius: 50%;
    animation: dkBounce 1s infinite;
    margin: 0 2px;
}
.dk-dots span:nth-child(2) { animation-delay: .15s; }
.dk-dots span:nth-child(3) { animation-delay: .30s; }
@keyframes dkBounce { 0%,80%,100%{transform:translateY(0)} 40%{transform:translateY(-7px)} }

/* Input area */
#chat-input-area {
    flex-shrink: 0;
    padding: 10px 12px;
    background: #0a1628;
    border-top: 1px solid #1e3a6b;
}
#chat-input-area .inner {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    background: #0d1b39;
    border: 1.5px solid #1e3a6b;
    border-radius: 14px;
    padding: 6px 8px 6px 14px;
    transition: border-color 0.2s;
}
#chat-input-area .inner:focus-within { border-color: #eab308; }
#user-input-chat {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: #e2e8f0;
    font-size: 16px;
    resize: none;
    max-height: 100px;
    line-height: 1.4;
    padding: 4px 0;
    font-family: inherit;
}
#user-input-chat::placeholder { color: #4a6080; }
#send-btn-chat {
    flex-shrink: 0;
    width: 40px; height: 40px;
    background: #ca8a04;
    border: none;
    border-radius: 10px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: background 0.2s, transform 0.1s;
}
#send-btn-chat:hover { background: #d97706; }
#send-btn-chat:active { transform: scale(0.93); }
#send-btn-chat:disabled { opacity: 0.45; cursor: not-allowed; }

/* Float button — aligned to header's "Ask Coach" button style */
#chat-float-btn {
    position: fixed;
    bottom: 20px; right: 20px;
    z-index: 49;
    width: 56px; height: 56px;
    background: #ca8a04;
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 22px;
    cursor: pointer;
    box-shadow: 0 6px 24px rgba(202,138,4,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, transform 0.2s;
}
#chat-float-btn:hover { background: #d97706; transform: scale(1.06); }

@keyframes dkFadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
.dk-fade-up { animation: dkFadeUp 0.25s ease-out both; }
</style>

<!-- Chat Widget HTML -->
<div id="chat-container" role="dialog" aria-label="Academic Coach Chat">

    <!-- Header — matches nav's bg-blue-900 pattern -->
    <div id="chat-header"
         class="flex justify-between items-center px-4 py-3 bg-blue-900 shrink-0 cursor-pointer"
         onclick="dkToggleChat()"
         style="border-bottom:1px solid #1e3a6b;">
        <div class="flex items-center gap-3">
            <div class="relative">
                <div class="w-9 h-9 rounded-full bg-blue-800 flex items-center justify-center border border-yellow-500/40">
                    <i class="fa-solid fa-graduation-cap text-yellow-400 text-sm"></i>
                </div>
                <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-green-400 border-2 border-blue-900 rounded-full"></span>
            </div>
            <div>
                <h4 class="font-bold text-sm text-white leading-tight">Academic Coach</h4>
                <span class="text-[11px] text-blue-300">Online · Ask me anything</span>
            </div>
        </div>
        <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-blue-800 transition text-blue-300"
                aria-label="Close chat">
            <i class="fa-solid fa-chevron-down" id="chat-chevron"></i>
        </button>
    </div>
    
    <!-- Takeover Indicator (Hidden by default) -->
    <div id="dk-takeover-indicator" style="display:none; align-items:center; justify-content:center; background:rgba(34,201,132,0.15); color:#22c984; font-size:11px; font-weight:700; padding:6px; border-bottom:1px solid rgba(34,201,132,0.3);">
        <!-- Content dynamically injected via JS -->
    </div>

    <!-- Lead Capture Gate -->
    <div id="lead-gate" class="flex flex-col p-6 bg-blue-950" style="padding-bottom: max(24px, env(safe-area-inset-bottom, 24px));">
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4 border border-yellow-500/30">
                <i class="fa-solid fa-graduation-cap text-yellow-400 text-2xl"></i>
            </div>
            <h3 class="text-white font-bold text-lg">Chat with your Academic Coach</h3>
            <p class="text-blue-300 text-sm mt-1">Quick intro helps us personalise your session</p>
        </div>
        <div class="space-y-3 max-w-xs mx-auto w-full">
            <input id="gate-name" type="text" placeholder="Your name" autocomplete="name"
                class="w-full p-3 rounded-xl bg-blue-900 text-white placeholder-blue-400 border border-blue-800 focus:border-yellow-500 focus:outline-none text-sm">
            <input id="gate-email" type="email" placeholder="Email address" autocomplete="email"
                class="w-full p-3 rounded-xl bg-blue-900 text-white placeholder-blue-400 border border-blue-800 focus:border-yellow-500 focus:outline-none text-sm">
            <input id="gate-phone" type="tel" placeholder="Phone (optional)" autocomplete="tel"
                class="w-full p-3 rounded-xl bg-blue-900 text-white placeholder-blue-400 border border-blue-800 focus:border-yellow-500 focus:outline-none text-sm">
            <button onclick="dkSubmitGate()"
                class="w-full py-3 bg-yellow-600 hover:bg-yellow-500 text-white font-bold rounded-xl transition text-sm">
                Start Chat <i class="fa-solid fa-arrow-right ml-1"></i>
            </button>
            <button onclick="dkSkipGate()" class="w-full py-2 text-blue-400 hover:text-blue-200 text-xs transition">
                Skip for now
            </button>
        </div>
    </div>

    <!-- Chat Messages -->
    <div id="chat-body" class="hidden" aria-live="polite"></div>

    <!-- Input Area -->
    <div id="chat-input-area" class="pb-safe-chat hidden">
        <div class="inner">
            <textarea id="user-input-chat" rows="1"
                placeholder="Type your question…"
                autocomplete="off"
                aria-label="Your message"></textarea>
            <button id="send-btn-chat" aria-label="Send message">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
        <p class="text-center text-[10px] text-blue-700 mt-2">Academic Coach · Powered by AI</p>
    </div>
</div>

<!-- Floating Button -->
<button onclick="dkToggleChat()" id="chat-float-btn" aria-label="Open academic chat">
    <i class="fa-solid fa-graduation-cap"></i>
</button>

<script>
(function () {
    const ADMIN_API   = '<?php echo esc_js($admin_api); ?>';
    const GEMINI_KEY  = '<?php echo esc_js($gemini_key); ?>';
    const AI_MODEL    = '<?php echo esc_js($ai_model); ?>';
    const SYSTEM_P    = `<?php echo $system_prompt; ?>`;
    const MAX_TOKENS  = <?php echo $max_tokens; ?>;
    const TEMPERATURE = <?php echo $temperature; ?>;
    const SECTOR      = 'academic';

    // ── THE AMNESIA FIX: PERSISTENT LOCAL STORAGE ──
    let sessionId = localStorage.getItem('dkhq_academic_session');
    if (!sessionId) {
        sessionId = 'sess_' + Date.now() + '_' + Math.random().toString(36).substr(2, 8);
        localStorage.setItem('dkhq_academic_session', sessionId);
    }

    let isResponding = false;
    let leadCaptured = false;
    let chatOpen     = false;
    let userData     = { name: '', email: '', phone: '' };
    let conversationHistory = [];
    let aiSummaryTimer = null;

    // ── THE REACTIVE POLLING ENGINE ──
    let takeoverMode   = false;   // Is the admin currently controlling this session?
    let lastLogId      = 0;       // Tracks the absolute latest message ID we've pulled
    let pollInterval   = null;    // The setInterval loop handle
    let chatStarted    = false;   // Has the visitor entered the chat phase?

    // Check history immediately on page load
    initHistoryCheck();

    async function initHistoryCheck() {
        try {
            const resp = await fetch(ADMIN_API + '?action=dkhq_get_session_detail&session_id=' + sessionId);
            const msgs = await resp.json();
            
            if (msgs && msgs.length > 0) {
                document.getElementById('lead-gate').classList.add('hidden');
                document.getElementById('chat-body').classList.remove('hidden');
                document.getElementById('chat-input-area').classList.remove('hidden');
                document.getElementById('chat-container').classList.add('chat-active');
                chatStarted = true;

                msgs.forEach(msg => {
                    if (msg.sender === 'admin') {
                        addAdminMessage(msg.message, msg.admin_name || 'Human Agent');
                    } else if (msg.sender === 'user') {
                        addUserMessage(msg.message);
                    } else {
                        addBotMessage(msg.message);
                    }
                    
                    conversationHistory.push({
                        role: msg.sender === 'user' ? 'user' : 'model',
                        parts: [{ text: msg.message }]
                    });
                    
                    // STRCIT NUMBER CASTING TO AVOID "9 IS BIGGER THAN 10" BUG
                    if (Number(msg.id) > Number(lastLogId)) lastLogId = Number(msg.id);
                });
                
                startPolling();
            }
        } catch (e) {
            // Ignore network issues on load
        }
    }

    function startPolling() {
        if (pollInterval) return; 
        
        pollInterval = setInterval(async () => {
            if (!chatStarted) return; 
            
            try {
                const [msgsRes, statusRes] = await Promise.all([
                    fetch(ADMIN_API + '?action=dkhq_get_session_detail&session_id=' + sessionId),
                    fetch(ADMIN_API + '?action=dkhq_get_takeover_status&session_id=' + sessionId)
                ]);

                const msgs = await msgsRes.json();
                const status = await statusRes.json();

                // 1. Process New Messages from the Admin
                if (msgs && msgs.length > 0) {
                    for (const msg of msgs) {
                        // STRICT NUMBER CASTING applied here to fix string comparison error!
                        if (Number(msg.id) > Number(lastLogId)) {
                            lastLogId = Number(msg.id); 
                            
                            if (msg.sender === 'admin') {
                                addAdminMessage(msg.message, msg.admin_name || 'Human Agent');
                            }
                        }
                    }
                    

                }

                // 2. Process Admin Takeover Status
                const isTakeoverActive = (status.is_active === true || Number(status.is_active) === 1);
                
                if (isTakeoverActive !== takeoverMode) {
                    takeoverMode = isTakeoverActive;
                    updateTakeoverUI();
                }

            } catch (e) {
                // Silently ignore network hiccups 
            }
        }, 1000);
    }

    function stopPolling() {
        if (pollInterval) { clearInterval(pollInterval); pollInterval = null; }
    }

    function updateTakeoverUI() {
        const indicator = document.getElementById('dk-takeover-indicator');
        if (!indicator) return;
        
        const inputEl = document.getElementById('user-input-chat');
        const sendBtn = document.getElementById('send-btn-chat');
        
        if (takeoverMode) {
            indicator.style.display = 'flex';
            indicator.innerHTML = '<span style="width:8px;height:8px;border-radius:50%;background:#22c984;display:inline-block;margin-right:6px;animation:tkPulse 1.5s infinite;"></span> A human agent has joined this chat';
            if (sendBtn) { sendBtn.style.display = 'flex'; sendBtn.disabled = false; }
            if (inputEl) { inputEl.placeholder = 'Message your agent…'; inputEl.disabled = false; }
        } else {
            indicator.style.display = 'none';
            if (sendBtn) { sendBtn.style.display = 'flex'; sendBtn.disabled = false; }
            if (inputEl) { inputEl.placeholder = 'Type your question…'; inputEl.disabled = false; }
        }
    }

    function addAdminMessage(text, adminName) {
        const chatBody = document.getElementById('chat-body');
        const div = document.createElement('div');
        div.style.cssText = 'display:flex;flex-direction:column;align-items:flex-start;';
        div.innerHTML = `
            <div style="font-size:10px;color:#22c984;font-weight:700;margin-bottom:3px;padding-left:2px;">🧑‍💼 ${escHtml(adminName) || 'Human Agent'}</div>
            <div class="dk-bubble-bot dk-fade-up" style="border-color:#22c984;border-width:1px;border-style:solid;">${escHtml(text.replace(/\\'/g, "'").replace(/\\"/g, '"'))}</div>
        `;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function escHtml(str) {
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    const chatEl   = document.getElementById('chat-container');
    const floatBtn = document.getElementById('chat-float-btn');
    const leadGate = document.getElementById('lead-gate');
    const chatBody = document.getElementById('chat-body');
    const inputArea= document.getElementById('chat-input-area');
    const inputEl  = document.getElementById('user-input-chat');
    const sendBtn  = document.getElementById('send-btn-chat');
    const chevron  = document.getElementById('chat-chevron');

    /* ── TOGGLE ── */
    window.dkToggleChat = window.toggleChat = function () {
        chatOpen = !chatOpen;
        chatEl.classList.toggle('open', chatOpen);
        if (floatBtn) floatBtn.style.display = chatOpen ? 'none' : 'flex';
        chevron.style.transform = chatOpen ? 'rotate(180deg)' : '';
        if (chatOpen && !leadGate.classList.contains('hidden')) {
            setTimeout(() => document.getElementById('gate-name')?.focus(), 320);
        }
        if (chatOpen && chatBody.children.length > 0) {
            setTimeout(() => chatBody.scrollTop = chatBody.scrollHeight, 50);
        }
    };

    /* ── LEAD GATE ── */
    window.dkSubmitGate = async function () {
        const name  = document.getElementById('gate-name').value.trim();
        const email = document.getElementById('gate-email').value.trim();
        const phone = document.getElementById('gate-phone').value.trim();
        userData = { name, email, phone };
        if (name || email) {
            const fd = new FormData();
            fd.append('action', 'dkhq_capture_lead'); fd.append('session_id', sessionId);
            fd.append('sector', SECTOR); fd.append('name', name);
            fd.append('email', email); fd.append('phone', phone);
            fetch(ADMIN_API, { method: 'POST', body: fd })
                .then(r => r.json())
                .then(d => { if (!d.ok) console.warn('[DK Chat] capture_lead failed:', d); })
                .catch(e => console.error('[DK Chat] capture_lead error:', e));
            leadCaptured = true;
        }
        showChat(name);
    };
    window.dkSkipGate = function () { showChat(''); };

    function showChat(name) {
        leadGate.classList.add('hidden');
        chatBody.classList.remove('hidden');
        inputArea.classList.remove('hidden');
        chatEl.classList.add('chat-active');
        chatStarted = true;
        
        const greeting = name
            ? `Hello ${escHtml(name)}! 👋 I'm your Academic Coach. What can I help you with today?`
            : `Hello! 👋 I'm your Academic Coach. How can I help you today?`;
        
        addBotMessage(greeting);
        conversationHistory.push({ role: 'model', parts: [{ text: greeting }] });
        
        logMessage('bot', greeting);
        
        setTimeout(() => inputEl.focus(), 100);
        startPolling();
    }

    function logMessage(sender, text) {
        const fd = new FormData();
        fd.append('action', 'dkhq_log_message'); fd.append('session_id', sessionId);
        fd.append('sector', SECTOR); fd.append('sender', sender);
        fd.append('message', text);
        fetch(ADMIN_API, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                if (!d.ok) { console.warn('[DK Chat] log_message failed:', d); return; }
                // STRICT NUMBER CASTING HERE TOO!
                if (d.log_id && Number(d.log_id) > Number(lastLogId)) lastLogId = Number(d.log_id);
            })
            .catch(e => console.error('[DK Chat] log_message error:', e));
    }

    function addBotMessage(text) {
        const div = document.createElement('div');
        div.className = 'dk-bubble-bot dk-fade-up';
        div.textContent = text.replace(/\\'/g, "'").replace(/\\"/g, '"');
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
        return div;
    }
    function addUserMessage(text) {
        const div = document.createElement('div');
        div.className = 'dk-bubble-user dk-fade-up';
        div.textContent = text.replace(/\\'/g, "'").replace(/\\"/g, '"');
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }
    function createBotBubble() {
        const div = document.createElement('div');
        div.className = 'dk-bubble-bot dk-fade-up';
        div.innerHTML = '<div class="dk-dots"><span></span><span></span><span></span></div>';
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
        return div;
    }

    /* ── INTELLIGENT BACKGROUND SUMMARIZER ── */
    async function generateIntelligentSummary() {
        try {
            const userMessagesOnly = conversationHistory.filter(msg => msg.role === 'user');
            if (userMessagesOnly.length < 2) return;

            const chatContext = conversationHistory.map(msg => {
                const sender = msg.role === 'user' ? 'Guest' : 'Coach';
                return `${sender}: ${msg.parts[0].text}`;
            }).join('\n');

            const summaryPrompt = `
                You are a CRM assistant analyzing a live chat between a Guest and an Academic Coach.
                Your task is to summarize the Guest's main inquiry, problem, or goal in exactly ONE short, professional sentence (under 15 words).
                
                CRITICAL RULES:
                1. Do not use greetings or quotes.
                2. If the Guest has ONLY exchanged pleasantries (e.g., "Hello", "How are you", "I am fine") and has NOT stated a specific need or question yet, you MUST reply with EXACTLY this phrase and nothing else: "Guest is exchanging greetings but has not stated a specific inquiry yet."
                
                Conversation so far:
                ${chatContext}
            `;

            const resp = await fetch(
                `https://generativelanguage.googleapis.com/v1beta/models/${AI_MODEL}:generateContent?key=${GEMINI_KEY}`,
                {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        contents: [{ role: 'user', parts: [{ text: summaryPrompt }] }],
                        generationConfig: { maxOutputTokens: 50, temperature: 0.1 } 
                    })
                }
            );

            const data = await resp.json();
            let summary = data?.candidates?.[0]?.content?.parts?.[0]?.text || '';

            if (summary) {
                summary = summary.replace(/\*/g, '').trim();
                
                const fd = new FormData();
                fd.append('action', 'dkhq_update_lead_summary'); 
                fd.append('session_id', sessionId);
                fd.append('summary', summary);
                
                fetch(ADMIN_API, { method: 'POST', body: fd })
                    .then(r => r.json())
                    .then(d => console.log('[DK Chat] Dashboard Summary Updated:', d));
            }
        } catch (e) {
            console.warn('[DK Chat] Background summary skipped:', e);
        }
    }

    async function sendMessage() {
        if (isResponding) return;
        const text = inputEl.value.trim();
        if (!text) return;
        inputEl.value = ''; inputEl.style.height = 'auto';
        addUserMessage(text);
        logMessage('user', text);

        // If admin has taken over, stop here. The admin will reply manually.
        if (takeoverMode) return;

        if (!leadCaptured) {
            const emailMatch = text.match(/[\w.-]+@[\w.-]+\.\w{2,}/);
            if (emailMatch) {
                const fd = new FormData();
                fd.append('action', 'dkhq_capture_lead'); fd.append('session_id', sessionId);
                fd.append('sector', SECTOR); fd.append('email', emailMatch[0]);
                fd.append('first_query', text);
                fetch(ADMIN_API, { method: 'POST', body: fd })
                    .then(r => r.json())
                    .then(d => { if (!d.ok) console.warn('[DK Chat] auto capture_lead failed:', d); })
                    .catch(e => console.error('[DK Chat] auto capture_lead error:', e));
                leadCaptured = true;
            }
        }
        conversationHistory.push({ role: 'user', parts: [{ text }] });

        // ── INACTIVITY TIMER LOGIC (DEBOUNCING) ──
        if (aiSummaryTimer) {
            clearTimeout(aiSummaryTimer);
        }
        aiSummaryTimer = setTimeout(() => {
            generateIntelligentSummary();
        }, 60000); 

        isResponding = true; sendBtn.disabled = true;
        const bubble = createBotBubble();

        if (!GEMINI_KEY) {
            bubble.textContent = '⚠️ Chat is not configured yet. Please contact us directly.';
            bubble.style.color = '#fca5a5';
            isResponding = false; sendBtn.disabled = false;
            return;
        }

        try {
            const resp = await fetch(
                `https://generativelanguage.googleapis.com/v1beta/models/${AI_MODEL}:streamGenerateContent?alt=sse&key=${GEMINI_KEY}`,
                {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        system_instruction: { parts: [{ text: SYSTEM_P }] },
                        contents: conversationHistory,
                        generationConfig: { maxOutputTokens: MAX_TOKENS, temperature: TEMPERATURE }
                    })
                }
            );

            if (!resp.ok) {
                const errData = await resp.json().catch(() => ({}));
                throw new Error(errData.error?.message || 'Connection issue. Please try again.');
            }

            const reader  = resp.body.getReader();
            const decoder = new TextDecoder();
            let fullText  = '';
            let buffer    = '';
            bubble.innerHTML = '';

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;
                buffer += decoder.decode(value, { stream: true });
                const lines = buffer.split('\n');
                buffer = lines.pop();
                for (const line of lines) {
                    if (!line.startsWith('data: ')) continue;
                    const jsonStr = line.slice(6).trim();
                    if (!jsonStr || jsonStr === '[DONE]') continue;
                    try {
                        const parsed = JSON.parse(jsonStr);
                        const token  = parsed?.candidates?.[0]?.content?.parts?.[0]?.text || '';
                        if (token) {
                            fullText += token
                                .replace(/\*\*(.*?)\*\*/g, '$1')
                                .replace(/\*(.*?)\*/g, '$1')
                                .replace(/##\s?/g, '')
                                .replace(/###\s?/g, '');
                            bubble.textContent = fullText;
                            chatBody.scrollTop = chatBody.scrollHeight;
                        }
                    } catch (_) {}
                }
            }

            if (buffer.startsWith('data: ')) {
                try {
                    const parsed = JSON.parse(buffer.slice(6).trim());
                    const token  = parsed?.candidates?.[0]?.content?.parts?.[0]?.text || '';
                    if (token) {
                        fullText += token.replace(/\*\*(.*?)\*\*/g, '$1').replace(/##\s?/g,'');
                        bubble.textContent = fullText;
                    }
                } catch(_) {}
            }

            if (fullText) {
                conversationHistory.push({ role: 'model', parts: [{ text: fullText }] });
                logMessage('bot', fullText);
            } else if (!bubble.textContent) {
                bubble.textContent = "Sorry, I didn't get a response. Please try asking again.";
            }

        } catch (err) {
            bubble.textContent = '⚠️ ' + (err.message || 'Something went wrong. Please try again.');
            bubble.style.color = '#fca5a5';
        } finally {
            isResponding = false; sendBtn.disabled = false;
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    }

    inputEl.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 100) + 'px';
    });

    const isTouch = window.matchMedia('(pointer: coarse)').matches;
    inputEl.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            if (isTouch) return;
            if (!e.shiftKey) { e.preventDefault(); sendMessage(); }
        }
    });
    sendBtn.addEventListener('click', sendMessage);

    // Always show float button
    floatBtn.style.display = 'flex';
})();
</script>
</body>
</html>