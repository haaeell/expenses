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
      ['slug'=>'first_transaction', 'name'=>'First Step',       'emoji'=>'👣', 'description'=>'Catat transaksi pertama'],
      ['slug'=>'goal_crusher',      'name'=>'Goal Crusher',     'emoji'=>'🎯', 'description'=>'Selesaikan goal pertama'],
      ['slug'=>'saver_duo',         'name'=>'Saver Duo',        'emoji'=>'🐷', 'description'=>'Saving rate 20% selama 3 bulan'],
      ['slug'=>'streak_keeper',    'name'=>'Streak Keeper',    'emoji'=>'🔥', 'description'=>'Catat 30 hari berturut-turut'],
      ['slug'=>'debt_free',         'name'=>'Debt Free Pair',   'emoji'=>'✨', 'description'=>'Tidak ada hutang 1 bulan'],
      ['slug'=>'wedding_hero',     'name'=>'Wedding Hero',     'emoji'=>'💍', 'description'=>'50% target dana nikah'],
      ['slug'=>'anniversary',      'name'=>'Anniversary Saver', 'emoji'=>'💕', 'description'=>'Nabung lebih dari tahun lalu'],
    ];

    foreach ($badges as $badge) {
      Badge::create($badge);
    }
  }
}
