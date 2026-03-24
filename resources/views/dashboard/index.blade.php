@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan keuangan bulan ' . now()->translatedFormat('F Y'))

@section('content')

{{-- ═══ HERO: Saldo & Pasangan ═══ --}}
<div class="relative rounded-2xl overflow-hidden mb-5 p-5 md:p-6"
     style="background: linear-gradient(135deg, #f43f5e 0%, #ec4899 55%, #f9a8d4 100%)">
    {{-- Decoration --}}
    <div class="absolute top-0 right-0 w-40 h-40 rounded-full opacity-10"
         style="background: white; transform: translate(30%, -30%)"></div>
    <div class="absolute bottom-0 left-1/3 w-28 h-28 rounded-full opacity-10"
         style="background: white; transform: translateY(40%)"></div>
    <div class="absolute top-3 right-20 text-2xl opacity-30 animate-float">💕</div>

    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        {{-- Left --}}
        <div>
            <p class="text-white/80 text-xs font-semibold uppercase tracking-wider mb-1">Saldo Bersama Bulan Ini</p>
            <p class="text-white font-display text-4xl font-bold mb-1">
                Rp {{ number_format($stats['balance'] ?? 3750000, 0, ',', '.') }}
            </p>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-white/70 text-xs">
                    {{ auth()->user()?->couple?->display_name ?? auth()->user()?->name }}
                </span>
                @if(auth()->user()?->couple)
                    <span class="text-white/50 text-xs">·</span>
                    @php $partner = auth()->user()->couple->getPartner(auth()->user()); @endphp
                    <div class="flex items-center gap-1">
                        <div class="w-5 h-5 rounded-full bg-white/30 flex items-center justify-center text-xs font-bold text-white">
                            {{ $partner ? strtoupper(substr($partner->name, 0, 1)) : '?' }}
                        </div>
                        <span class="text-white/70 text-xs">{{ $partner?->name ?? 'Pasangan' }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right: Quick stats --}}
        <div class="flex gap-3">
            <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center min-w-[90px]">
                <p class="text-white/70 text-xs mb-0.5">Pemasukan</p>
                <p class="text-white font-bold text-base">
                    {{ 'Rp '.number_format($stats['income'] ?? 8500000, 0, ',', '.') }}
                </p>
                <span class="text-xs bg-white/20 text-white rounded-full px-2 py-0.5">📈 +12%</span>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center min-w-[90px]">
                <p class="text-white/70 text-xs mb-0.5">Pengeluaran</p>
                <p class="text-white font-bold text-base">
                    {{ 'Rp '.number_format($stats['expense'] ?? 4750000, 0, ',', '.') }}
                </p>
                <span class="text-xs bg-white/20 text-white rounded-full px-2 py-0.5">📉 -5%</span>
            </div>
        </div>
    </div>

    {{-- Progress bar --}}
    <div class="relative mt-4">
        <div class="flex justify-between text-xs text-white/70 mb-1">
            <span>Pengeluaran vs Pemasukan</span>
            <span>{{ number_format(($stats['expense'] ?? 4750000) / ($stats['income'] ?? 8500000) * 100, 0) }}%</span>
        </div>
        <div class="h-2 bg-white/20 rounded-full overflow-hidden">
            @php $pct = min(100, round(($stats['expense'] ?? 4750000) / ($stats['income'] ?? 8500000) * 100)); @endphp
            <div class="h-full rounded-full bg-white transition-all duration-700"
                 style="width: {{ $pct }}%"></div>
        </div>
    </div>
</div>

