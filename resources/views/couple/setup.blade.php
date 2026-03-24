@extends('layouts.auth')

@section('title', 'Setup Pasangan – LoveLedger')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="animate-fade-up text-center mb-7">
        <div class="text-5xl mb-3">🎉</div>
        <h1 class="font-display text-2xl font-bold text-rose-800 mb-1">Kalian Resmi Terhubung!</h1>
        <p class="text-sm text-rose-400">Sekarang atur profil pasangan kalian</p>
    </div>

    {{-- Success banner --}}
    @if(session('success'))
        <div class="animate-fade-up mb-5 p-3.5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2">
            <span class="text-lg">🎊</span> {{ session('success') }}
        </div>
    @endif

    {{-- Couple display --}}
    <div class="animate-fade-up-delay mb-7 flex items-center justify-center gap-4">
        {{-- User 1 --}}
        <div class="text-center">
            <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold text-white mx-auto mb-1.5 shadow-md"
                 style="background: linear-gradient(135deg, {{ $couple->user1->color_hex ?? '#f43f5e' }}, #ec4899)">
                {{ strtoupper(substr($couple->user1->name, 0, 1)) }}
            </div>
            <p class="text-xs font-semibold text-rose-700">{{ $couple->user1->name }}</p>
        </div>
        <div class="text-3xl animate-float">💕</div>
        {{-- User 2 --}}
        <div class="text-center">
            <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold text-white mx-auto mb-1.5 shadow-md"
                 style="background: linear-gradient(135deg, {{ $couple->user2->color_hex ?? '#ec4899' }}, #f9a8d4)">
                {{ strtoupper(substr($couple->user2->name, 0, 1)) }}
            </div>
            <p class="text-xs font-semibold text-rose-700">{{ $couple->user2->name }}</p>
        </div>
    </div>

    {{-- Form --}}
    @if ($errors->any())
        <div class="animate-fade-up mb-5 p-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2"><span>❌</span> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('couple.setup.save') }}" class="space-y-5">
        @csrf

        {{-- Nama pasangan --}}
        <div class="animate-fade-up-delay">
            <label for="couple_name" class="block text-xs font-semibold text-rose-500 uppercase tracking-wider mb-1.5">
                Nama Pasangan Kalian
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-rose-300 text-lg">💑</span>
                <input type="text"
                       id="couple_name"
                       name="couple_name"
                       value="{{ old('couple_name', $couple->couple_name) }}"
                       maxlength="100"
                       placeholder="Contoh: Tim Hemat 💰, Pasangan Impian ✨"
                       class="input-love w-full pl-10 pr-4 py-3 rounded-xl border border-rose-200 bg-white/70 text-rose-900 placeholder-rose-300 text-sm transition-all hover:border-rose-300"/>
            </div>
            <p class="mt-1 text-xs text-rose-300">Opsional · Ini nama yang tampil di dashboard 😊</p>
        </div>

        {{-- Anniversary date --}}
        <div class="animate-fade-up-delay">
            <label for="anniversary_date" class="block text-xs font-semibold text-rose-500 uppercase tracking-wider mb-1.5">
                Tanggal Jadian / Menikah
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-rose-300 text-lg">📅</span>
                <input type="date"
                       id="anniversary_date"
                       name="anniversary_date"
                       value="{{ old('anniversary_date', $couple->anniversary_date?->format('Y-m-d')) }}"
                       max="{{ date('Y-m-d') }}"
                       class="input-love w-full pl-10 pr-4 py-3 rounded-xl border border-rose-200 bg-white/70 text-rose-900 text-sm transition-all hover:border-rose-300"/>
            </div>
            <p class="mt-1 text-xs text-rose-300">Opsional · Digunakan untuk recap & notifikasi anniversary 🎂</p>
        </div>

        {{-- Privacy mode --}}
        <div class="animate-fade-up-delay2">
            <label class="block text-xs font-semibold text-rose-500 uppercase tracking-wider mb-2">
                Mode Kolaborasi
            </label>
            <div class="grid grid-cols-2 gap-3">
                {{-- Shared --}}
                <label class="cursor-pointer">
                    <input type="radio" name="privacy_mode" value="shared"
                           {{ old('privacy_mode', $couple->privacy_mode) === 'shared' ? 'checked' : '' }}
                           class="hidden peer"/>
                    <div class="p-4 rounded-xl border-2 border-rose-100 bg-white/60 text-center transition-all
                                peer-checked:border-rose-400 peer-checked:bg-rose-50 peer-checked:shadow-sm peer-checked:shadow-rose-200
                                hover:border-rose-300">
                        <div class="text-2xl mb-1.5">👀</div>
                        <p class="text-xs font-bold text-rose-700">Shared</p>
                        <p class="text-xs text-rose-400 mt-0.5 leading-relaxed">Semua transaksi bisa dilihat berdua</p>
                    </div>
                </label>

                {{-- Semi-private --}}
                <label class="cursor-pointer">
                    <input type="radio" name="privacy_mode" value="semi_private"
                           {{ old('privacy_mode', $couple->privacy_mode) === 'semi_private' ? 'checked' : '' }}
                           class="hidden peer"/>
                    <div class="p-4 rounded-xl border-2 border-rose-100 bg-white/60 text-center transition-all
                                peer-checked:border-rose-400 peer-checked:bg-rose-50 peer-checked:shadow-sm peer-checked:shadow-rose-200
                                hover:border-rose-300">
                        <div class="text-2xl mb-1.5">🔒</div>
                        <p class="text-xs font-bold text-rose-700">Semi-Private</p>
                        <p class="text-xs text-rose-400 mt-0.5 leading-relaxed">Ada dompet pribadi masing-masing</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Submit --}}
        <div class="animate-fade-up-delay3 pt-1 space-y-3">
            <button type="submit"
                    class="btn-love w-full py-3.5 rounded-xl text-white font-bold text-sm tracking-wide shadow-lg">
                Simpan & Mulai LoveLedger 💕
            </button>
            <a href="{{ route('dashboard') }}"
               class="block text-center text-xs text-rose-300 hover:text-rose-500 transition-colors">
                Lewati untuk sekarang →
            </a>
        </div>
    </form>
</div>
@endsection
