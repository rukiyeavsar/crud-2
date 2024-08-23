@extends('layout')
@section('title', 'Ürün Detayı')
@section('content')
    @if(session('token'))
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">ÜRÜN ADI</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product['name']) }}" readonly>
                    <div id="name-error" class="text-danger"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">ÜRÜN AÇIKLAMASI</label>
                    <input type="text" class="form-control" name="description" id="description" value="{{ old('description', $product['description']) }}" readonly>
                    <div id="description-error" class="text-danger"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">ÜRÜNÜN FİYATI</label>
                    <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $product['price']) }}" readonly>
                    <div id="price-error" class="text-danger"></div>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-warning">Geri Dön</a>
        </div>
    </div>
</div>
@else
   <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
         <div class="col-md-6 text-center">
            <div style="text-align: center; font-size: 25px;">
               <p>Ürün detaylarını görebilmek için önce giriş yapman gerekiyor.</p>
               <a href="{{ route('login') }}" class="btn btn-primary">Buradan giriş yapabilirsin.</a>
               <a href="{{ route('registration') }}" class="btn btn-warning">Buradan kayıt olabilirsin.</a>
            </div>
         </div>
      </div>
   </div>
@endif
@endsection
