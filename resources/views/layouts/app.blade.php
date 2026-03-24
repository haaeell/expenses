<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') – LoveLedger 💕</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Poppins"', 'serif'],
                        body: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                        },
                    },
                    animation: {
                        'fade-in': 'fadeIn .4s ease forwards',
                        'slide-in': 'slideIn .35s ease forwards',
                        'float': 'float 5s ease-in-out infinite',
                        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            from: {
                                opacity: 0
                            },
                            to: {
                                opacity: 1
                            }
                        },
                        slideIn: {
                            from: {
                                opacity: 0,
                                transform: 'translateY(12px)'
                            },
                            to: {
                                opacity: 1,
                                transform: 'translateY(0)'
                            }
                        },
                        float: {
                            '0%,100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-6px)'
                            }
                        },
                        pulseSoft: {
                            '0%,100%': {
                                opacity: 1
                            },
                            '50%': {
                                opacity: 0.6
                            }
                        },
                    }
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .font-display {
            font-family: 'Poppins', serif;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #fff1f2;
        }

        ::-webkit-scrollbar-thumb {
            background: #fda4af;
            border-radius: 3px;
        }

        /* ── Sidebar ── */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 12px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #9f7070;
            transition: all .2s;
            cursor: pointer;
            text-decoration: none;
            position: relative;
        }

        .sidebar-link:hover {
            background: #fff1f2;
            color: #e11d48;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            color: white;
            box-shadow: 0 4px 14px rgba(244, 63, 94, .3);
        }

        .sidebar-link .icon {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        /* badge pill on sidebar */
        .sidebar-badge {
            margin-left: auto;
            font-size: 0.6rem;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 20px;
            background: #fecdd3;
            color: #be123c;
            line-height: 1.6;
        }

        .sidebar-link.active .sidebar-badge {
            background: rgba(255, 255, 255, .25);
            color: white;
        }

        /* section header in nav */
        .nav-section {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #f9a8d4;
            padding: 6px 12px 4px;
            margin-top: 8px;
        }

        /* ── Bottom nav (mobile) ── */
        .bnav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            flex: 1;
            padding: 8px 4px;
            font-size: 0.58rem;
            font-weight: 700;
            color: #c4909c;
            transition: all .2s;
            cursor: pointer;
            text-decoration: none;
        }

        .bnav-item .bnav-icon {
            font-size: 1.25rem;
            line-height: 1;
        }

        .bnav-item.active {
            color: #e11d48;
        }

        .bnav-item.active .bnav-icon {
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ── FAB ── */
        .fab {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 6px 20px rgba(244, 63, 94, .45);
            transition: all .2s;
            cursor: pointer;
            border: none;
        }

        .fab:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 24px rgba(244, 63, 94, .55);
        }

        .fab:active {
            transform: scale(0.96);
        }

        /* ── Cards ── */
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(244, 63, 94, .07);
        }

        .card-glass {
            background: rgba(255, 255, 255, .75);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, .6);
        }

        /* ── Gradient text ── */
        .grad-text {
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ── Stat badges ── */
        .badge-up {
            background: #dcfce7;
            color: #16a34a;
        }

        .badge-down {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-neu {
            background: #fef3c7;
            color: #d97706;
        }

        /* ── Modal backdrop ── */
        .modal-bg {
            background: rgba(0, 0, 0, .45);
            backdrop-filter: blur(4px);
        }

        /* ── Type tab ── */
        .type-tab {
            flex: 1;
            padding: 8px 4px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            transition: all .2s;
            border: 1.5px solid;
            cursor: pointer;
            text-align: center;
            line-height: 1.4;
        }

        .type-tab-inactive {
            background: white;
            color: #fda4af;
            border-color: #fecdd3;
        }

        .type-tab-inactive:hover {
            border-color: #fb7185;
            color: #e11d48;
        }

        /* ── Input base ── */
        .inp {
            width: 100%;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1.5px solid #fecdd3;
            background: #fff1f2;
            color: #9f1239;
            font-size: 0.875rem;
            font-weight: 500;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .inp:focus {
            border-color: #f43f5e;
            box-shadow: 0 0 0 3px rgba(244, 63, 94, .12);
        }

        .inp::placeholder {
            color: #fda4af;
        }

        /* ── Btn primary ── */
        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 20px;
            border-radius: 14px;
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(244, 63, 94, .35);
            transition: all .2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(244, 63, 94, .45);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* ── Progress bar ── */
        .progress-bar {
            height: 6px;
            border-radius: 99px;
            background: #fecdd3;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #f43f5e, #ec4899);
            transition: width .6s ease;
        }

        /* ── Couple header pill ── */
        .couple-pill {
            margin: 10px 12px 0;
            padding: 10px 12px;
            border-radius: 14px;
            background: linear-gradient(135deg, #fff1f2, #fce7f3);
            border: 1px solid rgba(244, 63, 94, .08);
        }

        /* ── Notification dot ── */
        .notif-dot {
            position: absolute;
            top: 6px;
            right: 8px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #f43f5e;
            border: 1.5px solid white;
            animation: pulseSoft 2s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-rose-50/40 min-h-screen">

    {{-- ════════════════════════════════════════════════════
     SIDEBAR — desktop (lg+)
════════════════════════════════════════════════════ --}}
    <aside id="sidebar"
        class="fixed left-0 top-0 h-full w-[230px] bg-white border-r border-rose-100 z-40 flex flex-col
           transition-transform duration-300 -translate-x-full lg:translate-x-0 overflow-hidden">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-rose-100 flex-shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-lg shadow-sm flex-shrink-0"
                    style="background: linear-gradient(135deg,#f43f5e,#ec4899)">💕</div>
                <div>
                    <p class="font-display font-bold text-rose-700 text-sm leading-tight">LoveLedger</p>
                    <p class="text-[10px] text-rose-400 font-medium">Keuangan Bersama</p>
                </div>
            </a>
        </div>

        {{-- Couple badge --}}
        <div class="couple-pill flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="flex -space-x-2 flex-shrink-0">
                    <div class="w-7 h-7 rounded-full border-2 border-white flex items-center justify-center text-xs font-bold text-white"
                        style="background: linear-gradient(135deg,#f43f5e,#ec4899)">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    @if (auth()->user()
                            ?->couple?->getPartner(auth()->user()))
                        <div class="w-7 h-7 rounded-full border-2 border-white flex items-center justify-center text-xs font-bold text-white"
                            style="background: linear-gradient(135deg,#ec4899,#f9a8d4)">
                            {{ strtoupper(substr(auth()->user()->couple->getPartner(auth()->user())->name,0,1)) }}
                        </div>
                    @else
                        <div
                            class="w-7 h-7 rounded-full border-2 border-white flex items-center justify-center text-xs font-bold bg-rose-100 text-rose-400">
                            ?</div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-rose-700 truncate leading-tight">
                        {{ auth()->user()?->couple?->display_name ?? auth()->user()?->name }}
                    </p>
                    <p class="text-[10px] text-rose-400 font-medium mt-0.5">
                        @if (auth()->user()?->couple)
                            <span class="inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block"></span>
                                Pasangan Aktif 💕
                            </span>
                        @else
                            <span class="text-amber-400">Belum terhubung</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Nav —— scrollable area --}}
        <nav class="flex-1 overflow-y-auto px-2 py-3 space-y-0.5">

            {{-- ── UTAMA ── --}}
            <p class="nav-section">Menu Utama</p>

            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="icon">📊</span> Dashboard
            </a>

            <a href="#" class="sidebar-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <span class="icon">💸</span> Transaksi
            </a>

            <a href="#" class="sidebar-link {{ request()->routeIs('wallets.*') ? 'active' : '' }}">
                <span class="icon">👛</span> Dompet
            </a>

            <a href="#" class="sidebar-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}">
                <span class="icon">📋</span> Budget
                {{-- Badge alert jika ada kategori over budget --}}
                @php $overBudget = 0; /* TODO: inject from view composer */ @endphp
                @if ($overBudget > 0)
                    <span class="sidebar-badge">{{ $overBudget }}</span>
                @endif
            </a>

            <a href="#" class="sidebar-link {{ request()->routeIs('goals.*') ? 'active' : '' }}">
                <span class="icon">🎯</span> Dream Goals
            </a>

            <a href="#" class="sidebar-link {{ request()->routeIs('split.*') ? 'active' : '' }}">
                <span class="icon">💳</span> Split Bill
                {{-- Badge hutang belum lunas --}}
                @php $unpaidSplit = 0; /* TODO: inject from view composer */ @endphp
                @if ($unpaidSplit > 0)
                    <span class="sidebar-badge">{{ $unpaidSplit }}</span>
                @endif
            </a>

            <a href="#" class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <span class="icon">📈</span> Laporan
            </a>

            {{-- ── FUN & INSIGHTS ── --}}
            <p class="nav-section" style="margin-top:12px">Fun & Insights</p>

            <a href="#" class="sidebar-link {{ request()->routeIs('missions.*') ? 'active' : '' }}">
                <span class="icon">🏆</span> Misi
                @php $activeMissions = 0; /* TODO: inject */ @endphp
                @if ($activeMissions > 0)
                    <span class="sidebar-badge">{{ $activeMissions }}</span>
                @endif
            </a>

            <a href="#" class="sidebar-link {{ request()->routeIs('badges.*') ? 'active' : '' }}">
                <span class="icon">🎖️</span> Badge & Skor
            </a>

            {{-- ── AKUN ── --}}
            <p class="nav-section" style="margin-top:12px">Akun</p>

            <a href="{{ route('couple.invite.index') }}"
                class="sidebar-link {{ request()->routeIs('couple.*') ? 'active' : '' }}">
                <span class="icon">💌</span> Pasangan
            </a>

            <a href="#" class="sidebar-link {{ request()->routeIs('reminders.*') ? 'active' : '' }}">
                <span class="icon">🔔</span> Reminder
                @php $dueReminders = 0; /* TODO: inject */ @endphp
                @if ($dueReminders > 0)
                    <span class="sidebar-badge">{{ $dueReminders }}</span>
                @endif
            </a>

            <a href="#" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <span class="icon">⚙️</span> Pengaturan
            </a>

        </nav>

        {{-- User footer --}}
        <div class="px-3 py-3 border-t border-rose-100 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                    style="background: linear-gradient(135deg,#f43f5e,#ec4899)">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-rose-800 truncate leading-tight">
                        {{ auth()->user()?->name ?? 'User' }}</p>
                    <p class="text-[10px] text-rose-400 truncate">{{ auth()->user()?->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-7 h-7 rounded-lg bg-rose-50 flex items-center justify-center text-rose-300 hover:bg-rose-100 hover:text-rose-500 transition-colors text-sm"
                        title="Logout">🚪</button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Overlay mobile --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- ════════════════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════════════════ --}}
    <div class="lg:ml-[230px] min-h-screen flex flex-col">

        {{-- ── TOP BAR ── --}}
        <header
            class="sticky top-0 z-20 bg-white/85 backdrop-blur-md border-b border-rose-100 px-4 lg:px-6 py-3 flex items-center justify-between gap-4">

            {{-- Left: hamburger + title --}}
            <div class="flex items-center gap-3 min-w-0">
                <button onclick="toggleSidebar()"
                    class="lg:hidden text-rose-400 hover:text-rose-600 text-xl p-1 flex-shrink-0 transition-colors">☰</button>

                {{-- Mobile logo --}}
                <div class="lg:hidden">
                    <span class="font-display font-bold text-rose-600 text-base">💕 LoveLedger</span>
                </div>

                {{-- Desktop page title --}}
                <div class="hidden lg:block min-w-0">
                    <h1 class="text-base font-bold text-rose-800 truncate leading-tight">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-rose-400 truncate">@yield('page-subtitle', '')</p>
                </div>
            </div>

            {{-- Right: actions --}}
            <div class="flex items-center gap-2 flex-shrink-0">

                {{-- Month picker --}}
                <button id="month-picker-btn"
                    class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 border border-rose-100
                       cursor-pointer hover:border-rose-300 transition-colors text-xs font-semibold text-rose-600">
                    📅 <span>{{ now()->translatedFormat('F Y') }}</span>
                </button>

                {{-- Notification bell --}}
                <a href="#"
                    class="relative w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-lg hover:bg-rose-100 transition-colors">
                    🔔
                    @if (($dueReminders ?? 0) > 0)
                        <span class="notif-dot"></span>
                    @endif
                </a>

                {{-- Quick add (desktop) --}}
                <button onclick="openQuickAdd()"
                    class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-white text-xs font-bold
                       transition-all hover:opacity-90 active:scale-95"
                    style="background: linear-gradient(135deg,#f43f5e,#ec4899); box-shadow: 0 3px 10px rgba(244,63,94,.3)">
                    ⚡ Catat
                </button>

                {{-- Avatar --}}
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold text-white cursor-pointer flex-shrink-0"
                    style="background: linear-gradient(135deg,#f43f5e,#ec4899)">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- ── FLASH MESSAGES ── --}}
        @if (session('success') || session('error') || session('info') || session('warning'))
            <div class="px-4 lg:px-6 pt-4 space-y-2">
                @if (session('success'))
                    <div
                        class="flex items-start gap-2.5 p-3.5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
                        <span class="flex-shrink-0 mt-0.5">✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div
                        class="flex items-start gap-2.5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm">
                        <span class="flex-shrink-0 mt-0.5">❌</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if (session('warning'))
                    <div
                        class="flex items-start gap-2.5 p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 text-sm">
                        <span class="flex-shrink-0 mt-0.5">⚠️</span>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif
                @if (session('info'))
                    <div
                        class="flex items-start gap-2.5 p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-600 text-sm">
                        <span class="flex-shrink-0 mt-0.5">💡</span>
                        <span>{{ session('info') }}</span>
                    </div>
                @endif
            </div>
        @endif

        {{-- ── PAGE CONTENT ── --}}
        <main class="flex-1 px-4 lg:px-6 py-4 pb-28 lg:pb-8 animate-fade-in">
            @yield('content')
        </main>

    </div>

    {{-- ════════════════════════════════════════════════════
     BOTTOM NAV — mobile only
════════════════════════════════════════════════════ --}}
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-rose-100"
        style="padding-bottom: env(safe-area-inset-bottom);">
        <div class="flex items-end h-16">

            <a href="{{ route('dashboard') }}"
                class="bnav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="bnav-icon">📊</span>
                <span>Dashboard</span>
            </a>

            <a href="#" class="bnav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <span class="bnav-icon">💸</span>
                <span>Transaksi</span>
            </a>

            {{-- FAB center --}}
            <div class="flex-1 flex justify-center items-center pb-2">
                <button class="fab" onclick="openQuickAdd()" title="Catat Transaksi">
                    <span class="text-white text-2xl leading-none">+</span>
                </button>
            </div>

            <a href="#" class="bnav-item {{ request()->routeIs('goals.*') ? 'active' : '' }}">
                <span class="bnav-icon">🎯</span>
                <span>Goals</span>
            </a>

            <a href="#" class="bnav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <span class="bnav-icon">📈</span>
                <span>Laporan</span>
            </a>

        </div>
    </nav>

    {{-- ════════════════════════════════════════════════════
     QUICK ADD MODAL
════════════════════════════════════════════════════ --}}
    <div id="quick-add-modal" class="fixed inset-0 z-50 flex items-end lg:items-center justify-center p-4 hidden">
        <div class="absolute inset-0 modal-bg" onclick="closeQuickAdd()"></div>
        <div class="relative bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl animate-slide-in">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-display text-lg font-bold text-rose-800">Catat Transaksi ⚡</h3>
                    <p class="text-xs text-rose-400 mt-0.5">Cepat, mudah, langsung tercatat</p>
                </div>
                <button onclick="closeQuickAdd()"
                    class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center text-rose-400 hover:bg-rose-100 transition-colors text-sm font-bold">✕</button>
            </div>

            {{-- Type tabs --}}
            <div class="flex gap-2 mb-5">
                @foreach ([
        'expense' => ['💸', 'Pengeluaran', 'rose'],
        'income' => ['💰', 'Pemasukan', 'green'],
        'saving' => ['🎯', 'Tabungan', 'blue'],
    ] as $type => [$icon, $label, $color])
                    <button onclick="setType('{{ $type }}')" id="type-{{ $type }}"
                        class="type-tab {{ $type === 'expense' ? 'bg-rose-500 text-white border-rose-500 shadow-sm' : 'type-tab-inactive' }}">
                        {{ $icon }}<br>{{ $label }}
                    </button>
                @endforeach
            </div>

            <form method="POST" action="#" class="space-y-3">
                @csrf
                <input type="hidden" name="type" id="input-type" value="expense" />

                {{-- Amount --}}
                <div>
                    <label class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">Jumlah</label>
                    <div class="relative mt-1">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-rose-400">Rp</span>
                        <input type="text" name="amount" placeholder="0" oninput="formatAmount(this)"
                            class="inp pl-10 text-lg font-bold !py-3" required />
                    </div>
                </div>

                {{-- Category + Wallet --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">Kategori</label>
                        <select name="category_id" class="inp mt-1">
                            <option value="">🍜 Makan</option>
                            <option value="">🚗 Transport</option>
                            <option value="">🛍️ Belanja</option>
                            <option value="">🎬 Hiburan</option>
                            <option value="">💕 Date Night</option>
                            <option value="">💊 Kesehatan</option>
                            <option value="">📚 Pendidikan</option>
                            <option value="">💡 Tagihan</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">Dompet</label>
                        <select name="wallet_id" class="inp mt-1">
                            <option value="">👤 Pribadi</option>
                            <option value="">💑 Bersama</option>
                        </select>
                    </div>
                </div>

                {{-- Date + Mood --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">Tanggal</label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}"
                            class="inp mt-1" />
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">Mood</label>
                        <select name="mood" class="inp mt-1">
                            <option value="neutral">😐 Biasa</option>
                            <option value="happy">😊 Happy</option>
                            <option value="stress">😰 Stress</option>
                            <option value="fomo">😱 FOMO</option>
                            <option value="hungry">🤤 Lapar</option>
                            <option value="guilty">😬 Guilty</option>
                        </select>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">Catatan</label>
                    <input type="text" name="description" placeholder="Tambah catatan... (opsional)"
                        class="inp mt-1" />
                </div>

                {{-- Actions --}}
                <div class="flex gap-2 pt-1">
                    <button type="button" onclick="closeQuickAdd()"
                        class="flex-1 py-3 rounded-xl border-2 border-rose-100 text-rose-400 font-bold text-sm hover:bg-rose-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="btn-primary flex-[2]">
                        💾 Simpan Transaksi
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- ════════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════════ --}}
    <script>
        /* ── Sidebar toggle ── */
        function toggleSidebar() {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('sidebar-overlay');
            const open = sb.classList.contains('-translate-x-full');
            sb.classList.toggle('-translate-x-full', !open);
            ov.classList.toggle('hidden', !open);
        }

        /* ── Quick Add modal ── */
        function openQuickAdd() {
            document.getElementById('quick-add-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeQuickAdd() {
            document.getElementById('quick-add-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        // Close on Escape
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeQuickAdd();
        });

        /* ── Transaction type switcher ── */
        const typeConfig = {
            expense: {
                bg: 'bg-rose-500',
                border: 'border-rose-500',
                text: 'text-white'
            },
            income: {
                bg: 'bg-green-500',
                border: 'border-green-500',
                text: 'text-white'
            },
            saving: {
                bg: 'bg-blue-500',
                border: 'border-blue-500',
                text: 'text-white'
            },
        };

        function setType(t) {
            document.getElementById('input-type').value = t;
            Object.keys(typeConfig).forEach(type => {
                const btn = document.getElementById(`type-${type}`);
                if (type === t) {
                    const c = typeConfig[t];
                    btn.className = `type-tab ${c.bg} ${c.border} ${c.text} shadow-sm`;
                } else {
                    btn.className = 'type-tab type-tab-inactive';
                }
            });
        }

        /* ── Rupiah formatter ── */
        function formatAmount(input) {
            const v = input.value.replace(/\D/g, '');
            input.value = v ? Number(v).toLocaleString('id-ID') : '';
        }

        /* ── Auto-close flash messages after 5s ── */
        setTimeout(() => {
            document.querySelectorAll('[data-flash]').forEach(el => {
                el.style.transition = 'opacity .4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>

</html>
