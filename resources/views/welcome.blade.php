<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LoveLedger — Kelola Keuangan Bareng Pasangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>

    <style>
        :root {
            --love: #F43F5E;
            --ledger: #7C3AED;
            --mid: #C026D3;
            --gold: #F59E0B;
            --soft: #FFF1F2;
            --dark: #1A0A2E;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #faf8ff;
            color: var(--dark);
            overflow-x: hidden;
            cursor: none;
        }

        /* ── Custom cursor ── */
        #cursor {
            width: 14px;
            height: 14px;
            background: var(--love);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transform: translate(-50%, -50%);
            transition: transform .1s ease, width .2s, height .2s, background .2s;
            mix-blend-mode: multiply;
        }

        #cursor-ring {
            width: 38px;
            height: 38px;
            border: 2px solid var(--ledger);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9998;
            transform: translate(-50%, -50%);
            transition: transform .18s ease, opacity .2s;
            opacity: .5;
        }

        body:hover #cursor {
            width: 14px;
            height: 14px;
        }

        /* ── Fonts ── */
        .font-display {
            font-family: 'Poppins', serif;
        }

        /* ── Gradient text ── */
        .grad-text {
            background: linear-gradient(135deg, var(--love) 0%, var(--mid) 50%, var(--ledger) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .grad-text-gold {
            background: linear-gradient(135deg, #F59E0B, #EF4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Noise overlay ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: .4;
        }

        /* ── Hero blob bg ── */
        .blob-bg {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-30px) scale(1.05);
            }
        }

        @keyframes floatR {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        /* ── Heartbeat ── */
        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            15% {
                transform: scale(1.18);
            }

            30% {
                transform: scale(1);
            }

            45% {
                transform: scale(1.1);
            }
        }

        .heartbeat {
            animation: heartbeat 2s ease-in-out infinite;
        }

        /* ── Coin spin ── */
        @keyframes coinSpin {
            0% {
                transform: rotateY(0deg);
            }

            100% {
                transform: rotateY(360deg);
            }
        }

        .coin-spin {
            animation: coinSpin 3s linear infinite;
            display: inline-block;
        }

        /* ── Slide in ── */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-up {
            opacity: 0;
            animation: slideUp .7s ease forwards;
        }

        /* ── Wiggle ── */
        @keyframes wiggle {

            0%,
            100% {
                transform: rotate(-3deg);
            }

            50% {
                transform: rotate(3deg);
            }
        }

        .wiggle:hover {
            animation: wiggle .4s ease-in-out infinite;
        }

        /* ── Marquee ── */
        @keyframes marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .marquee-track {
            animation: marquee 20s linear infinite;
            display: flex;
            width: max-content;
        }

        .marquee-wrap {
            overflow: hidden;
        }

        /* ── Card hover ── */
        .feat-card {
            background: white;
            border: 1.5px solid rgba(124, 58, 237, .12);
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        .feat-card:hover {
            transform: translateY(-8px) rotate(.5deg);
            box-shadow: 0 24px 48px rgba(124, 58, 237, .15);
            border-color: rgba(124, 58, 237, .35);
        }

        /* ── Phone mockup ── */
        .phone-shadow {
            filter: drop-shadow(0 40px 60px rgba(124, 58, 237, .35));
        }

        /* ── Stat card bounce ── */
        @keyframes bounceIn {
            0% {
                transform: scale(0.7);
                opacity: 0;
            }

            60% {
                transform: scale(1.08);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        .bounce-in {
            animation: bounceIn .6s ease forwards;
        }

        /* ── Sparkle ── */
        @keyframes sparkle {

            0%,
            100% {
                opacity: 0;
                transform: scale(0) rotate(0deg);
            }

            50% {
                opacity: 1;
                transform: scale(1) rotate(180deg);
            }
        }

        .sparkle {
            animation: sparkle 1.8s ease-in-out infinite;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f0eaff;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--love), var(--ledger));
            border-radius: 99px;
        }

        /* ── Pill badge ── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .04em;
        }

        /* ── Section divider wave ── */
        .wave-divider svg {
            display: block;
        }

        /* ── Glassmorphism card ── */
        .glass {
            background: rgba(255, 255, 255, .65);
            backdrop-filter: blur(16px);
            border: 1.5px solid rgba(255, 255, 255, .8);
        }

        /* ── Hover glow btn ── */
        .btn-love {
            background: linear-gradient(135deg, var(--love), var(--mid), var(--ledger));
            background-size: 200% 200%;
            animation: gradMove 4s ease infinite;
            transition: transform .2s, box-shadow .2s;
        }

        .btn-love:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 16px 40px rgba(244, 63, 94, .4);
        }

        @keyframes gradMove {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* ── Tilt cards ── */
        .tilt {
            transition: transform .2s ease;
        }

        /* ── Nav ── */
        nav {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, .8);
        }

        /* ── Scroll reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── Heart particles ── */
        .particle {
            position: absolute;
            pointer-events: none;
            animation: particleFloat 3s ease-out forwards;
            font-size: 1.2rem;
        }

        @keyframes particleFloat {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            100% {
                opacity: 0;
                transform: translateY(-120px) scale(.3);
            }
        }

        /* ── FAQ accordion ── */
        .faq-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height .4s ease;
        }

        .faq-body.open {
            max-height: 300px;
        }

        .faq-icon {
            transition: transform .3s ease;
        }

        .faq-icon.open {
            transform: rotate(45deg);
        }

        /* ── Number counter ── */
        .counter {
            font-variant-numeric: tabular-nums;
        }

        /* ── Mobile menu ── */
        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height .4s ease;
        }

        #mobile-menu.open {
            max-height: 400px;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        love: '#F43F5E',
                        ledger: '#7C3AED',
                        mid: '#C026D3',
                        gold: '#F59E0B',
                        dark: '#1A0A2E',
                    }
                }
            }
        }
    </script>
