<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un utilisateur de test
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Catégories de revenus
        $incomeCategories = [
            ['name' => 'Salaire', 'icon' => '💼', 'color' => '#10b981'],
            ['name' => 'Freelance', 'icon' => '💻', 'color' => '#14b8a6'],
            ['name' => 'Investissement', 'icon' => '📈', 'color' => '#06b6d4'],
        ];

        // Catégories de dépenses
        $expenseCategories = [
            ['name' => 'Logement', 'icon' => '🏠', 'color' => '#ef4444'],
            ['name' => 'Alimentation', 'icon' => '🛒', 'color' => '#f59e0b'],
            ['name' => 'Transport', 'icon' => '🚗', 'color' => '#3b82f6'],
            ['name' => 'Factures', 'icon' => '⚡', 'color' => '#8b5cf6'],
            ['name' => 'Loisirs', 'icon' => '🍽️', 'color' => '#ec4899'],
            ['name' => 'Santé', 'icon' => '⚕️', 'color' => '#f43f5e'],
        ];

        $categories = [];

        foreach ($incomeCategories as $cat) {
            $categories[] = Category::create([
                'user_id' => $user->id,
                'name' => $cat['name'],
                'type' => 'income',
                'icon' => $cat['icon'],
                'color' => $cat['color'],
            ]);
        }

        foreach ($expenseCategories as $cat) {
            $categories[] = Category::create([
                'user_id' => $user->id,
                'name' => $cat['name'],
                'type' => 'expense',
                'icon' => $cat['icon'],
                'color' => $cat['color'],
            ]);
        }

        // Créer des transactions de test
        $transactions = [
            [
                'category_name' => 'Salaire',
                'amount' => 3500,
                'type' => 'income',
                'description' => 'Salaire mensuel',
                'transaction_date' => now()->startOfMonth(),
            ],
            [
                'category_name' => 'Logement',
                'amount' => 850,
                'type' => 'expense',
                'description' => 'Loyer',
                'transaction_date' => now()->subDays(15),
            ],
            [
                'category_name' => 'Alimentation',
                'amount' => 250,
                'type' => 'expense',
                'description' => 'Courses du mois',
                'transaction_date' => now()->subDays(10),
            ],
            [
                'category_name' => 'Factures',
                'amount' => 120,
                'type' => 'expense',
                'description' => 'Électricité et Internet',
                'transaction_date' => now()->subDays(8),
            ],
            [
                'category_name' => 'Loisirs',
                'amount' => 60,
                'type' => 'expense',
                'description' => 'Restaurant',
                'transaction_date' => now()->subDays(5),
            ],
        ];

        foreach ($transactions as $trans) {
            $category = collect($categories)->firstWhere('name', $trans['category_name']);
            
            if ($category) {
                Transaction::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'amount' => $trans['amount'],
                    'type' => $trans['type'],
                    'description' => $trans['description'],
                    'transaction_date' => $trans['transaction_date'],
                ]);
            }
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Email: test@example.com');
        $this->command->info('🔑 Password: password');
    }
}
