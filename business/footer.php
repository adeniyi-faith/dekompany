<?php
/**
 * De Kompany — Business Footer (with Lead Capture + Chat Logging + Section Toggles)
 */

// ── Bulletproof WordPress Core Loader ─────────────────────────────────────────
if (!defined('ABSPATH')) {
    $wp_load_paths = [
        dirname(__DIR__) . '/wp/wp-load.php',   // If in standard theme inside /wp/ setup
        dirname(__DIR__) . '/wp-load.php',      // Standard root setup
        $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php',
        $_SERVER['DOCUMENT_ROOT'] . '/wp/wp-load.php'
    ];
    $loaded = false;
    foreach ($wp_load_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            $loaded = true;
            break;
        }
    }
    if (!$loaded) {
        // Fail gracefully instead of causing a fatal error if WP can't be found
        error_log('[DKHQ Error] Could not locate wp-load.php in business-footer.php');
    }
}
global $wpdb;

// ── Fetch active business prompt from DB ──────────────────────────────────────
$prompt_row = $wpdb ? $wpdb->get_row(
    "SELECT * FROM {$wpdb->prefix}dkhq_prompts WHERE sector = 'business' AND is_active = 1 ORDER BY id DESC LIMIT 1"
) : null;

$system_prompt = $prompt_row
    ? addslashes($prompt_row->system_prompt)
    : "You are a Senior Strategy Consultant for 'De Kompany'. Tone: Professional, sophisticated, data-driven. Keep answers plain text. Conclude with a strategic question.";

$ai_model   = $prompt_row ? esc_js($prompt_row->ai_model) : 'gemini-2.5-flash-lite';
$max_tokens = $prompt_row ? intval($prompt_row->max_tokens) : 300;
$temperature= $prompt_row ? floatval($prompt_row->temperature) : 0.7;

// Securely fetch Gemini key from WP options
$gemini_key = function_exists('get_option') ? get_option('dkhq_gemini_key', '') : '';

// Use native WP admin-ajax for rock-solid routing
$admin_api = function_exists('admin_url') ? admin_url('admin-ajax.php') : '/wp/wp-admin/admin-ajax.php';
?>

<footer id="business-contact" class="bg-white border-t border-gray-100 pt-20 pb-12 relative z-10">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 border-b border-gray-100 pb-16">
            <div class="md:col-span-4 space-y-6">
                <div class="flex items-center gap-3">
                    <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg" class="w-12 h-12 rounded-full shadow-md border-2 border-white" alt="De Kompany">
                    <span class="text-xl font-bold tracking-tight text-blue-900 font-serif">De Kompany</span>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed max-w-sm">
                    Strategic Intelligence for the Modern Enterprise. We structure ideas into measurable assets.
                </p>
                <div class="flex gap-4 pt-2 text-xs font-bold uppercase tracking-wider text-gray-400">
                    <a href="#" class="hover:text-blue-900 transition-colors">LinkedIn</a>
                    <span class="text-gray-200">|</span>
                    <a href="#" class="hover:text-blue-900 transition-colors">Twitter</a>
                    <span class="text-gray-200">|</span>
                    <a href="#" class="hover:text-blue-900 transition-colors">Instagram</a>
                </div>
            </div>

            <div class="md:col-span-2 md:col-start-6">
                <h4 class="font-bold text-gray-900 mb-6 text-sm uppercase tracking-wider">Company</h4>
                <ul class="space-y-4 text-sm text-gray-500">
                    <li><a href="#about-us" class="hover:text-blue-900 hover:pl-2 transition-all">About Us</a></li>
                    <li><a href="#business-expertise" class="hover:text-blue-900 hover:pl-2 transition-all">Services</a></li>
                    <li><a href="#portfolio" class="hover:text-blue-900 hover:pl-2 transition-all">Portfolio</a></li>
                    <li><a href="#business-insights" class="hover:text-blue-900 hover:pl-2 transition-all">Insights</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h4 class="font-bold text-gray-900 mb-6 text-sm uppercase tracking-wider">Contact</h4>
                <ul class="space-y-4 text-sm text-gray-500">
                    <li class="flex items-start gap-3"><i class="fa-solid fa-envelope mt-1 text-blue-900/50"></i><span>consult@dekompany.com</span></li>
                    <li class="flex items-start gap-3"><i class="fa-solid fa-phone mt-1 text-blue-900/50"></i><span>+234 912 704 0327</span></li>
                    <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot mt-1 text-blue-900/50"></i><span>Lagos, Nigeria</span></li>
                </ul>
            </div>

            <div class="md:col-span-4">
                <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                    <h4 class="font-bold text-blue-900 mb-2">Join The Inner Circle</h4>
                    <p class="text-xs text-gray-500 mb-4">Strategic insights, no noise.</p>
                    <div class="relative">
                        <input type="email" id="newsletter-email" placeholder="Enter your email address" class="w-full pl-4 pr-12 py-3 bg-white border-0 rounded-xl text-sm text-gray-700 shadow-sm ring-1 ring-gray-100 focus:ring-2 focus:ring-blue-900 focus:outline-none placeholder:text-gray-400">
                        <button onclick="subscribeNewsletter()" aria-label="Subscribe to newsletter" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-blue-900 text-white rounded-lg flex items-center justify-center hover:bg-blue-800 transition-colors focus-visible:ring-2 focus-visible:ring-blue-900 outline-none">
                            <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-400">
            <div class="text-center md:text-left">
                <p>&copy; <?php echo date('Y'); ?> De Kompany. All rights reserved.</p>
                <p class="mt-1">Designed and Developed by <a href="https://getonlinestudio.com/" rel="nofollow" target="_blank" class="text-blue-600 hover:text-blue-900 font-medium">GetOnline Studio</a>.</p>
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-blue-900">Privacy Policy</a>
                <a href="#" class="hover:text-blue-900">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