</head>

<body>

    <!-- ── Custom Cursor ── -->
    <div id="cursor"></div>
    <div id="cursor-ring"></div>

    <!-- ══════════════════════════════════════════
     NAV
══════════════════════════════════════════ -->
    <nav class="fixed top-0 left-0 right-0 z-50 border-b border-white/40 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="heartbeat text-2xl">💑</div>
                <span class="font-display text-xl font-bold">
                    <span class="text-love">Love</span><span class="text-ledger">Ledger</span>
                </span>
            </div>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-dark/70">
                <a href="#fitur" class="hover:text-love transition-colors">Fitur</a>
                <a href="#cara-kerja" class="hover:text-love transition-colors">Cara Kerja</a>
                <a href="#statistik" class="hover:text-love transition-colors">Statistik</a>
                <a href="#faq" class="hover:text-love transition-colors">FAQ</a>
            </div>

            <!-- CTA -->
            <div class="hidden md:flex items-center gap-3">
                <a href="/login" class="text-sm font-semibold text-ledger hover:text-love transition-colors">Masuk</a>
                <a href="/register" class="btn-love text-white text-sm font-bold px-5 py-2.5 rounded-full shadow-lg">
                    Mulai Gratis 💕
                </a>
            </div>

            <!-- Hamburger -->
            <button id="hamburger" class="md:hidden text-dark" onclick="toggleMenu()">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="3" y1="7" x2="21" y2="7" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="17" x2="21" y2="17" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden bg-white/95 px-6 pb-4">
            <div class="flex flex-col gap-4 text-sm font-semibold text-dark/80 pt-2">
                <a href="#fitur" onclick="toggleMenu()">Fitur</a>
                <a href="#cara-kerja" onclick="toggleMenu()">Cara Kerja</a>
                <a href="#statistik" onclick="toggleMenu()">Statistik</a>
                <a href="#faq" onclick="toggleMenu()">FAQ</a>
                <a href="#" class="btn-love text-white font-bold px-5 py-2.5 rounded-full text-center">Mulai
                    Gratis 💕</a>
            </div>
        </div>
    </nav>


    <!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
    <section class="relative min-h-screen flex items-center pt-24 pb-16 overflow-hidden">

        <!-- Blobs -->
        <div class="blob-bg w-96 h-96 bg-love/20 -top-20 -left-20" style="animation-delay:0s"></div>
        <div class="blob-bg w-80 h-80 bg-ledger/20 top-40 right-0" style="animation-delay:2s"></div>
        <div class="blob-bg w-64 h-64 bg-gold/20 bottom-0 left-1/3" style="animation-delay:4s"></div>

        <!-- Floating emojis bg -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden select-none">
            <span class="absolute text-4xl opacity-10"
                style="top:10%;left:5%;animation:floatR 6s ease-in-out infinite">💸</span>
            <span class="absolute text-3xl opacity-10"
                style="top:20%;right:8%;animation:floatR 8s ease-in-out infinite 1s">💖</span>
            <span class="absolute text-2xl opacity-10"
                style="bottom:20%;left:12%;animation:floatR 7s ease-in-out infinite 2s">🏦</span>
            <span class="absolute text-3xl opacity-10"
                style="bottom:30%;right:5%;animation:floatR 5s ease-in-out infinite 3s">🎯</span>
            <span class="absolute text-2xl opacity-10"
                style="top:50%;left:45%;animation:floatR 9s ease-in-out infinite .5s">✨</span>
        </div>

        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <!-- Left copy -->
                <div>
                    <!-- Badge -->
                    <div class="pill bg-love/10 text-love mb-6 slide-up" style="animation-delay:.1s">
                        <span class="coin-spin">💰</span>
                        Aplikasi keuangan untuk pasangan #1
                    </div>

                    <!-- Headline -->
                    <h1 class="font-display text-5xl lg:text-6xl xl:text-7xl font-black leading-[1.1] mb-6 slide-up"
                        style="animation-delay:.2s">
                        Cinta itu<br />
                        <span class="grad-text">indah,</span><br />
                        keuangan<br />
                        <span class="grad-text">lebih indah.</span>
                    </h1>

                    <p class="text-lg text-dark/60 leading-relaxed mb-8 max-w-md slide-up"
                        style="animation-delay:.35s">
                        LoveLedger membantu kamu dan pasangan <strong>mencatat, merencanakan, dan mencapai</strong>
                        goals finansial bersama — dengan cara yang menyenangkan 🥰
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 mb-10 slide-up" style="animation-delay:.45s">
                        <a href="#" id="hero-cta"
                            class="btn-love text-white font-bold px-8 py-4 rounded-full text-base shadow-xl flex items-center gap-2">
                            <span>Mulai Sekarang</span>
                            <span class="heartbeat">💕</span>
                        </a>
                        <a href="#cara-kerja"
                            class="bg-white border-2 border-ledger/20 text-ledger font-bold px-8 py-4 rounded-full text-base hover:bg-ledger/5 transition-all flex items-center gap-2 shadow-sm">
                            <span>Lihat Demo</span>
                            <span>▶</span>
                        </a>
                    </div>

                    <!-- Social proof -->
                    <div class="flex items-center gap-4 slide-up" style="animation-delay:.55s">
                        <div class="flex -space-x-3">
                            <div
                                class="w-10 h-10 rounded-full border-2 border-white bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center text-white text-sm font-bold">
                                A</div>
                            <div
                                class="w-10 h-10 rounded-full border-2 border-white bg-gradient-to-br from-purple-400 to-violet-600 flex items-center justify-center text-white text-sm font-bold">
                                B</div>
                            <div
                                class="w-10 h-10 rounded-full border-2 border-white bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-sm font-bold">
                                C</div>
                            <div
                                class="w-10 h-10 rounded-full border-2 border-white bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white text-sm font-bold">
                                D</div>
                            <div
                                class="w-10 h-10 rounded-full border-2 border-white bg-dark/80 flex items-center justify-center text-white text-xs font-bold">
                                +2K</div>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-dark">2.400+ pasangan</div>
                            <div class="text-xs text-dark/50">sudah mulai perjalanan finansial bareng ⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                </div>

                <!-- Right — Phone mockup -->
                <div class="relative flex justify-center items-center slide-up" style="animation-delay:.3s">

                    <!-- Glow ring -->
                    <div class="absolute w-80 h-80 rounded-full bg-gradient-to-br from-love/30 to-ledger/30 blur-3xl">
                    </div>

                    <!-- Phone -->
                    <div class="phone-shadow relative z-10" style="animation: float 6s ease-in-out infinite">
                        <div class="w-64 bg-dark rounded-[3rem] p-2 shadow-2xl border border-white/10">
                            <div class="bg-[#12002a] rounded-[2.5rem] overflow-hidden">

                                <!-- Status bar -->
                                <div class="flex justify-between items-center px-6 pt-4 pb-2">
                                    <span class="text-white/50 text-xs">9:41</span>
                                    <div class="w-20 h-5 bg-dark rounded-full"></div>
                                    <div class="flex gap-1">
                                        <div class="w-4 h-2 bg-white/30 rounded-sm"></div>
                                        <div class="w-2 h-2 bg-white/30 rounded-full"></div>
                                    </div>
                                </div>

                                <!-- App UI -->
                                <div class="px-4 pb-6">
                                    <!-- Header -->
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <p class="text-white/40 text-xs">Halo, Anisa 👋</p>
                                            <p class="text-white font-bold text-sm">Maret 2026</p>
                                        </div>
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-love to-ledger flex items-center justify-center text-sm">
                                            💑</div>
                                    </div>

                                    <!-- Balance card -->
                                    <div class="rounded-2xl p-4 mb-3"
                                        style="background: linear-gradient(135deg, #F43F5E, #7C3AED)">
                                        <p class="text-white/70 text-xs mb-1">Total Tabungan Bersama</p>
                                        <p class="text-white font-black text-2xl">Rp 4.750.000</p>
                                        <div class="flex justify-between mt-3">
                                            <div>
                                                <p class="text-white/60 text-xs">Pemasukan</p>
                                                <p class="text-green-300 text-sm font-bold">+8.2 jt</p>
                                            </div>
                                            <div>
                                                <p class="text-white/60 text-xs">Pengeluaran</p>
                                                <p class="text-red-300 text-sm font-bold">-3.4 jt</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Goal progress -->
                                    <div class="bg-white/10 rounded-2xl p-3 mb-3">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-white text-xs font-semibold">🏠 Rumah Impian</span>
                                            <span class="text-white/50 text-xs">68%</span>
                                        </div>
                                        <div class="bg-white/20 rounded-full h-2">
                                            <div class="h-2 rounded-full"
                                                style="width:68%;background:linear-gradient(90deg,#F43F5E,#7C3AED)">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Recent tx -->
                                    <div class="space-y-2">
                                        <p class="text-white/40 text-xs mb-1">Transaksi Terbaru</p>
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-full bg-green-500/20 flex items-center justify-center text-xs">
                                                🍕</div>
                                            <div class="flex-1">
                                                <p class="text-white text-xs font-semibold">Makan Malam</p>
                                                <p class="text-white/40 text-xs">😊 happy</p>
                                            </div>
                                            <span class="text-red-400 text-xs font-bold">-85K</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-full bg-blue-500/20 flex items-center justify-center text-xs">
                                                💼</div>
                                            <div class="flex-1">
                                                <p class="text-white text-xs font-semibold">Gaji Bulanan</p>
                                                <p class="text-white/40 text-xs">😊 happy</p>
                                            </div>
                                            <span class="text-green-400 text-xs font-bold">+5jt</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating badges -->
                    <div class="glass absolute -left-4 top-16 rounded-2xl px-4 py-3 shadow-xl bounce-in wiggle"
                        style="animation-delay:.8s">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">🏆</span>
                            <div>
                                <p class="text-xs font-bold text-dark">Badge Baru!</p>
                                <p class="text-xs text-dark/50">Budget Master</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass absolute -right-6 bottom-24 rounded-2xl px-4 py-3 shadow-xl bounce-in"
                        style="animation-delay:1s">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">🔥</span>
                            <div>
                                <p class="text-xs font-bold text-dark">30 Hari Streak!</p>
                                <p class="text-xs text-dark/50">Konsisten banget 💪</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass absolute -right-2 top-8 rounded-2xl px-3 py-2 shadow-xl bounce-in"
                        style="animation-delay:1.2s">
                        <p class="text-xs font-bold text-ledger">💕 Budi setuju</p>
                        <p class="text-xs text-dark/50">Split bill settled!</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════════════
     MARQUEE
