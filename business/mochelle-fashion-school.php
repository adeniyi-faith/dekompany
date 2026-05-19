<?php include 'header.php'; ?>

<!-- Custom Styles for this Proposal -->
<style>
    .brand-pink-text { color: #db2777; }
    .brand-pink-bg { background-color: #fce7f3; }
    .brand-gradient { background: linear-gradient(135deg, #0a1128 0%, #1e3a8a 100%); }
    .letter-paper {
        background-color: #fff;
        background-image: radial-gradient(#f0f0f0 1px, transparent 1px);
        background-size: 20px 20px;
    }
    .signature-font { font-family: 'Playfair Display', serif; font-style: italic; }
    .glass-stat-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .glass-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -10px rgba(219, 39, 119, 0.15);
    }
</style>

<main class="bg-gray-50">
    
    <!-- 1. Hero: The Hook -->
    <section class="relative h-[90vh] flex items-center justify-center overflow-hidden brand-gradient text-white">
        <!-- Abstract Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-400 rounded-full blur-3xl mix-blend-overlay"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 brand-pink-bg rounded-full blur-3xl mix-blend-overlay"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-2 px-4 border border-pink-400/50 bg-pink-900/20 rounded-full text-pink-300 text-xs font-bold tracking-widest uppercase mb-6 backdrop-blur-sm animate-pulse">
                Strategic Alignment Proposal
            </span>
            <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">
                Mochelle <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-300 to-white">Fashion School</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto font-light leading-relaxed">
                "Fashion rewards taste, not volume." <br>
                Moving your brand from <span class="font-bold text-white">Visibility</span> to <span class="font-bold text-white">Institutional Authority</span>.
            </p>
            
            <div class="mt-12 animate-bounce">
                <i class="fa-solid fa-arrow-down text-pink-400 text-2xl"></i>
            </div>
        </div>
    </section>

    <!-- 2. The Letter: Context & Story -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="letter-paper p-8 md:p-16 shadow-2xl rounded-sm border border-gray-100 relative">
                <!-- Decorative Tape -->
                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-32 h-8 bg-pink-100/50 rotate-[-2deg]"></div>

                <h2 class="text-3xl font-serif font-bold text-blue-900 mb-8">A Note on Divine Oneness...</h2>
                
                <div class="prose prose-lg text-gray-600 leading-relaxed font-serif">
                    <p>It was a Sunday morning—the kind wrapped in the quiet anticipation of a new year. I opened a status update from you, explaining how you abandoned a red-carpet concept because you saw it elsewhere.</p>
                    
                    <p>Instead of defeat, you felt gratitude. That struck me. It reminded me of the <strong>Law of Divine Oneness</strong>: that everything is connected. Your values, your creativity, and your vision resonated with us instantly.</p>

                    <p>We don't see your brand as just another business. We see a story waiting to be told correctly. Just as fabric needs a pattern to become a masterpiece, your social presence needs a strategy to become an institution.</p>
                    
                    <p class="text-blue-900 font-bold italic border-l-4 border-pink-500 pl-6 my-8">
                        "Social media is not just marketing for a fashion brand; it is performance, culture, and storytelling woven into a powerful experience."
                    </p>

                    <p>We are not here to flatter you. We are here to partner with you. To do that, we must first look at the truth of where we stand today.</p>
                </div>

                <div class="mt-12 flex items-center gap-4">
                    <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg" class="w-16 h-16 rounded-full border-2 border-white shadow-lg">
                    <div>
                        <p class="signature-font text-xl text-blue-900">Damilare, Itunu Olayinka</p>
                        <p class="text-xs text-gray-400 uppercase tracking-widest">Executive Director, De Kompany</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. The Diagnosis: Digital Footprint Analysis (Visual & Direct) -->
    <section class="py-24 bg-gray-50 relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(#1e3a8a 1px, transparent 1px); background-size: 30px 30px;"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row items-end justify-between mb-12">
                <div>
                    <span class="text-pink-600 font-bold tracking-widest uppercase text-xs">Dec 1 - Jan 1 Report</span>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-blue-900 mt-2">The Current Architecture</h2>
                    <p class="text-gray-500 mt-2 max-w-xl">We audited your primary platforms. The data reveals a massive opportunity gap.</p>
                </div>
                <div class="hidden md:block">
                     <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm text-sm font-bold text-gray-600">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data Analysis
                     </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Instagram Card -->
                <div class="glass-stat-card p-8 rounded-2xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-pink-500 to-orange-400"></div>
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Audience</div>
                            <div class="text-4xl font-bold text-gray-900">25,600</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-pink-50 flex items-center justify-center text-pink-600 text-xl">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-4 border-t border-gray-100 pt-6">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Engagement Rate</span>
                                <span class="font-bold text-red-500">2.34%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="bg-red-400 h-1.5 rounded-full" style="width: 25%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Below industry standard (4-5%)</p>
                        </div>
                        <div class="p-3 bg-red-50 rounded-lg border border-red-100">
                            <p class="text-xs text-red-800 font-medium"><i class="fa-solid fa-triangle-exclamation mr-1"></i> "Audience is passive. Content is viewed but not felt."</p>
                        </div>
                    </div>
                </div>

                <!-- TikTok Card -->
                <div class="glass-stat-card p-8 rounded-2xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1 h-full bg-black"></div>
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Audience</div>
                            <div class="text-4xl font-bold text-gray-900">34,200</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-900 text-xl">
                            <i class="fa-brands fa-tiktok"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-4 border-t border-gray-100 pt-6">
                         <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Engagement Rate</span>
                                <span class="font-bold text-yellow-600">3.07%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="bg-yellow-500 h-1.5 rounded-full" style="width: 35%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Average performance.</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                            <p class="text-xs text-yellow-800 font-medium"><i class="fa-solid fa-lightbulb mr-1"></i> "High reach, but low conversion to other platforms."</p>
                        </div>
                    </div>
                </div>

                <!-- The Insight (Diagnosis) -->
                <div class="bg-blue-900 text-white p-8 rounded-2xl shadow-xl flex flex-col justify-center relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 text-9xl text-white opacity-5 font-serif font-bold">?</div>
                    
                    <h3 class="text-xl font-bold mb-2 text-pink-300">Core Diagnosis</h3>
                    <h4 class="text-2xl font-serif font-bold mb-6">Strategic Ambiguity</h4>
                    
                    <p class="text-blue-200 text-sm leading-relaxed mb-6">
                        The accounts have visibility but lack clarity. New visitors cannot immediately tell if this is a <strong>training institution</strong>, a <strong>personal brand</strong>, or a <strong>commercial entity</strong>.
                    </p>
                    
                    <div class="mt-auto">
                         <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-check-circle text-green-400"></i>
                            <span class="text-sm font-bold">Attention Exists</span>
                         </div>
                         <div class="flex items-center gap-3">
                            <i class="fa-solid fa-xmark-circle text-red-400"></i>
                            <span class="text-sm font-bold">Trust Signal is Weak</span>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. The Architects (Team) -->
    <section class="py-24 bg-white border-t border-gray-200">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-pink-600 font-bold tracking-widest uppercase text-xs">The Architects</span>
                <h2 class="text-3xl font-serif font-bold text-blue-900 mt-2">Who Builds The Vision?</h2>
                <p class="text-gray-500 mt-4 max-w-2xl mx-auto">We combine academic rigor with creative strategy. We don't guess; we structure.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Damilare -->
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 hover:border-pink-200 hover:shadow-lg transition text-center group">
                    <div class="w-20 h-20 mx-auto bg-white rounded-full mb-4 shadow-sm p-1">
                         <img src="https://placehold.co/200x200/1e3a8a/ffffff?text=DO" class="w-full h-full object-cover rounded-full grayscale group-hover:grayscale-0 transition">
                    </div>
                    <h3 class="font-bold text-gray-900">Damilare Olayinka</h3>
                    <p class="text-[10px] text-pink-600 font-bold uppercase tracking-wider mb-3">Chief Word Architect</p>
                    <p class="text-xs text-gray-500 leading-relaxed">Disciplined creative with a poetic mind. He ensures every word carries weight, history, and purpose.</p>
                </div>

                <!-- Olumide -->
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 hover:border-pink-200 hover:shadow-lg transition text-center group">
                    <div class="w-20 h-20 mx-auto bg-white rounded-full mb-4 shadow-sm p-1">
                         <img src="https://placehold.co/200x200/1e3a8a/ffffff?text=ON" class="w-full h-full object-cover rounded-full grayscale group-hover:grayscale-0 transition">
                    </div>
                    <h3 class="font-bold text-gray-900">Olumide Nathaniel</h3>
                    <p class="text-[10px] text-pink-600 font-bold uppercase tracking-wider mb-3">Strategic Analyst</p>
                    <p class="text-xs text-gray-500 leading-relaxed">The bridge between chaos and structure. Translates complex fashion ideas into clear business strategies.</p>
                </div>

                <!-- Folorunsho -->
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 hover:border-pink-200 hover:shadow-lg transition text-center group">
                     <div class="w-20 h-20 mx-auto bg-white rounded-full mb-4 shadow-sm p-1">
                         <img src="https://placehold.co/200x200/1e3a8a/ffffff?text=FT" class="w-full h-full object-cover rounded-full grayscale group-hover:grayscale-0 transition">
                    </div>
                    <h3 class="font-bold text-gray-900">Folorunsho Tosin</h3>
                    <p class="text-[10px] text-pink-600 font-bold uppercase tracking-wider mb-3">Visual Strategy Lead</p>
                    <p class="text-xs text-gray-500 leading-relaxed">The mind behind the aesthetic. Turns concepts into compelling visual systems that stop the scroll.</p>
                </div>

                <!-- Agbenike -->
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 hover:border-pink-200 hover:shadow-lg transition text-center group">
                     <div class="w-20 h-20 mx-auto bg-white rounded-full mb-4 shadow-sm p-1">
                         <img src="https://placehold.co/200x200/1e3a8a/ffffff?text=AP" class="w-full h-full object-cover rounded-full grayscale group-hover:grayscale-0 transition">
                    </div>
                    <h3 class="font-bold text-gray-900">Agbenike Puah</h3>
                    <p class="text-[10px] text-pink-600 font-bold uppercase tracking-wider mb-3">Creative Relations</p>
                    <p class="text-xs text-gray-500 leading-relaxed">Brings emotional intelligence into creativity. Shapes how the brand connects with the human heart.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Visual Proof: The Bio Transformation (Rich Content) -->
    <section class="py-24 bg-blue-900 text-white overflow-hidden relative">
        <!-- Abstract Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row gap-16 items-center">
                <div class="md:w-1/2">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-12 h-1 bg-pink-500 rounded-full"></span>
                        <span class="text-pink-300 font-bold uppercase text-xs tracking-widest">Immediate Impact</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold mb-6">Small Change. <br>Massive Authority.</h2>
                    <p class="text-blue-200 leading-relaxed mb-8 text-lg">
                        This is just <strong>one</strong> element of our 4-Pillar Strategy. By simply restructuring how you present yourself, we shift the perception from "Hobby" to "Institution."
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-pink-500 flex items-center justify-center text-white flex-shrink-0 mt-1"><i class="fa-solid fa-check"></i></div>
                            <div>
                                <h4 class="font-bold text-white">Clarity</h4>
                                <p class="text-sm text-blue-200">The visitor knows exactly what you offer in 3 seconds.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-pink-500 flex items-center justify-center text-white flex-shrink-0 mt-1"><i class="fa-solid fa-check"></i></div>
                            <div>
                                <h4 class="font-bold text-white">Conversion</h4>
                                <p class="text-sm text-blue-200">A clear Call-To-Action directs traffic where it matters.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="md:w-1/2 w-full">
                    <!-- Transformation Card -->
                    <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden text-gray-800">
                        <div class="grid grid-cols-2">
                            <!-- Before -->
                            <div class="p-6 bg-gray-100 border-r border-gray-200">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-4 block">Current State</span>
                                <div class="font-mono text-xs text-gray-500 space-y-2 opacity-70">
                                    <p>Fashion School In Ibadan</p>
                                    <p>Entrepreneur</p>
                                    <p>Best pattern drafting school</p>
                                    <p>Use the link below</p>
                                </div>
                                <div class="mt-8 pt-4 border-t border-gray-200">
                                    <span class="text-xs text-red-400 font-bold"><i class="fa-solid fa-xmark mr-1"></i> Low Trust</span>
                                </div>
                            </div>
                            <!-- After -->
                            <div class="p-6 bg-white relative">
                                <div class="absolute top-0 right-0 bg-pink-600 text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg">PROPOSED</div>
                                <span class="text-[10px] font-bold text-pink-600 uppercase tracking-wider mb-4 block">Future State</span>
                                <div class="font-sans text-sm text-gray-800 space-y-2">
                                    <p class="font-bold text-lg leading-tight">Fashion Design & Education</p>
                                    <p class="text-xs text-gray-600">Training Africa's Next Designers.</p>
                                    <p class="text-xs font-medium text-gray-800"><i class="fa-solid fa-check text-pink-500 mr-1"></i> Skills • Insights • Mentorship</p>
                                    <p class="text-blue-900 font-bold text-xs mt-3">Apply Now | Ibadan <i class="fa-solid fa-arrow-right ml-1"></i></p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <span class="text-xs text-green-500 font-bold"><i class="fa-solid fa-check-circle mr-1"></i> High Authority</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. CTA -->
    <section class="py-24 bg-white text-center">
        <div class="container mx-auto px-6 max-w-2xl">
            <h2 class="text-4xl font-serif font-bold text-blue-900 mb-6">Let's Write This Story Together.</h2>
            <p class="text-gray-600 mb-10 text-lg leading-relaxed">
                Generic CVs don't build legacies. Partnerships do. <br>
                We are ready to align with your vision. Let's move Mochelle Fashion School from "active" to "iconic."
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <!-- Actionable WhatsApp Link -->
                <a href="https://wa.me/2349127040327?text=Hello%20De%20Kompany,%20I%20have%20reviewed%20your%20proposal%20for%20Mochelle%20Fashion%20School.%20Let's%20discuss%20the%20next%20steps." target="_blank" class="px-8 py-4 bg-blue-900 text-white font-bold rounded-lg hover:bg-blue-800 transition shadow-xl transform hover:-translate-y-1 text-lg flex items-center justify-center gap-3">
                    <i class="fa-brands fa-whatsapp text-2xl"></i> Begin Partnership
                </a>
            </div>
            
            <div class="mt-12 pt-12 border-t border-gray-100">
                <p class="text-gray-500 text-sm mb-4">Would you like to read the full technical breakdown?</p>
                <!-- Download Proposal Button -->
                <a href="https://getonlinestudio.com/insights/wp-content/uploads/2026/01/MochelleFashionSchoolProposal.pdf" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-50 hover:border-gray-300 transition shadow-md transform hover:-translate-y-1 text-lg">
                    <i class="fa-solid fa-file-pdf text-red-500"></i> Download Full Proposal PDF
                </a>
            </div>
            
            <p class="mt-8 text-xs text-gray-400 tracking-widest uppercase">Prepared Exclusively for Mochelle Fashion School by De Kompany</p>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>