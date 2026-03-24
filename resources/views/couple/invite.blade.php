@extends('layouts.auth')

@section('title', 'Undang Pasangan – LoveLedger')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="animate-fade-up text-center mb-8">
        <div class="text-5xl mb-3">💌</div>
        <h1 class="font-display text-2xl font-bold text-rose-800 mb-1">Undang Pasanganmu</h1>
        <p class="text-sm text-rose-400">Hubungkan akun kalian untuk mulai kelola keuangan bersama</p>
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="animate-fade-up mb-5 p-3.5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2">
            <span class="text-lg">✅</span> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="animate-fade-up mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm flex items-center gap-2">
            <span class="text-lg">😔</span> {{ session('error') }}
        </div>
    @endif

    {{-- ═══ BAGIAN A: Punya kode invite ═══ --}}
    @if ($invite)
        {{-- Kode aktif --}}
        <div class="animate-fade-up-delay mb-6 rounded-2xl overflow-hidden border border-rose-200 shadow-sm shadow-rose-100">

            {{-- Header card --}}
            <div class="px-5 py-3 flex items-center justify-between"
                 style="background: linear-gradient(135deg, #fff1f2, #fce7f3)">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🎫</span>
                    <span class="text-xs font-bold text-rose-500 uppercase tracking-wider">Kode Invite Aktif</span>
                </div>
                <span class="text-xs text-rose-400 bg-white/70 px-2 py-0.5 rounded-full border border-rose-100">
                    ⏰ {{ $invite->time_remaining }}
                </span>
            </div>

            <div class="p-5 bg-white/60">
                {{-- Token display --}}
                <div class="text-center mb-4">
                    <div id="token-display"
                         class="inline-block font-display text-4xl font-bold tracking-[0.3em] text-rose-600 bg-rose-50 border-2 border-dashed border-rose-200 rounded-2xl px-8 py-4 select-all cursor-pointer hover:border-rose-400 transition-colors"
                         onclick="copyToken('{{ $invite->token }}')"
                         title="Klik untuk copy">
                        {{ $invite->token }}
                    </div>
                    <p id="copy-hint" class="mt-2 text-xs text-rose-300">👆 Klik kode untuk menyalin</p>
                    <p id="copy-success" class="mt-2 text-xs text-green-500 hidden">✅ Kode berhasil disalin!</p>
                </div>

                {{-- Share via link --}}
                <div class="mb-4">
                    <p class="text-xs text-rose-500 font-semibold mb-2 uppercase tracking-wider">atau bagikan link langsung:</p>
                    <div class="flex gap-2">
                        <input type="text"
                               value="{{ route('couple.invite.accept', $invite->token) }}"
                               readonly
                               id="invite-url"
                               class="flex-1 text-xs px-3 py-2.5 rounded-xl border border-rose-200 bg-rose-50/50 text-rose-500 focus:outline-none"/>
                        <button onclick="copyLink()"
                                class="px-3 py-2.5 rounded-xl text-white text-xs font-semibold shadow-sm transition-all hover:scale-105 active:scale-95"
                                style="background: linear-gradient(135deg, #f43f5e, #ec4899)">
                            📋 Copy
                        </button>
                    </div>
                    <p id="link-copy-success" class="mt-1.5 text-xs text-green-500 hidden">✅ Link berhasil disalin!</p>
                </div>

                {{-- Share buttons --}}
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <a href="https://wa.me/?text={{ urlencode('Hei! Aku mengundangmu untuk bergabung di LoveLedger 💕 Gunakan kode: ' . $invite->token . ' atau klik: ' . route('couple.invite.accept', $invite->token)) }}"
                       target="_blank"
                       class="flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 hover:shadow-md"
                       style="background: #25D366">
                        <span>📱</span> WhatsApp
                    </a>
                    <button onclick="copyToken('{{ $invite->token }}')"
                            class="flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-rose-600 border border-rose-200 bg-rose-50 transition-all hover:bg-rose-100">
                        <span>📋</span> Salin Kode
                    </button>
                </div>

                {{-- Cancel invite --}}
                <form method="POST" action="{{ route('couple.invite.cancel', $invite) }}"
                      onsubmit="return confirm('Batalkan kode invite ini?')">
                    @csrf @method('POST')
                    {{-- Note: cancel pakai POST bukan DELETE untuk simplicity --}}
                    <button type="submit"
                            class="w-full py-2 text-xs text-rose-300 hover:text-rose-500 transition-colors">
                        ✕ Batalkan kode ini & buat yang baru
                    </button>
                </form>
            </div>
        </div>

    @else
        {{-- Belum punya kode invite --}}
        <div class="animate-fade-up-delay mb-6 p-5 rounded-2xl border-2 border-dashed border-rose-200 text-center">
            <div class="text-4xl mb-3">💌</div>
            <p class="text-sm text-rose-500 mb-4">Buat kode invite untuk dikirim ke pasanganmu</p>
            <form method="POST" action="{{ route('couple.invite.generate') }}">
                @csrf
                <button type="submit"
                        class="btn-love px-8 py-3 rounded-xl text-white font-bold text-sm shadow-lg">
                    🎫 Buat Kode Invite
                </button>
            </form>
        </div>
    @endif

    {{-- Divider --}}
    <div class="flex items-center gap-3 my-5">
        <div class="flex-1 h-px bg-rose-100"></div>
        <span class="text-xs text-rose-300 font-medium">punya kode dari pasangan?</span>
        <div class="flex-1 h-px bg-rose-100"></div>
    </div>

    {{-- ═══ BAGIAN B: Masukkan kode dari pasangan ═══ --}}
    <div class="animate-fade-up-delay2">
        <p class="text-xs font-semibold text-rose-500 uppercase tracking-wider mb-2">Masukkan Kode Invite</p>
        @if ($errors->has('code'))
            <p class="text-xs text-red-400 mb-2 flex items-center gap-1">
                <span>❌</span> {{ $errors->first('code') }}
            </p>
        @endif
        <form method="POST" action="{{ route('couple.invite.code') }}" class="flex gap-2">
            @csrf
            <input type="text"
                   name="code"
                   value="{{ old('code') }}"
                   placeholder="XXXX-XXXX"
                   maxlength="9"
                   oninput="formatCode(this)"
                   class="input-love flex-1 px-4 py-3 rounded-xl border border-rose-200 bg-white/70 text-rose-900 placeholder-rose-300 text-sm font-mono tracking-widest uppercase text-center transition-all hover:border-rose-300"/>
            <button type="submit"
                    class="btn-love px-5 py-3 rounded-xl text-white font-bold text-sm shadow-md">
                Gabung 💕
            </button>
        </form>
        <p class="mt-2 text-xs text-rose-300 text-center">Format: 4 huruf/angka, dash, 4 huruf/angka</p>
    </div>

</div>

<script>
function copyToken(token) {
    navigator.clipboard.writeText(token).then(() => {
        document.getElementById('copy-hint').classList.add('hidden');
        document.getElementById('copy-success').classList.remove('hidden');
        document.getElementById('token-display').classList.add('border-green-400', 'bg-green-50');
        document.getElementById('token-display').classList.remove('border-rose-200', 'bg-rose-50');
        setTimeout(() => {
            document.getElementById('copy-hint').classList.remove('hidden');
            document.getElementById('copy-success').classList.add('hidden');
            document.getElementById('token-display').classList.remove('border-green-400', 'bg-green-50');
            document.getElementById('token-display').classList.add('border-rose-200', 'bg-rose-50');
        }, 2500);
    });
}

function copyLink() {
    const url = document.getElementById('invite-url').value;
    navigator.clipboard.writeText(url).then(() => {
        document.getElementById('link-copy-success').classList.remove('hidden');
        setTimeout(() => document.getElementById('link-copy-success').classList.add('hidden'), 2500);
    });
}

function formatCode(input) {
    let val = input.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
    if (val.length > 4) val = val.slice(0, 4) + '-' + val.slice(4, 8);
    input.value = val;
}
</script>
@endsection
