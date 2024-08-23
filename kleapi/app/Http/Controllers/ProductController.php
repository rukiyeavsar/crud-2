<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|regex:/^(?!\d+$).+$/',
                'price' => 'required|numeric|min:0',
            ], [
                'name.required' => 'Ürün adı boş bırakılamaz.',
                'name.max' => 'İsim en fazla 255 karakter olmalıdır.',
                'description.required' => 'Ürün açıklaması boş bırakılamaz.',
                'description.regex' => 'Ürün açıklamasında sadece rakam bulunamaz.',
                'price.required' => 'Ürün fiyatı boş bırakılamaz.',
                'price.numeric' => 'Ürün fiyatına sadece rakam girilebilir.',
            ]);

            $product = Product::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Ürün Başarıyla eklendi',
                'product' => $product,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product, 200);
        } else {
            return response()->json(['message' => 'Ürün bulunamadı'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
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
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator_>errors()
            ], 422);
        }

        $product = Product::findOrFail($id);

        $product->name = $request->name;
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Ürün bulunamadı'], 404);
        }
    }
}
