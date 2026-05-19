<?php 
// SEO Details
$pageTitle = "Damilare Olayinka | The Manifesto";
$pageDesc = "Better a little deranged. Read the personal manifesto of the Chief Word Architect behind De Kompany.";
include 'header.php'; 
?>

<!-- Custom Styles for Narrative Profile -->
<style>
    /* Artistic Background Texture */
    .paper-texture {
        background-color: #fdfbf7;
        background-image: url("https://www.transparenttextures.com/patterns/cream-paper.png");
    }
    
    /* Typography */
    .quote-font { font-family: 'Playfair Display', serif; font-style: italic; }
    
    /* The Line of Curiosity (Timeline) */
    .timeline-line {
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #1e3a8a, #ca8a04, #1e3a8a);
        transform: translateX(-50%);
    }
    
    /* Reveal Animation */
    .reveal-text {
        opacity: 0;
        transform: translateY(20px);
        animation: reveal 1s forwards 0.5s;
    }
    @keyframes reveal { to { opacity: 1; transform: translateY(0); } }

    /* The "Dual Mind" Split */
    .brain-split {
        background: linear-gradient(90deg, #eff6ff 50%, #fffbeb 50%);
    }
</style>

<main class="paper-texture text-gray-800">

    <!-- 1. The Hook: "Better a little deranged" -->
    <section class="min-h-[80vh] flex flex-col justify-center items-center text-center relative overflow-hidden py-20">
        <!-- Abstract Art Elements -->
        <div class="absolute top-10 left-10 w-32 h-32 border border-blue-900/10 rounded-full animate-spin-slow"></div>
        <div class="absolute bottom-10 right-10 w-48 h-48 border border-yellow-500/10 rounded-full animate-pulse"></div>
        
        <div class="container mx-auto px-6 relative z-10 max-w-4xl">
            <div class="mb-8">
                <span class="text-blue-900 font-bold tracking-[0.3em] text-xs uppercase border-b border-blue-900 pb-1">Who I Am</span>
            </div>
            
            <h1 class="text-4xl md:text-6xl font-serif font-bold text-blue-950 leading-tight mb-8 reveal-text">
                "Normality is a paved road; <br>
                <span class="text-yellow-600 italic font-light">it's comfortable to walk on,</span> <br>
                but no flowers grow on it."
            </h1>
            
            <p class="text-gray-500 text-sm md:text-base font-serif italic mb-12 reveal-text">
                — Vincent van Gogh
            </p>

            <div class="prose prose-lg text-gray-700 mx-auto leading-relaxed reveal-text">
                <p>
                    Life, I believe, is better a little deranged. My goal has never been to be normal, but to be <strong class="text-blue-900">deranged with knowledge</strong>. It is far more entertaining—and far more meaningful.
                </p>
            </div>
            
            <div class="mt-12 animate-bounce text-blue-900/50">
                <i class="fa-solid fa-arrow-down"></i>
            </div>
        </div>
    </section>

    <!-- 2. The Anatomy of a Mediator (INFP) -->
    <section class="py-24 bg-white border-y border-gray-100">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <!-- The Monogram Illustration -->
                    <div class="w-full aspect-square bg-blue-950 rounded-full flex items-center justify-center relative overflow-hidden shadow-2xl">
                        <!-- Constellation Graphic (CSS Stars) -->
                        <div class="absolute top-1/4 left-1/4 w-1 h-1 bg-white rounded-full shadow-[0_0_10px_white]"></div>
                        <div class="absolute top-1/2 left-1/3 w-1.5 h-1.5 bg-yellow-400 rounded-full shadow-[0_0_10px_gold]"></div>
                        <div class="absolute bottom-1/3 right-1/4 w-1 h-1 bg-white rounded-full"></div>
                        <!-- Connecting Lines -->
                        <svg class="absolute inset-0 w-full h-full opacity-20 pointer-events-none">
                            <line x1="25%" y1="25%" x2="33%" y2="50%" stroke="white" stroke-width="1" />
                            <line x1="33%" y1="50%" x2="75%" y2="66%" stroke="white" stroke-width="1" />
                        </svg>
                        
                        <div class="text-center relative z-10">
                            <span class="block text-6xl text-white font-serif font-bold mb-2">INFP</span>
                            <span class="block text-yellow-500 text-xs tracking-widest uppercase">The Mediator</span>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-8">
                    <h2 class="text-3xl font-serif font-bold text-blue-950">Wired for Insight.</h2>
                    <p class="text-gray-600 leading-relaxed">
                        I possess a rare personality type defined by introversion, intuition, feeling, and prospecting. While others see data, I see stories. While others see chaos, I see patterns waiting to be structured.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-4 border-l-2 border-blue-900 bg-blue-50/50">
                            <h4 class="font-bold text-blue-900 text-sm mb-1">Passionate Curiosity</h4>
                            <p class="text-xs text-gray-500">"I have no special talents. I am only passionately curious." — Einstein</p>
                        </div>
                        <div class="p-4 border-l-2 border-yellow-500 bg-yellow-50/50">
                            <h4 class="font-bold text-yellow-700 text-sm mb-1">Authentic Expression</h4>
                            <p class="text-xs text-gray-500">Naturally drawn to purpose, meaning, and authentic storytelling.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. The Timeline: From WhatsApp to The World -->
    <section class="py-24 relative overflow-hidden">
        <div class="container mx-auto px-6 max-w-4xl relative">
            <div class="timeline-line hidden md:block"></div>
            
            <h2 class="text-center text-3xl font-serif font-bold text-blue-950 mb-16 relative z-10 bg-inherit inline-block px-4">
                The Architecture of a Career
            </h2>

            <div class="space-y-12">
                <!-- Milestone 1 -->
                <div class="flex flex-col md:flex-row items-center justify-between group">
                    <div class="md:w-5/12 text-center md:text-right pr-8">
                        <h3 class="font-bold text-xl text-blue-900">The WhatsApp Status Era</h3>
                        <p class="text-sm text-gray-500 mt-2">Where it began. Short, humorous stories shared as status updates earned early recognition and revealed the power of words.</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-950 border-4 border-white shadow-lg relative z-10 flex-shrink-0 flex items-center justify-center text-white text-xs">1</div>
                    <div class="md:w-5/12 pl-8 opacity-50 text-sm font-mono text-gray-400">Early Days</div>
                </div>

                <!-- Milestone 2 -->
                <div class="flex flex-col md:flex-row-reverse items-center justify-between group">
                    <div class="md:w-5/12 text-center md:text-left pl-8">
                        <h3 class="font-bold text-xl text-blue-900">Decousinsseries (2018)</h3>
                        <p class="text-sm text-gray-500 mt-2">The birth of the platform. A Facebook page for thought-provoking write-ups that grew to nearly 1,000 followers. Now known as De Kompany.</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-900 border-4 border-white shadow-lg relative z-10 flex-shrink-0 flex items-center justify-center text-white text-xs">2</div>
                    <div class="md:w-5/12 text-right pr-8 opacity-50 text-sm font-mono text-gray-400">2018</div>
                </div>

                <!-- Milestone 3 -->
                <div class="flex flex-col md:flex-row items-center justify-between group">
                    <div class="md:w-5/12 text-center md:text-right pr-8">
                        <h3 class="font-bold text-xl text-blue-900">The Scientist's Mind</h3>
                        <p class="text-sm text-gray-500 mt-2">BSc in Human Anatomy. "Science refined my thinking; writing preserved my humanity." Qualified as a certified medical science practitioner.</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-800 border-4 border-white shadow-lg relative z-10 flex-shrink-0 flex items-center justify-center text-white text-xs">3</div>
                    <div class="md:w-5/12 pl-8 opacity-50 text-sm font-mono text-gray-400">University Phase</div>
                </div>

                <!-- Milestone 4 -->
                <div class="flex flex-col md:flex-row-reverse items-center justify-between group">
                    <div class="md:w-5/12 text-center md:text-left pl-8">
                        <h3 class="font-bold text-xl text-blue-900">Civic Torch Magazine</h3>
                        <p class="text-sm text-gray-500 mt-2">Writer, Editor, Social Media Manager. Sharpening the ability to communicate with clarity, structure, and impact.</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-700 border-4 border-white shadow-lg relative z-10 flex-shrink-0 flex items-center justify-center text-white text-xs">4</div>
                    <div class="md:w-5/12 text-right pr-8 opacity-50 text-sm font-mono text-gray-400">Journalism</div>
                </div>
                
                 <!-- Milestone 5 -->
                <div class="flex flex-col md:flex-row items-center justify-between group">
                    <div class="md:w-5/12 text-center md:text-right pr-8">
                        <h3 class="font-bold text-xl text-yellow-600">CEO, De Kompany</h3>
                        <p class="text-sm text-gray-500 mt-2">Architects of intelligent outcomes. Transforming ideas into structured, strategic solutions.</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-yellow-500 border-4 border-white shadow-lg relative z-10 flex-shrink-0 flex items-center justify-center text-white text-xs">★</div>
                    <div class="md:w-5/12 pl-8 opacity-50 text-sm font-mono text-gray-400">Present Day</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. The Philosophy: Science x Art -->
    <section class="brain-split py-24 border-t border-gray-200">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-serif font-bold text-blue-950 mb-12">The Intersection</h2>
            <div class="flex flex-col md:flex-row justify-center gap-12 max-w-4xl mx-auto">
                
                <!-- Left: Science -->
                <div class="md:w-1/2 text-right border-r border-blue-100 pr-6">
                    <div class="inline-block p-3 bg-blue-100 text-blue-900 rounded-full mb-4"><i class="fa-solid fa-microscope text-2xl"></i></div>
                    <h3 class="text-xl font-bold text-blue-900 mb-2">Science</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Anatomy taught me precision. It taught me that every system has a structure, and every structure has a function. I do not just create content; I dissect ideas.
                    </p>
                </div>

                <!-- Right: Art -->
                <div class="md:w-1/2 text-left pl-6">
                    <div class="inline-block p-3 bg-yellow-100 text-yellow-700 rounded-full mb-4"><i class="fa-solid fa-feather-pointed text-2xl"></i></div>
                    <h3 class="text-xl font-bold text-yellow-700 mb-2">Art</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Poetry taught me empathy. It taught me that words can touch the soul. "Arts in Thoughts, Thoughts in Rhymes" was my training ground for human connection.
                    </p>
                </div>
            </div>
            
            <div class="mt-16 bg-white inline-block px-8 py-4 rounded-xl shadow-xl border border-gray-100">
                <span class="block text-xs text-gray-400 uppercase tracking-widest mb-1">Guiding Principle</span>
                <p class="text-xl font-serif font-bold text-blue-950">"Knowledge is leverage. Information is power."</p>
            </div>
        </div>
    </section>

    <!-- 5. Footer Signature -->
    <section class="py-20 bg-blue-950 text-white text-center">
        <div class="container mx-auto px-6">
            <p class="text-blue-300 mb-6 italic text-lg font-serif">"This is not just what I do. This is what I am building."</p>
            
            <div class="w-24 h-px bg-yellow-500 mx-auto mb-6"></div>
            
            <h2 class="text-3xl font-serif font-bold">Damilare, Itunu Olayinka</h2>
            <span class="text-xs uppercase tracking-widest text-blue-400 mt-2 block">Chief Word Architect</span>
            
            <div class="mt-8 flex justify-center gap-4">
                <a href="mailto:contact@dekompany.com" class="px-6 py-2 border border-blue-700 rounded-full hover:bg-blue-800 transition text-sm">Get in Touch</a>
                <a href="team.php" class="px-6 py-2 bg-yellow-600 text-white rounded-full hover:bg-yellow-500 transition text-sm">Back to Team</a>
            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>