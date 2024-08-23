<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('login');
    }
    
    public function registration(Request $request)
    {
        return view('registration');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'E-posta adresi boş bırakılamaz.',
            'email.email' => 'E-posta adresi geçersiz.',
            'password.required' => 'Şifre boş bırakılamaz.',
        ]);

        $response = Http::post('http://host.docker.internal:82/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        
        $data = $response->json();

        if ($response->ok() && $data['status'] === 'success') {
            session(['token' => $data['token']]);
            session(['username' => $data['user']['name']]);
            return redirect()->route('home')->with('success', 'Giriş Başarılı');
        } else {
            return redirect()->back()->withErrors(['error' => $data['error'] ?? 'Giriş yapılamadı, lütfen tekrar deneyin.']);
        }
    }

    public function registrationPost(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
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
        
        $response = Http::post('http://host.docker.internal:82/api/registration', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);
    
        // Yanıtı logla
        \Log::info('API Yanıtı: ', ['response' => $response->body()]);
    
        $data = $response->json();
    
        if ($response->ok() && $data['status'] === 'success') {
            return redirect(route('login'))->with('success', 'Başarıyla kayıt oldunuz. Hesabınıza giriş yapmak için oturum açın.');
        }
    
        return redirect(route('registration'))->with('error', $data['message'] ?? 'Kayıt olamadınız, tekrar deneyin.');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
