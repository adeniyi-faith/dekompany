<?php include 'header.php'; ?>

<main class="relative z-10 container mx-auto px-6 py-10 md:py-16">
    
    <!-- Services Hero -->
    <div class="page-transition flex flex-col items-center text-center mb-20">
        <span class="text-yellow-400 font-bold tracking-widest uppercase text-xs mb-3">Excellence in Scholarship</span>
        <h1 class="text-4xl md:text-6xl font-serif font-bold text-white mb-6">Academic <span class="text-yellow-400">Mastery</span></h1>
        <p class="text-lg text-blue-200 max-w-2xl leading-relaxed">
            From structuring complex arguments to rigorous data analysis, our services are designed to elevate your work to publication standards.
        </p>
    </div>

    <!-- Academic Writing Section -->
    <section id="writing" class="mb-24 scroll-mt-24">
        <div class="flex items-center gap-4 mb-12">
            <div class="w-12 h-12 bg-yellow-600 text-white rounded-full flex items-center justify-center text-xl font-bold">1</div>
            <h2 class="text-3xl font-serif font-bold text-white">Academic Writing</h2>
            <div class="h-px bg-blue-800 flex-grow"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <div class="bg-blue-900/20 border border-blue-800 p-6 rounded-xl">
                    <h3 class="text-xl font-bold text-white mb-2"><i class="fa-solid fa-pen-nib text-yellow-500 mr-2"></i> Essays & Coursework</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">
                        We assist in crafting compelling arguments, ensuring logical flow, and strictly adhering to academic marking rubrics. Whether it's argumentative, descriptive, or analytical, we ensure your voice remains authoritative.
                    </p>
                </div>
                <div class="bg-blue-900/20 border border-blue-800 p-6 rounded-xl">
                    <h3 class="text-xl font-bold text-white mb-2"><i class="fa-solid fa-book-open text-yellow-500 mr-2"></i> Theses & Dissertations</h3>
                    <p class="text-blue-300 text-sm leading-relaxed">
                        Comprehensive support for long-form projects. From formulating a hypothesis to the final conclusion, we help structure chapters, refine methodology sections, and ensure coherence across thousands of words.
                    </p>
                </div>
            </div>
            
            <!-- Visual/Process List -->
            <div class="bg-blue-950 border border-blue-800 p-8 rounded-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 text-9xl text-white font-serif font-bold">W</div>
                <h3 class="text-white font-serif text-xl mb-6">The Writing Standard</h3>
                <ul class="space-y-4 text-blue-200 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check text-yellow-500 mt-1"></i>
                        <span><strong>Critical Analysis:</strong> Moving beyond description to evaluation.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check text-yellow-500 mt-1"></i>
                        <span><strong>Referencing Precision:</strong> APA, MLA, Chicago, Harvard, and IEEE styles.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check text-yellow-500 mt-1"></i>
                        <span><strong>Plagiarism Free:</strong> 100% original thought and proper citation.</span>
                    </li>
                </ul>
                <button onclick="toggleChat()" class="mt-8 w-full py-3 border border-yellow-600 text-yellow-500 hover:bg-yellow-600 hover:text-white transition rounded font-bold uppercase text-xs tracking-wider">
                    Discuss Your Topic
                </button>
            </div>
        </div>
    </section>

    <!-- Research Section -->
    <section id="research" class="mb-24 scroll-mt-24">
        <div class="flex items-center gap-4 mb-12">
            <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold">2</div>
            <h2 class="text-3xl font-serif font-bold text-white">Research & Analysis</h2>
            <div class="h-px bg-blue-800 flex-grow"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-blue-900/10 border border-blue-800 hover:border-blue-500 transition rounded-lg group">
                <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">📊</div>
                <h3 class="text-white font-bold mb-3">Quantitative Analysis</h3>
                <p class="text-blue-300 text-sm">Statistical support using SPSS, R, or Python. We help interpret data sets to prove or disprove your hypothesis effectively.</p>
            </div>

            <div class="p-6 bg-blue-900/10 border border-blue-800 hover:border-blue-500 transition rounded-lg group">
                <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">📑</div>
                <h3 class="text-white font-bold mb-3">Literature Reviews</h3>
                <p class="text-blue-300 text-sm">Systematic searching and synthesis of existing scholarly works to identify gaps in current research.</p>
            </div>

            <div class="p-6 bg-blue-900/10 border border-blue-800 hover:border-blue-500 transition rounded-lg group">
                <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">🔬</div>
                <h3 class="text-white font-bold mb-3">Methodology Design</h3>
                <p class="text-blue-300 text-sm">Guidance on choosing the right research framework (Qualitative, Quantitative, or Mixed Methods) for your study.</p>
            </div>
        </div>
    </section>

    <!-- CTA Strip -->
    <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 rounded-2xl p-10 md:p-16 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-serif font-bold text-white mb-4">Ready to Elevate Your Work?</h2>
            <p class="text-yellow-100 mb-8 max-w-xl mx-auto">Schedule a consultation with an academic coach to determine the best strategy for your current project.</p>
            <button onclick="toggleChat()" class="px-10 py-4 bg-white text-yellow-800 font-bold rounded-lg hover:bg-yellow-50 transition shadow-xl">
                Start Consultation
            </button>
        </div>
    </div>

<?php include 'footer.php'; ?>