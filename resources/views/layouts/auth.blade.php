<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LoveLedger') 💕</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts: Playfair Display + Nunito --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Poppins"', 'serif'],
                        body: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        rose: {
                            50:  '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                        },
                        blush: {
                            50:  '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                        },
                        cream: {
                            50:  '#fefce8',
                            100: '#fef9c3',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delay': 'float 6s ease-in-out 2s infinite',
                        'float-slow': 'float 8s ease-in-out 1s infinite',
                        'fade-up': 'fadeUp 0.7s ease forwards',
                        'fade-up-delay': 'fadeUp 0.7s ease 0.15s forwards',
                        'fade-up-delay2': 'fadeUp 0.7s ease 0.3s forwards',
                        'fade-up-delay3': 'fadeUp 0.7s ease 0.45s forwards',
                        'pulse-soft': 'pulseSoft 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-14px)' },
                        },
                        fadeUp: {
                            from: { opacity: '0', transform: 'translateY(20px)' },
                            to: { opacity: '1', transform: 'translateY(0)' },
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '0.6' },
                            '50%': { opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Poppins', serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #fff1f2; }
        ::-webkit-scrollbar-thumb { background: #fda4af; border-radius: 3px; }

        /* Input focus ring custom */
        .input-love:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.15);
            border-color: #f43f5e;
        }

        /* Floating hearts background */
        .heart-bg::before,
        .heart-bg::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            opacity: 0.03;
            pointer-events: none;
        }
        .heart-bg::before {
            width: 600px; height: 600px;
            background: radial-gradient(circle, #f43f5e, transparent);
            top: -200px; right: -150px;
        }
        .heart-bg::after {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #ec4899, transparent);
            bottom: -150px; left: -100px;
        }

        /* Glass card */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Gradient button */
        .btn-love {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
            transition: all 0.3s ease;
        }
        .btn-love:hover {
            background: linear-gradient(135deg, #e11d48 0%, #db2777 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(244, 63, 94, 0.35);
        }
        .btn-love:active { transform: translateY(0); }

        /* Opacity 0 for animated elements */
        .animate-fade-up,
        .animate-fade-up-delay,
        .animate-fade-up-delay2,
        .animate-fade-up-delay3 {
            opacity: 0;
        }
    </style>
</head>
<body class="heart-bg min-h-screen font-body" style="background: linear-gradient(135deg, #fff1f2 0%, #fce7f3 40%, #fdf2f8 70%, #fef9c3 100%);">

    {{-- Decorative floating elements --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-16 left-10 text-4xl animate-float opacity-20">💕</div>
        <div class="absolute top-1/3 right-16 text-3xl animate-float-delay opacity-15">✨</div>
        <div class="absolute bottom-24 left-20 text-2xl animate-float-slow opacity-20">💖</div>
        <div class="absolute top-1/2 left-1/4 text-xl animate-float opacity-10">🌸</div>
        <div class="absolute bottom-1/3 right-10 text-3xl animate-float-delay opacity-15">💰</div>
        <div class="absolute top-20 right-1/3 text-2xl animate-float-slow opacity-10">🌷</div>

        {{-- Soft blobs --}}
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full opacity-20"
             style="background: radial-gradient(circle, #fda4af, transparent); transform: translate(30%, -30%)"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full opacity-15"
             style="background: radial-gradient(circle, #f9a8d4, transparent); transform: translate(-30%, 30%)"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 rounded-full opacity-10"
             style="background: radial-gradient(circle, #fb7185, transparent); transform: translate(-50%, -50%)"></div>
    </div>

    {{-- Main content --}}
    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-10">

        {{-- Logo --}}
        <div class="animate-fade-up mb-8 text-center">
            <a href="{{ url('/') }}" class="inline-flex flex-col items-center gap-1 group">
                <div class="text-5xl mb-1 group-hover:scale-110 transition-transform duration-300">💕</div>
                <span class="font-display text-3xl font-bold text-rose-600 tracking-tight">LoveLedger</span>
                <span class="text-xs text-rose-400 font-medium tracking-widest uppercase">Keuangan Bersama</span>
            </a>
        </div>

        {{-- Card --}}
        <div class="glass-card w-full max-w-md rounded-3xl shadow-2xl shadow-rose-200/50 overflow-hidden border border-white/60">
            @yield('content')
        </div>

        {{-- Footer --}}
        <p class="mt-6 text-center text-xs text-rose-300 animate-fade-up-delay3">
            Dibuat dengan 💕 untuk pasangan yang peduli finansial bersama
        </p>
    </div>

</body>
</html>