══════════════════════════════════════════ -->
    <div class="py-4 overflow-hidden border-y border-love/10"
        style="background: linear-gradient(135deg,rgba(244,63,94,.05),rgba(124,58,237,.05))">
        <div class="marquee-wrap">
            <div class="marquee-track gap-8 text-sm font-semibold text-dark/50">
                <template id="marquee-items">
                    <span class="px-4">💰 Catat Transaksi Bersama</span>
                    <span class="text-love px-2">✦</span>
                    <span class="px-4">🎯 Capai Goals Finansial</span>
                    <span class="text-ledger px-2">✦</span>
                    <span class="px-4">🤝 Split Bill Otomatis</span>
                    <span class="text-mid px-2">✦</span>
                    <span class="px-4">📊 Analisis Mood Belanja</span>
                    <span class="text-love px-2">✦</span>
                    <span class="px-4">🏆 Kumpulkan Badge</span>
                    <span class="text-ledger px-2">✦</span>
                    <span class="px-4">🔔 Pengingat Tagihan</span>
                    <span class="text-mid px-2">✦</span>
                    <span class="px-4">💑 Couple Financial Score</span>
                    <span class="text-love px-2">✦</span>
                    <span class="px-4">🌱 Mulai Investasi Bareng</span>
                    <span class="text-ledger px-2">✦</span>
                </template>
            </div>
        </div>
    </div>


    <!-- ══════════════════════════════════════════
     FEATURES
