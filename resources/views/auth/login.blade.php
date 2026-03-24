@extends('layouts.auth')

@section('title', 'Masuk ke LoveLedger')

@section('content')

{{-- Tab switcher --}}
<div class="flex border-b border-rose-100">
    <a href="{{ route('login') }}"
       class="flex-1 py-4 text-center text-sm font-semibold text-rose-600 border-b-2 border-rose-500 bg-rose-50/50 transition-all">
        Masuk
    </a>
    <a href="{{ route('register') }}"
       class="flex-1 py-4 text-center text-sm font-medium text-rose-300 hover:text-rose-500 transition-colors">
        Daftar
    </a>
</div>

<div class="p-8">
    {{-- Header --}}
    <div class="animate-fade-up text-center mb-7">
        <h1 class="font-display text-2xl font-bold text-rose-800 mb-1">Selamat Datang Kembali 👋</h1>
        <p class="text-sm text-rose-400">Masuk dan lanjutkan perjalanan finansialmu bersama</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="animate-fade-up mb-5 p-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2">
            <span>✅</span> {{ session('status') }}
        </div>
    @endif

    {{-- Error bag --}}
    @if ($errors->any())
        <div class="animate-fade-up mb-5 p-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2"><span>❌</span> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div class="animate-fade-up-delay">
            <label for="email" class="block text-xs font-semibold text-rose-500 uppercase tracking-wider mb-1.5">
                Email
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-rose-300 text-lg">📧</span>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nama@email.com"
                    class="input-love w-full pl-10 pr-4 py-3 rounded-xl border border-rose-200 bg-white/70 text-rose-900 placeholder-rose-300 text-sm transition-all duration-200 hover:border-rose-300"
                />
            </div>
        </div>

        {{-- Password --}}
        <div class="animate-fade-up-delay2">
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-rose-500 uppercase tracking-wider">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-rose-400 hover:text-rose-600 transition-colors">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-rose-300 text-lg">🔑</span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="input-love w-full pl-10 pr-12 py-3 rounded-xl border border-rose-200 bg-white/70 text-rose-900 placeholder-rose-300 text-sm transition-all duration-200 hover:border-rose-300"
                />
                {{-- Toggle show/hide password --}}
                <button type="button"
                    onclick="togglePassword('password', this)"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-rose-300 hover:text-rose-500 transition-colors text-sm select-none">
                    👁️
                </button>
            </div>
        </div>

        {{-- Remember me --}}
        <div class="animate-fade-up-delay2 flex items-center gap-2.5">
            <input
                type="checkbox"
                id="remember_me"
                name="remember"
                class="w-4 h-4 rounded border-rose-300 text-rose-500 accent-rose-500 cursor-pointer"
            />
            <label for="remember_me" class="text-sm text-rose-500 cursor-pointer select-none">
                Ingat saya di perangkat ini
            </label>
        </div>

        {{-- Submit --}}
        <div class="animate-fade-up-delay3 pt-1">
            <button type="submit"
                class="btn-love w-full py-3.5 rounded-xl text-white font-bold text-sm tracking-wide shadow-lg">
                Masuk ke LoveLedger 💕
            </button>
        </div>
    </form>

    {{-- Divider --}}
    <div class="animate-fade-up-delay3 flex items-center gap-3 my-6">
        <div class="flex-1 h-px bg-rose-100"></div>
        <span class="text-xs text-rose-300 font-medium">atau</span>
        <div class="flex-1 h-px bg-rose-100"></div>
    </div>

    {{-- Register link --}}
    <div class="animate-fade-up-delay3 text-center">
        <p class="text-sm text-rose-400">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-rose-500 hover:text-rose-700 transition-colors ml-1">
                Daftar sekarang ✨
            </a>
        </p>
    </div>
</div>

<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    if (field.type === 'password') {
        field.type = 'text';
        btn.textContent = '🙈';
    } else {
        field.type = 'password';
        btn.textContent = '👁️';
    }
}
</script>

@endsection
