<?php
// 1. Dynamic SEO Logic
// If variables are not set by the page, these defaults are used.
$metaTitle = isset($pageTitle) ? $pageTitle . " | De Kompany" : "De Kompany | Global Headquarters";
$metaDesc = isset($pageDesc) ? $pageDesc : "Structuring intelligence for the modern world. We operate at the intersection of corporate strategy, academic rigor, and digital innovation.";
$metaImage = isset($pageImage) ? $pageImage : "https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg"; // Default Brand Logo
$currentUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DRSB4JLYKS"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-DRSB4JLYKS');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title><?php echo htmlspecialchars($metaTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <link rel="canonical" href="<?php echo $currentUrl; ?>">

    <!-- Open Graph / Facebook / WhatsApp (Crucial for Sharing) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $currentUrl; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($metaTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <meta property="og:image" content="<?php echo $metaImage; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo $currentUrl; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($metaTitle); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <meta property="twitter:image" content="<?php echo $metaImage; ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" href="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg" type="image/jpeg">

    <!-- Styles & Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;800&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        .page-transition { animation: fadeIn 0.8s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        /* The Golden Bridge Link Hover */
        .nav-link { position: relative; }
        .nav-link::after {
            content: ''; position: absolute; width: 0; height: 1px; bottom: -2px; left: 0;
            background-color: #ca8a04; /* Yellow-600 */
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }

        /* Mobile Menu Animation */
        #mobile-menu {
            transition: max-height 0.4s ease-in-out, opacity 0.4s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        #mobile-menu.open {
            max-height: 500px;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-white text-slate-900 font-sans selection:bg-blue-900 selection:text-white">

    <!-- Global HQ Nav -->
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

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('open');
        }
    </script>