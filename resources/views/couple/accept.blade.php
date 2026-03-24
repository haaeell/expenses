@extends('layouts.auth')

@section('title', 'Terima Undangan – LoveLedger')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="animate-fade-up text-center mb-8">
        <div class="text-5xl mb-3 animate-pulse-soft">💕</div>
        <h1 class="font-display text-2xl font-bold text-rose-800 mb-1">Ada yang Mengundangmu!</h1>
        <p class="text-sm text-rose-400">Seseorang ingin mulai perjalanan finansial bersamamu</p>
    </div>

    {{-- Inviter card --}}
    <div class="animate-fade-up-delay mb-7">
        <div class="relative rounded-2xl overflow-hidden border border-rose-200 shadow-md shadow-rose-100">

            {{-- Gradient header --}}
            <div class="h-16" style="background: linear-gradient(135deg, #fda4af, #f9a8d4, #fce7f3)"></div>

            {{-- Avatar --}}
            <div class="flex justify-center -mt-8 mb-3">
                <div class="w-16 h-16 rounded-full border-4 border-white shadow-md flex items-center justify-center text-3xl"
                     style="background: {{ $invite->inviter->color_hex ?? '#fda4af' }}20; border-color: {{ $invite->inviter->color_hex ?? '#fda4af' }}">
                    @if($invite->inviter->avatar)
                        <img src="{{ asset('storage/' . $invite->inviter->avatar) }}"
                             class="w-full h-full rounded-full object-cover" alt="Avatar">
                    @else
                        <span class="font-bold text-rose-500 text-xl">
                            {{ strtoupper(substr($invite->inviter->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="text-center pb-5 px-5">
                <h2 class="font-display text-xl font-bold text-rose-800">{{ $invite->inviter->name }}</h2>
                <p class="text-xs text-rose-400 mt-0.5">{{ $invite->inviter->email }}</p>

                <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-rose-50 border border-rose-100">
                    <span class="text-sm">⏰</span>
                    <span class="text-xs text-rose-500 font-medium">Invite berlaku {{ $invite->time_remaining }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Kamu + dia --}}
    <div class="animate-fade-up-delay2 flex items-center justify-center gap-4 mb-7">
        {{-- User saat ini --}}
        <div class="text-center">
            <div class="w-14 h-14 rounded-full border-3 border-rose-300 flex items-center justify-center text-xl font-bold text-rose-500 mx-auto mb-1"
                 style="background: {{ auth()->user()->color_hex ?? '#fda4af' }}20">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <p class="text-xs text-rose-600 font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-xs text-rose-300">Kamu</p>
        </div>

        {{-- Connector --}}
        <div class="flex flex-col items-center gap-1">
            <div class="text-2xl">💕</div>
            <div class="w-16 h-0.5 bg-gradient-to-r from-rose-300 to-pink-300 rounded-full"></div>
        </div>

        {{-- Inviter --}}
        <div class="text-center">
            <div class="w-14 h-14 rounded-full border-3 border-pink-300 flex items-center justify-center text-xl font-bold text-pink-500 mx-auto mb-1"
                 style="background: {{ $invite->inviter->color_hex ?? '#f9a8d4' }}20">
                {{ strtoupper(substr($invite->inviter->name, 0, 1)) }}
            </div>
            <p class="text-xs text-rose-600 font-semibold">{{ $invite->inviter->name }}</p>
            <p class="text-xs text-rose-300">Pasanganmu</p>
        </div>
    </div>

    {{-- Info box --}}
    <div class="animate-fade-up-delay2 p-4 rounded-xl bg-rose-50 border border-rose-100 mb-6">
        <p class="text-xs text-rose-500 font-semibold uppercase tracking-wider mb-2">Setelah terhubung, kalian bisa:</p>
        <ul class="space-y-1.5">
            @foreach(['💰 Mencatat transaksi bersama & individu', '🎯 Membuat tujuan tabungan bersama', '📊 Melihat laporan keuangan gabungan', '💳 Split bill & lacak hutang pasangan'] as $item)
                <li class="flex items-center gap-2 text-xs text-rose-500">
                    <span>{{ explode(' ', $item)[0] }}</span>
                    <span>{{ implode(' ', array_slice(explode(' ', $item), 1)) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Action buttons --}}
    <div class="animate-fade-up-delay3 space-y-3">
        {{-- Accept --}}
        <form method="POST" action="{{ route('couple.invite.confirm', $invite->token) }}">
            @csrf
            <button type="submit"
                    class="btn-love w-full py-3.5 rounded-xl text-white font-bold text-sm tracking-wide shadow-lg">
                💕 Ya, Terima Undangan!
            </button>
        </form>

        {{-- Decline --}}
        <a href="{{ route('couple.invite.index') }}"
           class="block w-full py-3 rounded-xl text-center text-sm font-medium text-rose-400 border border-rose-200 bg-white/60 hover:bg-rose-50 transition-colors">
            Tidak, Kembali
        </a>
    </div>

    {{-- Token info --}}
    <div class="animate-fade-up-delay3 mt-4 text-center">
        <p class="text-xs text-rose-300">
            Kode invite: <span class="font-mono font-bold">{{ $invite->token }}</span>
        </p>
    </div>
</div>
@endsection
