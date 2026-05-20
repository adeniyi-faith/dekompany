<div id="bg-glow-student" class="ambient-glow top-[-20%] left-[-10%] w-[80vw] h-[80vw] bg-blue-900/20 opacity-40"></div>
    <div id="bg-glow-business" class="ambient-glow bottom-[-20%] right-[-10%] w-[80vw] h-[80vw] bg-gray-100/10 opacity-20"></div>

    <div class="app-shell">
        <div class="app-container">
            <header class="flex flex-col items-center pb-3 px-4 animate-in">
                <div class="flex items-center justify-between w-full max-w-2xl mx-auto gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg"
                             alt="De Kompany"
                             class="w-10 h-10 rounded-full border border-white/20 shadow-xl object-cover flex-shrink-0">
                        <div class="text-left min-w-0">
                            <h1 class="text-lg font-serif font-bold tracking-wide leading-tight truncate">De Kompany</h1>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-medium mt-0.5">Concierge Desk</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 flex-shrink-0">
                        <div id="status-dot" class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-[9px] uppercase tracking-wider text-gray-400 font-semibold" id="header-status">Online</span>
                    </div>
                </div>
            </header>

            <main class="chat-history" id="chat-history" aria-live="polite">
                <div class="msg-wrapper-ai animate-in delay-1">
                    <div class="ai-avatar ai-avatar-logo">
                        <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg"
                             alt="De Kompany"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="msg-ai">
                        Hey! 👋 Welcome to De Kompany. I'm your concierge, the friendly face at the front desk.<br><br>
                        Tell me a little about what you're working on, and I’ll guide you to the right team.
                    </div>
                </div>
            </main>

            <div class="bottom-area animate-in delay-2">
                <form id="chat-form" class="chat-input-wrapper rounded-[24px] px-3 py-2 flex items-end gap-2 w-full" novalidate>
                    <i class="fa-solid fa-sparkles text-yellow-500/50 text-sm flex-shrink-0 mb-2.5 ml-1" aria-hidden="true"></i>
                    <label for="user-input" class="visually-hidden">Type your message</label>
                    <textarea id="user-input"
                              rows="1"
                              placeholder="Type your message..."
                              class="bg-transparent border-none outline-none flex-grow text-white placeholder-gray-500 font-light overflow-hidden pt-1.5 pb-1.5"
                              autocomplete="off"
                              maxlength="1200"></textarea>

                    <button type="submit" id="send-btn" class="bg-yellow-500 hover:bg-yellow-400 text-black rounded-full w-9 h-9 flex items-center justify-center transition-all transform active:scale-90 mb-0.5 touch-manipulation flex-shrink-0" aria-label="Send message">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 ml-0.5">
                            <path d="M3.478 2.404a.75.75 0 00-.926.941l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.404z" />
                        </svg>
                    </button>
                </form>

                <div class="flex items-center gap-3 px-2 pt-1 w-full">
                    <div class="flex-grow h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                    <button type="button" id="toggle-browse" aria-expanded="false" aria-controls="browse-section" class="text-[10px] md:text-xs text-gray-400 uppercase tracking-widest flex items-center gap-2 hover:text-white transition py-1">
                        <span>Browse Departments</span>
                        <i id="toggle-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform" style="transform: rotate(-90deg);"></i>
                    </button>
                    <div class="flex-grow h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                </div>

                <div class="browse-section collapsed w-full" id="browse-section">
                    <div class="grid grid-cols-1 gap-2 px-1 pb-2">
                        <a href="/student" data-sector="Academic Sector" class="sector-card rounded-xl p-3 flex items-center gap-4 group cursor-pointer border-l-4 border-l-transparent hover:border-l-yellow-500 focus-visible:border-l-yellow-500">
                            <div class="w-10 h-10 rounded-full bg-blue-900/30 flex items-center justify-center border border-blue-500/20 group-active:bg-blue-900 transition-colors flex-shrink-0">
                                <i class="fa-solid fa-graduation-cap text-blue-300 text-sm"></i>
                            </div>
                            <div class="flex-grow min-w-0">
                                <h3 class="text-sm font-serif font-bold text-gray-200">Academic Sector</h3>
                                <p class="text-[11px] text-gray-400 truncate mt-0.5">Coaching · Thesis · Research</p>
                            </div>
                        </a>

                        <a href="/business" data-sector="Business Sector" class="sector-card rounded-xl p-3 flex items-center gap-4 group cursor-pointer border-l-4 border-l-transparent hover:border-l-white focus-visible:border-l-white">
                            <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center border border-white/10 group-active:bg-white/20 transition-colors flex-shrink-0">
                                <i class="fa-solid fa-briefcase text-gray-300 text-sm"></i>
                            </div>
                            <div class="flex-grow min-w-0">
                                <h3 class="text-sm font-serif font-bold text-gray-200">Business Sector</h3>
                                <p class="text-[11px] text-gray-400 truncate mt-0.5">Strategy · Plans · Consulting</p>
                            </div>
                        </a>

                        <a href="/innovation" data-sector="Innovation Sector" class="sector-card rounded-xl p-3 flex items-center gap-4 group cursor-pointer border-l-4 border-l-transparent hover:border-l-cyan-400 focus-visible:border-l-cyan-400">
                            <div class="w-10 h-10 rounded-full bg-cyan-900/25 flex items-center justify-center border border-cyan-400/20 group-active:bg-cyan-900/45 transition-colors flex-shrink-0">
                                <i class="fa-solid fa-lightbulb text-cyan-300 text-sm"></i>
                            </div>
                            <div class="flex-grow min-w-0">
                                <h3 class="text-sm font-serif font-bold text-gray-200">Innovation Sector</h3>
                                <p class="text-[11px] text-gray-400 truncate mt-0.5">Ideas · Products · Tech Builds</p>
                            </div>
                        </a>
                    </div>
                    <p class="text-center text-[10px] text-gray-500 pb-1 mt-2">
                        &copy; 2026 De Kompany &middot; Built by <a href="https://getonlinestudio.com/" target="_blank" rel="nofollow noopener" class="text-yellow-600 font-medium hover:text-yellow-400">GetOnline Studio</a>
                    </p>
                </div>
            </div>
        </div>
    </div>