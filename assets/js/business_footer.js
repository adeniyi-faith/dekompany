(function() {
    const ADMIN_API   = window.DKHQ_CONFIG.ADMIN_API;
    const GEMINI_KEY  = window.DKHQ_CONFIG.GEMINI_KEY;
    const AI_MODEL    = window.DKHQ_CONFIG.AI_MODEL;
    const SYSTEM_P    = window.DKHQ_CONFIG.SYSTEM_P;
    const MAX_TOKENS  = window.DKHQ_CONFIG.MAX_TOKENS;
    const TEMPERATURE = window.DKHQ_CONFIG.TEMPERATURE;
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