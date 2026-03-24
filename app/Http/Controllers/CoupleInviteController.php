<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use App\Models\CoupleInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoupleInviteController extends Controller
{
    // ─── 1. Halaman utama invite ──────────────────────────────────

    /**
     * Tampilkan halaman invite (generate kode, lihat status, dll).
     */
    public function index()
    {
        $user = Auth::user();

        // Jika sudah punya pasangan, redirect ke dashboard
        if ($user->couple_id) {
            return redirect()->route('dashboard')
                ->with('info', 'Kamu sudah terhubung dengan pasangan 💕');
        }

        // Ambil invite pending yang masih valid
        $invite = CoupleInvite::where('inviter_id', $user->id)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        return view('couple.invite', compact('user', 'invite'));
    }

    // ─── 2. Generate kode invite baru ────────────────────────────

    public function generate()
    {
        $user = Auth::user();

        if ($user->couple_id) {
            return back()->with('error', 'Kamu sudah punya pasangan! 💕');
        }

        $invite = CoupleInvite::createForUser($user);

        return back()->with('success', "Kode invite berhasil dibuat: {$invite->token} 🎉");
    }

    // ─── 3. Batalkan invite ───────────────────────────────────────

    public function cancel(CoupleInvite $invite)
    {
        $user = Auth::user();

        // Pastikan invite milik user ini
        abort_if($invite->inviter_id !== $user->id, 403);

        $invite->update(['status' => 'cancelled']);

        return back()->with('success', 'Kode invite berhasil dibatalkan.');
    }

    // ─── 4. Halaman accept invite (dari link/kode) ────────────────

    /**
     * Halaman konfirmasi sebelum menerima invite.
     * Bisa dari URL: /invite/{token}
     * Atau dari form input kode manual.
     */
    public function showAccept(string $token)
    {
        $user = Auth::user();

        if ($user->couple_id) {
            return redirect()->route('dashboard')
                ->with('info', 'Kamu sudah terhubung dengan pasangan 💕');
        }

        $invite = CoupleInvite::where('token', strtoupper($token))
            ->where('status', 'pending')
            ->with('inviter')
            ->first();

        if (!$invite) {
            return redirect()->route('couple.invite.index')
                ->with('error', 'Kode invite tidak ditemukan atau sudah tidak berlaku. 😔');
        }

        if ($invite->isExpired()) {
            $invite->update(['status' => 'expired']);
            return redirect()->route('couple.invite.index')
                ->with('error', 'Kode invite sudah kedaluwarsa. Minta kode baru ya! ⏰');
        }

        // Tidak bisa accept invite sendiri
        if ($invite->inviter_id === $user->id) {
            return redirect()->route('couple.invite.index')
                ->with('error', 'Kamu tidak bisa menerima invite milik sendiri 😄');
        }

        return view('couple.accept', compact('invite', 'user'));
    }

    /**
     * Proses input kode manual dari form.
     */
    public function inputCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'regex:/^[A-Za-z0-9]{4}-[A-Za-z0-9]{4}$/'],
        ], [
            'code.required' => 'Kode invite wajib diisi.',
            'code.regex' => 'Format kode harus XXXX-XXXX (8 karakter).',
        ]);

        return redirect()->route('couple.invite.accept', [
            'token' => strtoupper($request->code),
        ]);
    }

    // ─── 5. Konfirmasi & simpan pasangan ─────────────────────────

    public function accept(string $token)
    {
        $user = Auth::user();

        if ($user->couple_id) {
            return redirect()->route('dashboard')
                ->with('info', 'Kamu sudah terhubung dengan pasangan 💕');
        }

        $invite = CoupleInvite::where('token', strtoupper($token))
            ->where('status', 'pending')
            ->with('inviter')
            ->first();

        if (!$invite || $invite->isExpired() || $invite->inviter_id === $user->id) {
            return redirect()->route('couple.invite.index')
                ->with('error', 'Invite tidak valid atau sudah tidak berlaku. 😔');
        }

        DB::transaction(function () use ($invite, $user) {
            // Buat entitas couple
            $couple = Couple::create([
                'user1_id' => $invite->inviter_id,
                'user2_id' => $user->id,
                'privacy_mode' => 'shared',
            ]);

            // Update kedua user dengan couple_id
            $invite->inviter->update(['couple_id' => $couple->id]);
            $user->update(['couple_id' => $couple->id]);

            // Update status invite
            $invite->update([
                'status' => 'accepted',
                'accepted_by' => $user->id,
                'accepted_at' => now(),
            ]);
        });

        return redirect()->route('couple.setup')
            ->with('success', "Yeay! Kamu dan {$invite->inviter->name} sekarang resmi jadi pasangan di LoveLedger! 💕🎉");
    }

    // ─── 6. Setup awal pasangan (nama & anniversary) ─────────────

    public function showSetup()
    {
        $user = Auth::user()->loadCouple();
        $couple = $user->couple;

        if (!$couple) {
            return redirect()->route('couple.invite.index');
        }

        return view('couple.setup', compact('user', 'couple'));
    }

    public function saveSetup(Request $request)
    {
        $user = Auth::user();
        $couple = $user->couple;

        abort_if(!$couple, 404);

        $validated = $request->validate([
            'couple_name' => ['nullable', 'string', 'max:100'],
            'anniversary_date' => ['nullable', 'date', 'before_or_equal:today'],
            'privacy_mode' => ['required', 'in:shared,semi_private'],
        ], [
            'couple_name.max' => 'Nama pasangan maksimal 100 karakter.',
            'anniversary_date.before_or_equal' => 'Tanggal anniversary tidak boleh di masa depan.',
            'privacy_mode.required' => 'Mode kolaborasi wajib dipilih.',
        ]);

        $couple->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Profil pasangan berhasil disimpan! Selamat memulai perjalanan finansial bersama 💕');
    }

    // ─── 7. Putuskan pasangan ─────────────────────────────────────

    public function disconnect(Request $request)
    {
        $request->validate([
            'confirm' => ['required', 'in:PUTUSKAN'],
        ], [
            'confirm.in' => 'Ketik PUTUSKAN untuk konfirmasi.',
        ]);

        $user = Auth::user();
        $couple = $user->couple;

        abort_if(!$couple, 404);

        DB::transaction(function () use ($couple) {
            // Reset couple_id kedua user
            $couple->user1->update(['couple_id' => null]);
            $couple->user2->update(['couple_id' => null]);
            $couple->delete();
        });

        return redirect()->route('couple.invite.index')
            ->with('success', 'Hubungan pasangan telah diputus. 💔');
    }
}
