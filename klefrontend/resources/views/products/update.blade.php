@extends('layout')
@section('title', 'Ürün Güncelle')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Alert for error messages -->
            @if(session()->has('error'))
                <div class="alert alert-warning alert-dismissible fade show" style="margin-top: 5%" role="alert">
                    <strong>Uyarı!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Hata Mesajları -->
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Başarı Mesajları -->
            @if(session()->has('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form id="update-product-form" action="{{ route('products.update', $product['id']) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">ÜRÜN ADI</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product['name']) }}">
        <div id="name-error" class="text-danger"></div>
    </div>
    <div class="mb-3">
        <label class="form-label">ÜRÜN AÇIKLAMASI</label>
        <input type="text" class="form-control" name="description" id="description" value="{{ old('description', $product['description']) }}">
        <div id="description-error" class="text-danger"></div>
    </div>
    <div class="mb-3">
        <label class="form-label">ÜRÜNÜN FİYATI</label>
        <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $product['price']) }}">
        <div id="price-error" class="text-danger"></div>
    </div>
    <button type="submit" class="btn btn-primary">Ürün Güncelle</button>
    <a href="{{ route('products.index') }}" class="btn btn-warning">Geri Dön</a>
</form>
<div id="form-messages"></div>

        </div>
    </div>
</div>
@endsection
