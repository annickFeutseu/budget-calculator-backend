<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function summary(Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Revenus et dépenses du mois en cours
        $income = Transaction::forUser($userId)
            ->income()
            ->dateRange($startOfMonth, $endOfMonth)
            ->sum('amount');

        $expenses = Transaction::forUser($userId)
            ->expense()
            ->dateRange($startOfMonth, $endOfMonth)
            ->sum('amount');

        // Nombre total de transactions
        $transactionsCount = Transaction::forUser($userId)
            ->dateRange($startOfMonth, $endOfMonth)
            ->count();

        // Top catégories de dépenses
        $topCategories = Transaction::forUser($userId)
            ->expense()
            ->dateRange($startOfMonth, $endOfMonth)
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->with('category:id,name,color,icon')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category->name,
                    'total' => $item->total,
                    'color' => $item->category->color,
                    'icon' => $item->category->icon,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'total_income' => $income,
                'total_expenses' => $expenses,
                'balance' => $income - $expenses,
                'transactions_count' => $transactionsCount,
                'top_categories' => $topCategories,
                'period' => [
                    'start' => $startOfMonth->toDateString(),
                    'end' => $endOfMonth->toDateString(),
                ],
            ],
        ]);
    }

    public function chartData(Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $period = $request->input('period', 'month'); // month, year
        
        if ($period === 'year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
            $groupBy = DB::raw('MONTH(transaction_date) as period');
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $groupBy = DB::raw('DAY(transaction_date) as period');
        }

        // Données pour le graphique
        $chartData = Transaction::forUser($userId)
            ->dateRange($startDate, $endDate)
            ->select(
                $groupBy,
                'type',
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('period', 'type')
            ->orderBy('period')
            ->get()
            ->groupBy('period');

        $labels = [];
        $incomeData = [];
        $expenseData = [];

        foreach ($chartData as $period => $transactions) {
            $labels[] = $period;
            $incomeData[] = $transactions->where('type', 'income')->sum('total');
            $expenseData[] = $transactions->where('type', 'expense')->sum('total');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Revenus',
                        'data' => $incomeData,
                        'backgroundColor' => 'rgba(16, 185, 129, 0.5)',
                        'borderColor' => 'rgb(16, 185, 129)',
                        'borderWidth' => 2,
                    ],
                    [
                        'label' => 'Dépenses',
                        'data' => $expenseData,
                        'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                        'borderColor' => 'rgb(239, 68, 68)',
                        'borderWidth' => 2,
                    ],
                ],
            ],
        ]);
    }
}
