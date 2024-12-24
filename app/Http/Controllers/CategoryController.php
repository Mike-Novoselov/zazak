<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Получение всех категорий текущего пользователя
    public function index()
    {
        $categories = Auth::user()->categories()->get();
        return response()->json($categories);
    }

    // Создание новой категории
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Auth::user()->categories()->create([
            'name' => $validated['name'],
        ]);

        return response()->json($category, 201);
    }

    // Обновление категории
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Auth::user()->categories()->findOrFail($id);
        $category->update($validated);

        return response()->json($category);
    }

    // Удаление категории
    public function destroy($id)
    {
        $category = Auth::user()->categories()->findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
