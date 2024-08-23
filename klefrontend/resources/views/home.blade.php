@extends('layout')
@section('title', "Home Page")
@section('content')
   @if(session('token'))
      <div style="text-align: center; font-size: 40px; margin-top: 10%; margin-bottom: 5%;">
         <p>Hoşgeldin, {{session('username')}}!</p>
      </div>
      <div style="text-align: center; font-size: 20px;">
         <p>Yapmak istediğin işlemi seç:</p>
            <a href="{{ route('products.create') }}" style="display: inline-block; padding: 10px 20px; font-size: 16px; font-weight: bold; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px; margin-right: 10px;">Ürün Ekle</a>
            <a href="{{route('products.index')}}" style="display: inline-block; padding: 10px 20px; font-size: 16px; font-weight: bold; color: #fff; background-color: #28a745; text-decoration: none; border-radius: 5px;">Ürünleri Gör</a>
         </p>
      </div>
   @else
   <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
         <div class="col-md-6 text-center">
            
            <div style="text-align: center; font-size: 40px;">
               <p>Hoşgeldin!</p>
            </div>
            <div style="text-align: center; font-size: 20px;">
               <p>Anasayfayı görebilmek için giriş yapman gerekiyor.</p>
               <a href="{{ route('login') }}" class="btn btn-primary">Buradan giriş yapabilirsin.</a>
            </div>
         </div>
      </div>
   </div>
   @endif
@endsection