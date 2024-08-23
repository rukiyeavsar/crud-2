@extends('layout')
@section('title', "Products")
@section('content')
@if(session('token'))
<div class="container mt-4">
    <h1>Ürünler Sayfası</h1>
    <p>Bu alanda ürünler listelenecektir.</p>
    
    <div class="text-end mb-3">
        <a href="{{ route('products.create') }}" type="button" class="btn btn-success">ÜRÜN EKLE</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ÜRÜN ADI</th>
                    <th scope="col">ÜRÜN AÇIKLAMASI</th>
                    <th scope="col">ÜRÜN FİYATI</th>
                    <th scope="col">İŞLEMLER</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $product['id'] }}</th>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['description'] }}</td>
                        <td>{{ $product['price'] }}</td>
                        <td>
                            <a href="{{ route('products.show', $product['id']) }}" class="btn btn-info btn-sm">GÖSTER</a>
                            <a href="{{ route('products.update', $product['id']) }}" class="btn btn-warning btn-sm">DÜZENLE</a>
                            <form action="{{ route('products.destroy', $product['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">SİL</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
   <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
         <div class="col-md-6 text-center">
            <div style="text-align: center; font-size: 25px;">
               <p>Ürünleri görebilmek için önce giriş yapman gerekiyor.</p>
               <a href="{{ route('login') }}" class="btn btn-primary">Buradan giriş yapabilirsin.</a>
               <a href="{{ route('registration') }}" class="btn btn-warning">Buradan kayıt olabilirsin.</a>
            </div>
         </div>
      </div>
   </div>
   @endif
@endsection