══════════════════════════════════════════ -->
    <section id="fitur" class="py-24 px-6 relative overflow-hidden">
        <div class="max-w-6xl mx-auto">

            <!-- Section header -->
            <div class="text-center mb-16 reveal">
                <div class="pill bg-ledger/10 text-ledger mb-4 mx-auto w-fit">✨ Kenapa LoveLedger?</div>
                <h2 class="font-display text-4xl lg:text-5xl font-black mb-4">
                    Semua yang kalian butuhkan<br />
                    <span class="grad-text">dalam satu aplikasi</span>
                </h2>
                <p class="text-dark/50 text-lg max-w-xl mx-auto">Dirancang khusus untuk pasangan yang ingin tumbuh
                    bersama — finansial dan emosional.</p>
            </div>

            <!-- Feature grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Card 1 -->
                <div class="feat-card rounded-3xl p-7 reveal">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-5"
                        style="background: linear-gradient(135deg,#ffd6dd,#ffe4f0)">💸</div>
                    <h3 class="font-display text-xl font-bold mb-2">Catat Bareng</h3>
                    <p class="text-dark/55 text-sm leading-relaxed">Setiap transaksi, dicatat bersama. Lihat siapa
                        belanja apa, kapan, dan dengan mood apa. Transparansi tanpa drama.</p>
                    <div class="flex gap-2 mt-4">
                        <span class="pill bg-love/10 text-love text-xs">😊 Mood Tracker</span>
                        <span class="pill bg-ledger/10 text-ledger text-xs">📸 Foto Struk</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="feat-card rounded-3xl p-7 reveal" style="transition-delay:.1s">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-5"
                        style="background: linear-gradient(135deg,#e8d5ff,#f0e5ff)">🎯</div>
                    <h3 class="font-display text-xl font-bold mb-2">Goals Bersama</h3>
                    <p class="text-dark/55 text-sm leading-relaxed">Set target tabungan — rumah, liburan, nikah, dana
                        darurat. Pantau progres real-time dan rayakan milestone bareng!</p>
                    <div class="flex gap-2 mt-4">
                        <span class="pill bg-ledger/10 text-ledger text-xs">🏠 Shared Goals</span>
                        <span class="pill bg-mid/10 text-mid text-xs">🎉 Milestone</span>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="feat-card rounded-3xl p-7 reveal" style="transition-delay:.2s">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-5"
                        style="background: linear-gradient(135deg,#fff3cc,#fff8d6)">🤝</div>
                    <h3 class="font-display text-xl font-bold mb-2">Split Bill Fair</h3>
                    <p class="text-dark/55 text-sm leading-relaxed">Tagihan liburan, makan, belanja — bagi otomatis.
                        Equal, persentase, atau custom. No more awkward money talk!</p>
                    <div class="flex gap-2 mt-4">
                        <span class="pill bg-gold/20 text-yellow-700 text-xs">⚖️ Auto Split</span>
                        <span class="pill bg-green-100 text-green-700 text-xs">✅ Quick Settle</span>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="feat-card rounded-3xl p-7 reveal" style="transition-delay:.3s">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-5"
                        style="background: linear-gradient(135deg,#d6f5e8,#e5fdf0)">📊</div>
                    <h3 class="font-display text-xl font-bold mb-2">Budget Pintar</h3>
                    <p class="text-dark/55 text-sm leading-relaxed">Set batas pengeluaran per kategori. Dapat
                        notifikasi sebelum limit terlampaui. Hemat tanpa stress berkat visual yang fun.</p>
                    <div class="flex gap-2 mt-4">
                        <span class="pill bg-green-100 text-green-700 text-xs">🔔 Alert Otomatis</span>
                        <span class="pill bg-love/10 text-love text-xs">📈 Visualisasi</span>
                    </div>
                </div>

                <!-- Card 5 — Highlight -->
                <div class="feat-card rounded-3xl p-7 reveal lg:col-span-2"
                    style="transition-delay:.4s; background: linear-gradient(135deg,#1A0A2E,#2d1060)">
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <div class="flex-1">
                            <div class="pill bg-white/10 text-white/70 mb-4 text-xs">🌟 Fitur Unggulan</div>
                            <h3 class="font-display text-2xl font-bold text-white mb-2">Financial Health Score</h3>
                            <p class="text-white/55 text-sm leading-relaxed mb-4">Skor finansial couple kamu diupdate
                                setiap hari. Dari "Broke Couple" naik ke "Money Power Couple" — kompetisi sehat bareng
                                pasangan!</p>
                            <div class="flex gap-2 flex-wrap">
                                <span class="pill bg-white/10 text-white/70 text-xs">💪 Level System</span>
                                <span class="pill bg-white/10 text-white/70 text-xs">🏅 Badge Rewards</span>
                                <span class="pill bg-white/10 text-white/70 text-xs">🎮 Gamifikasi</span>
                            </div>
                        </div>
                        <!-- Score visual -->
                        <div class="flex flex-col items-center gap-2">
                            <div class="relative w-32 h-32">
                                <svg viewBox="0 0 120 120" class="w-full h-full -rotate-90">
                                    <circle cx="60" cy="60" r="50" fill="none"
                                        stroke="rgba(255,255,255,.1)" stroke-width="10" />
                                    <circle cx="60" cy="60" r="50" fill="none"
                                        stroke="url(#scoreGrad)" stroke-width="10" stroke-dasharray="314"
                                        stroke-dashoffset="95" stroke-linecap="round" />
                                    <defs>
                                        <linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%"
                                            y2="0%">
                                            <stop offset="0%" stop-color="#F43F5E" />
                                            <stop offset="100%" stop-color="#7C3AED" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-3xl font-black text-white counter" data-target="87">87</span>
                                    <span class="text-white/50 text-xs">/ 100</span>
                                </div>
                            </div>
                            <span class="text-yellow-400 text-sm font-bold">💎 Money Power</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════════════
     CARA KERJA