</main>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<!-- ══════════════════════════════════════════════ -->
<!-- BUSINESS CHAT WIDGET v2 — with Lead Capture  -->
<!-- ══════════════════════════════════════════════ -->

<!-- ADDED: The Missing Floating Button to Trigger the Chat -->
<button onclick="toggleChat()" id="chat-float-btn" class="fixed bottom-6 right-6 z-[49] w-14 h-14 bg-blue-900 text-white rounded-full flex items-center justify-center shadow-xl hover:bg-blue-800 transition-transform transform hover:scale-105 focus-visible:ring-2 focus-visible:ring-blue-900 outline-none" aria-label="Open strategy consultation">
    <i class="fa-solid fa-briefcase text-xl" aria-hidden="true"></i>
</button>

<div id="chat-container" class="fixed bottom-0 right-0 sm:m-4 w-full sm:max-w-sm transform translate-y-[110%] transition-transform duration-500 z-50 font-sans shadow-2xl rounded-t-lg overflow-hidden" style="max-height:90vh;">

    <div class="flex justify-between items-center p-4 bg-blue-900 text-white cursor-pointer" onclick="toggleChat()">
        <div class="flex items-center gap-2">
            <div class="relative">
                <i class="fa-solid fa-briefcase"></i>
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-white rounded-full animate-ping"></span>
            </div>
            <div>
                <h4 class="font-bold text-sm">Strategic Consultant</h4>
                <span class="text-xs opacity-80">De Kompany AI</span>
            </div>
        </div>
        <button aria-label="Close chat" class="text-sm opacity-70 hover:opacity-100 p-2 focus-visible:ring-2 focus-visible:ring-white outline-none rounded"><i class="fa-solid fa-times text-lg" aria-hidden="true"></i></button>
    </div>

    <!-- Lead Gate -->
    <div id="biz-lead-gate" class="bg-white p-6" style="display:block;">
        <div class="text-center mb-5">
            <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-briefcase text-white"></i>
            </div>
            <h3 class="font-bold text-blue-900 text-base">Speak with a Strategy Consultant</h3>
            <p class="text-gray-500 text-xs mt-1">Introduce yourself to get started</p>
        </div>
        <div class="space-y-3">
            <input id="biz-gate-name" type="text" placeholder="Your name" class="w-full p-3 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
            <input id="biz-gate-email" type="email" placeholder="Business email" class="w-full p-3 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
            <input id="biz-gate-company" type="text" placeholder="Company (optional)" class="w-full p-3 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-900">
            <button onclick="bizSubmitGate()" class="w-full py-3 bg-blue-900 hover:bg-blue-800 text-white font-bold rounded-lg text-sm transition">
                Begin Consultation <i class="fa-solid fa-arrow-right ml-1"></i>
            </button>
            <button onclick="bizSkipGate()" class="w-full py-2 text-gray-400 hover:text-gray-600 text-xs transition">Skip</button>
        </div>
    </div>

    <!-- Chat Body -->
    <div id="chat-body" class="h-64 overflow-y-auto p-4 bg-white text-gray-700 text-sm space-y-4" style="display:none;">
        <div class="flex justify-start">
            <div class="bg-gray-100 text-gray-800 px-4 py-2 rounded-2xl rounded-tl-sm shadow-sm max-w-[80%]" id="biz-welcome-bubble">
                Welcome. I am your strategic assistant. How can we optimize your business today?
            </div>
        </div>
    </div>

    <!-- Input -->
    <div id="biz-chat-footer" class="p-3 border-t border-gray-200 bg-gray-50" style="display:none;">
        <form onsubmit="handleChatSubmit(event)" class="flex gap-2">
            <input type="text" id="chat-user-input" placeholder="Type your query…" class="flex-1 p-2 rounded border border-gray-200 text-black focus:outline-none text-sm" autocomplete="off">
            <button type="submit" id="chat-send-btn" aria-label="Send message" class="px-4 py-2 rounded bg-blue-900 hover:bg-blue-800 text-white transition focus-visible:ring-2 focus-visible:ring-blue-900 outline-none"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i></button>
        </form>
    </div>
