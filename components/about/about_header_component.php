<nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Center Logo for HQ Feel -->
                <div class="flex items-center gap-3 cursor-pointer" onclick="window.location.href='/about/index.php'">
                    <img src="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg" class="w-10 h-10 rounded-full border border-gray-200">
                    <div class="flex flex-col">
                        <span class="font-serif font-bold text-lg text-blue-950 leading-none">De Kompany</span>
                        <span class="text-[10px] text-yellow-600 uppercase tracking-widest font-bold">Global Headquarters</span>
                    </div>
                </div>

                <!-- Desktop HQ Menu -->
                <div class="hidden md:flex gap-8 text-sm font-medium text-gray-600 items-center">
                    <!-- Links to other pages within /about/ -->
                    <a href="/about/index.php" class="nav-link hover:text-blue-900 transition">The Firm</a>
                    <a href="/about/team.php" class="nav-link hover:text-blue-900 transition">Leadership</a>
                    <a href="/about/pov.php" class="nav-link hover:text-blue-900 transition">Thoughts</a>

                    <!-- Sector Splitter -->
                    <div class="h-4 w-px bg-gray-300 mx-2"></div>

                    <!-- Links Jumping OUT to other folders -->
                    <a href="/business/index.php" class="hover:text-blue-900 transition flex items-center gap-2 group">
                        <span class="w-2 h-2 rounded-full bg-blue-900 group-hover:scale-125 transition"></span>
                        Business
                    </a>
                    <a href="/student/index.php" class="hover:text-blue-900 transition flex items-center gap-2 group">
                        <span class="w-2 h-2 rounded-full bg-yellow-500 group-hover:scale-125 transition"></span>
                        Academic
                    </a>
                </div>

                <div class="flex items-center gap-4">
                     <a href="mailto:contact@dekompany.com" class="hidden md:inline-block px-6 py-2 border border-blue-950 text-blue-950 rounded hover:bg-blue-950 hover:text-white transition text-sm font-medium">
                        Contact HQ
                    </a>

                    <!-- Mobile Hamburger -->
                    <button onclick="toggleMobileMenu()" class="md:hidden text-blue-950 focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="md:hidden border-t border-gray-100 mt-4">
                <div class="flex flex-col gap-4 py-6 text-sm font-medium text-gray-600">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">HQ Navigation</span>
                    <a href="/about/index.php" class="hover:text-blue-900 transition pl-4 border-l-2 border-transparent hover:border-blue-900">The Firm (About)</a>
                    <a href="/about/team.php" class="hover:text-blue-900 transition pl-4 border-l-2 border-transparent hover:border-blue-900">Leadership</a>
                    <a href="/about/pov.php" class="hover:text-blue-900 transition pl-4 border-l-2 border-transparent hover:border-blue-900">Thoughts & POV</a>

                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 mt-4">Sector Switch</span>
                    <a href="/business/index.php" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                        <span class="w-2 h-2 rounded-full bg-blue-900"></span>
                        <span class="text-blue-900 font-bold">Go To Business Strategy</span>
                    </a>
                    <a href="/student/index.php" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-yellow-50 transition">
                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                        <span class="text-yellow-700 font-bold">Go To Academic Sector</span>
                    </a>

                    <a href="mailto:contact@dekompany.com" class="mt-4 w-full text-center py-3 border border-blue-950 text-blue-950 rounded font-bold">Contact HQ</a>
                </div>
            </div>
        </div>
    </nav>