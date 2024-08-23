@extends('layout')
@section('title', 'Login')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Özel Hata Mesajı -->
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

                <!-- Giriş Formu -->
                <form action="{{ route('login.post') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">E-posta Adresi</label>
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}" >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Şifre</label>
                        <input type="password" class="form-control" name="password" >
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button href="{{ route('home') }}" type="submit" class="btn btn-primary">Oturum Aç</button>
                </form>
            </div>
        </div>
    </div>
@endsection