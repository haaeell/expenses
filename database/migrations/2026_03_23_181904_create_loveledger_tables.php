<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── 1. USERS ──────────────────────────────────
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nickname')->nullable();
            $table->string('avatar')->nullable();
            $table->string('color_hex', 7)->default('#F43F5E');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
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
            $table->string('couple_name')->nullable();
            $table->date('anniversary_date')->nullable();
            $table->enum('privacy_mode', ['shared', 'semi_private'])->default('shared');
            $table->integer('health_score')->default(50);
            $table->timestamps();
        });

        // ── 5. COUPLE INVITES ─────────────────────────
        Schema::create('couple_invites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inviter_id')->constrained('users')->cascadeOnDelete();
            $table->string('token', 20)->unique();
            $table->enum('status', ['pending', 'accepted', 'expired','cancelled'])->default('pending');
            $table->foreignId('accepted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
        });

        // ── 6. CATEGORIES ─────────────────────────────
        // Must come before transactions
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('emoji', 8)->default('📦');
            $table->enum('type', ['income', 'expense', 'saving', 'investment'])->default('expense');
            $table->string('color_hex', 7)->default('#6B7280');
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // ── 7. WALLETS ────────────────────────────────
        // Must come before transactions & recurring_transactions
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('emoji', 8)->default('💰');
            $table->enum('type', ['personal', 'shared', 'savings', 'investment'])->default('personal');
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('color_hex', 7)->default('#F43F5E');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // ── 8. TRANSACTIONS ───────────────────────────
        // Depends on: couples, users, wallets, categories
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('wallet_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['income', 'expense', 'saving', 'transfer', 'investment']);
            $table->decimal('amount', 15, 2);
            $table->string('description')->nullable();
            $table->enum('mood', ['happy', 'neutral', 'stress', 'fomo', 'hungry', 'guilty'])->default('neutral');
            $table->string('receipt_photo')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_freq', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->date('transaction_date');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['couple_id', 'transaction_date']);
            $table->index(['couple_id', 'type']);
        });

        // ── 9. RECURRING TRANSACTIONS ─────────────────
        // Depends on: couples, users, categories, wallets
        Schema::create('recurring_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('wallet_id')->constrained()->restrictOnDelete();
            $table->enum('type', ['income', 'expense', 'saving', 'investment']);
            $table->decimal('amount', 15, 2);
            $table->string('description')->nullable();
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'yearly']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('next_run_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── 10. GOALS ─────────────────────────────────
        // Depends on: couples, users
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
            $table->enum('type', ['shared', 'personal', 'emergency'])->default('shared');
            $table->integer('user1_ratio')->default(50);
            $table->integer('user2_ratio')->default(50);
            $table->enum('status', ['active', 'completed', 'paused', 'cancelled'])->default('active');
            $table->json('milestones')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // ── 11. GOAL MILESTONES ───────────────────────
        // Depends on: goals
        Schema::create('goal_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('target_amount', 15, 2);
            $table->integer('order')->default(0);
            $table->boolean('is_reached')->default(false);
            $table->timestamp('reached_at')->nullable();
            $table->timestamps();
        });

        // ── 12. GOAL CONTRIBUTIONS ────────────────────
        // Depends on: goals, users, transactions
        Schema::create('goal_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('note')->nullable();
            $table->timestamp('contributed_at');
            $table->timestamps();
        });

        // ── 13. SPLIT BILL EVENTS ─────────────────────
        // Depends on: couples
        Schema::create('split_bill_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('emoji', 10)->default('🎉');
            $table->date('event_date')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });

        // ── 14. SPLIT BILLS ───────────────────────────
        // Depends on: couples, users, transactions, split_bill_events
        Schema::create('split_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->foreignId('paid_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('event_id')->nullable()->constrained('split_bill_events')->nullOnDelete();
            $table->decimal('total_amount', 15, 2);
            $table->enum('split_type', ['equal', 'custom', 'percentage'])->default('equal');
            $table->decimal('user1_amount', 15, 2);
            $table->decimal('user2_amount', 15, 2);
            $table->text('description')->nullable();
            $table->boolean('is_settled')->default(false);
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['couple_id', 'is_settled']);
        });

        // ── 15. BUDGETS ───────────────────────────────
        // Depends on: couples, categories
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->decimal('limit_amount', 15, 2);
            $table->integer('month'); // 1-12
            $table->integer('year');
            $table->timestamps();
            $table->unique(['couple_id', 'category_id', 'month', 'year']);
        });

        // ── 16. MISSIONS ──────────────────────────────
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('emoji', 10)->default('🎯');
            $table->enum('type', ['saving', 'recording', 'budget', 'challenge'])->default('challenge');
            $table->json('criteria');
            $table->integer('reward_points')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── 17. COUPLE MISSIONS ───────────────────────
        // Depends on: couples, missions
        Schema::create('couple_missions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mission_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['active', 'completed', 'failed', 'abandoned'])->default('active');
            $table->integer('progress')->default(0); // 0-100
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('deadline_at')->nullable();
            $table->timestamps();
        });

        // ── 18. REMINDERS ─────────────────────────────
        // Depends on: couples, transactions
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('message')->nullable();
            $table->enum('type', ['bill_due', 'goal', 'budget_alert', 'weekly_summary', 'monthly_review', 'anniversary', 'salary'])->default('bill_due');
            $table->enum('frequency', ['once', 'daily', 'weekly', 'monthly', 'yearly'])->default('once');
            $table->json('notify_days_before')->nullable();
            $table->date('due_date')->nullable();
            $table->time('remind_at')->default('08:00:00');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // ── 19. BADGES ────────────────────────────────
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('emoji', 10);
            $table->string('image_url')->nullable();
            $table->json('criteria');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── 20. COUPLE BADGES ─────────────────────────
        // Depends on: couples, badges
        Schema::create('couple_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->foreignId('badge_id')->constrained()->cascadeOnDelete();
            $table->timestamp('earned_at');
            $table->unique(['couple_id', 'badge_id']);
        });

        // ── 21. FINANCIAL SCORES ──────────────────────
        // Depends on: couples
        Schema::create('financial_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('score'); // 0-100
            $table->string('level');
            $table->json('breakdown')->nullable();
            $table->date('recorded_date');
            $table->timestamps();

            $table->index(['couple_id', 'recorded_date']);
        });

        // ── 22. NOTIFICATIONS ─────────────────────────
        // Depends on: users, couples
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('couple_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');
            $table->json('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'read_at']);
        });

        // ── 23. CALENDAR SYNCS ────────────────────────
        // Depends on: couples, users, reminders
        Schema::create('calendar_syncs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reminder_id')->nullable()->constrained()->nullOnDelete();
            $table->string('google_event_id')->nullable();
            $table->string('google_calendar_id')->nullable();
            $table->enum('status', ['synced', 'pending', 'failed'])->default('pending');
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
        });

        // ── 24. REPORTS CACHE ─────────────────────────
        // Depends on: couples
        Schema::create('reports_cache', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['monthly', 'yearly', 'anniversary', 'mood_analysis']);
            $table->unsignedTinyInteger('month')->nullable();
            $table->unsignedSmallInteger('year');
            $table->json('data');
            $table->timestamp('generated_at');
            $table->timestamps();

            $table->unique(['couple_id', 'type', 'month', 'year']);
            $table->index(['couple_id', 'type', 'year']);
        });
    }

    public function down(): void
    {
        // Drop in strict reverse-dependency order
        collect([
            'reports_cache',
            'calendar_syncs',
            'notifications',
            'financial_scores',
            'couple_badges',
            'badges',
            'reminders',
            'couple_missions',
            'missions',
            'budgets',
            'split_bills',
            'split_bill_events',
            'goal_contributions',
            'goal_milestones',
            'goals',
            'recurring_transactions',
            'transactions',
            'wallets',
            'categories',
            'couple_invites',
            'couples',
            'sessions',
            'password_reset_tokens',
            'users',
        ])->each(fn($t) => Schema::dropIfExists($t));
    }
};
