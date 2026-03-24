@extends('layouts.auth')

@section('title', 'Daftar ke LoveLedger')

@section('content')

{{-- Tab switcher --}}
<div class="flex border-b border-rose-100">
    <a href="{{ route('login') }}"
       class="flex-1 py-4 text-center text-sm font-medium text-rose-300 hover:text-rose-500 transition-colors">
        Masuk
    </a>
    <a href="{{ route('register') }}"
       class="flex-1 py-4 text-center text-sm font-semibold text-rose-600 border-b-2 border-rose-500 bg-rose-50/50 transition-all">
        Daftar
    </a>
</div>

<div class="p-8">
    {{-- Header --}}
    <div class="animate-fade-up text-center mb-7">
        <h1 class="font-display text-2xl font-bold text-rose-800 mb-1">Mulai Perjalanan Bersama 🌹</h1>
        <p class="text-sm text-rose-400">Buat akun LoveLedger dan undang pasanganmu</p>
    </div>

    {{-- Error bag --}}
    @if ($errors->any())
        <div class="animate-fade-up mb-5 p-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2"><span>❌</span> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div class="animate-fade-up-delay">
            <label for="name" class="block text-xs font-semibold text-rose-500 uppercase tracking-wider mb-1.5">
                Nama Panggilanmu
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-rose-300 text-lg">🌸</span>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama kamu (bisa nickname)"
                    class="input-love w-full pl-10 pr-4 py-3 rounded-xl border border-rose-200 bg-white/70 text-rose-900 placeholder-rose-300 text-sm transition-all duration-200 hover:border-rose-300"
                />
            </div>
            <p class="mt-1 text-xs text-rose-300">Ini yang akan dilihat pasanganmu 💕</p>
        </div>

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
                    autocomplete="username"
                    placeholder="nama@email.com"
                    class="input-love w-full pl-10 pr-4 py-3 rounded-xl border border-rose-200 bg-white/70 text-rose-900 placeholder-rose-300 text-sm transition-all duration-200 hover:border-rose-300"
                />
            </div>
        </div>

        {{-- Password --}}
        <div class="animate-fade-up-delay2">
            <label for="password" class="block text-xs font-semibold text-rose-500 uppercase tracking-wider mb-1.5">
                Password
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-rose-300 text-lg">🔑</span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Min. 8 karakter"
                    oninput="checkPasswordStrength(this.value)"
                    class="input-love w-full pl-10 pr-12 py-3 rounded-xl border border-rose-200 bg-white/70 text-rose-900 placeholder-rose-300 text-sm transition-all duration-200 hover:border-rose-300"
                />
                <button type="button"
                    onclick="togglePassword('password', this)"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-rose-300 hover:text-rose-500 transition-colors text-sm select-none">
                    👁️
                </button>
            </div>
            {{-- Password strength indicator --}}
            <div id="password-strength" class="mt-2 hidden">
                <div class="flex gap-1 mb-1">
                    <div id="bar1" class="h-1 flex-1 rounded-full bg-rose-100 transition-all duration-300"></div>
                    <div id="bar2" class="h-1 flex-1 rounded-full bg-rose-100 transition-all duration-300"></div>
                    <div id="bar3" class="h-1 flex-1 rounded-full bg-rose-100 transition-all duration-300"></div>
                    <div id="bar4" class="h-1 flex-1 rounded-full bg-rose-100 transition-all duration-300"></div>
                </div>
                <p id="strength-text" class="text-xs text-rose-400"></p>
            </div>
        </div>

        {{-- Confirm Password --}}
        <div class="animate-fade-up-delay2">
            <label for="password_confirmation" class="block text-xs font-semibold text-rose-500 uppercase tracking-wider mb-1.5">
                Konfirmasi Password
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-rose-300 text-lg">🔒</span>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                    oninput="checkPasswordMatch()"
                    class="input-love w-full pl-10 pr-12 py-3 rounded-xl border border-rose-200 bg-white/70 text-rose-900 placeholder-rose-300 text-sm transition-all duration-200 hover:border-rose-300"
                />
                <button type="button"
                    onclick="togglePassword('password_confirmation', this)"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-rose-300 hover:text-rose-500 transition-colors text-sm select-none">
                    👁️
                </button>
            </div>
            <p id="match-msg" class="mt-1 text-xs hidden"></p>
        </div>

        {{-- Info box --}}
        <div class="animate-fade-up-delay2 p-3 rounded-xl bg-rose-50 border border-rose-100 flex gap-2.5">
            <span class="text-xl mt-0.5 flex-shrink-0">💡</span>
            <p class="text-xs text-rose-500 leading-relaxed">
                Setelah daftar, kamu bisa <strong>mengundang pasangan</strong> dengan kode invite unik untuk menghubungkan akun kalian.
            </p>
        </div>

        {{-- Submit --}}
        <div class="animate-fade-up-delay3 pt-1">
            <button type="submit"
                class="btn-love w-full py-3.5 rounded-xl text-white font-bold text-sm tracking-wide shadow-lg">
                Buat Akun LoveLedger 💕
            </button>
        </div>
    </form>

    {{-- Terms --}}
    <div class="animate-fade-up-delay3 mt-4 text-center">
        <p class="text-xs text-rose-300 leading-relaxed">
            Dengan mendaftar, kamu menyetujui
            <a href="#" class="underline hover:text-rose-500 transition-colors">Syarat & Ketentuan</a>
            dan
            <a href="#" class="underline hover:text-rose-500 transition-colors">Kebijakan Privasi</a> kami
        </p>
    </div>

    {{-- Divider --}}
    <div class="animate-fade-up-delay3 flex items-center gap-3 my-5">
        <div class="flex-1 h-px bg-rose-100"></div>
        <span class="text-xs text-rose-300 font-medium">atau</span>
        <div class="flex-1 h-px bg-rose-100"></div>
    </div>

    {{-- Login link --}}
    <div class="animate-fade-up-delay3 text-center">
        <p class="text-sm text-rose-400">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-rose-500 hover:text-rose-700 transition-colors ml-1">
                Masuk di sini 🌸
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

