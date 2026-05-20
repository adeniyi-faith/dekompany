const apiKey = "AIzaSyC1DPDJzt5psEkIDgqK3XztuVLgXnDwwZM";
        const MODEL = "gemini-2.5-flash";

        let conversationHistory = [];
        let isProcessing = false;
        let turnCount = 0;
        const ROUTING_TURN_THRESHOLD = 5;

        const chatHistory = document.getElementById('chat-history');
        const chatForm = document.getElementById('chat-form');
        const chatInputWrap = document.querySelector('.chat-input-wrapper');
        const inputField = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');
        const toggleBrowse = document.getElementById('toggle-browse');
        const browseSection = document.getElementById('browse-section');
        const toggleIcon = document.getElementById('toggle-icon');
        const headerStatus = document.getElementById('header-status');
        const statusDot = document.getElementById('status-dot');
        const sectorCards = document.querySelectorAll('.sector-card');

        const ROUTE_TAGS = {
            '[ROUTE_ACADEMIC]': { name: 'Academic Sector', url: '/student' },
            '[ROUTE_BUSINESS]': { name: 'Business Sector', url: '/business' },
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
- When the user's request is already clear enough, confidently recommend the best department instead of dragging the conversation.
- If you are explicitly told the conversation limit has been reached, acknowledge the need, say you are redirecting them now, and append exactly one route tag at the very end: [ROUTE_ACADEMIC], [ROUTE_BUSINESS], or [ROUTE_INNOVATION].`;

        function escapeHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function formatMessage(text) {
            return escapeHtml(text).replace(/\n/g, '<br>');
        }

        function scrollToBottom(force = false) {
            requestAnimationFrame(() => {
                chatHistory.scrollTo({
                    top: chatHistory.scrollHeight,
                    behavior: force ? 'auto' : 'smooth'
                });
            });
        }

        function setStatus(text, color = 'green') {
            headerStatus.innerText = text;
            statusDot.classList.remove('bg-green-500', 'bg-yellow-500', 'bg-red-500');
            if (color === 'yellow') statusDot.classList.add('bg-yellow-500');
            else if (color === 'red') statusDot.classList.add('bg-red-500');
            else statusDot.classList.add('bg-green-500');
        }

        function setProcessingState(active) {
            isProcessing = active;
            sendBtn.disabled = active;
            chatInputWrap.classList.toggle('disabled', active);
            if (!active) {
                inputField.focus({ preventScroll: true });
            }
        }

        function addUserMessage(text) {
            const div = document.createElement('div');
            div.className = 'msg-wrapper-user';
            div.innerHTML = `<div class="msg-user">${formatMessage(text)}</div>`;
            chatHistory.appendChild(div);
            scrollToBottom();
        }

        function createStreamingBubble() {
            const div = document.createElement('div');
            div.className = 'msg-wrapper-ai is-thinking';
            div.innerHTML = `
                <div class="ai-avatar ai-avatar-logo">
                    <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg"
                         alt="De Kompany"
                         class="w-full h-full object-cover">
                </div>
                <div class="msg-ai streaming-target">
                    <span class="typing-dots" aria-label="Thinking"><span></span><span></span><span></span></span>
                </div>
            `;
            chatHistory.appendChild(div);
            scrollToBottom();
            return div.querySelector('.streaming-target');
        }

        function detectRouteTag(text) {
            for (const [tag, config] of Object.entries(ROUTE_TAGS)) {
                if (text.includes(tag)) {
                    return { tag, config };
                }
            }
            return null;
        }

        function stripRouteTags(text) {
            return text.replace(/\[ROUTE_(ACADEMIC|BUSINESS|INNOVATION)\]/g, '').trim();
        }

        function executeSoftHandoff(sectorName, urlPath) {
            setProcessingState(true);
            setStatus('Transferring...', 'yellow');

            const toast = document.createElement('div');
            toast.className = 'routing-toast';
            toast.innerHTML = `<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Connecting to ${escapeHtml(sectorName)} Team...`;
            chatHistory.appendChild(toast);
            scrollToBottom();

            setTimeout(() => {
                toast.innerHTML = `<i class="fa-solid fa-check text-green-500 mr-2"></i> Redirecting now!`;
                window.location.href = urlPath;
            }, 1400);
        }

        function handleManualDepartmentClick(event) {
            event.preventDefault();
            if (isProcessing) return;
            const link = event.currentTarget;
            const sectorName = link.dataset.sector || 'Selected Department';
            const href = link.getAttribute('href') || '/';
            executeSoftHandoff(sectorName, href);
        }

        let browseOpen = false;
        toggleBrowse.addEventListener('click', (event) => {
            event.preventDefault();
            browseOpen = !browseOpen;
            browseSection.classList.toggle('collapsed', !browseOpen);
            toggleBrowse.setAttribute('aria-expanded', String(browseOpen));
            toggleIcon.style.transform = browseOpen ? 'rotate(0deg)' : 'rotate(-90deg)';
            scrollToBottom();
        });

        sectorCards.forEach((card) => {
            card.addEventListener('click', handleManualDepartmentClick);
        });

        inputField.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                chatForm.requestSubmit();
            }
        });

        window.addEventListener('resize', () => scrollToBottom(true));

        chatForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            if (isProcessing) return;

            const text = inputField.value.trim();
            if (!text) return;

            inputField.value = '';
            addUserMessage(text);
            turnCount += 1;
            setProcessingState(true);
            setStatus('Typing...', 'yellow');

            let apiPayloadText = text;
            if (turnCount >= ROUTING_TURN_THRESHOLD) {
                apiPayloadText += '\n\n[SYSTEM INSTRUCTION: The conversation limit has been reached. Please acknowledge the visitor\'s need, state clearly that you are redirecting them to the best department right now, and append exactly one route tag at the end: [ROUTE_ACADEMIC], [ROUTE_BUSINESS], or [ROUTE_INNOVATION]. Do not ask any more questions.]';
            }

            conversationHistory.push({ role: 'user', parts: [{ text: apiPayloadText }] });

            const streamingBubble = createStreamingBubble();
            let rawAiResponse = '';
            let cleanAiResponse = '';
            let targetRoute = null;

            try {
                const url = `https://generativelanguage.googleapis.com/v1beta/models/${MODEL}:streamGenerateContent?alt=sse&key=${apiKey}`;

                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        system_instruction: { parts: [{ text: SYSTEM_PROMPT }] },
                        contents: conversationHistory,
                        generationConfig: {
                            temperature: 0.7,
                            maxOutputTokens: 300
                        }
                    })
                });

                if (!response.ok) {
                    const errData = await response.json().catch(() => ({}));
                    throw new Error(errData.error?.message || 'Unable to reach the AI service right now.');
                }

                if (!response.body) {
                    throw new Error('Streaming is not available in this browser response.');
                }

                const reader = response.body.getReader();
                const decoder = new TextDecoder();
                let buffer = '';
                streamingBubble.closest('.msg-wrapper-ai')?.classList.remove('is-thinking');
                streamingBubble.innerHTML = '';

                while (true) {
                    const { done, value } = await reader.read();
                    if (done) break;

                    buffer += decoder.decode(value, { stream: true });
                    const lines = buffer.split('\n');
                    buffer = lines.pop() || '';

                    for (const line of lines) {
                        if (!line.startsWith('data: ')) continue;

                        const jsonStr = line.slice(6).trim();
                        if (!jsonStr || jsonStr === '[DONE]') continue;

                        try {
                            const parsed = JSON.parse(jsonStr);
                            const token = parsed?.candidates?.[0]?.content?.parts?.[0]?.text || '';
                            if (!token) continue;

                            rawAiResponse += token;
                            const detected = detectRouteTag(rawAiResponse);
                            if (detected) {
                                targetRoute = detected.config;
                            }

                            cleanAiResponse = stripRouteTags(rawAiResponse);
                            streamingBubble.innerHTML = formatMessage(cleanAiResponse);
                            scrollToBottom();
                        } catch (parseError) {
                            console.warn('Skipped malformed stream chunk.', parseError);
                        }
                    }
                }

                cleanAiResponse = stripRouteTags(rawAiResponse);
                conversationHistory.push({ role: 'model', parts: [{ text: cleanAiResponse }] });

                if (targetRoute) {
                    executeSoftHandoff(targetRoute.name, targetRoute.url);
                    return;
                }

                setStatus('Online', 'green');
            } catch (error) {
                console.error('Streaming Error:', error);
                streamingBubble.closest('.msg-wrapper-ai')?.classList.remove('is-thinking');
                streamingBubble.innerHTML = "I'm having a little trouble connecting right now. You can still browse the departments below manually.";
                setStatus('Offline', 'red');
            } finally {
                if (!targetRoute) {
                    setProcessingState(false);
                }
            }
        });

        scrollToBottom(true);