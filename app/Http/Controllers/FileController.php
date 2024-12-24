<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileController extends Controller
{
    // Загрузка файла
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:2048',
        ]);

        $filePath = $request->file('file')->store('files', 'public');

        $file = File::create([
            'file_path' => $filePath,
            'file_type' => $request->file('file')->getClientMimeType(),
            'bookmark_id' => $request->input('bookmark_id'), // предположим, что ID закладки передается
        ]);

        return response()->json($file, 201);
    }

    // Удаление файла
    public function destroy($id)
    {
        $file = File::findOrFail($id);
        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return response()->json(['message' => 'File deleted successfully']);
    }
}
//FileController:
//
//Использует Storage для загрузки файлов в локальное хранилище или S3.
//Проверяет MIME-тип файла и ограничивает его размер.
