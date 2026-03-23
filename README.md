## Daftar Model & Relasi

```
User
 ├── coupleAsUser1()         → HasOne Couple (user1_id)
 ├── coupleAsUser2()         → HasOne Couple (user2_id)
 ├── couple()                → helper, returns Couple|null
 ├── coupleInvites()         → HasMany CoupleInvite
 ├── wallets()               → HasMany Wallet
 ├── transactions()          → HasMany Transaction
 ├── recurringTransactions() → HasMany RecurringTransaction
 ├── goals()                 → HasMany Goal (created_by)
 ├── goalContributions()     → HasMany GoalContribution
 ├── splitBillsPaid()        → HasMany SplitBill (paid_by)
 ├── notifications()         → HasMany Notification
 └── calendarSyncs()         → HasMany CalendarSync

Couple
 ├── user1()                 → BelongsTo User
 ├── user2()                 → BelongsTo User
 ├── members()               → helper, Collection of users
 ├── wallets()               → HasMany Wallet
 ├── categories()            → HasMany Category
 ├── transactions()          → HasMany Transaction
 ├── recurringTransactions() → HasMany RecurringTransaction
 ├── goals()                 → HasMany Goal
 ├── splitBillEvents()       → HasMany SplitBillEvent
 ├── splitBills()            → HasMany SplitBill
 ├── budgets()               → HasMany Budget
 ├── missions()              → HasMany CoupleMission
 ├── reminders()             → HasMany Reminder
 ├── badges()                → HasMany CoupleBadge
 ├── financialScores()       → HasMany FinancialScore
 ├── notifications()         → HasMany Notification
 ├── calendarSyncs()         → HasMany CalendarSync
 └── reportsCache()          → HasMany ReportsCache

CoupleInvite
 └── inviter()               → BelongsTo User

Wallet
 ├── couple()                → BelongsTo Couple
 ├── user()                  → BelongsTo User
 ├── transactions()          → HasMany Transaction
 └── recurringTransactions() → HasMany RecurringTransaction

Category
 ├── couple()                → BelongsTo Couple (nullable, null = default)
 ├── transactions()          → HasMany Transaction
 ├── recurringTransactions() → HasMany RecurringTransaction
 └── budgets()               → HasMany Budget
 Scopes: scopeDefaults(), scopeForCouple($coupleId)

Transaction
 ├── couple()                → BelongsTo Couple
 ├── user()                  → BelongsTo User
 ├── wallet()                → BelongsTo Wallet
 ├── category()              → BelongsTo Category
 ├── goalContribution()      → HasOne GoalContribution
 ├── splitBill()             → HasOne SplitBill
 └── reminder()              → HasOne Reminder
 Scopes: scopeExpenses(), scopeIncome(), scopeForMonth($year, $month)

RecurringTransaction
 ├── couple()                → BelongsTo Couple
 ├── user()                  → BelongsTo User
 ├── category()              → BelongsTo Category
 └── wallet()                → BelongsTo Wallet
 Scopes: scopeActive(), scopeDueToday()

Goal
 ├── couple()                → BelongsTo Couple
 ├── creator()               → BelongsTo User (created_by)
 ├── milestoneRecords()      → HasMany GoalMilestone (ordered)
 └── contributions()         → HasMany GoalContribution
 Helpers: progressPercentage(), isCompleted()
 Scopes: scopeActive()

GoalMilestone
 └── goal()                  → BelongsTo Goal

GoalContribution
 ├── goal()                  → BelongsTo Goal
 ├── user()                  → BelongsTo User
 └── transaction()           → BelongsTo Transaction

SplitBillEvent
 ├── couple()                → BelongsTo Couple
 └── splitBills()            → HasMany SplitBill
 Helpers: totalAmount()

SplitBill
 ├── couple()                → BelongsTo Couple
 ├── paidBy()                → BelongsTo User (paid_by)
 ├── transaction()           → BelongsTo Transaction
 └── event()                 → BelongsTo SplitBillEvent
 Scopes: scopeUnsettled()

Budget
 ├── couple()                → BelongsTo Couple
 └── category()              → BelongsTo Category
 Helpers: spentAmount(), remainingAmount(), usagePercentage()
 Scopes: scopeForPeriod($year, $month)

Mission
 └── coupleMissions()        → HasMany CoupleMission
 Scopes: scopeActive()

CoupleMission
 ├── couple()                → BelongsTo Couple
 └── mission()               → BelongsTo Mission
 Scopes: scopeActive(), scopeCompleted()

Reminder
 ├── couple()                → BelongsTo Couple
 ├── transaction()           → BelongsTo Transaction
 └── calendarSync()          → HasOne CalendarSync
 Scopes: scopeActive()

Badge
 └── coupleBadges()          → HasMany CoupleBadge
 Scopes: scopeActive()

CoupleBadge  (no timestamps)
 ├── couple()                → BelongsTo Couple
 └── badge()                 → BelongsTo Badge

FinancialScore
 └── couple()                → BelongsTo Couple
 Helpers: FinancialScore::resolveLevel($score) [static]
 Scopes: scopeLatest(), scopeForYear($year)

Notification  (UUID primary key, uses HasUuids)
 ├── user()                  → BelongsTo User
 └── couple()                → BelongsTo Couple
 Helpers: isRead(), markAsRead()
 Scopes: scopeUnread(), scopeRead(), scopeOfType($type)

CalendarSync
 ├── couple()                → BelongsTo Couple
 ├── user()                  → BelongsTo User
 └── reminder()              → BelongsTo Reminder
 Scopes: scopeSynced(), scopePending(), scopeFailed()

ReportsCache  ($table = 'reports_cache')
 └── couple()                → BelongsTo Couple
 Helpers: ReportsCache::remember($coupleId, $type, $year, $month, $callback) [static]
 Scopes: scopeOfType($type), scopeForPeriod($year, $month)
```

## Catatan Penting

- **`Notification`** menggunakan UUID sebagai primary key via trait `HasUuids`.
  Pastikan kolom `id` di migration tetap `uuid`.

- **`CoupleBadge`** meng-set `$timestamps = false` karena tabel hanya punya `earned_at`.

- **`Category`** dengan `couple_id = null` adalah kategori default sistem.
  Gunakan scope `scopeForCouple($coupleId)` untuk mengambil kategori milik couple
  sekaligus kategori default dalam satu query.

- **`ReportsCache::remember()`** bekerja mirip `Cache::remember()` Laravel — mengambil
  data dari tabel jika sudah ada, atau menjalankan `$generator` untuk mengisinya.

- **`FinancialScore::resolveLevel()`** adalah static helper untuk memetakan
  skor numerik ke label teks sebelum disimpan ke kolom `level`.
