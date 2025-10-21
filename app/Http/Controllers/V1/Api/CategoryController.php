<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Afficher la liste des catégories
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $categories = Category::where('user_id', $request->user()->id)
            ->orderBy('name')
            ->get();

        return returnResponse($categories);
    }

    /**
     * Créer une nouvelle catégorie
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
            'color' => 'nullable|string|size:7',
            'icon' => 'nullable|string|max:50',
        ]);

        $category = Category::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'color' => $validated['color'] ?? '#3b82f6',
            'icon' => $validated['icon'] ?? '💰',
        ]);


        return returnResponse($category, true, 201, "Catégorie créée avec succès");
    }

    /**
     * Mettre à jour une catégorie
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        if ($category->user_id !== $request->user()->id) {
            return returnResponse([], false, 403, "Non autorisé");
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'color' => 'nullable|string|size:7',
            'icon' => 'nullable|string|max:50',
        ]);

        $category->update($validated);

        return returnResponse($category, true, 200, "Catégorie mise à jour");
    }

    /**
     * Supprimer une catégorie
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Request $request, Category $category): JsonResponse
    {
        if ($category->user_id !== $request->user()->id) {
            return returnResponse([], false, 403, "Non autorisé");
        }

        // Vérifier si des transactions utilisent cette catégorie
        if ($category->transactions()->count() > 0) {
            return returnResponse([], false, 402, "Impossible de supprimer une catégorie avec des transactions");
        }

        $category->delete();

        return returnResponse([], true, 200, "Catégorie supprimée");
    }
}