function checkPasswordStrength(value) {
    const indicator = document.getElementById('password-strength');
    const bars = [document.getElementById('bar1'), document.getElementById('bar2'),
                  document.getElementById('bar3'), document.getElementById('bar4')];
    const text = document.getElementById('strength-text');

    if (!value) { indicator.classList.add('hidden'); return; }
    indicator.classList.remove('hidden');

    let score = 0;
    if (value.length >= 8)  score++;
    if (/[A-Z]/.test(value)) score++;
    if (/[0-9]/.test(value)) score++;
    if (/[^A-Za-z0-9]/.test(value)) score++;

    const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-400'];
    const labels = ['Lemah 😬', 'Lumayan 😐', 'Kuat 😊', 'Sangat Kuat 💪'];
    const textColors = ['text-red-400', 'text-orange-400', 'text-yellow-500', 'text-green-500'];

    bars.forEach((bar, i) => {
        bar.className = 'h-1 flex-1 rounded-full transition-all duration-300';
        if (i < score) bar.classList.add(colors[score - 1]);
        else bar.classList.add('bg-rose-100');
    });

    text.className = `text-xs ${textColors[score - 1] || 'text-rose-400'}`;
    text.textContent = labels[score - 1] || '';
}

function checkPasswordMatch() {
    const pw = document.getElementById('password').value;
    const cf = document.getElementById('password_confirmation').value;
    const msg = document.getElementById('match-msg');

    if (!cf) { msg.classList.add('hidden'); return; }
    msg.classList.remove('hidden');

    if (pw === cf) {
        msg.textContent = '✅ Password cocok!';
        msg.className = 'mt-1 text-xs text-green-500';
    } else {
        msg.textContent = '❌ Password belum cocok';
        msg.className = 'mt-1 text-xs text-red-400';
    }
}
</script>

@endsection
