<?php
namespace Database\Seeders;
use App\Models\{Category, Badge};
use Illuminate\Database\Seeder;

class DefaultDataSeeder extends Seeder {
  public function run(): void {
    // ── Default Categories ──────────────────────────
    $categories = [
      // Expense
      ['name'=>'Makan & Minuman', 'emoji'=>'🍜', 'type'=>'expense', 'color_hex'=>'#F97316'],
      ['name'=>'Transport',       'emoji'=>'🚗', 'type'=>'expense', 'color_hex'=>'#3B82F6'],
      ['name'=>'Belanja',         'emoji'=>'🛍️', 'type'=>'expense', 'color_hex'=>'#EC4899'],
      ['name'=>'Hiburan',         'emoji'=>'🎬', 'type'=>'expense', 'color_hex'=>'#8B5CF6'],
      ['name'=>'Kesehatan',       'emoji'=>'💊', 'type'=>'expense', 'color_hex'=>'#10B981'],
      ['name'=>'Tagihan',         'emoji'=>'💡', 'type'=>'expense', 'color_hex'=>'#EAB308'],
      ['name'=>'Pendidikan',      'emoji'=>'📚', 'type'=>'expense', 'color_hex'=>'#6366F1'],
      ['name'=>'Date Night',     'emoji'=>'💕', 'type'=>'expense', 'color_hex'=>'#F43F5E'],
      ['name'=>'Lain-lain',      'emoji'=>'📦', 'type'=>'expense', 'color_hex'=>'#6B7280'],
      // Income
      ['name'=>'Gaji',            'emoji'=>'💰', 'type'=>'income',  'color_hex'=>'#10B981'],
      ['name'=>'Freelance',       'emoji'=>'💻', 'type'=>'income',  'color_hex'=>'#3B82F6'],
      ['name'=>'Bonus',           'emoji'=>'🎁', 'type'=>'income',  'color_hex'=>'#F59E0B'],
      ['name'=>'Investasi',       'emoji'=>'📈', 'type'=>'income',  'color_hex'=>'#6366F1'],
      ['name'=>'Transfer Masuk',  'emoji'=>'🔄', 'type'=>'income',  'color_hex'=>'#14B8A6'],
    ];

    foreach ($categories as $i => $cat) {
      Category::create([...$cat, 'is_default'=>true, 'sort_order'=>$i]);
    }

    // ── Badges ──────────────────────────────────────
    $badges = [

            // ──────────────────────────────────────────────
            //  PENCATATAN TRANSAKSI
            // ──────────────────────────────────────────────
            [
                'name'        => 'First Step',
                'description' => 'Catat transaksi pertama kamu bersama.',
                'emoji'       => '👣',
                'image_url'   => null,
                'criteria'    => ['type' => 'transaction_count', 'count' => 1],
                'is_active'   => true,
            ],
            [
                'name'        => 'On a Roll',
                'description' => 'Catat 50 transaksi.',
                'emoji'       => '🎲',
                'image_url'   => null,
                'criteria'    => ['type' => 'transaction_count', 'count' => 50],
                'is_active'   => true,
            ],
            [
                'name'        => 'Century Club',
                'description' => 'Catat 100 transaksi.',
                'emoji'       => '💯',
                'image_url'   => null,
                'criteria'    => ['type' => 'transaction_count', 'count' => 100],
                'is_active'   => true,
            ],
            [
                'name'        => 'Pencatat Sejati',
                'description' => 'Catat 500 transaksi.',
                'emoji'       => '📒',
                'image_url'   => null,
                'criteria'    => ['type' => 'transaction_count', 'count' => 500],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  STREAK HARIAN
            // ──────────────────────────────────────────────
            [
                'name'        => 'Week Warrior',
                'description' => 'Catat transaksi 7 hari berturut-turut.',
                'emoji'       => '🗓️',
                'image_url'   => null,
                'criteria'    => ['type' => 'daily_streak', 'days' => 7],
                'is_active'   => true,
            ],
            [
                'name'        => 'Bulan Produktif',
                'description' => 'Catat transaksi 30 hari berturut-turut.',
                'emoji'       => '🔥',
                'image_url'   => null,
                'criteria'    => ['type' => 'daily_streak', 'days' => 30],
                'is_active'   => true,
            ],
            [
                'name'        => 'Konsisten Banget',
                'description' => 'Catat transaksi 100 hari berturut-turut.',
                'emoji'       => '⚡',
                'image_url'   => null,
                'criteria'    => ['type' => 'daily_streak', 'days' => 100],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  TABUNGAN & GOALS
            // ──────────────────────────────────────────────
            [
                'name'        => 'Dream Starters',
                'description' => 'Buat goal pertama kalian bersama.',
                'emoji'       => '🌱',
                'image_url'   => null,
                'criteria'    => ['type' => 'goal_created', 'count' => 1],
                'is_active'   => true,
            ],
            [
                'name'        => 'Goal Getter',
                'description' => 'Selesaikan 1 goal bersama.',
                'emoji'       => '🏆',
                'image_url'   => null,
                'criteria'    => ['type' => 'goal_completed', 'count' => 1],
                'is_active'   => true,
            ],
            [
                'name'        => 'Dream Team',
                'description' => 'Selesaikan 5 goal bersama.',
                'emoji'       => '🌟',
                'image_url'   => null,
                'criteria'    => ['type' => 'goal_completed', 'count' => 5],
                'is_active'   => true,
            ],
            [
                'name'        => 'Halfway There',
                'description' => 'Capai 50% dari sebuah goal.',
                'emoji'       => '🎯',
                'image_url'   => null,
                'criteria'    => ['type' => 'goal_progress', 'percentage' => 50],
                'is_active'   => true,
            ],
            [
                'name'        => 'Dana Darurat Ready',
                'description' => 'Selesaikan goal bertipe Emergency Fund.',
                'emoji'       => '🛡️',
                'image_url'   => null,
                'criteria'    => ['type' => 'goal_completed_by_type', 'goal_type' => 'emergency'],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  BUDGET
            // ──────────────────────────────────────────────
            [
                'name'        => 'Budget Maker',
                'description' => 'Buat budget pertama kali.',
                'emoji'       => '📊',
                'image_url'   => null,
                'criteria'    => ['type' => 'budget_created', 'count' => 1],
                'is_active'   => true,
            ],
            [
                'name'        => 'Under Control',
                'description' => 'Tidak melewati budget di semua kategori dalam 1 bulan.',
                'emoji'       => '✅',
                'image_url'   => null,
                'criteria'    => ['type' => 'budget_not_exceeded', 'months' => 1],
                'is_active'   => true,
            ],
            [
                'name'        => 'Budget Master',
                'description' => 'Tidak melewati budget selama 3 bulan berturut-turut.',
                'emoji'       => '👑',
                'image_url'   => null,
                'criteria'    => ['type' => 'budget_not_exceeded', 'months' => 3],
                'is_active'   => true,
            ],
            [
                'name'        => 'Hemat Sejati',
                'description' => 'Sisa budget lebih dari 30% di akhir bulan.',
                'emoji'       => '💰',
                'image_url'   => null,
                'criteria'    => ['type' => 'budget_saved_percentage', 'percentage' => 30],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  SPLIT BILL
            // ──────────────────────────────────────────────
            [
                'name'        => 'Fair & Square',
                'description' => 'Selesaikan split bill pertama kalian.',
                'emoji'       => '🤝',
                'image_url'   => null,
                'criteria'    => ['type' => 'split_bill_settled', 'count' => 1],
                'is_active'   => true,
            ],
            [
                'name'        => 'No Debt Club',
                'description' => 'Tidak punya split bill yang belum diselesaikan selama 30 hari.',
                'emoji'       => '🕊️',
                'image_url'   => null,
                'criteria'    => ['type' => 'no_unsettled_split_bill_days', 'days' => 30],
                'is_active'   => true,
            ],
            [
                'name'        => 'Trip Planner',
                'description' => 'Buat split bill event pertama kalian.',
                'emoji'       => '✈️',
                'image_url'   => null,
                'criteria'    => ['type' => 'split_bill_event_created', 'count' => 1],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  MOOD & PERILAKU BELANJA
            // ──────────────────────────────────────────────
            [
                'name'        => 'Happy Spender',
                'description' => 'Catat 10 transaksi dengan mood Happy.',
                'emoji'       => '😊',
                'image_url'   => null,
                'criteria'    => ['type' => 'mood_count', 'mood' => 'happy', 'count' => 10],
                'is_active'   => true,
            ],
            [
                'name'        => 'Mindful Buyer',
                'description' => 'Tidak ada transaksi dengan mood FOMO selama 1 bulan.',
                'emoji'       => '🧘',
                'image_url'   => null,
                'criteria'    => ['type' => 'no_mood_in_month', 'mood' => 'fomo'],
                'is_active'   => true,
            ],
            [
                'name'        => 'Stress-Free Finance',
                'description' => 'Tidak ada transaksi dengan mood Stress selama 2 minggu.',
                'emoji'       => '🌈',
                'image_url'   => null,
                'criteria'    => ['type' => 'no_mood_days', 'mood' => 'stress', 'days' => 14],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  FINANSIAL SCORE
            // ──────────────────────────────────────────────
            [
                'name'        => 'Getting There',
                'description' => 'Capai financial score 50 untuk pertama kali.',
                'emoji'       => '📈',
                'image_url'   => null,
                'criteria'    => ['type' => 'financial_score_reached', 'score' => 50],
                'is_active'   => true,
            ],
            [
                'name'        => 'Saving Duo',
                'description' => 'Capai financial score 75.',
                'emoji'       => '💪',
                'image_url'   => null,
                'criteria'    => ['type' => 'financial_score_reached', 'score' => 75],
                'is_active'   => true,
            ],
            [
                'name'        => 'Money Power Couple',
                'description' => 'Capai financial score 90.',
                'emoji'       => '🚀',
                'image_url'   => null,
                'criteria'    => ['type' => 'financial_score_reached', 'score' => 90],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  MISI
            // ──────────────────────────────────────────────
            [
                'name'        => 'Mission Accepted',
                'description' => 'Selesaikan misi pertama kalian.',
                'emoji'       => '🎖️',
                'image_url'   => null,
                'criteria'    => ['type' => 'mission_completed', 'count' => 1],
                'is_active'   => true,
            ],
            [
                'name'        => 'Mission Addict',
                'description' => 'Selesaikan 5 misi.',
                'emoji'       => '🏅',
                'image_url'   => null,
                'criteria'    => ['type' => 'mission_completed', 'count' => 5],
                'is_active'   => true,
            ],
            [
                'name'        => 'Unstoppable',
                'description' => 'Selesaikan 10 misi.',
                'emoji'       => '💥',
                'image_url'   => null,
                'criteria'    => ['type' => 'mission_completed', 'count' => 10],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  ANNIVERSARY & MILESTONE PASANGAN
            // ──────────────────────────────────────────────
            [
                'name'        => 'Couple Goals',
                'description' => 'Lengkapi profil couple kalian (nama, foto, anniversary).',
                'emoji'       => '💑',
                'image_url'   => null,
                'criteria'    => ['type' => 'couple_profile_complete'],
                'is_active'   => true,
            ],
            [
                'name'        => '1 Month Together',
                'description' => 'Gunakan aplikasi bersama selama 1 bulan.',
                'emoji'       => '🥂',
                'image_url'   => null,
                'criteria'    => ['type' => 'app_usage_months', 'months' => 1],
                'is_active'   => true,
            ],
            [
                'name'        => '6 Months Strong',
                'description' => 'Gunakan aplikasi bersama selama 6 bulan.',
                'emoji'       => '💍',
                'image_url'   => null,
                'criteria'    => ['type' => 'app_usage_months', 'months' => 6],
                'is_active'   => true,
            ],
            [
                'name'        => '1 Year Legend',
                'description' => 'Gunakan aplikasi bersama selama 1 tahun penuh.',
                'emoji'       => '🎂',
                'image_url'   => null,
                'criteria'    => ['type' => 'app_usage_months', 'months' => 12],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  WALLET & INVESTASI
            // ──────────────────────────────────────────────
            [
                'name'        => 'Multi-Wallet',
                'description' => 'Buat 3 wallet atau lebih.',
                'emoji'       => '👛',
                'image_url'   => null,
                'criteria'    => ['type' => 'wallet_count', 'count' => 3],
                'is_active'   => true,
            ],
            [
                'name'        => 'Investor Muda',
                'description' => 'Catat transaksi bertipe Investment pertama kali.',
                'emoji'       => '📉',
                'image_url'   => null,
                'criteria'    => ['type' => 'transaction_type_first', 'transaction_type' => 'investment'],
                'is_active'   => true,
            ],
            [
                'name'        => 'Passive Income',
                'description' => 'Catat income dari kategori investasi sebanyak 5 kali.',
                'emoji'       => '🌊',
                'image_url'   => null,
                'criteria'    => ['type' => 'investment_income_count', 'count' => 5],
                'is_active'   => true,
            ],

            // ──────────────────────────────────────────────
            //  SPECIAL / RAHASIA
            // ──────────────────────────────────────────────
            [
                'name'        => 'Night Owl',
                'description' => 'Catat transaksi antara jam 00.00–04.00.',
                'emoji'       => '🦉',
                'image_url'   => null,
                'criteria'    => ['type' => 'transaction_time_range', 'from' => '00:00', 'to' => '04:00'],
                'is_active'   => true,
            ],
            [
                'name'        => 'Payday Rush',
                'description' => 'Catat income dan expense pada hari yang sama.',
                'emoji'       => '💸',
                'image_url'   => null,
                'criteria'    => ['type' => 'income_and_expense_same_day'],
                'is_active'   => true,
            ],
            [
                'name'        => 'Receipt Hoarder',
                'description' => 'Upload 10 foto struk belanja.',
                'emoji'       => '🧾',
                'image_url'   => null,
                'criteria'    => ['type' => 'receipt_photo_count', 'count' => 10],
                'is_active'   => true,
            ],
            [
                'name'        => 'Tag Master',
                'description' => 'Gunakan tags di 20 transaksi berbeda.',
                'emoji'       => '🏷️',
                'image_url'   => null,
                'criteria'    => ['type' => 'tagged_transaction_count', 'count' => 20],
                'is_active'   => true,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['name' => $badge['name']],
                $badge
            );
        }
  }
}
