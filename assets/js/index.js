/**
     * De Kompany — Homepage Concierge (Fixed)
     *
     * FIXES APPLIED:
     *  1. Messages no longer cut mid-thought (streaming SSE implemented)
     *  2. Conversation history maintained across turns (multi-turn context)
     *  3. Admin API logging connected to /wp/admin/api.php
     *  4. Lead capture from concierge chat
     *  5. Input state properly managed (no double-send)
     *  6. Routing tags stripped before display
     *
     * API KEY LOCATION: Store in WP options as 'dkhq_gemini_key'
     * For static HTML deployment, replace the placeholder below.
     */

    // If this file is served as PHP, replace with: get_option('dkhq_gemini_key')
    const apiKey    = "AIzaSyAMJTeqc2xvNbGzg3FAuaQx44-iGtLpwAM";
    const MODEL     = "gemini-2.5-flash";
    const ADMIN_API = "/wp/admin/api.php"; // where logs + leads are captured

    let conversationHistory = [];
    let isProcessing  = false;
    let turnCount     = 0;
    let sessionId     = 'conc_' + Date.now() + '_' + Math.random().toString(36).substr(2,8);
    let leadCaptured  = false;

    const ROUTING_TURN_THRESHOLD = 5;

    const chatHistory    = document.getElementById('chat-history');
    const chatForm       = document.getElementById('chat-form');
    const chatInputWrap  = document.querySelector('.chat-input-wrapper');
    const inputField     = document.getElementById('user-input');
    const sendBtn        = document.getElementById('send-btn');
    const toggleBrowse   = document.getElementById('toggle-browse');
    const browseSection  = document.getElementById('browse-section');
    const toggleIcon     = document.getElementById('toggle-icon');
    const headerStatus   = document.getElementById('header-status');
    const statusDot      = document.getElementById('status-dot');
    const sectorCards    = document.querySelectorAll('.sector-card');
    const isCoarsePointer= window.matchMedia('(pointer: coarse)').matches;
    let resizeTimer      = null;

    const ROUTE_TAGS = {
        '[ROUTE_ACADEMIC]':   { name: 'Academic Sector',   url: '/student' },
        '[ROUTE_BUSINESS]':   { name: 'Business Sector',   url: '/business' },
        '[ROUTE_INNOVATION]': { name: 'Innovation Sector', url: '/innovation' }
    };

    const SYSTEM_PROMPT = `You are Komi, the warm, friendly front-desk concierge at De Kompany. Your job is to have a genuine conversation with each visitor, understand what they need, and eventually guide them to the right department.

DE KOMPANY has three departments:
1. ACADEMIC SECTOR for students, learners, and researchers.
2. BUSINESS SECTOR for entrepreneurs and companies.
3. INNOVATION SECTOR for inventors and tech builders.

YOUR PERSONALITY:
- Warm, friendly, and highly professional.
- Ask one good follow-up question per response when more clarity is still needed.
- Keep responses concise, 2 to 4 sentences max per turn.
- Do not use markdown formatting like asterisks. Keep answers plain text.
- Respond in English only.
- When the user's request is already clear enough, confidently recommend the best department instead of dragging the conversation.
- If you are explicitly told the conversation limit has been reached, acknowledge the need, say you are redirecting them now, and append exactly one route tag at the very end: [ROUTE_ACADEMIC], [ROUTE_BUSINESS], or [ROUTE_INNOVATION].`;

    /* ── UTILITIES ── */
    function escapeHtml(str) {
        return String(str)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
    }
    function formatMessage(text) {
        return escapeHtml(text).replace(/\n/g,'<br>');
    }
    function scrollToBottom(immediate = false) {
        if (immediate) { chatHistory.scrollTop = chatHistory.scrollHeight; }
        else { chatHistory.scrollTo({ top: chatHistory.scrollHeight, behavior: 'smooth' }); }
    }
    function setStatus(text, color='green') {
        headerStatus.innerText = text;
        statusDot.classList.remove('bg-green-500','bg-yellow-500','bg-red-500');
        if (color === 'yellow') statusDot.classList.add('bg-yellow-500');
        else if (color === 'red') statusDot.classList.add('bg-red-500');
        else statusDot.classList.add('bg-green-500');
    }
    function setProcessingState(active) {
        isProcessing = active;
        sendBtn.disabled = active;
        chatInputWrap.classList.toggle('disabled', active);
        if (!active && !isCoarsePointer) inputField.focus({ preventScroll: true });
    }

    /* ── LOG to admin ── */
    function logMessage(sender, text) {
        const fd = new FormData();
        fd.append('action', 'log_message');
        fd.append('session_id', sessionId);
        fd.append('sector', 'concierge');
        fd.append('sender', sender);
        fd.append('message', text);
        fetch(ADMIN_API, { method:'POST', body: fd }).catch(()=>{});
    }

    function tryCaptureLead(text) {
        if (leadCaptured) return;
        const emailMatch = text.match(/[\w.-]+@[\w.-]+\.\w{2,}/);
        if (emailMatch) {
            const fd = new FormData();
            fd.append('action', 'capture_lead');
            fd.append('session_id', sessionId);
            fd.append('sector', 'concierge');
            fd.append('email', emailMatch[0]);
            fd.append('first_query', text);
            fetch(ADMIN_API, { method:'POST', body: fd }).catch(()=>{});
            leadCaptured = true;
        }
    }

    /* ── MESSAGES ── */
    function addUserMessage(text) {
        const div = document.createElement('div');
        div.className = 'msg-wrapper-user';
        div.innerHTML = `<div class="msg-user">${formatMessage(text)}</div>`;
        chatHistory.appendChild(div);
        scrollToBottom(false);
    }

    function createStreamingBubble() {
        const div = document.createElement('div');
        div.className = 'msg-wrapper-ai is-thinking';
        div.innerHTML = `
            <div class="ai-avatar ai-avatar-logo">
                <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg"
                     alt="De Kompany" class="w-full h-full object-cover">
            </div>
            <div class="msg-ai streaming-target">
                <span class="typing-dots" aria-label="Thinking"><span></span><span></span><span></span></span>
            </div>`;
        chatHistory.appendChild(div);
        scrollToBottom(false);
        return div.querySelector('.streaming-target');
    }

    function detectRouteTag(text) {
        for (const [tag, config] of Object.entries(ROUTE_TAGS)) {
            if (text.includes(tag)) return { tag, config };
        }
        return null;
    }
    function stripRouteTags(text) {
        return text.replace(/\[ROUTE_(ACADEMIC|BUSINESS|INNOVATION)\]/g,'').trim();
    }

    function executeSoftHandoff(sectorName, urlPath) {
        setProcessingState(true);
        setStatus('Transferring...', 'yellow');
        const toast = document.createElement('div');
        toast.className = 'routing-toast';
        toast.innerHTML = `<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Connecting to ${escapeHtml(sectorName)} Team...`;
        chatHistory.appendChild(toast);
        scrollToBottom(false);
        setTimeout(() => {
            toast.innerHTML = `<i class="fa-solid fa-check text-green-500 mr-2"></i> Redirecting now!`;
            window.location.href = urlPath;
        }, 1400);
    }

    /* ── SECTOR CARDS ── */
    function handleManualDepartmentClick(event) {
        event.preventDefault();
        if (isProcessing) return;
        const link = event.currentTarget;
        const sectorName = link.dataset.sector || 'Selected Department';
        const href = link.getAttribute('href') || '/';
        executeSoftHandoff(sectorName, href);
    }

    /* ── BROWSE TOGGLE ── */
    let browseOpen = false;
    toggleBrowse.addEventListener('click', (event) => {
        event.preventDefault();
        browseOpen = !browseOpen;
        browseSection.classList.toggle('collapsed', !browseOpen);
        toggleBrowse.setAttribute('aria-expanded', String(browseOpen));
        toggleIcon.style.transform = browseOpen ? 'rotate(0deg)' : 'rotate(-90deg)';
        scrollToBottom(false);
    });
    sectorCards.forEach(card => card.addEventListener('click', handleManualDepartmentClick));

    /* ── INPUT RESIZE ── */
    inputField.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        this.style.overflowY = this.scrollHeight > 140 ? 'auto' : 'hidden';
    });
    inputField.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            if (isCoarsePointer) return; // mobile: allow newline
            if (!event.shiftKey) {
                event.preventDefault();
                if (!isProcessing && inputField.value.trim()) chatForm.requestSubmit();
            }
        }
    });
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => scrollToBottom(true), 120);
    });

    /* ── MAIN SUBMIT — STREAMING FIXED ── */
    chatForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (isProcessing) return;

        const text = inputField.value.trim();
        if (!text) return;

        inputField.value = '';
        inputField.style.height = 'auto';

        addUserMessage(text);
        logMessage('user', text);
        tryCaptureLead(text);

        turnCount += 1;
        setProcessingState(true);
        setStatus('Typing...', 'yellow');

        let apiPayloadText = text;
        if (turnCount >= ROUTING_TURN_THRESHOLD) {
            apiPayloadText += '\n\n[SYSTEM INSTRUCTION: The conversation limit has been reached. Please acknowledge the visitor\'s need, state clearly that you are redirecting them to the best department right now, and append exactly one route tag at the end: [ROUTE_ACADEMIC], [ROUTE_BUSINESS], or [ROUTE_INNOVATION]. Do not ask any more questions.]';
        }

        conversationHistory.push({ role: 'user', parts: [{ text: apiPayloadText }] });

        const streamingBubble = createStreamingBubble();
        let fullText   = '';
        let buffer     = '';
        let targetRoute = null;

        try {
            // ── FIX: Use streaming SSE so messages never cut mid-thought ──
            const resp = await fetch(
                `https://generativelanguage.googleapis.com/v1beta/models/${MODEL}:streamGenerateContent?alt=sse&key=${apiKey}`,
                {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        system_instruction: { parts: [{ text: SYSTEM_PROMPT }] },
                        contents: conversationHistory,
                        generationConfig: { temperature: 0.7, maxOutputTokens: 350 }
                    })
                }
            );

            if (!resp.ok) {
                const errData = await resp.json().catch(() => ({}));
                throw new Error(errData.error?.message || 'Unable to reach the AI service.');
            }

            // Clear typing dots once stream starts
            streamingBubble.closest('.msg-wrapper-ai')?.classList.remove('is-thinking');
            streamingBubble.innerHTML = '';

            const reader  = resp.body.getReader();
            const decoder = new TextDecoder();

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;
                buffer += decoder.decode(value, { stream: true });
                const lines = buffer.split('\n');
                buffer = lines.pop(); // keep incomplete line in buffer

                for (const line of lines) {
                    if (!line.startsWith('data: ')) continue;
                    const jsonStr = line.slice(6).trim();
                    if (!jsonStr || jsonStr === '[DONE]') continue;
                    try {
                        const parsed = JSON.parse(jsonStr);
                        const token  = parsed?.candidates?.[0]?.content?.parts?.[0]?.text || '';
                        if (token) {
                            fullText += token;
                            // Show cleaned text while streaming
                            const displayText = stripRouteTags(
                                fullText.replace(/\*\*(.*?)\*\*/g,'$1').replace(/##\s?/g,'')
                            );
                            streamingBubble.innerHTML = formatMessage(displayText);
                            scrollToBottom(true);
                        }
                    } catch(_) { /* bad chunk, skip */ }
                }
            }

            // Process remaining buffer
            if (buffer.startsWith('data: ')) {
                try {
                    const parsed = JSON.parse(buffer.slice(6).trim());
                    const token  = parsed?.candidates?.[0]?.content?.parts?.[0]?.text || '';
                    if (token) fullText += token;
                } catch(_) {}
            }

            // Final render
            const detected = detectRouteTag(fullText);
            if (detected) targetRoute = detected.config;

            const cleanAiResponse = stripRouteTags(
                fullText.replace(/\*\*(.*?)\*\*/g,'$1').replace(/##\s?/g,'')
            );
            streamingBubble.innerHTML = formatMessage(cleanAiResponse);
            scrollToBottom(true);

            conversationHistory.push({ role: 'model', parts: [{ text: cleanAiResponse }] });
            logMessage('bot', cleanAiResponse);

            if (targetRoute) {
                executeSoftHandoff(targetRoute.name, targetRoute.url);
                return;
            }
            setStatus('Online', 'green');

        } catch (error) {
            console.error('Concierge error:', error);
            streamingBubble.closest('.msg-wrapper-ai')?.classList.remove('is-thinking');
            streamingBubble.innerHTML = "I'm having a little trouble connecting right now. You can still browse the departments below manually.";
            setStatus('Offline', 'red');
        } finally {
            if (!targetRoute) setProcessingState(false);
        }
    });

    scrollToBottom(true);
