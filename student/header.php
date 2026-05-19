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
    <title>De Kompany | Academic Sector</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg" type="image/jpeg">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;800&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Royal Blue Theme */
        .bg-royal-dark { background-color: #0a1128; } /* Deep Royal Blue */
        
        .page-transition {
            animation: fadeIn 0.8s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Subtle Scanline for Texture */
        .scanline::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(234, 179, 8, 0.02) 51%);
            background-size: 100% 4px;
            pointer-events: none;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-blue-950 text-blue-50 font-sans selection:bg-yellow-500 selection:text-blue-950">

    <div class="scanline fixed inset-0 pointer-events-none z-0"></div>
    
    <!-- Royal Nav -->
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
                    <button onclick="toggleStudentMenu()" class="md:hidden text-yellow-400 hover:text-white">
                        <i class="fa-solid fa-bars text-xl"></i>
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

    <script>
        function toggleStudentMenu() {
            const menu = document.getElementById('student-mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleChat() {
            if (typeof window.LiveChatWidget !== "undefined") {
                window.LiveChatWidget.call('maximize');
            } else {
                console.log("Chat toggled");
                // Fallback if chat widget isn't loaded yet or scroll to contact
                const contactSection = document.getElementById('student-contact');
                if(contactSection) contactSection.scrollIntoView({behavior: 'smooth'});
            }
        }
    </script>