══════════════════════════════════════════ -->
    <section id="cara-kerja" class="py-24 px-6"
        style="background: linear-gradient(180deg, #faf8ff 0%, #f5f0ff 100%)">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16 reveal">
                <div class="pill bg-love/10 text-love mb-4 mx-auto w-fit">🗺️ Cara Kerja</div>
                <h2 class="font-display text-4xl lg:text-5xl font-black mb-4">
                    3 langkah,<br /><span class="grad-text">mulai dari sekarang</span>
                </h2>
            </div>

            <div class="relative">
                <!-- Connecting line -->
                <div class="hidden lg:block absolute top-1/2 left-0 right-0 h-0.5 -translate-y-1/2"
                    style="background: linear-gradient(90deg, var(--love), var(--mid), var(--ledger)); opacity: .3; z-index:0">
                </div>

                <div class="grid lg:grid-cols-3 gap-8 relative z-10">

                    <!-- Step 1 -->
                    <div class="flex flex-col items-center text-center reveal">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center text-3xl mb-6 shadow-xl wiggle"
                            style="background: linear-gradient(135deg, #F43F5E, #C026D3)">
                            💑
                        </div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-black mb-4"
                            style="background: var(--love)">1</div>
                        <h3 class="font-display text-xl font-bold mb-2">Buat Akun & Invite</h3>
                        <p class="text-dark/55 text-sm">Daftar gratis dalam 30 detik. Kirim kode invite ke pasangan
                            kamu. Boom — kalian terhubung!</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center text-center reveal" style="transition-delay:.15s">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center text-3xl mb-6 shadow-xl wiggle"
                            style="background: linear-gradient(135deg, #C026D3, #7C3AED)">
                            ⚙️
                        </div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-black mb-4"
                            style="background: var(--mid)">2</div>
                        <h3 class="font-display text-xl font-bold mb-2">Setup Bareng</h3>
                        <p class="text-dark/55 text-sm">Buat wallet, set budget, tentukan goals bersama. Semua
                            disesuaikan dengan kebutuhan kalian.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center text-center reveal" style="transition-delay:.3s">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center text-3xl mb-6 shadow-xl wiggle"
                            style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                            🚀
                        </div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-black mb-4"
                            style="background: var(--ledger)">3</div>
                        <h3 class="font-display text-xl font-bold mb-2">Tumbuh Bersama</h3>
                        <p class="text-dark/55 text-sm">Catat transaksi harian, pantau progress goals, dan rayakan
                            setiap pencapaian finansial kalian!</p>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════════════
     STATISTIK
