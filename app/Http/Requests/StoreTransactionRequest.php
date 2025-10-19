<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:500',
            'transaction_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'La catégorie est requise',
            'category_id.exists' => 'Catégorie invalide',
            'amount.required' => 'Le montant est requis',
            'amount.min' => 'Le montant doit être supérieur à 0',
            'type.required' => 'Le type est requis',
            'type.in' => 'Type invalide',
            'transaction_date.required' => 'La date est requise',
        ];
    }
}