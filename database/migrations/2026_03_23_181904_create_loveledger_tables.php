<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    // ── 1. USERS ──────────────────────────────────
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('email')->unique();
      $table->string('nickname')->nullable();
      $table->string('avatar')->nullable();
      $table->string('color_hex', 7)->default('#F43F5E');
      $table->date('birth_date')->nullable();
      $table->enum('gender', ['male','female','other'])->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();
      $table->timestamps();
    });

    // ── 2. PASSWORD RESET TOKENS ──────────────────
    Schema::create('password_reset_tokens', function (Blueprint $table) {
      $table->string('email')->primary();
      $table->string('token');
      $table->timestamp('created_at')->nullable();
    });

    // ── 3. SESSIONS ───────────────────────────────
    Schema::create('sessions', function (Blueprint $table) {
      $table->string('id')->primary();
      $table->foreignId('user_id')->nullable()->index();
      $table->string('ip_address', 45)->nullable();
      $table->text('user_agent')->nullable();
      $table->longText('payload');
      $table->integer('last_activity')->index();
    });

    // ── 4. COUPLES ────────────────────────────────
    Schema::create('couples', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user1_id')->constrained('users')->cascadeOnDelete();
      $table->foreignId('user2_id')->nullable()->constrained('users')->nullOnDelete();
      $table->string('couple_name')->nullable(); // e.g. "Tim Hemat 2026"
      $table->date('anniversary_date')->nullable();
      $table->enum('privacy_mode', ['shared','semi_private'])->default('shared');
      $table->integer('health_score')->default(50);
      $table->timestamps();
    });

    // ── 5. COUPLE INVITES ─────────────────────────
    Schema::create('couple_invites', function (Blueprint $table) {
      $table->id();
      $table->foreignId('inviter_id')->constrained('users')->cascadeOnDelete();
      $table->string('token', 8)->unique();
      $table->enum('status', ['pending','accepted','expired'])->default('pending');
      $table->timestamp('expires_at');
      $table->timestamps();
    });

    // ── 6. WALLETS ────────────────────────────────
    Schema::create('wallets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
      $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
      $table->string('name');
      $table->string('emoji', 8)->default('💰');
      $table->enum('type', ['personal','shared'])->default('personal');
      $table->decimal('balance', 15, 2)->default(0);
      $table->string('color_hex', 7)->default('#F43F5E');
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });

    // ── 7. CATEGORIES ─────────────────────────────
    Schema::create('categories', function (Blueprint $table) {
      $table->id();
      $table->foreignId('couple_id')->nullable()->constrained()->nullOnDelete();
      $table->string('name');
      $table->string('emoji', 8)->default('📦');
      $table->enum('type', ['income','expense','both'])->default('expense');
      $table->string('color_hex', 7)->default('#6B7280');
      $table->boolean('is_default')->default(false); // system default, null couple_id
      $table->integer('sort_order')->default(0);
      $table->timestamps();
    });

    // ── 8. TRANSACTIONS ───────────────────────────
    Schema::create('transactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('wallet_id')->nullable()->constrained()->nullOnDelete();
      $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
      $table->enum('type', ['income','expense','saving','transfer','investment']);
      $table->decimal('amount', 15, 2);
      $table->string('description')->nullable();
      $table->enum('mood', ['happy','neutral','stress','fomo','hungry','guilty'])->default('neutral');
      $table->string('receipt_photo')->nullable();
      $table->json('tags')->nullable();
      $table->boolean('is_recurring')->default(false);
      $table->enum('recurring_freq', ['daily','weekly','monthly','yearly'])->nullable();
      $table->date('transaction_date');
      $table->softDeletes();
      $table->timestamps();

      $table->index(['couple_id','transaction_date']);
      $table->index(['couple_id','type']);
    });

    // ── 9. GOALS ──────────────────────────────────
    Schema::create('goals', function (Blueprint $table) {
      $table->id();
      $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
      $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
      $table->string('name');
      $table->string('emoji', 8)->default('🎯');
      $table->string('photo_url')->nullable();
      $table->text('description')->nullable();
      $table->decimal('target_amount', 15, 2);
      $table->decimal('current_amount', 15, 2)->default(0);
      $table->date('deadline')->nullable();
      $table->enum('type', ['shared','personal','emergency'])->default('shared');
      $table->integer('user1_ratio')->default(50); // %
      $table->integer('user2_ratio')->default(50);
      $table->enum('status', ['active','completed','paused','cancelled'])->default('active');
      $table->json('milestones')->nullable(); // [{name,amount,reached_at}]
      $table->timestamps();
    });

    // ── 10. GOAL CONTRIBUTIONS ────────────────────
    Schema::create('goal_contributions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('goal_id')->constrained()->cascadeOnDelete();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
      $table->decimal('amount', 15, 2);
      $table->string('note')->nullable();
      $table->date('contributed_at');
      $table->timestamps();
    });

    // ── 11. SPLIT BILLS ───────────────────────────
    Schema::create('split_bills', function (Blueprint $table) {
      $table->id();
      $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
      $table->foreignId('paid_by')->constrained('users')->cascadeOnDelete();
      $table->decimal('total_amount', 15, 2);
      $table->enum('split_type', ['equal','custom','percentage'])->default('equal');
      $table->decimal('user1_amount', 15, 2);
      $table->decimal('user2_amount', 15, 2);
      $table->string('description')->nullable();
      $table->string('emoji', 8)->default('🧾');
      $table->boolean('is_settled')->default(false);
      $table->timestamp('settled_at')->nullable();
      $table->date('bill_date');
      $table->timestamps();
    });

    // ── 12. BUDGETS ───────────────────────────────
    Schema::create('budgets', function (Blueprint $table) {
      $table->id();
      $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
      $table->foreignId('category_id')->constrained()->cascadeOnDelete();
      $table->decimal('limit_amount', 15, 2);
      $table->integer('month'); // 1-12
      $table->integer('year');
      $table->timestamps();
      $table->unique(['couple_id','category_id','month','year']);
    });

    // ── 13. REMINDERS ─────────────────────────────
    Schema::create('reminders', function (Blueprint $table) {
      $table->id();
      $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
      $table->string('title');
      $table->string('emoji', 8)->default('🔔');
      $table->decimal('amount', 15, 2)->nullable();
      $table->enum('frequency', ['once','monthly','yearly'])->default('monthly');
      $table->integer('due_day')->nullable(); // tanggal dalam bulan
      $table->date('due_date')->nullable(); // untuk once
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });

    // ── 14. BADGES ────────────────────────────────
    Schema::create('badges', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('description');
      $table->string('emoji', 8);
      $table->string('slug')->unique();
      $table->timestamps();
    });

    // ── 15. COUPLE BADGES ─────────────────────────
    Schema::create('couple_badges', function (Blueprint $table) {
      $table->id();
      $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
      $table->foreignId('badge_id')->constrained()->cascadeOnDelete();
      $table->timestamp('earned_at');
      $table->unique(['couple_id','badge_id']);
    });

    // ── 16. NOTIFICATIONS ─────────────────────────
    Schema::create('notifications', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('type');
      $table->morphs('notifiable');
      $table->text('data');
      $table->timestamp('read_at')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    // Drop in reverse order to respect FK constraints
    collect([
      'notifications','couple_badges','badges','reminders','budgets',
      'split_bills','goal_contributions','goals','transactions',
      'categories','wallets','couple_invites','couples',
      'sessions','password_reset_tokens','users',
    ])->each(fn($t) => Schema::dropIfExists($t));
  }
};