══════════════════════════════════════════ -->
    <section id="statistik" class="py-24 px-6 relative overflow-hidden">
        <div class="absolute inset-0" style="background: linear-gradient(135deg, #1A0A2E 0%, #2d0a4e 100%)"></div>

        <!-- Stars -->
        <div class="absolute inset-0 pointer-events-none" id="stars-container"></div>

        <div class="max-w-5xl mx-auto relative z-10">

            <div class="text-center mb-16 reveal">
                <div class="pill bg-white/10 text-white/70 mb-4 mx-auto w-fit">📈 Dalam Angka</div>
                <h2 class="font-display text-4xl lg:text-5xl font-black text-white mb-4">
                    LoveLedger by<br /><span class="grad-text-gold">the numbers</span>
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass rounded-3xl p-7 text-center reveal">
                    <div class="text-4xl mb-2">💑</div>
                    <div class="font-display text-4xl font-black grad-text counter" data-target="2400">0</div>
                    <div class="text-xs font-semibold text-dark/50 mt-1">Pasangan Aktif</div>
                </div>
                <div class="glass rounded-3xl p-7 text-center reveal" style="transition-delay:.1s">
                    <div class="text-4xl mb-2">💸</div>
                    <div class="font-display text-4xl font-black grad-text counter" data-target="850"
                        data-suffix="M">0</div>
                    <div class="text-xs font-semibold text-dark/50 mt-1">Total Transaksi Tercatat</div>
                </div>
                <div class="glass rounded-3xl p-7 text-center reveal" style="transition-delay:.2s">
                    <div class="text-4xl mb-2">🏆</div>
                    <div class="font-display text-4xl font-black grad-text counter" data-target="12500">0</div>
                    <div class="text-xs font-semibold text-dark/50 mt-1">Badge Diraih</div>
                </div>
                <div class="glass rounded-3xl p-7 text-center reveal" style="transition-delay:.3s">
                    <div class="text-4xl mb-2">⭐</div>
                    <div class="font-display text-4xl font-black grad-text">4.9</div>
                    <div class="text-xs font-semibold text-dark/50 mt-1">Rating App</div>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="grid md:grid-cols-3 gap-5 mt-10">
                <div class="glass rounded-3xl p-6 reveal">
                    <div class="flex gap-1 mb-3 text-yellow-400 text-sm">⭐⭐⭐⭐⭐</div>
                    <p class="text-dark/70 text-sm italic leading-relaxed mb-4">"Akhirnya ada app yang bikin ngobrol
                        soal duit sama pasangan jadi seru, bukan bikin berantem 😂"</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-full bg-gradient-to-br from-pink-400 to-love flex items-center justify-center text-white text-sm font-bold">
                            R</div>
                        <div>
                            <p class="text-sm font-bold text-dark">Raka & Sari</p>
                            <p class="text-xs text-dark/40">Jakarta · 8 bulan pakai</p>
                        </div>
                    </div>
                </div>
                <div class="glass rounded-3xl p-6 reveal" style="transition-delay:.1s">
                    <div class="flex gap-1 mb-3 text-yellow-400 text-sm">⭐⭐⭐⭐⭐</div>
                    <p class="text-dark/70 text-sm italic leading-relaxed mb-4">"Goals nikah kami tercapai lebih cepat
                        3 bulan dari rencana! Financial score kami sekarang 94 🎉"</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-400 to-ledger flex items-center justify-center text-white text-sm font-bold">
                            D</div>
                        <div>
                            <p class="text-sm font-bold text-dark">Dino & Mega</p>
                            <p class="text-xs text-dark/40">Surabaya · 1 tahun pakai</p>
                        </div>
                    </div>
                </div>
                <div class="glass rounded-3xl p-6 reveal" style="transition-delay:.2s">
                    <div class="flex gap-1 mb-3 text-yellow-400 text-sm">⭐⭐⭐⭐⭐</div>
                    <p class="text-dark/70 text-sm italic leading-relaxed mb-4">"Split bill liburan Bali kami beres
                        dalam 2 menit. Dulu ribut mulu soal itu 😅 Makasih LoveLedger!"</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-gold flex items-center justify-center text-white text-sm font-bold">
                            F</div>
                        <div>
                            <p class="text-sm font-bold text-dark">Faris & Nadia</p>
                            <p class="text-xs text-dark/40">Bandung · 5 bulan pakai</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- ══════════════════════════════════════════
     FAQ
