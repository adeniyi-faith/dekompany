<?php include 'header.php'; ?>

    <main class="container mx-auto px-6 py-10 md:py-16 pb-32">
        <!-- Hero -->
        <div class="page-transition flex flex-col md:flex-row items-center gap-12 mb-20">
            <div class="md:w-1/2 text-center md:text-left">
                <span class="text-blue-900 font-bold tracking-wide uppercase text-xs mb-3 block">The Knowledge Architecture Firm</span>
                <h1 class="text-4xl md:text-6xl font-serif font-bold text-blue-900 mb-6 leading-tight">Strategic Intelligence for Modern Business.</h1>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg mx-auto md:mx-0">
                    We don't just write. We structure your ideas into measurable assets. From brand strategy to high-level corporate documentation.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <button onclick="toggleChat()" class="px-8 py-3 bg-blue-900 hover:bg-blue-800 text-white rounded shadow-lg shadow-blue-900/30 transition font-medium active:scale-95">
                        Start Strategy Session
                    </button>
                    <a href="#portfolio" class="px-8 py-3 bg-white border border-gray-300 hover:border-gray-400 text-gray-700 rounded transition font-medium active:scale-95 flex items-center justify-center">
                        Our Portfolio
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 relative w-full">
                <div class="glass-panel p-6 md:p-8 rounded-xl relative z-10 border-t-4 border-blue-900 shadow-2xl">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-blue-900 text-lg">Performance Metrics</h3>
                        <span class="text-blue-900 font-bold bg-blue-50 px-2 py-1 rounded text-sm">+127% Growth</span>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between text-xs text-gray-500 mb-1"><span>Brand Clarity</span><span>98%</span></div>
                            <div class="h-2 bg-gray-100 rounded overflow-hidden"><div class="h-full bg-blue-900 w-[98%]"></div></div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs text-gray-500 mb-1"><span>Market Positioning</span><span>85%</span></div>
                            <div class="h-2 bg-gray-100 rounded overflow-hidden"><div class="h-full bg-blue-700 w-[85%]"></div></div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs text-gray-500 mb-1"><span>Content ROI</span><span>110%</span></div>
                            <div class="h-2 bg-gray-100 rounded overflow-hidden"><div class="h-full bg-blue-500 w-[100%]"></div></div>
                        </div>
                    </div>
                </div>
                <!-- Decor element -->
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-blue-50 rounded-full -z-0 blur-3xl"></div>
                <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-blue-50 rounded-full -z-0 blur-3xl"></div>
            </div>
        </div>

        <!-- The Knowledge Architecture Approach -->
        <div id="about-us" class="page-transition mb-24 scroll-mt-24">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-serif font-bold text-blue-900 mb-4">The Knowledge Architecture Approach</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We move beyond traditional consulting. We architect your business intelligence into three distinct phases.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-gray-50 rounded-lg hover:bg-white hover:shadow-lg transition duration-300 border border-transparent hover:border-blue-100">
                    <div class="w-12 h-12 bg-blue-100 text-blue-900 rounded-lg flex items-center justify-center mb-6 text-xl font-bold">1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Discover</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">We audit your current brand position, market gaps, and internal capabilities to find the hidden value.</p>
                </div>
                <div class="p-8 bg-gray-50 rounded-lg hover:bg-white hover:shadow-lg transition duration-300 border border-transparent hover:border-blue-100">
                    <div class="w-12 h-12 bg-blue-900 text-white rounded-lg flex items-center justify-center mb-6 text-xl font-bold">2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Design</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">We structure the solution. Whether it's a 50-page business plan or a brand identity system.</p>
                </div>
                <div class="p-8 bg-gray-50 rounded-lg hover:bg-white hover:shadow-lg transition duration-300 border border-transparent hover:border-blue-100">
                    <div class="w-12 h-12 bg-blue-800 text-white rounded-lg flex items-center justify-center mb-6 text-xl font-bold">3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Deliver</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">We execute with precision. Providing you with the assets you need to scale and secure funding.</p>
                </div>
            </div>
        </div>

        <!-- Services Grid -->
        <div id="business-expertise" class="page-transition mb-24 scroll-mt-24">
             <div class="flex items-center gap-4 mb-8">
                <h2 class="text-2xl font-bold text-blue-900 font-serif">Core Expertise</h2>
                <div class="h-px bg-gray-200 flex-grow"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                 <div class="p-6 border border-gray-100 rounded-lg hover:shadow-md transition">
                    <h3 class="font-bold text-gray-900 mb-2">Business Documentation</h3>
                    <p class="text-sm text-gray-600">Proposals, Company Profiles, Business Plans.</p>
                 </div>
                 <div class="p-6 border border-gray-100 rounded-lg hover:shadow-md transition">
                    <h3 class="font-bold text-gray-900 mb-2">Brand Strategy</h3>
                    <p class="text-sm text-gray-600">Positioning, Narrative Development, Identity.</p>
                 </div>
                 <div class="p-6 border border-gray-100 rounded-lg hover:shadow-md transition">
                    <h3 class="font-bold text-gray-900 mb-2">Corporate Writing</h3>
                    <p class="text-sm text-gray-600">Annual Reports, Speeches, Stakeholder Comms.</p>
                 </div>
            </div>
        </div>

        <!-- Portfolio -->
        <div id="portfolio" class="page-transition bg-blue-900 rounded-2xl p-8 md:p-16 text-white mb-24 relative overflow-hidden scroll-mt-24">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <h2 class="text-3xl md:text-4xl font-serif font-bold mb-6">Why De Kompany?</h2>
                    <p class="text-blue-100 mb-8 leading-relaxed">In a world of noise, clarity is power. We don't just provide services; we provide the strategic edge that separates market leaders from the rest.</p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check-circle text-blue-300"></i> <span>Data-Backed Strategies</span></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check-circle text-blue-300"></i> <span>Confidentiality Guaranteed</span></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check-circle text-blue-300"></i> <span>Global Standard Documentation</span></li>
                    </ul>
                </div>
                <div class="md:w-1/2 grid grid-cols-2 gap-4">
                    <div class="bg-white/10 p-6 rounded-lg backdrop-blur-sm">
                        <div class="text-3xl font-bold text-white mb-1">500+</div>
                        <div class="text-xs text-blue-200">Projects Completed</div>
                    </div>
                    <div class="bg-white/10 p-6 rounded-lg backdrop-blur-sm">
                        <div class="text-3xl font-bold text-white mb-1">98%</div>
                        <div class="text-xs text-blue-200">Client Retention</div>
                    </div>
                    <div class="bg-white/10 p-6 rounded-lg backdrop-blur-sm">
                        <div class="text-3xl font-bold text-white mb-1">24h</div>
                        <div class="text-xs text-blue-200">Response Time</div>
                    </div>
                    <div class="bg-white/10 p-6 rounded-lg backdrop-blur-sm">
                        <div class="text-3xl font-bold text-white mb-1">100%</div>
                        <div class="text-xs text-blue-200">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insights -->
        <div id="business-insights" class="page-transition scroll-mt-24">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <span class="text-blue-900 font-bold uppercase text-xs tracking-wider">The Boardroom</span>
                    <h2 class="text-3xl font-serif font-bold text-gray-900 mt-2">Latest Strategic Insights</h2>
                </div>
                <a href="#" class="hidden md:inline-flex items-center text-blue-900 font-bold hover:text-blue-700 transition">View All <i class="fa-solid fa-arrow-right ml-2"></i></a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="blog-card bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-lg">
                    <div class="h-48 bg-gray-200 relative">
                         <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover">
                         <div class="absolute top-4 left-4 bg-white px-3 py-1 text-xs font-bold text-blue-900 rounded shadow">STRATEGY</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-800 cursor-pointer">Navigating Market Saturation in 2025</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">How to pivot your brand narrative when the market feels overcrowded.</p>
                        <a href="#" class="text-blue-600 text-sm font-semibold hover:underline">Read Analysis</a>
                    </div>
                </div>

                <div class="blog-card bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-lg">
                    <div class="h-48 bg-gray-200 relative">
                         <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover">
                         <div class="absolute top-4 left-4 bg-white px-3 py-1 text-xs font-bold text-blue-900 rounded shadow">FUNDING</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-800 cursor-pointer">The Investor Deck Checklist</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">What VCs are actually looking for in your slide deck (It's not just numbers).</p>
                        <a href="#" class="text-blue-600 text-sm font-semibold hover:underline">Read Analysis</a>
                    </div>
                </div>

                <div class="blog-card bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-lg">
                    <div class="h-48 bg-gray-200 relative">
                         <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover">
                         <div class="absolute top-4 left-4 bg-white px-3 py-1 text-xs font-bold text-blue-900 rounded shadow">LEADERSHIP</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-800 cursor-pointer">Leadership in the Age of AI</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">Balancing automated efficiency with human creativity in your corporate culture.</p>
                        <a href="#" class="text-blue-600 text-sm font-semibold hover:underline">Read Analysis</a>
                    </div>
                </div>
            </div>
        </div>

    <?php include 'footer.php'; ?>