{{-- ═══ 4 STAT CARDS ═══ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
    @php
    $statCards = [
        ['icon'=>'💰','label'=>'Total Pemasukan','value'=>'Rp 8.500.000','badge'=>'+12%','type'=>'up','sub'=>'vs bulan lalu'],
        ['icon'=>'💸','label'=>'Total Pengeluaran','value'=>'Rp 4.750.000','badge'=>'-5%','type'=>'down','sub'=>'vs bulan lalu'],
        ['icon'=>'🎯','label'=>'Total Tabungan','value'=>'Rp 1.500.000','badge'=>'+8%','type'=>'up','sub'=>'ke semua goals'],
        ['icon'=>'💳','label'=>'Hutang Bersih','value'=>'Rp 250.000','badge'=>'↗ Kamu','type'=>'neu','sub'=>'kamu yang lebih bayar'],
    ];
    @endphp

    @foreach($statCards as $card)
    <div class="card p-4 flex flex-col gap-2 hover:shadow-lg hover:shadow-rose-100 transition-shadow">
        <div class="flex items-center justify-between">
            <span class="text-2xl">{{ $card['icon'] }}</span>
            <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $card['type']==='up' ? 'badge-up' : ($card['type']==='down' ? 'badge-down' : 'badge-neu') }}">
                {{ $card['badge'] }}
            </span>
        </div>
        <div>
            <p class="text-xs text-rose-400 font-semibold">{{ $card['label'] }}</p>
            <p class="font-bold text-rose-900 text-base leading-tight">{{ $card['value'] }}</p>
            <p class="text-xs text-rose-300 mt-0.5">{{ $card['sub'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- ═══ ROW: Chart + Goals ═══ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

    {{-- Donut chart pengeluaran per kategori --}}
    <div class="card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-rose-800">Pengeluaran per Kategori</h3>
                <p class="text-xs text-rose-400">Bulan {{ now()->translatedFormat('F Y') }}</p>
            </div>
            <select class="text-xs border border-rose-100 rounded-lg px-2 py-1.5 text-rose-600 bg-rose-50 focus:outline-none">
                <option>Bulan ini</option>
                <option>3 Bulan</option>
                <option>6 Bulan</option>
            </select>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-5">
            {{-- Canvas --}}
            <div class="w-40 h-40 flex-shrink-0">
                <canvas id="categoryChart"></canvas>
            </div>
            {{-- Legend --}}
            <div class="flex-1 grid grid-cols-2 gap-y-2 gap-x-3 w-full">
                @php
                $cats = [
                    ['🍜','Makan','1.250.000','26%','#f43f5e'],
                    ['🚗','Transport','750.000','16%','#ec4899'],
                    ['🛍️','Belanja','900.000','19%','#f9a8d4'],
                    ['🎬','Hiburan','500.000','11%','#fda4af'],
                    ['💕','Date Night','650.000','14%','#fb7185'],
                    ['💡','Tagihan','700.000','14%','#fecdd3'],
                ];
                @endphp
                @foreach($cats as [$icon,$name,$amount,$pct,$color])
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:{{ $color }}"></div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-rose-700 truncate">{{ $icon }} {{ $name }}</p>
                        <p class="text-xs text-rose-400">Rp {{ $amount }} · {{ $pct }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Dream Goals mini --}}
    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-rose-800">Dream Goals 🎯</h3>
            <a href="#" class="text-xs text-rose-400 hover:text-rose-600 transition-colors">Lihat semua →</a>
        </div>
        <div class="space-y-4">
            @php
            $goals = [
                ['💍','Dana Nikah','47.500.000','150.000.000','32'],
                ['🏠','DP Rumah','12.000.000','80.000.000','15'],
                ['✈️','Honeymoon Bali','4.500.000','15.000.000','30'],
            ];
            @endphp
            @foreach($goals as [$icon,$name,$current,$target,$pct])
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-semibold text-rose-700">{{ $icon }} {{ $name }}</span>
                    <span class="text-xs font-bold text-rose-500">{{ $pct }}%</span>
                </div>
                <div class="h-2 bg-rose-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700"
                         style="width:{{ $pct }}%; background: linear-gradient(90deg,#f43f5e,#ec4899)"></div>
                </div>
                <div class="flex justify-between mt-0.5">
                    <span class="text-xs text-rose-400">Rp {{ $current }}</span>
                    <span class="text-xs text-rose-300">dari Rp {{ $target }}</span>
                </div>
            </div>
            @endforeach
            <a href="#" class="block mt-2 py-2 rounded-xl text-center text-xs font-semibold text-rose-500 border border-rose-200 hover:bg-rose-50 transition-colors">
                + Tambah Goal Baru
            </a>
        </div>
    </div>
</div>

{{-- ═══ ROW: Bar chart + Upcoming bills ═══ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

    {{-- Bar chart mingguan --}}
    <div class="card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-rose-800">Pemasukan vs Pengeluaran</h3>
                <p class="text-xs text-rose-400">7 hari terakhir</p>
            </div>
            <div class="flex items-center gap-3 text-xs text-rose-400">
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full inline-block" style="background:#f43f5e"></span>Keluar</span>
                <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full inline-block" style="background:#4ade80"></span>Masuk</span>
            </div>
        </div>
        <canvas id="weeklyChart" height="120"></canvas>
    </div>

    {{-- Upcoming bills --}}
    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-rose-800">Tagihan Jatuh Tempo ⏰</h3>
            <span class="text-xs bg-rose-100 text-rose-600 font-bold px-2 py-0.5 rounded-full">7 hari</span>
        </div>
        <div class="space-y-3">
            @php
            $bills = [
                ['💡','PLN Listrik','350.000','26 Mar','2'],
                ['📱','Paket Internet','150.000','28 Mar','4'],
                ['🎵','Spotify Duo','29.000','30 Mar','6'],
                ['🏋️','Gym Membership','250.000','31 Mar','7'],
            ];
            @endphp
            @foreach($bills as [$icon,$name,$amount,$date,$daysLeft])
            <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-rose-50 transition-colors">
                <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-lg flex-shrink-0">{{ $icon }}</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-rose-800 truncate">{{ $name }}</p>
                    <p class="text-xs text-rose-400">{{ $date }} · <span class="{{ intval($daysLeft) <= 2 ? 'text-red-500 font-bold' : 'text-rose-400' }}">{{ $daysLeft }} hari lagi</span></p>
                </div>
                <p class="text-sm font-bold text-rose-700 flex-shrink-0">Rp {{ $amount }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══ ROW: Transaksi terbaru + Kontribusi ═══ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

    {{-- Recent transactions --}}
    <div class="card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-rose-800">Transaksi Terbaru</h3>
            <a href="#" class="text-xs text-rose-400 hover:text-rose-600 transition-colors">Lihat semua →</a>
        </div>
        <div class="space-y-2">
            @php
            $transactions = [
                ['💕','Date Night Restoran','Kemarin, 19:30','expense','-Rp 320.000','Andi'],
                ['🍜','Makan Siang Bareng','Kemarin, 12:15','expense','-Rp 85.000','Sari'],
                ['💰','Gaji Bulan Maret','25 Mar, 09:00','income','+Rp 5.000.000','Andi'],
                ['🎯','Setor Dana Nikah','24 Mar, 20:00','saving','-Rp 500.000','Sari'],
                ['🛍️','Belanja Groceries','24 Mar, 15:45','expense','-Rp 245.000','Andi'],
                ['💰','Freelance Project','23 Mar, 14:00','income','+Rp 1.500.000','Sari'],
            ];
            @endphp
            @foreach($transactions as [$icon,$desc,$time,$type,$amount,$who])
            <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-rose-50 transition-colors group">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0
                            {{ $type==='income' ? 'bg-green-50' : ($type==='saving' ? 'bg-blue-50' : 'bg-rose-50') }}">
                    {{ $icon }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-rose-800 truncate">{{ $desc }}</p>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs text-rose-400">{{ $time }}</span>
                        <span class="text-rose-300">·</span>
                        <span class="text-xs font-semibold text-rose-500">{{ $who }}</span>
                    </div>
                </div>
                <p class="text-sm font-bold flex-shrink-0 {{ str_starts_with($amount,'+') ? 'text-green-600' : ($type==='saving' ? 'text-blue-600' : 'text-rose-700') }}">
                    {{ $amount }}
                </p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Kontribusi per orang --}}
    <div class="card p-5">
        <div class="mb-4">
            <h3 class="font-bold text-rose-800">Kontribusi Bulan Ini 💑</h3>
            <p class="text-xs text-rose-400">Perbandingan pengeluaran berdua</p>
        </div>

        {{-- Couple comparison --}}
        <div class="space-y-4 mb-5">
            @php
            $members = [
                ['Andi','A','#f43f5e','#ec4899','2.800.000','59'],
                ['Sari','S','#ec4899','#f9a8d4','1.950.000','41'],
            ];
            @endphp
            @foreach($members as [$name,$initial,$from,$to,$amount,$pct])
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold text-white"
                             style="background: linear-gradient(135deg,{{ $from }},{{ $to }})">{{ $initial }}</div>
                        <span class="text-sm font-semibold text-rose-800">{{ $name }}</span>
                    </div>
                    <span class="text-sm font-bold text-rose-700">{{ $pct }}%</span>
                </div>
                <div class="h-2.5 bg-rose-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700"
                         style="width:{{ $pct }}%; background: linear-gradient(90deg,{{ $from }},{{ $to }})"></div>
                </div>
                <p class="text-xs text-rose-400 mt-0.5">Rp {{ $amount }}</p>
            </div>
            @endforeach
        </div>

        {{-- Doughnut kecil: split --}}
        <div class="flex justify-center mb-4">
            <div class="w-28 h-28">
                <canvas id="splitChart"></canvas>
            </div>
        </div>

        {{-- Hutang summary --}}
        <div class="p-3 rounded-xl bg-amber-50 border border-amber-100">
            <div class="flex items-center gap-2">
                <span class="text-lg">💳</span>
                <div>
                    <p class="text-xs font-bold text-amber-700">Hutang Saat Ini</p>
                    <p class="text-xs text-amber-600">Andi lebih bayar <strong>Rp 250.000</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ─── Donut chart kategori ────────────────────────────────
const catCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(catCtx, {
    type: 'doughnut',
    data: {
        labels: ['Makan','Transport','Belanja','Hiburan','Date Night','Tagihan'],
        datasets: [{
            data: [1250000, 750000, 900000, 500000, 650000, 700000],
            backgroundColor: ['#f43f5e','#ec4899','#f9a8d4','#fda4af','#fb7185','#fecdd3'],
            borderWidth: 0,
            hoverOffset: 8,
        }]
    },
    options: {
        cutout: '68%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` Rp ${ctx.raw.toLocaleString('id-ID')}`
                }
            }
        }
    }
});

// ─── Bar chart mingguan ───────────────────────────────────
const wCtx = document.getElementById('weeklyChart').getContext('2d');
new Chart(wCtx, {
    type: 'bar',
    data: {
        labels: ['Sel','Rab','Kam','Jum','Sab','Min','Sen'],
        datasets: [
            {
                label: 'Pemasukan',
                data: [0, 1500000, 0, 5000000, 0, 0, 0],
                backgroundColor: 'rgba(74,222,128,.7)',
                borderRadius: 8, borderSkipped: false,
            },
            {
                label: 'Pengeluaran',
                data: [405000, 245000, 320000, 150000, 890000, 720000, 85000],
                backgroundColor: 'rgba(244,63,94,.7)',
                borderRadius: 8, borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#c4909c' } },
            y: {
                grid: { color: '#fce7f3' },
                ticks: {
                    font: { size: 10 }, color: '#c4909c',
                    callback: v => v >= 1000000 ? `${v/1000000}jt` : (v >= 1000 ? `${v/1000}rb` : v)
                }
            }
        }
    }
});

// ─── Doughnut split kontribusi ────────────────────────────
const sCtx = document.getElementById('splitChart').getContext('2d');
new Chart(sCtx, {
    type: 'doughnut',
    data: {
        labels: ['Andi','Sari'],
        datasets: [{
            data: [59, 41],
            backgroundColor: ['#f43f5e','#f9a8d4'],
            borderWidth: 0, hoverOffset: 4,
        }]
    },
    options: {
        cutout: '60%',
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ` ${ctx.raw}%` } }
        }
    }
});
</script>
@endpush