══════════════════════════════════════════ -->
    <section id="faq" class="py-24 px-6" style="background: linear-gradient(180deg, #f5f0ff 0%, #faf8ff 100%)">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-14 reveal">
                <div class="pill bg-mid/10 text-mid mb-4 mx-auto w-fit">❓ FAQ</div>
                <h2 class="font-display text-4xl font-black mb-4">Pertanyaan yang<br /><span class="grad-text">sering
                        ditanyain</span></h2>
            </div>

            <div class="space-y-4" id="faq-list">
                <!-- FAQ items rendered by JS -->
            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════════════
     CTA BOTTOM
══════════════════════════════════════════ -->
    <section class="py-24 px-6 relative overflow-hidden">
        <div class="absolute inset-0 blob-bg w-full h-full opacity-50"
            style="background: linear-gradient(135deg, rgba(244,63,94,.15), rgba(124,58,237,.15))"></div>

        <!-- Sparkles -->
        <div class="absolute top-8 left-16 text-2xl sparkle" style="animation-delay:0s">✨</div>
        <div class="absolute top-12 right-20 text-xl sparkle" style="animation-delay:.7s">💫</div>
        <div class="absolute bottom-10 left-1/4 text-2xl sparkle" style="animation-delay:1.2s">⭐</div>
        <div class="absolute bottom-6 right-1/3 text-xl sparkle" style="animation-delay:.4s">✨</div>

        <div class="max-w-3xl mx-auto text-center relative z-10 reveal">
            <div class="text-6xl mb-6 heartbeat inline-block">💕</div>
            <h2 class="font-display text-5xl lg:text-6xl font-black mb-6">
                Siap mulai perjalanan<br />
                <span class="grad-text">finansial bersama?</span>
            </h2>
            <p class="text-dark/55 text-lg mb-10 max-w-xl mx-auto">
                Gratis selamanya untuk fitur dasar. Tidak perlu kartu kredit. Cukup cinta dan komitmen 💍
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" id="bottom-cta"
                    class="btn-love text-white font-black text-lg px-10 py-5 rounded-full shadow-2xl flex items-center gap-3 justify-center">
                    <span>Mulai Gratis Sekarang</span>
                    <span class="heartbeat">💕</span>
                </a>
                <a href="#"
                    class="bg-white border-2 border-dark/10 text-dark font-bold text-lg px-10 py-5 rounded-full hover:border-ledger/30 transition-all">
                    Pelajari Lebih Lanjut →
                </a>
            </div>
            <p class="text-dark/40 text-sm mt-6">Sudah 2.400+ pasangan bergabung minggu ini 🎉</p>
        </div>
    </section>


    <!-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ -->
    <footer class="py-12 px-6 border-t border-dark/5" style="background: #1A0A2E">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-2">
                    <div class="heartbeat text-2xl">💑</div>
                    <span class="font-display text-2xl font-bold">
                        <span class="text-love">Love</span><span class="text-purple-400">Ledger</span>
                    </span>
                </div>
                <div class="flex gap-8 text-sm text-white/40 font-medium">
                    <a href="#" class="hover:text-white transition-colors">Tentang</a>
                    <a href="#" class="hover:text-white transition-colors">Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat</a>
                    <a href="#" class="hover:text-white transition-colors">Kontak</a>
                </div>
                <p class="text-white/25 text-sm">© 2026 LoveLedger. Dibuat dengan 💕</p>
            </div>
        </div>
    </footer>


    <!-- ══════════════════════════════════════════
     JS
