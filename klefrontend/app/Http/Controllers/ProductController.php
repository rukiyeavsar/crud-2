<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = session('token');  // Kullanıcı oturum açtıktan sonra alınan token
    }

    public function index()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('http://host.docker.internal:82/api/products');

        if ($response->successful()) {
            $products = $response->json();
            return view('products.index', compact('products'));
        } else {
            return redirect()->back()->with('error', 'Ürünleri getirirken bir hata oluştu.');
        }
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|regex:/^(?!\d+$).+$/',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Ürün adı boş bırakılamaz.',
            'description.required' => 'Ürün açıklaması boş bırakılamaz.',
            'description.regex' => 'Ürün açıklamasında sadece rakam bulunamaz.',
            'price.required' => 'Ürün fiyatı boş bırakılamaz.',
            'price.numeric' => 'Ürün fiyatına sadece rakam girilebilir.',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('http://host.docker.internal:82/api/products/store', $request->all());

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Ürün başarıyla eklendi.');
        } else {
            $errors = $response->json('errors');
            return redirect()->back()->with('errors', $errors);
        }
    }

    public function show(string $id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('http://host.docker.internal:82/api/products/' . $id . '/show');

        if ($response->successful()) {
            $product = $response->json();
            return view('products.show', compact('product'));
        } else {
            return redirect()->back()->with('error', 'Ürün detayları getirilemedi.');
        }
    }

    public function edit(string $id)
    {
        $response = Http::get('http://host.docker.internal:82/api/products/' . $id . '/show');

        if ($response->successful()) {
            $product = $response->json();
            return view('products.update', compact('product'));
        } else {
            return redirect()->back()->with('error', 'Ürün bilgileri getirilemedi.');
        }
    }

    public function update(Request $request, string $id)
    {
        

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->put('http://host.docker.internal:82/api/products/' . $id . '/update', $request->all());

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Ürün başarıyla güncellendi.');
        } else {
            $errors = $response->json('errors');
            return redirect()->back()->with('errors', $errors);
        }
    }

    public function destroy(string $id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->delete('http://host.docker.internal:82/api/products/' . $id . '/delete');

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Ürün başarıyla silindi.');
        } else {
            return redirect()->back()->with('error', 'Ürün silinirken bir hata oluştu.');
        }
    }
}
