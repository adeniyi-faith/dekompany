<nav class="border-b border-white/10 bg-blue-950/95 backdrop-blur-md p-4 sticky top-0 z-50 w-full shadow-lg">
        <div class="container mx-auto">
            <div class="flex flex-row justify-between items-center">
                <div class="flex items-center gap-3 cursor-pointer" onclick="window.location.href='/'">
                    <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg" class="w-10 h-10 rounded-full border border-yellow-500/30">
                    <div class="flex flex-col">
                        <span class="font-serif font-bold text-lg text-white leading-none">De Kompany</span>
                        <span class="text-[10px] text-yellow-400 uppercase tracking-widest">Academic Sector</span>
                    </div>
                </div>

                <div class="hidden md:flex gap-8 text-sm font-medium text-blue-200">
                    <a href="#student-services" class="hover:text-yellow-400 transition-colors">Services</a>
                    <a href="#student-lounge" class="hover:text-yellow-400 transition-colors">Student Lounge</a>
                    <a href="#student-contact" class="hover:text-yellow-400 transition-colors">Contact</a>
                </div>

                <div class="flex items-center gap-4">
                    <button onclick="toggleChat()" class="hidden md:block px-5 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-500 transition text-sm font-medium shadow-lg shadow-yellow-600/20">
                        Ask Coach
                    </button>
                    <button onclick="toggleStudentMenu()" class="md:hidden text-yellow-400 hover:text-white rounded focus-visible:ring-2 focus-visible:ring-yellow-400 outline-none" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="student-mobile-menu">
                        <i class="fa-solid fa-bars text-xl" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="student-mobile-menu" class="hidden md:hidden mt-4 border-t border-white/10 pt-4 flex flex-col gap-4 text-sm">
                <a href="#student-services" class="text-blue-200 hover:text-yellow-400">Services</a>
                <a href="#student-lounge" class="text-blue-200 hover:text-yellow-400">Student Lounge</a>
                <a href="#student-contact" class="text-blue-200 hover:text-yellow-400">Contact</a>
                <button onclick="toggleChat()" class="w-full text-center px-5 py-3 bg-yellow-600 text-white rounded hover:bg-yellow-500 transition text-sm font-medium">
                    Ask Coach
                </button>
            </div>
        </div>
    </nav>