</div>

<script>
(function() {
    const ADMIN_API   = '<?php echo esc_js($admin_api); ?>';
    const GEMINI_KEY  = '<?php echo esc_js($gemini_key); ?>';
    const AI_MODEL    = '<?php echo $ai_model; ?>';
    const SYSTEM_P    = `<?php echo $system_prompt; ?>`;
    const MAX_TOKENS  = <?php echo $max_tokens; ?>;
    const TEMPERATURE = <?php echo $temperature; ?>;
    const SECTOR      = 'business';

    let sessionId    = 'sess_' + Date.now() + '_' + Math.random().toString(36).substr(2,8);
    let isResponding = false;
    let leadCaptured = false;
    let userData     = {};

    let conversationHistory = [];
    let aiSummaryTimer = null;

    window.toggleMobileMenu = function() {
        const m = document.getElementById('mobile-menu');
        if (m) m.classList.toggle('hidden');
    };

    window.toggleChat = function() {
        const chat = document.getElementById('chat-container');
        const floatBtn = document.getElementById('chat-float-btn');
        const isHidden = chat.classList.contains('translate-y-[110%]');

        if (isHidden) {
            chat.classList.remove('translate-y-[110%]');
            chat.classList.add('translate-y-0');
            if (floatBtn) floatBtn.style.display = 'none'; // Hide button when chat is open
        } else {
            chat.classList.remove('translate-y-0');
            chat.classList.add('translate-y-[110%]');
            if (floatBtn) floatBtn.style.display = 'flex'; // Show button when chat is closed
        }
    };

    window.bizSubmitGate = async function() {
        const name    = document.getElementById('biz-gate-name').value.trim();
        const email   = document.getElementById('biz-gate-email').value.trim();
        const company = document.getElementById('biz-gate-company')?.value.trim() || '';
        userData = { name, email, company };

        if (name || email) {
            const fd = new FormData();
            fd.append('action', 'dkhq_capture_lead');
            fd.append('session_id', sessionId);
            fd.append('sector', SECTOR);
            fd.append('name', name + (company ? ` (${company})` : ''));
            fd.append('email', email);
            fetch(ADMIN_API, { method: 'POST', body: fd }).catch(() => {});
            leadCaptured = true;
        }
        showBizChat(name);
    };

    window.bizSkipGate = function() { showBizChat(''); };

    function showBizChat(name) {
        document.getElementById('biz-lead-gate').style.display  = 'none';
        document.getElementById('chat-body').style.display      = 'block';
        document.getElementById('biz-chat-footer').style.display = 'block';

        const greeting = name
            ? `Welcome, ${name}. I'm your strategic consultant. How can De Kompany support your business goals today?`
            : `Welcome. I am your strategic assistant. How can we optimize your business today?`;

        document.getElementById('biz-welcome-bubble').textContent = greeting;

        conversationHistory.push({ role: 'model', parts: [{ text: greeting }] });
        setTimeout(() => document.getElementById('chat-user-input')?.focus(), 100);
    }

    function logMessage(sender, text) {
        const fd = new FormData();
        fd.append('action', 'dkhq_log_message');
        fd.append('session_id', sessionId);
        fd.append('sector', SECTOR);
        fd.append('sender', sender);
        fd.append('message', text);
        fetch(ADMIN_API, { method: 'POST', body: fd }).catch(() => {});
    }

    function addMessage(sender, text) {
        const body = document.getElementById('chat-body');
        const div  = document.createElement('div');
        div.className = sender === 'user' ? 'flex justify-end animate-[fadeIn_0.3s_ease-out]' : 'flex justify-start animate-[fadeIn_0.3s_ease-out]';
        const bubble = document.createElement('div');
        bubble.className = sender === 'user'
            ? 'bg-blue-900 text-white px-4 py-2 rounded-2xl rounded-tr-sm shadow-sm max-w-[80%]'
            : 'bg-gray-100 text-gray-800 px-4 py-2 rounded-2xl rounded-tl-sm shadow-sm max-w-[80%]';
        bubble.innerText = text;
        div.appendChild(bubble);
        body.appendChild(div);
        body.scrollTop = body.scrollHeight;
    }

    function createBotBubble() {
        const body = document.getElementById('chat-body');
        const div  = document.createElement('div');
        div.className = 'flex justify-start animate-[fadeIn_0.3s_ease-out]';
        const bubble = document.createElement('div');
        bubble.className = 'bg-gray-100 text-gray-800 px-4 py-2 rounded-2xl rounded-tl-sm shadow-sm max-w-[80%]';
        div.appendChild(bubble);
        body.appendChild(div);
        body.scrollTop = body.scrollHeight;
        return bubble;
    }

    async function generateIntelligentSummary() {
        try {
            const userMessagesOnly = conversationHistory.filter(msg => msg.role === 'user');
            if (userMessagesOnly.length < 2) {
                console.log('[DK B2B Chat] Summary skipped: Waiting for more substantial conversation.');
                return;
            }

            console.log('[DK B2B Chat] 12 seconds of silence detected. Analyzing context and calling Gemini for summary...');

            const chatContext = conversationHistory.map(msg => {
                const sender = msg.role === 'user' ? 'Client' : 'Consultant';
                return `${sender}: ${msg.parts[0].text}`;
            }).join('\n');

            const summaryPrompt = `
                You are a senior CRM analyst evaluating a business consultation chat between a Corporate Client and a Strategy Consultant.
                Summarize the Client's core business need, pain point, or strategic goal in EXACTLY ONE short, highly professional sentence (under 15 words).

                CRITICAL RULES:
                1. Use formal B2B language (e.g., "Client is exploring operational restructuring").
                2. Do NOT use greetings, quotes, or conversational filler.
                3. If the Client has ONLY exchanged pleasantries (e.g., "Hello", "Good morning") without stating a business need, you MUST reply with EXACTLY this phrase: "Client is exchanging greetings but has not stated a strategic inquiry yet."

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
                        // CHANGED: Increased maxOutputTokens from 50 to 200.
                        // This gives the Gemini 2.5 engine enough "Token Budget" to process its internal thoughts
                        // AND write the final CRM summary without starving.
                        generationConfig: { maxOutputTokens: 200, temperature: 0.1 }
                    })
                }
            );

            // --- ADDED: Strict Error Handling (Prevents Silent Crashes) ---
            if (!resp.ok) {
                const errText = await resp.text();
                throw new Error(`Gemini rejected summary request. Status: ${resp.status}, Error: ${errText}`);
            }

            const data = await resp.json();
            let summary = data?.candidates?.[0]?.content?.parts?.[0]?.text || '';

            if (!summary) {
                console.warn('[DK B2B Chat] Gemini returned an empty summary. Raw response:', data);
                return;
            }

            summary = summary.replace(/\*/g, '').trim();
            console.log('[DK B2B Chat] Gemini successfully generated summary:', summary);

            // --- ADDED: The "Ghost Lead" Fix (Creates a home for the summary) ---
            if (!leadCaptured) {
                console.log('[DK B2B Chat] Ghost Lead detected! Creating a blank row in the DB so the summary has a home...');
                const fdGate = new FormData();
                fdGate.append('action', 'dkhq_capture_lead');
                fdGate.append('session_id', sessionId);
                fdGate.append('sector', SECTOR);
                // We await this to ensure the row exists BEFORE we try to update it!
                await fetch(ADMIN_API, { method: 'POST', body: fdGate });
                leadCaptured = true;
            }
            // ------------------------------------------------------------------

            console.log('[DK B2B Chat] Sending summary to WordPress Admin...');

            const fd = new FormData();
            fd.append('action', 'dkhq_update_lead_summary');
            fd.append('session_id', sessionId);
            fd.append('summary', summary);

            fetch(ADMIN_API, { method: 'POST', body: fd })
                .then(r => r.json())
                .then(d => {
                    if (d.ok) {
                        console.log('[DK B2B Chat] SUCCESS: Summary permanently saved to Admin Dashboard!', d);
                    } else {
                        console.warn('[DK B2B Chat] BACKEND REJECTED IT:', d);
                    }
                })
                .catch(err => console.error('[DK B2B Chat] Fetch error to Admin API:', err));
        } catch (e) {
            console.error('[DK B2B Chat] Background summary crashed:', e);
        }
    }

    window.handleChatSubmit = async function(e) {
        e.preventDefault();
        if (isResponding) return;
        const input   = document.getElementById('chat-user-input');
        const sendBtn = document.getElementById('chat-send-btn');
        const text    = input.value.trim();
        if (!text) return;

        addMessage('user', text);
        logMessage('user', text);
        input.value = '';

        conversationHistory.push({ role: 'user', parts: [{ text }] });

        if (!leadCaptured) {
            const emailMatch = text.match(/[\w.-]+@[\w.-]+\.\w{2,}/);
            if (emailMatch) {
                const fd = new FormData();
                fd.append('action', 'dkhq_capture_lead');
                fd.append('session_id', sessionId);
                fd.append('sector', SECTOR);
                fd.append('email', emailMatch[0]);
                fd.append('first_query', text);
                fetch(ADMIN_API, { method: 'POST', body: fd })
                    .then(r => r.json())
                    .then(d => console.log('[DK B2B Chat] Auto-captured lead via email.', d))
                    .catch(()=>({}));
                leadCaptured = true;
            }
        }

        if (aiSummaryTimer) {
            clearTimeout(aiSummaryTimer);
            console.log('[DK B2B Chat] Client is still typing. Timer reset.');
        }

        // CHANGED: Timer drastically reduced to 12 seconds for lightning-fast CRM updates
        aiSummaryTimer = setTimeout(() => {
            generateIntelligentSummary();
        }, 12000);

        isResponding = true;
        if (sendBtn) { sendBtn.disabled = true; sendBtn.classList.add('opacity-50'); }

        const body = document.getElementById('chat-body');
        const loadDiv = document.createElement('div');
        loadDiv.id = 'loading-indicator';
        loadDiv.className = 'flex justify-start';
        loadDiv.innerHTML = '<div class="bg-gray-100 px-4 py-3 rounded-2xl rounded-tl-sm"><div class="flex gap-1"><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:.1s"></div><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:.2s"></div></div></div>';
        body.appendChild(loadDiv);
        body.scrollTop = body.scrollHeight;

        if (!GEMINI_KEY) {
            document.getElementById('loading-indicator')?.remove();
            addMessage('bot', '⚠️ Strategy engine is currently offline (API Key missing). Please contact consult@dekompany.com directly.');
            isResponding = false;
            if (sendBtn) { sendBtn.disabled = false; sendBtn.classList.remove('opacity-50'); }
            return;
        }

        try {
            // --- ADDED: The "Executive Word Count" Override ---
            // A 300 token limit is too small for a deep B2B strategy answer.
            // This forces a safe minimum of 1500 tokens (approx 1000 words) so it NEVER cuts off.
            const b2bMaxTokens = Math.max(MAX_TOKENS, 1500);

            // CHANGED: Removed "streamGenerateContent?alt=sse" and replaced with "generateContent"
            const resp = await fetch(
                `https://generativelanguage.googleapis.com/v1beta/models/${AI_MODEL}:generateContent?key=${GEMINI_KEY}`,
                {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        system_instruction: { parts: [{ text: SYSTEM_P }] },
                        contents: conversationHistory,
                        // CHANGED: We now use our new massive b2bMaxTokens limit
                        generationConfig: { maxOutputTokens: b2bMaxTokens, temperature: TEMPERATURE }
                    })
                }
            );

            if (!resp.ok) throw new Error((await resp.json().catch(()=>({}))).error?.message || resp.statusText);

            // CHANGED: We now wait for the entire response to arrive in one solid piece
            const data = await resp.json();

            // Remove the loading dots only after the full data has arrived
            document.getElementById('loading-indicator')?.remove();

            let fullText = data?.candidates?.[0]?.content?.parts?.[0]?.text || '';

            if (fullText) {
                // Clean up any bolding or heading markdown
                fullText = fullText.replace(/\*\*/g, '').replace(/##/g, '').replace(/\*/g, '');

                // Create the bubble and display the text ALL AT ONCE
                const bubble = createBotBubble();
                bubble.innerText = fullText;

                // Scroll to bottom
                body.scrollTop = body.scrollHeight;

                // Save to memory and log to the WordPress backend
                conversationHistory.push({ role: 'model', parts: [{ text: fullText }] });
                logMessage('bot', fullText);
            } else {
                throw new Error("Received an empty response from the AI.");
            }

        } catch (err) {
            document.getElementById('loading-indicator')?.remove();
            addMessage('bot', '⚠️ Connection error: ' + err.message);
        } finally {
            isResponding = false;
            if (sendBtn) { sendBtn.disabled = false; sendBtn.classList.remove('opacity-50'); }
        }
    };

    window.subscribeNewsletter = function() {
        const email = document.getElementById('newsletter-email')?.value.trim();
        if (!email || !email.includes('@')) { alert('Enter a valid email.'); return; }
        const fd = new FormData();
        fd.append('action', 'dkhq_capture_lead');
        fd.append('sector', 'business');
        fd.append('session_id', 'newsletter_' + Date.now());
        fd.append('email', email);
        fd.append('first_query', 'Newsletter subscription');
        fetch(ADMIN_API, { method: 'POST', body: fd })
            .then(() => {
                document.getElementById('newsletter-email').value = '';
                alert('Thank you! You have been added to the inner circle.');
            }).catch(() => {});
    };
})();
</script>
</body>
</html    <link rel="stylesheet" href="/assets/css/business_footer.css">
<?php require_once __DIR__ . '/../components/business/business_footer_component.php'; ?>

<script>
    window.DKHQ_CONFIG = {
        ADMIN_API: '<?php echo esc_js($admin_api); ?>',
        GEMINI_KEY: '<?php echo esc_js($gemini_key); ?>',
        AI_MODEL: '<?php echo esc_js($ai_model); ?>',
        SYSTEM_P: `<?php echo $system_prompt; ?>`,
        MAX_TOKENS: <?php echo intval($max_tokens); ?>,
        TEMPERATURE: <?php echo floatval($temperature); ?>,
        SECTOR: 'business'
    };
</script>
<script src="/assets/js/business_footer.js"></script>
</body>
</html>