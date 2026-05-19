<?php 
// SEO Details
$pageTitle = "Global Headquarters";
$pageDesc = "De Kompany is the architecture of intelligent outcomes. We operate at the intersection of business strategy, academic rigor, and digital innovation.";
include 'header.php'; 
?>

<style>
    /* Global HQ Typography */
    .font-display { font-family: 'Playfair Display', serif; }
    
    /* Subtle Grid Pattern for "Structure" feel */
    .bg-grid-slate {
        background-size: 40px 40px;
        background-image: linear-gradient(to right, rgba(30, 58, 138, 0.05) 1px, transparent 1px),
                          linear-gradient(to bottom, rgba(30, 58, 138, 0.05) 1px, transparent 1px);
    }

    /* Hover Card Effect */
    .sector-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sector-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -5px rgba(30, 58, 138, 0.1);
    }
    .sector-card:hover .icon-circle {
        transform: scale(1.1);
        background-color: #ca8a04; /* Yellow-600 */
        color: white;
    }
</style>

<main class="bg-white text-slate-900 selection:bg-blue-900 selection:text-white">

    <!-- 1. Hero: The Knowledge Architecture Firm -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-grid-slate"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-blue-50/50 to-transparent"></div>
        
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-2 px-4 border border-blue-900/10 bg-white shadow-sm text-blue-900 text-xs font-bold tracking-[0.2em] uppercase mb-8 rounded-full animate-fadeIn">
                Global Headquarters
            </span>
            
            <h1 class="text-5xl md:text-8xl font-display font-bold text-blue-950 mb-8 leading-tight">
                Architects of <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-900 to-yellow-600">Intelligent Outcomes.</span>
            </h1>
            
            <p class="text-xl text-gray-500 max-w-3xl mx-auto leading-relaxed mb-12 font-light">
                We exist at the intersection of academic rigor and business strategy. <br class="hidden md:block">
                De Kompany is not just a service provider; we are a structure for those who value <strong>clarity, intelligence, and originality.</strong>
            </p>

            <div class="flex flex-col md:flex-row justify-center gap-6">
                <a href="#sectors" class="px-8 py-4 bg-blue-950 text-white font-bold rounded hover:bg-blue-900 transition shadow-xl">
                    Explore The Ecosystem
                </a>
                <a href="team.php" class="px-8 py-4 bg-white border border-gray-200 text-blue-950 font-bold rounded hover:border-yellow-500 transition">
                    Meet The Leadership
                </a>
            </div>
        </div>
    </section>

    <!-- 2. The Origin Story (Narrative) -->
    <section class="py-24 bg-blue-950 text-white relative">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
        
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="flex flex-col md:flex-row items-center gap-16">
                <div class="md:w-1/2">
                    <h2 class="text-yellow-500 font-bold tracking-widest text-sm uppercase mb-4">Our Origin</h2>
                    <h3 class="text-4xl md:text-5xl font-display font-bold mb-8">From WhatsApp Status <br> to Corporate Strategy.</h3>
                    <div class="prose prose-lg prose-invert text-blue-100 font-light">
                        <p>
                            It started with a belief: <em>"Normality is a paved road; it's comfortable to walk on, but no flowers grow on it."</em>
                        </p>
                        <p>
                            De Kompany began in 2018 as <strong>Decousinsseries</strong>, a digital space for thought-provoking narratives. What started as short stories shared on social media status updates evolved into a profound realization: <strong>Words are assets.</strong>
                        </p>
                        <p>
                            Today, we have transitioned from a blog into a <strong>Consulting Firm</strong> rooted in both the academic and business worlds. We are built for a generation that refuses noise and values meaning.
                        </p>
                    </div>
                </div>
                <div class="md:w-1/2 relative">
                    <div class="border border-white/20 p-8 rounded-2xl bg-white/5 backdrop-blur-sm">
                        <div class="mb-8">
                            <i class="fa-solid fa-quote-left text-4xl text-yellow-500 opacity-50"></i>
                        </div>
                        <p class="text-2xl font-display italic leading-relaxed mb-8">
                            "We do not guess; we research. We do not decorate ideas; we structure them. Every solution carries intellectual depth."
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center font-bold text-blue-950 text-xl font-display">D</div>
                            <div>
                                <h4 class="font-bold">Damilare Olayinka</h4>
                                <span class="text-xs text-blue-300 uppercase tracking-wider">Executive Director</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. The 4 Pillars (The Sectors) -->
    <section id="sectors" class="py-32 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <span class="text-blue-900 font-bold tracking-widest text-xs uppercase">The Ecosystem</span>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-blue-950 mt-4">What We Do</h2>
                <p class="text-gray-500 mt-4 max-w-2xl mx-auto">We operate four distinct but interconnected engines.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                
                <!-- 1. Business -->
                <a href="/business/index.php" class="sector-card bg-white p-10 rounded-2xl border border-gray-100 group">
                    <div class="flex justify-between items-start mb-8">
                        <div class="icon-circle w-16 h-16 bg-blue-50 text-blue-900 rounded-2xl flex items-center justify-center text-2xl transition duration-500">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold uppercase tracking-wider rounded-full group-hover:bg-blue-900 group-hover:text-white transition">Corporate</span>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 group-hover:text-blue-700 transition">Business Strategy</h3>
                    <p class="text-gray-500 leading-relaxed mb-6">
                        We structure ideas into measurable assets. From brand positioning to high-level corporate documentation, we give your business the clarity it needs to scale.
                    </p>
                    <span class="text-blue-900 font-bold text-sm flex items-center gap-2">Enter Boardroom <i class="fa-solid fa-arrow-right opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:translate-x-1"></i></span>
                </a>

                <!-- 2. Education -->
                <a href="/student/index.php" class="sector-card bg-white p-10 rounded-2xl border border-gray-100 group">
                    <div class="flex justify-between items-start mb-8">
                        <div class="icon-circle w-16 h-16 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center text-2xl transition duration-500">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold uppercase tracking-wider rounded-full group-hover:bg-yellow-500 group-hover:text-white transition">Academic</span>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 group-hover:text-yellow-600 transition">Academic Excellence</h3>
                    <p class="text-gray-500 leading-relaxed mb-6">
                        We provide companionship to the ambitious student. Through research coaching, thesis structuring, and career development, we guide you toward distinction.
                    </p>
                    <span class="text-yellow-600 font-bold text-sm flex items-center gap-2">Enter Academy <i class="fa-solid fa-arrow-right opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:translate-x-1"></i></span>
                </a>

                <!-- 3. Innovation -->
                <div class="sector-card bg-white p-10 rounded-2xl border border-gray-100 group">
                    <div class="flex justify-between items-start mb-8">
                        <div class="icon-circle w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl transition duration-500">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold uppercase tracking-wider rounded-full group-hover:bg-indigo-600 group-hover:text-white transition">Technology</span>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 group-hover:text-indigo-600 transition">Digital Innovation</h3>
                    <p class="text-gray-500 leading-relaxed mb-6">
                        Led by our Platform Innovation unit, we build the digital ecosystems where ideas live. Websites, mobile applications, and intelligent automation systems.
                    </p>
                    <span class="text-indigo-600 font-bold text-sm flex items-center gap-2">View Solutions <i class="fa-solid fa-arrow-right opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:translate-x-1"></i></span>
                </div>

                <!-- 4. Thoughts -->
                <a href="pov.php" class="sector-card bg-white p-10 rounded-2xl border border-gray-100 group">
                    <div class="flex justify-between items-start mb-8">
                        <div class="icon-circle w-16 h-16 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-2xl transition duration-500">
                            <i class="fa-solid fa-feather-pointed"></i>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold uppercase tracking-wider rounded-full group-hover:bg-red-600 group-hover:text-white transition">Editorial</span>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-950 mb-3 group-hover:text-red-600 transition">Thoughts & POV</h3>
                    <p class="text-gray-500 leading-relaxed mb-6">
                        The heartbeat of our philosophy. We explore culture, trends, and human psychology through "Gbemidebe" level storytelling and rigorous analysis.
                    </p>
                    <span class="text-red-600 font-bold text-sm flex items-center gap-2">Read The Manifesto <i class="fa-solid fa-arrow-right opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:translate-x-1"></i></span>
                </a>

            </div>
        </div>
    </section>

    <!-- 4. The Philosophy Bar -->
    <section class="bg-blue-900 text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="font-display text-3xl md:text-4xl italic mb-4">"Knowledge is leverage. Information is power."</h2>
            <div class="w-24 h-1 bg-yellow-500 mx-auto"></div>
        </div>
    </section>

    <!-- 5. Global CTA -->
    <section class="py-24 bg-white text-center">
        <div class="container mx-auto px-6 max-w-2xl">
            <h2 class="text-4xl font-display font-bold text-blue-950 mb-6">Ready to Build With Us?</h2>
            <p class="text-gray-600 mb-10 text-lg">
                Whether you are a company seeking strategy or a student seeking excellence, De Kompany is your partner.
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="mailto:contact@dekompany.com" class="px-8 py-3 bg-blue-950 text-white font-bold rounded shadow-xl hover:bg-blue-900 transition">
                    Contact HQ
                </a>
                <a href="/business/index.php" class="px-8 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded hover:bg-gray-50 transition">
                    Go to Business
                </a>
            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>