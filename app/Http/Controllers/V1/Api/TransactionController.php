<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * Afficher la liste des transactions
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Transaction::with('category')
            ->forUser($request->user()->id)
            ->orderBy('transaction_date', 'desc');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        $transactions = $query->paginate(15);

        return returnResponse(
            TransactionResource::collection($transactions),
            true,
            200,
            "",
            [
                'current_page' => $transactions->currentPage(),
                'total' => $transactions->total(),
                'per_page' => $transactions->perPage(),
            ],
        );
    }

    /**
     * Créer une nouvelle transaction
     * @param StoreTransactionRequest $request
     * @return JsonResponse
     */
    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
        ]);

        return returnResponse(
            new TransactionResource($transaction->load('category')),
            true,
            201,
            "Transaction créée avec succès"
        );
    }

    /**
     * Afficher une transaction spécifique
     * @param Request $request
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function show(Request $request, Transaction $transaction): JsonResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            return returnResponse([], false, 403, "Non autorisé");
        }

        return returnResponse(new TransactionResource($transaction->load('category')));
    }

    /**
     * Mettre à jour une transaction
     * @param StoreTransactionRequest $request
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function update(StoreTransactionRequest $request, Transaction $transaction): JsonResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            return returnResponse([], false, 403, "Non autorisé");
        }

        $transaction->update($request->validated());

        return returnResponse(new TransactionResource($transaction->load('category')), true, 200, "Transaction mise à jour");
    }

    /**
     * Supprimer une transaction
     * @param Request $request
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function destroy(Request $request, Transaction $transaction): JsonResponse
    {
        if ($transaction->user_id !== $request->user()->id) {
            return returnResponse([], false, 403, "Non autorisé");
        }

        $transaction->delete();

        return returnResponse([], true, 200, "Transaction supprimée");
    }
}
