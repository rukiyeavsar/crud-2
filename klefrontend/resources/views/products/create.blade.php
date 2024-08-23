@extends('layout')
@section('title', 'Ürün Ekle')
@section('content')
@if(session('token'))
<div class="container mt-4">
    <h1>Yeni Ürün Ekle</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Ürün Adı</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Ürün Açıklaması</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Ürün Fiyatı</label>
            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="{{ route('products.index') }}" class="btn btn-warning">Ürünü Gör</a>
    </form>
</div>
@else
   <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
         <div class="col-md-6 text-center">
            <div style="text-align: center; font-size: 25px;">
               <p>Ürün ekleyebilmek için önce giriş yapman gerekiyor.</p>
               <a href="{{ route('login') }}" class="btn btn-primary">Buradan giriş yapabilirsin.</a>
               <a href="{{ route('registration') }}" class="btn btn-warning">Buradan kayıt olabilirsin.</a>
            </div>
         </div>
      </div>
   </div>
@endif
@endsection
