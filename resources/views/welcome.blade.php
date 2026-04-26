<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PawResort - Welcome</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-white font-['Inter']">

    <nav class="flex items-center justify-between px-16 py-8">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-[#0F172A] rounded-full flex items-center justify-center shadow-md">
                <span class="text-white font-bold text-xl">P</span>
            </div>
            <span class="text-2xl font-extrabold text-[#0F172A] tracking-tight">PawResort</span>
        </div>
        
        <div class="hidden md:flex items-center gap-10 font-semibold text-gray-500">
            <a href="#" class="text-[#0F172A]">Home</a>
            <a href="#" class="hover:text-blue-600 transition">About</a>
            <a href="#" class="hover:text-blue-600 transition">Contact</a>
            <div class="ml-4 flex gap-3">
                <a href="{{ route('login') }}" class="px-7 py-2.5 border-2 border-[#0F172A] text-[#0F172A] rounded-full hover:bg-gray-50 transition">Login</a>
                <a href="{{ route('register') }}" class="px-7 py-2.5 bg-[#FACC15] text-[#0F172A] rounded-full font-bold hover:bg-yellow-500 transition shadow-sm">Sign Up</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-16 pt-10 pb-24 grid grid-cols-1 md:grid-cols-2 items-center gap-16">
        
        <div class="space-y-6">
            <div class="inline-flex items-center px-4 py-1.5 bg-blue-50 border border-blue-100 rounded-full">
                <span class="text-blue-600 text-sm font-bold uppercase tracking-wider">🐾 Best Pet Boarding</span>
            </div>
            
            <h1 class="text-7xl lg:text-8xl font-extrabold text-[#0F172A] leading-[0.95] tracking-tighter">
                Your Pet's <br>
                <span class="text-blue-600 italic">Second Home</span> <br>
                Away from Home.
            </h1>

            <p class="text-xl text-gray-500 max-w-lg leading-relaxed pt-4">
                PawResort adalah platform reservasi penitipan hewan berbasis web yang mendigitalisasi proses pemesanan kandang secara transparan dan terstruktur[cite: 9].
            </p>
            
            <div class="flex items-center gap-5 pt-8">
                <a href="{{ route('register') }}" class="px-12 py-5 bg-[#0F172A] text-white text-xl font-bold rounded-2xl hover:scale-105 transition-all shadow-2xl">
                    Booking Now!
                </a>
                <button class="group p-5 border-2 border-gray-100 rounded-2xl hover:bg-gray-50 transition">
                    <svg class="w-7 h-7 text-gray-400 group-hover:text-[#0F172A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>

        <div class="relative h-[550px] flex items-center justify-center">
            <div class="absolute w-[120%] h-[120%] bg-blue-50 rounded-full blur-3xl opacity-60"></div>
            
            <div class="absolute left-0 z-10 w-44 h-64 bg-slate-200 rounded-[40px] overflow-hidden border-[8px] border-white shadow-xl transform -rotate-12 translate-y-8">
                <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=1000&auto=format&fit=crop" 
                    alt="Cute Cat" class="w-full h-full object-cover">
            </div>

            <div class="relative z-20 w-64 h-80 bg-slate-300 rounded-[60px] overflow-hidden border-[16px] border-white shadow-[0_40px_80px_-15px_rgba(0,0,0,0.3)] transform rotate-2">
                <img src="https://images.unsplash.com/photo-1541364983171-a8ba01e95cfc?q=80&w=1000&auto=format&fit=crop" 
                    alt="Happy Dog" class="w-full h-full object-cover">
            </div>

            <div class="absolute right-0 z-10 w-44 h-64 bg-slate-200 rounded-[40px] overflow-hidden border-[8px] border-white shadow-xl transform rotate-12 translate-y-8">
                <img src="https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?q=80&w=1000&auto=format&fit=crop" 
                    alt="Cute Rabbit" class="w-full h-full object-cover">
            </div>
        </div>
    </main>

    <footer class="container mx-auto px-16 py-12 border-t border-gray-100">
        <div class="flex flex-wrap justify-between items-center gap-8 text-gray-300 font-black italic text-2xl uppercase tracking-widest">
            <span class="hover:text-blue-600 transition cursor-default">PixelCraft [cite: 251]</span>
            <span class="hover:text-blue-600 transition cursor-default">Anabul.co</span>
            <span class="hover:text-blue-600 transition cursor-default">Pet-Care</span>
            <span class="text-blue-600/20">© 2026</span>
        </div>
    </footer>

</body>
</html>