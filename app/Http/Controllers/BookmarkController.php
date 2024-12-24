<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // Получение всех закладок с фильтрацией
    public function index(Request $request)
    {
        $query = Auth::user()->bookmarks();

        // Фильтрация по категории
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Поиск по названию или описанию
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $bookmarks = $query->get();

        return response()->json($bookmarks);
    }

    // Создание новой закладки
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $bookmark = Auth::user()->bookmarks()->create($validated);

        return response()->json($bookmark, 201);
    }

    // Обновление закладки
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $bookmark = Auth::user()->bookmarks()->findOrFail($id);
        $bookmark->update($validated);

        return response()->json($bookmark);
    }

    // Удаление закладки
    public function destroy($id)
    {
        $bookmark = Auth::user()->bookmarks()->findOrFail($id);
        $bookmark->delete();

        return response()->json(['message' => 'Bookmark deleted successfully']);
    }
}

