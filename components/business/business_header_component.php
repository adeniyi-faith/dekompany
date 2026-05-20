<nav class="bg-white/95 backdrop-blur border-b border-gray-200 sticky top-0 z-50 shadow-sm w-full">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3 cursor-pointer" onclick="window.location.href='/'">
                    <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg" class="w-10 h-10 rounded-full shadow-sm border border-gray-100">
                    <div class="flex flex-col">
                        <span class="text-xl font-bold tracking-tight text-blue-900 font-serif leading-none">De Kompany</span>
                        <span class="text-[10px] text-gray-500 uppercase tracking-widest">Business Sector</span>
                    </div>
                </div>

                <div class="hidden md:flex gap-8 text-sm font-medium text-gray-600">
                    <a href="#about-us" class="hover:text-blue-900 transition">About Us</a>
                    <a href="#business-expertise" class="hover:text-blue-900 transition">Services</a>
                    <a href="#portfolio" class="hover:text-blue-900 transition">Portfolio</a>
                    <a href="#business-insights" class="hover:text-blue-900 transition">Insights</a>
                    <a href="#business-contact" class="hover:text-blue-900 transition">Contact</a>
                </div>

                <div class="flex items-center gap-4">
                    <button onclick="toggleChat()" class="hidden md:block px-5 py-2 bg-blue-900 text-white rounded hover:bg-blue-800 transition text-sm font-medium shadow-lg shadow-blue-900/20">
                        Consult AI
                    </button>
                    <button onclick="toggleMobileMenu()" class="md:hidden text-gray-600 hover:text-blue-900 rounded focus-visible:ring-2 focus-visible:ring-blue-900 outline-none" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-menu">
                        <i class="fa-solid fa-bars text-xl" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t border-gray-100 pt-4 flex flex-col gap-4 animate-[fadeIn_0.3s_ease-out]">
                <a href="#about-us" class="text-gray-600 hover:text-blue-900 font-medium">About Us</a>
                <a href="#business-expertise" class="text-gray-600 hover:text-blue-900 font-medium">Services</a>
                <a href="#portfolio" class="text-gray-600 hover:text-blue-900 font-medium">Portfolio</a>
                <a href="#business-insights" class="text-gray-600 hover:text-blue-900 font-medium">Insights</a>
                <a href="#business-contact" class="text-gray-600 hover:text-blue-900 font-medium">Contact</a>
                <button onclick="toggleChat()" class="w-full text-center px-5 py-3 bg-blue-900 text-white rounded hover:bg-blue-800 transition text-sm font-medium">
                    Consult AI
                </button>
            </div>
        </div>
    </nav>