<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Bookmark;

class TagController extends Controller
{
    // Получение списка всех тегов пользователя
    public function index()
    {
        $tags = Tag::where('user_id', auth()->id())->get();
        return response()->json($tags);
    }

    // Создание нового тега
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag = Tag::create([
            'name' => $validated['name'],
            'user_id' => auth()->id(),
        ]);

        return response()->json($tag, 201);
    }

    // Привязка тега к закладке
    public function attach(Request $request, $bookmarkId)
    {
        $bookmark = Bookmark::where('user_id', auth()->id())->findOrFail($bookmarkId);
        $validated = $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        $bookmark->tags()->attach($validated['tag_id']);
        return response()->json(['message' => 'Tag attached successfully']);
    }

    // Удаление тега из закладки
    public function detach(Request $request, $bookmarkId)
    {
        $bookmark = Bookmark::where('user_id', auth()->id())->findOrFail($bookmarkId);
        $validated = $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        $bookmark->tags()->detach($validated['tag_id']);
        return response()->json(['message' => 'Tag detached successfully']);
    }
}

//TagController:
//
//Работает с тегами и связующей таблицей bookmark_tag.
//Реализованы методы для привязки и отвязки тегов от закладок.
