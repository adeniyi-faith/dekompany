<?php include 'header.php'; ?>

    <main class="relative z-10 container mx-auto px-6 py-10 md:py-16">
        <!-- Hero -->
        <div class="page-transition flex flex-col md:flex-row items-center gap-12 mb-20">
            <div class="md:w-1/2">
                <span class="text-yellow-400 font-bold tracking-widest uppercase text-xs mb-3 block">For The Ambitious Student</span>
                <h1 class="text-4xl md:text-6xl font-serif font-bold text-white mb-6 leading-tight">Your Academic <br><span class="text-yellow-400">Success Strategy.</span></h1>
                <p class="text-lg text-blue-200 mb-8 leading-relaxed">
                    University isn't just about surviving; it's about architectural precision. We provide the coaching, research, and tools you need to excel.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="toggleChat()" class="px-8 py-3 bg-white text-blue-950 font-bold rounded hover:bg-blue-50 transition shadow-[0_0_20px_rgba(255,255,255,0.2)]">
                        Get Started
                    </button>
                    <!-- Updated Link -->
                    <a href="services.php" class="px-8 py-3 border border-blue-700 text-blue-100 rounded hover:border-yellow-400 hover:text-yellow-400 transition flex items-center justify-center">
                        Explore Resources
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 relative">
                <!-- Academic Abstract Art -->
                <div class="relative z-10 bg-gradient-to-br from-blue-900 to-blue-950 border border-blue-800 p-8 rounded-2xl shadow-2xl">
                    <div class="flex items-center justify-between mb-6 border-b border-blue-800 pb-4">
                        <h3 class="text-white font-serif text-xl">Current Mission</h3>
                        <span class="bg-yellow-600/20 text-yellow-400 px-3 py-1 rounded text-xs font-bold">IN PROGRESS</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-blue-300 text-sm">Thesis Research</span>
                            <div class="w-32 h-2 bg-blue-900 rounded-full overflow-hidden"><div class="w-3/4 h-full bg-yellow-500"></div></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-300 text-sm">Essay Structure</span>
                            <div class="w-32 h-2 bg-blue-900 rounded-full overflow-hidden"><div class="w-1/2 h-full bg-blue-500"></div></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-300 text-sm">Exam Prep</span>
                            <div class="w-32 h-2 bg-blue-900 rounded-full overflow-hidden"><div class="w-1/4 h-full bg-blue-700"></div></div>
                        </div>
                    </div>
                </div>
                <!-- Glow -->
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-blue-600/30 rounded-full blur-3xl -z-0"></div>
            </div>
        </div>

        <!-- Services Grid -->
        <div id="student-services" class="page-transition mb-24 scroll-mt-24">
            <div class="flex items-center gap-4 mb-8">
                <h2 class="text-2xl font-bold text-white font-serif">Academic Services</h2>
                <div class="h-px bg-blue-800 flex-grow"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 (Linked) -->
                <a href="services.php#writing" class="block p-8 bg-blue-900/20 border border-blue-800 hover:border-yellow-500/50 rounded-xl transition-all hover:transform hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center mb-6 text-2xl">📝</div>
                    <h3 class="text-xl font-bold mb-3 text-white">Academic Writing</h3>
                    <p class="text-sm text-blue-300 leading-relaxed">Expert assistance with essays, theses, and project documentation that meets global standards.</p>
                </a>

                <!-- Card 2 (Linked) -->
                <a href="services.php#research" class="block p-8 bg-blue-900/20 border border-blue-800 hover:border-yellow-500/50 rounded-xl transition-all hover:transform hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center mb-6 text-2xl">🔍</div>
                    <h3 class="text-xl font-bold mb-3 text-white">Research & Edit</h3>
                    <p class="text-sm text-blue-300 leading-relaxed">Deep dive research assistance and professional proofreading to polish your work.</p>
                </a>

                <!-- Card 3 (Action) -->
                <div onclick="toggleChat()" class="block p-8 bg-blue-900/20 border border-blue-800 hover:border-yellow-500/50 rounded-xl transition-all hover:transform hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center mb-6 text-2xl">🧠</div>
                    <h3 class="text-xl font-bold mb-3 text-white">Academic Coach</h3>
                    <p class="text-sm text-blue-300 leading-relaxed">One-on-one mentorship to help you navigate your academic journey and career planning.</p>
                </div>
            </div>
        </div>

        <!-- Student Lounge -->
        <div id="student-lounge" class="page-transition mb-24 scroll-mt-24">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <span class="text-yellow-500 font-bold uppercase text-xs tracking-wider">The Library</span>
                    <h2 class="text-3xl font-serif font-bold text-white mt-2">Student Lounge</h2>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <article class="group relative overflow-hidden rounded-xl bg-blue-900/20 border border-blue-800 hover:border-blue-600 transition">
                    <div class="p-8">
                        <div class="text-xs text-yellow-500 mb-2 font-bold tracking-wider">STUDY HACKS</div>
                        <h3 class="text-2xl text-white font-bold mb-4 group-hover:text-blue-300 transition-colors">The 4.0 GPA Blueprint</h3>
                        <p class="text-blue-200 mb-6">Discover the techniques top students use to manage time and retain information without burnout.</p>
                        <a href="#" class="inline-flex items-center text-white text-sm font-bold border-b border-yellow-500 pb-1">Read Article <i class="fa-solid fa-arrow-right ml-2 text-yellow-500"></i></a>
                    </div>
                </article>

                 <article class="group relative overflow-hidden rounded-xl bg-blue-900/20 border border-blue-800 hover:border-blue-600 transition">
                    <div class="p-8">
                        <div class="text-xs text-yellow-500 mb-2 font-bold tracking-wider">CAREER</div>
                        <h3 class="text-2xl text-white font-bold mb-4 group-hover:text-blue-300 transition-colors">CVs That Get Hired</h3>
                        <p class="text-blue-200 mb-6">Translating your academic achievements into corporate language that employers understand.</p>
                        <a href="#" class="inline-flex items-center text-white text-sm font-bold border-b border-yellow-500 pb-1">Read Article <i class="fa-solid fa-arrow-right ml-2 text-yellow-500"></i></a>
                    </div>
                </article>
            </div>
        </div>

        <!-- Terminal -->
        <div class="mt-8 p-4 bg-blue-950 border border-blue-800 rounded font-mono text-xs md:text-sm h-32 overflow-y-auto" id="system-logs">
            <div class="text-yellow-600">>> SYSTEM ONLINE</div>
            <div class="text-yellow-600">>> LOADING RESOURCES...</div>
            <div class="text-yellow-400 animate-pulse">>> READY FOR INPUT...</div>
        </div>

    <?php include 'footer.php'; ?>