══════════════════════════════════════════ -->
    <script>
        // ── Cursor ──
        const cursor = document.getElementById('cursor');
        const ring = document.getElementById('cursor-ring');
        let mx = 0,
            my = 0,
            rx = 0,
            ry = 0;
        document.addEventListener('mousemove', e => {
            mx = e.clientX;
            my = e.clientY;
        });

        function animateCursor() {
            rx += (mx - rx) * 0.18;
            ry += (my - ry) * 0.18;
            cursor.style.left = mx + 'px';
            cursor.style.top = my + 'px';
            ring.style.left = rx + 'px';
            ring.style.top = ry + 'px';
            requestAnimationFrame(animateCursor);
        }
        animateCursor();
        document.querySelectorAll('a,button').forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursor.style.width = '24px';
                cursor.style.height = '24px';
                cursor.style.background = 'var(--ledger)';
            });
            el.addEventListener('mouseleave', () => {
                cursor.style.width = '14px';
                cursor.style.height = '14px';
                cursor.style.background = 'var(--love)';
            });
        });

        // ── Marquee duplicate ──
        const track = document.querySelector('.marquee-track');
        const tmpl = document.getElementById('marquee-items');
        const html = tmpl.innerHTML;
        track.innerHTML = html + html;

        // ── Mobile menu ──
        function toggleMenu() {
            document.getElementById('mobile-menu').classList.toggle('open');
        }

        // ── Scroll reveal ──
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver(entries => {
            entries.forEach((e, i) => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    observer.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.12
        });
        revealEls.forEach(el => observer.observe(el));

        // ── Counter animation ──
        const counters = document.querySelectorAll('.counter[data-target]');
        const counterObserver = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    const el = e.target;
                    const target = parseInt(el.dataset.target);
                    const suffix = el.dataset.suffix || '';
                    const duration = 1800;
                    const step = target / (duration / 16);
                    let current = 0;
                    const timer = setInterval(() => {
                        current = Math.min(current + step, target);
                        el.textContent = Math.floor(current).toLocaleString('id') + suffix;
                        if (current >= target) clearInterval(timer);
                    }, 16);
                    counterObserver.unobserve(el);
                }
            });
        }, {
            threshold: 0.5
        });
        counters.forEach(el => counterObserver.observe(el));

        // ── Stars ──
        const starsContainer = document.getElementById('stars-container');
        for (let i = 0; i < 60; i++) {
            const star = document.createElement('div');
            const size = Math.random() * 2.5 + .5;
            star.style.cssText = `
    position:absolute; border-radius:50%; background:white;
    width:${size}px; height:${size}px;
    top:${Math.random()*100}%; left:${Math.random()*100}%;
    opacity:${Math.random()*.7+.1};
    animation: sparkle ${Math.random()*3+2}s ease-in-out ${Math.random()*3}s infinite;
  `;
            starsContainer.appendChild(star);
        }

        // ── FAQ ──
        const faqs = [{
                q: 'Apakah LoveLedger gratis?',
                a: 'Ya! Fitur dasar LoveLedger sepenuhnya gratis untuk selamanya. Kamu bisa mencatat transaksi, set goals, dan split bill tanpa bayar apapun.'
            },
            {
                q: 'Apakah data keuangan kami aman?',
                a: 'Keamanan data adalah prioritas utama kami. Semua data dienkripsi dengan standar bank-grade. Kami tidak pernah menjual data kamu ke pihak ketiga.'
            },
            {
                q: 'Bisa digunakan untuk pasangan yang LDR?',
                a: 'Tentu! LoveLedger berjalan di cloud, jadi kamu dan pasangan bisa sync keuangan real-time dari mana saja, meski beda kota atau negara.'
            },
            {
                q: 'Bagaimana cara invite pasangan?',
                a: 'Cukup daftar akun, lalu kirim kode invite 8 digit unik ke pasangan kamu. Mereka tinggal masukkan kode tersebut dan kalian langsung terhubung!'
            },
            {
                q: 'Apakah bisa digunakan oleh lebih dari 2 orang?',
                a: 'Saat ini LoveLedger dirancang khusus untuk 2 orang (couples). Kami sedang mengembangkan fitur untuk family plan di masa mendatang.'
            },
        ];

        const faqList = document.getElementById('faq-list');
        faqs.forEach((faq, i) => {
            const item = document.createElement('div');
            item.className = 'feat-card rounded-2xl overflow-hidden';
            item.innerHTML = `
    <button class="w-full flex justify-between items-center px-6 py-5 text-left" onclick="toggleFaq(${i})">
      <span class="font-semibold text-dark text-sm pr-4">${faq.q}</span>
      <span class="faq-icon text-ledger text-xl font-light flex-shrink-0" id="faq-icon-${i}">+</span>
    </button>
    <div class="faq-body" id="faq-body-${i}">
      <p class="px-6 pb-5 text-dark/55 text-sm leading-relaxed">${faq.a}</p>
    </div>
  `;
            faqList.appendChild(item);
        });

        function toggleFaq(i) {
            const body = document.getElementById('faq-body-' + i);
            const icon = document.getElementById('faq-icon-' + i);
            const isOpen = body.classList.contains('open');
            document.querySelectorAll('.faq-body').forEach(b => b.classList.remove('open'));
            document.querySelectorAll('.faq-icon').forEach(ic => ic.classList.remove('open'));
            if (!isOpen) {
                body.classList.add('open');
                icon.classList.add('open');
            }
        }

        // ── Heart particles on CTA click ──
        function spawnHearts(btn) {
            for (let i = 0; i < 12; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                p.textContent = ['💕', '💖', '💗', '💓', '✨'][Math.floor(Math.random() * 5)];
                const rect = btn.getBoundingClientRect();
                p.style.left = (rect.left + Math.random() * rect.width) + 'px';
                p.style.top = (rect.top + window.scrollY) + 'px';
                p.style.animationDelay = (Math.random() * .4) + 's';
                document.body.appendChild(p);
                setTimeout(() => p.remove(), 3000);
            }
        }
        document.getElementById('hero-cta')?.addEventListener('click', function(e) {
            spawnHearts(this);
        });
        document.getElementById('bottom-cta')?.addEventListener('click', function(e) {
            spawnHearts(this);
        });

        // ── Card tilt ──
        document.querySelectorAll('.feat-card').forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - .5;
                const y = (e.clientY - rect.top) / rect.height - .5;
                card.style.transform =
                    `perspective(800px) rotateX(${-y*6}deg) rotateY(${x*6}deg) translateY(-8px)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });

        // ── Smooth scroll ──
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const href = a.getAttribute('href');
                if (href === '#') return;
                e.preventDefault();
                document.querySelector(href)?.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
