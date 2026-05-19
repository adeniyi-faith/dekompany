<?php 
// SEO Details
$pageTitle = "Leadership & Team";
$pageDesc = "Meet the architects behind De Kompany. A blend of academic thinkers and creative strategists building intelligent outcomes.";
include 'header.php'; 
?>

<!-- Custom Styles for Team Cards -->
<style>
    .monogram-card {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .monogram-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px -5px rgba(30, 58, 138, 0.15);
    }
    .monogram-bg {
        background: radial-gradient(circle at top right, #1e3a8a, #0a1128);
    }
    .role-badge {
        background: linear-gradient(90deg, #ca8a04 0%, #eab308 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<main>
    <!-- 1. Hero: The Architects -->
    <section class="relative py-24 bg-white overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none">
            <div class="absolute right-0 top-0 w-1/2 h-full bg-blue-50 transform skew-x-12"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-1 px-3 border border-blue-900/10 bg-blue-50 text-blue-900 text-[10px] font-bold tracking-widest uppercase mb-6 rounded-full">
                Global Leadership
            </span>
            <h1 class="text-5xl md:text-7xl font-serif font-bold text-blue-950 mb-6">
                The Architects.
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed font-light">
                We do not guess; we research. We do not decorate ideas; we structure them. Meet the minds bridging the gap between academic rigor and business strategy.
            </p>
        </div>
    </section>

    <!-- 2. The Executive (Featured Leader) -->
    <section class="pb-20">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl mx-auto bg-white border border-gray-100 rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-500 relative">
                <!-- Golden Corner Accent -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/10 rounded-bl-full -z-0"></div>

                <div class="flex flex-col md:flex-row relative z-10">
                    <!-- Premium Monogram (Replaces Photo) -->
                    <div class="md:w-2/5 monogram-bg p-12 flex flex-col items-center justify-center text-center relative overflow-hidden group">
                        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                        <div class="relative z-10 w-40 h-40 rounded-full border-4 border-yellow-500/30 flex items-center justify-center bg-white/5 backdrop-blur-sm group-hover:scale-105 transition duration-500">
                            <span class="font-serif text-6xl text-yellow-500 font-bold">OD</span>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-white font-serif text-2xl">Olayinka Damilare</h3>
                            <p class="text-yellow-500 text-xs font-bold uppercase tracking-widest mt-2">Executive Director</p>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="md:w-3/5 p-10 md:p-14 flex flex-col justify-center">
                        <span class="text-blue-900 font-bold text-xs uppercase tracking-widest mb-4 opacity-50">Chief Word Architect</span>
                        <h2 class="text-3xl font-serif font-bold text-blue-950 mb-6">"Words are assets."</h2>
                        <div class="prose prose-blue text-gray-600 leading-relaxed mb-8">
                            <p>
                                A disciplined creative with a poetic mind, Damilare leads De Kompany's writing philosophy. He specializes in crafting mantras, narratives, and academic expressions that are both beautiful and precise.
                            </p>
                            <p>
                                He ensures every word carries weight, history, and purpose, moving brands from simple noise to institutional authority.
                            </p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 pt-6 border-t border-gray-100">
                            <div class="flex items-center gap-4">
                                <span class="text-xs text-gray-400 font-bold">FOCUS:</span>
                                <span class="px-3 py-1 bg-blue-50 text-blue-900 text-xs font-bold rounded-full">Narrative Strategy</span>
                                <span class="px-3 py-1 bg-blue-50 text-blue-900 text-xs font-bold rounded-full">Philosophy</span>
                            </div>
                            
                            <!-- LINK TO NEW PROFILE -->
                            <a href="director-profile.php" class="inline-flex items-center gap-2 text-blue-900 font-bold text-sm border-b-2 border-yellow-500 hover:text-yellow-600 transition pb-1">
                                Read The Manifesto <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. The Core Team Grid -->
    <section class="py-20 bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">

                <!-- Olumide Nathaniel -->
                <div class="monogram-card bg-white p-8 rounded-xl border border-gray-100 relative group">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full monogram-bg flex-shrink-0 flex items-center justify-center border-2 border-white shadow-lg">
                            <span class="font-serif text-2xl text-yellow-500 font-bold">ON</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-blue-950 group-hover:text-blue-700 transition">Olumide Nathaniel</h3>
                            <p class="role-badge font-bold text-xs uppercase tracking-wider mb-3">Administrative Director</p>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                An academic thinker with an imaginative edge. He bridges structure and creativity, translating complex ideas into clear strategies. His strength lies in coordination and research-backed storytelling.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Folorunsho Tosin -->
                <div class="monogram-card bg-white p-8 rounded-xl border border-gray-100 relative group">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full monogram-bg flex-shrink-0 flex items-center justify-center border-2 border-white shadow-lg">
                            <span class="font-serif text-2xl text-yellow-500 font-bold">FT</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-blue-950 group-hover:text-blue-700 transition">Folorunsho Tosin</h3>
                            <p class="role-badge font-bold text-xs uppercase tracking-wider mb-3">Visual Strategy Lead</p>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                The mind behind the De Kompany visual language. He specializes in graphic design and digital aesthetics, turning abstract concepts into compelling visual systems that communicate instantly.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Agbenike Puah -->
                <div class="monogram-card bg-white p-8 rounded-xl border border-gray-100 relative group">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full monogram-bg flex-shrink-0 flex items-center justify-center border-2 border-white shadow-lg">
                            <span class="font-serif text-2xl text-yellow-500 font-bold">AP</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-blue-950 group-hover:text-blue-700 transition">Agbenike Puah</h3>
                            <p class="role-badge font-bold text-xs uppercase tracking-wider mb-3">Creative Relations</p>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                With a strong sense for colors and human connection, she shapes how De Kompany relates with the world. She brings emotional intelligence into creativity, ensuring our work resonates beyond metrics.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Adeniyi Faith -->
                <div class="monogram-card bg-white p-8 rounded-xl border border-gray-100 relative group">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-full monogram-bg flex-shrink-0 flex items-center justify-center border-2 border-white shadow-lg">
                            <span class="font-serif text-2xl text-yellow-500 font-bold">AF</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-blue-950 group-hover:text-blue-700 transition">Adeniyi Faith</h3>
                            <p class="role-badge font-bold text-xs uppercase tracking-wider mb-3">Platform Innovation</p>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                A precision builder who collaborates where vision demands structure. He transforms ideas into working digital ecosystems, focusing on online positioning through infrastructure.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. Join Us CTA -->
    <section class="py-24 bg-blue-950 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
        <div class="container mx-auto px-6 relative z-10">
            <h2 class="text-3xl font-serif font-bold mb-4">Are You A Detailed Thinker?</h2>
            <p class="text-blue-200 mb-8 max-w-xl mx-auto">
                We are always looking for minds that value structure, clarity, and depth. If you believe in the power of intelligent work, we should talk.
            </p>
            <a href="mailto:careers@dekompany.com" class="inline-block px-8 py-3 border border-yellow-500 text-yellow-500 font-bold rounded hover:bg-yellow-500 hover:text-blue-950 transition">
                Contact Careers
            </a>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>