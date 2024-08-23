<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ], [
            'name.required' => 'Ad-soyad boş bırakılamaz.',
            'email.required' => 'E-posta adresi boş bırakılamaz.',
            'email.email' => 'E-posta adresi geçersiz.',
            'email.unique' => 'Böyle bir e-posta adresi zaten var.',
            'password.required' => 'Şifre boş bırakılamaz.',
            'password.confirmed' => 'Şifre uyuşmuyor.',
            'password.min' => 'Şifre en az 8 karakterden oluşmalıdır.',
            'password_confirmation.required' => 'Tekrar şifre kısmı boş bırakılamaz.',
        ]);
    
        if (empty($request->password) && !empty($request->password_confirmation)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Önce şifre girmeniz gerekmektedir.'
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'message' => 'Kayıt başarılı'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'E-posta adresi boş bırakılamaz.',
            'email.email' => 'E-posta adresi geçersiz.',
            'password.required' => 'Şifre boş bırakılamaz.',
        ]);

        $data = $request->only('email', 'password');
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'error' => 'Böyle bir e-posta adresi yok',
                'status' => 'fail',
            ], 401);
        }

        if (!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'error' => 'Bu şifre yanlış',
                'status' => 'fail',
            ], 401);
        }

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $name = Auth::user()->name;
            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Başarıyla Giriş Yapıldı',
                'user' => $user,
                'token' => $token,
                'name' => $name
            ]);
        } else {
            return response()->json([
                'error' => 'Unauthorized',
                'status' => 'fail',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
