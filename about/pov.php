<?php 
// SEO & Social Optimization
$pageTitle = "Da Ti E Mon | The 2026 Trend Series";
$pageDesc = "Sabi Your Own. Sabi Your Blood. Know Your Circle. Read the viral manifesto on People Topology and the architecture of human connection.";
// Using the editorial image for sharing
$pageImage = "https://getonlinestudio.com/insights/wp-content/uploads/2026/01/IMG-20260118-WA0061.jpg";

include 'header.php'; 
?>

<style>
    /* Editorial Typography */
    .font-display { font-family: 'Playfair Display', serif; }
    
    /* Elegant Text Gradient */
    .text-gradient-gold {
        background: linear-gradient(135deg, #fce7f3 0%, #eab308 50%, #ca8a04 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    /* Image Reveal Effect */
    .reveal-image-container {
        position: relative;
        overflow: hidden;
        height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    
    /* Text Highlighter Effect */
    .highlight-gold {
        background: linear-gradient(120deg, rgba(234, 179, 8, 0.2) 0%, rgba(234, 179, 8, 0.2) 100%);
        background-repeat: no-repeat;
        background-size: 100% 40%;
        background-position: 0 90%;
        transition: background-size 0.3s ease;
    }
    .highlight-gold:hover { background-size: 100% 100%; }

    /* Custom Scrollbar for this page */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #0a1128; }
    ::-webkit-scrollbar-thumb { background: #ca8a04; border-radius: 4px; }
    
    .drop-cap:first-letter {
        float: left;
        font-size: 4rem;
        line-height: 0.8;
        font-weight: bold;
        color: #1e3a8a;
        margin-right: 0.5rem;
    }
</style>

<main class="bg-white text-gray-900 selection:bg-yellow-500 selection:text-white">

    <!-- 1. The Hook (Refined & Professional Hero) -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-blue-950 text-white">
        <!-- Background Image with Gradient Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://getonlinestudio.com/insights/wp-content/uploads/2026/01/IMG-20260118-WA0061.jpg" class="w-full h-full object-cover opacity-40 scale-105">
            <!-- Gradient to ensure text readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-950/70 to-blue-900/30 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-blue-950/50 to-transparent"></div>
        </div>

        <div class="container relative z-10 px-6 text-center max-w-5xl mx-auto pt-20 pb-10">
            <!-- Badge -->
            <div class="mb-8">
                <span class="inline-block py-1 px-4 border border-yellow-500/40 rounded-full text-yellow-400 text-xs font-bold tracking-[0.2em] uppercase backdrop-blur-sm bg-blue-950/30">
                    The 2026 Trend Series
                </span>
            </div>

            <!-- Main Title -->
            <h1 class="text-7xl md:text-9xl font-display font-bold leading-none mb-4 tracking-tight drop-shadow-2xl">
                DA TI <br />
                <span class="text-gradient-gold">E MON!</span>
            </h1>

            <!-- Elegant Divider -->
            <div class="flex items-center justify-center gap-4 my-8 text-gray-400 text-xs md:text-sm font-light tracking-[0.2em] uppercase opacity-80">
                <span>Sabi Your Own</span>
                <span class="text-yellow-500 text-lg">•</span>
                <span class="text-white font-medium">Know Your Circle</span>
                <span class="text-yellow-500 text-lg">•</span>
                <span>Sabi Your Blood</span>
            </div>

            <!-- Intro Text (Cleaned up from "Rowdy" box) -->
            <div class="max-w-2xl mx-auto mt-10 space-y-6">
                <p class="font-serif italic text-blue-100 text-xl md:text-2xl leading-relaxed">
                    “Before you decide in your subconscious mind if you want to read this… Egbon abeg chill one minute, calm boss.”
                </p>
                <p class="text-sm font-bold text-yellow-500/90 uppercase tracking-widest">
                    Wetin make I offer you? Water, whiskey or wine?
                </p>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce opacity-50">
                <span class="text-[10px] uppercase tracking-widest block mb-2 text-gray-400">Scroll</span>
                <i class="fa-solid fa-arrow-down-long text-white text-xl"></i>
            </div>
        </div>
    </section>

    <!-- 2. The Editorial Body -->
    <section class="py-24 relative">
        <div class="container mx-auto px-6 max-w-4xl">
            <h3 class="font-display text-3xl text-center mb-12 italic text-blue-900">First of all:</h3>
            
            <!-- Salutations -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16 border-b border-gray-100 pb-12">
                <div class="p-6 bg-blue-50/50 rounded-xl border border-blue-100 hover:shadow-lg transition group">
                    <h4 class="font-bold text-blue-900 text-xs uppercase mb-2 tracking-widest group-hover:text-blue-600 transition">To My Guys</h4>
                    <p class="font-serif italic text-gray-600">The Fine Correct Niggas;<br><strong class="text-blue-950">Alaye Tuale! Konibaje</strong></p>
                </div>
                <div class="p-6 bg-pink-50/50 rounded-xl border border-pink-100 hover:shadow-lg transition group">
                    <h4 class="font-bold text-pink-900 text-xs uppercase mb-2 tracking-widest group-hover:text-pink-600 transition">To The Pretty Damsels</h4>
                    <p class="font-serif italic text-gray-600">All My Sexy Ladies;<br><strong class="text-pink-950">Hello darling, how are you doing?</strong></p>
                </div>
                <div class="p-6 bg-yellow-50/50 rounded-xl border border-yellow-100 hover:shadow-lg transition group">
                    <h4 class="font-bold text-yellow-900 text-xs uppercase mb-2 tracking-widest group-hover:text-yellow-600 transition">To The Elders</h4>
                    <p class="font-serif italic text-gray-600">Our Forever Young;<br><strong class="text-yellow-950">Maximum respect, Daddy and Mummy (PBUY)</strong></p>
                </div>
            </div>

            <div class="prose prose-lg prose-blue mx-auto">
                <p class="drop-cap">
                    Based on the basis of the base, our New Year, 2026 Nigeria trend series (cruise) started this January with a strong slang. Actually, a stronger slang than the likes of <em>Sope-Purrr</em>, <em>Whobimostor</em>, <em>Involve Me</em>, <em>Clocked It</em>, amongst many others.
                </p>
                <p>
                    The new trend touched down as a powerful mantra, an authoritative slogan, a watchword, and a routine daily reminder.
                </p>
                
                <h3 class="text-center font-bold text-blue-950 text-2xl my-8">Let He That Has Ears...</h3>
                
                <blockquote class="bg-gray-50 border-l-8 border-blue-900 p-8 my-8 rounded-r-xl">
                    <p class="font-serif text-xl italic text-gray-700">“If your circle of friends can’t pull up 10 million in a day, I can’t rate you for real”.</p>
                    <footer class="text-sm font-bold text-blue-900 mt-4">— An X User</footer>
                </blockquote>

                <p>
                    Subsequently on the same street of X are other dozens of tweets centred on the idea <strong>“Circle of Friends must have Quality and not Quantity”.</strong>
                </p>
                
                <p class="text-sm font-bold text-red-500 uppercase tracking-wide bg-red-50 p-4 rounded text-center my-8 border border-red-100">
                    (Spoiler alert: this is not a surface level friendship talk. Are you a lover of truth?)
                </p>

                <p>
                    Most people think of friends emotionally, but circles of friends behave in <span class="highlight-gold px-1 font-bold">Topology</span>. Not all friends occupy the same position, even if we pretend they do.
                </p>
                
                <p>
                    Many circles are formed out of sentiment, geography, routine, direction, and growth rate, but only the Circles built on <strong>alignment</strong> will survive distance, and time when proximity expire and conditions change.
                </p>
                
                <p>
                    It is a known fact that your circle of friends influences your behaviour. It impacts how you talk, what you tolerate, and what you attend your values with.
                </p>
            </div>
        </div>
    </section>

    <!-- 3. Visual Break: The Architecture of Connection -->
    <div class="reveal-image-container" style="background-image: url('https://getonlinestudio.com/insights/wp-content/uploads/2026/01/IMG-20260118-WA0062.jpg');">
        <div class="absolute inset-0 bg-blue-900/60 mix-blend-multiply"></div>
        <div class="relative z-10 text-center p-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl max-w-3xl mx-4 shadow-2xl">
            <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6">Engine or Anchor?</h2>
            <p class="text-blue-100 text-xl font-light italic leading-relaxed">
                "Your circle of friends basically mirror your self-relationship, which is how you treat yourself what you let slide internally and the standards you avoid setting."
            </p>
        </div>
    </div>

    <!-- 4. The Deep Dive -->
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="flex flex-col md:flex-row gap-16 items-start">
                <div class="md:w-1/3">
                    <div class="bg-white p-8 rounded-2xl shadow-xl border-t-8 border-yellow-500 relative overflow-hidden">
                        <span class="block text-[10rem] text-gray-50 font-bold absolute -top-10 -right-10 z-0 leading-none">?</span>
                        <h3 class="font-bold text-2xl text-blue-950 relative z-10 mb-4">The Warning</h3>
                        <p class="text-base text-gray-600 relative z-10 leading-relaxed font-medium">
                            Your circle is either your engine or anchor. Healthy circles challenge you to want to do more, to be more and get all. Unhealthy circles neutralize you!
                        </p>
                    </div>
                    <div class="mt-8 text-center">
                         <span class="inline-block px-4 py-2 bg-blue-900 text-white text-xs font-bold rounded-full">#THOUGHTLEADERSHIP</span>
                    </div>
                </div>
                
                <div class="md:w-2/3 prose prose-lg prose-blue">
                    <h3 class="font-display text-3xl font-bold text-blue-950 mb-6">The System of Limits</h3>
                    <p>
                        The circle of friends is not just a social idea. It is a system which structure, limits, dynamics and consequences. A key thing to always remember is <strong>“Not every circle is meant to be permanent.”</strong>
                    </p>
                    <p>
                        Letting circles be seasonal is not betrayal. It is honest evaluation, of both yourself and your values. Circle is not what we choose once; we re-choose it every day through behaviour.
                    </p>
                    <p>
                        In conclusion brethren, your circle of friends is not a reflection of who you like, rather, it is a reflection of who you are becoming, what values you can add and who you are willing to disappoint. Not everyone in your circle is meant to go where you’re going, understand what you’re building or benefits from your good. 
                    </p>
                    <p class="font-bold text-red-600">
                        The most dangerous circles are not abusive ones. They are comfortable circles.
                    </p>
                    <div class="bg-blue-900 text-white p-4 text-center rounded font-bold uppercase tracking-widest my-8">
                        Choose Your Circle Wisely!
                    </div>

                    <h3 class="font-display text-2xl font-bold text-blue-950 mt-12 mb-4">"Not everyone carries the same Emotional Load"</h3>
                    <p>
                        Every man is often secretly oppressed by the role he has to play; by always having to be responsible, to be in control and to be rational.
                    </p>
                    <p>
                        Most people have dreams in their youth that get shattered or worn down with age. They find themselves disappointed by people, events and reality, that didn’t align with their youthful ideals.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. People Topology & Science -->
    <section class="py-24 bg-white relative overflow-hidden">
         <div class="absolute top-0 left-0 w-full h-full opacity-5 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
         
         <div class="container mx-auto px-6 max-w-4xl relative z-10">
            <h2 class="text-4xl md:text-5xl font-display font-bold text-center text-blue-950 mb-12">People Topology</h2>
            
            <div class="bg-gray-50 p-8 md:p-12 rounded-3xl border border-gray-100 mb-16">
                <p class="text-lg leading-relaxed text-gray-700 text-center">
                    Having quality in your circle of friends directly relates to how the human body works together; each part having its specific function. <br><br>
                    <strong>People Topology plainly is how people are arranged, connected and enabled to work, not who reports to whom; it is simply the architecture of human interaction.</strong>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <p class="text-gray-600">
                        Everything that exists, seen and unseen is connected and nothing stands alone. Every thought, every action, and every event is linked, each influencing and being influenced by something else.
                    </p>
                    <div class="border-l-4 border-yellow-500 pl-4">
                        <p class="font-serif italic text-blue-900">
                            "If you want to find the secrets of the universe, think in terms of energy, frequency, and vibration."
                        </p>
                         <p class="text-xs text-gray-400 mt-2">— Nikola Tesla</p>
                    </div>
                </div>
                <div>
                      <p class="text-gray-600">
                        Everything that exists, every creature, every inanimate object, every thought, feeling, and desire, possesses its own unique vibration. This means that every particle in the universe is in constant motion, continuously emitting and responding to energy.
                      </p>
                </div>
            </div>

            <div class="mt-16 text-center">
                <p class="text-2xl font-serif text-blue-950 mb-6">
                    Self-reflect by asking yourself if your circles of friends are placed where their thinking style matches the problem.
                </p>
                <div class="inline-block px-8 py-4 bg-yellow-500 text-white font-bold text-lg rounded-full shadow-lg transform rotate-[-2deg] hover:rotate-0 transition">
                    Always ensure to fill your circle with high-frequency vibrant people.
                </div>
                
                <div class="mt-12 space-y-2">
                    <p class="text-3xl font-bold text-blue-900">Feel me?</p>
                    <p class="text-4xl font-bold text-yellow-500">You better!</p>
                    <p class="text-xs text-gray-400 mt-4 italic">(...if you are still here with us- in this over 700 worded masterpiece, clock it ejeh!)</p>
                </div>
            </div>
         </div>
    </section>

    <!-- 6. Conclusion: Gbemidebe Level -->
    <section class="py-24 bg-blue-950 text-white text-center relative">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
        
        <div class="container mx-auto px-6 max-w-3xl relative z-10">
            <h2 class="text-5xl font-display font-bold mb-8 text-yellow-500">On A More Gbemidebe Level</h2>
            
            <p class="text-xl leading-relaxed mb-8">
                If I can be of value to you, you are of value to me. Iron sharpens iron, and as my people do say;
            </p>
            
            <blockquote class="text-2xl font-serif italic text-blue-200 mb-10 border-y border-blue-800 py-8">
                “Agbajo Owo la fin So’ya, Igi kan ole da Igbo se... Gbe kin Gbe, Je kin Je loni Ile Aiye”.
            </blockquote>
            
            <p class="text-lg mb-12">
                You need People but you have to know <span class="font-bold text-yellow-400 text-2xl">Your People</span>; the overall concept meaning of People Topology.
            </p>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 md:p-12 mb-12 border border-white/20 hover:border-yellow-500/50 transition duration-300">
                <h3 class="font-bold text-2xl mb-4">To-Me-To-You</h3>
                <p class="mb-6">With heart like gold and compassion of the Good Samaritan, based on the base...</p>
                <p class="font-bold text-lg mb-8 text-yellow-400">Kindly help review this survey on the undergraduate life of university students.</p>
                
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSesP9_3gUz811syg3CAlwnwUVwD9woqVP5e7isW9d8PviXRjw/viewform?usp=publish-editor" target="_blank" class="inline-flex items-center gap-3 px-10 py-4 bg-white text-blue-950 font-bold rounded-full hover:bg-yellow-400 hover:text-blue-950 transition shadow-xl transform hover:-translate-y-1">
                    <span>Take The Survey</span> <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <p class="text-sm text-gray-400 italic mb-16">
                (Should your heart be like stone and you skipped the link, nice one, omo lile! Sha drop a <strong class="text-white">To-You-To-Us</strong> in comment section).
            </p>

            <div class="space-y-4">
                <p class="text-2xl font-serif">Peace Be Unto You</p>
                <p class="font-bold tracking-[0.3em] text-yellow-500 text-lg">DE KOMPANY 2026.</p>
            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>