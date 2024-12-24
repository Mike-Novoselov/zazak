<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class UserController extends Controller
{
    // Получение данных профиля
    public function show()
    {
        $user = auth()->user();
        return response()->json($user);
    }

    // Обновление данных профиля
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if ($validated['name']) {
            $user->name = $validated['name'];
        }
        if ($validated['email']) {
            $user->email = $validated['email'];
        }
        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        return response()->json(['message' => 'Profile updated successfully']);
    }

    // Удаление аккаунта
    public function destroy()
    {
        $user = auth()->user();
        $user->delete();

        return response()->json(['message' => 'User account deleted successfully']);
    }
}

//UserController:
//
//Реализует просмотр, обновление профиля, а также удаление аккаунта.
//Добавлена валидация для всех пользовательских данных.
