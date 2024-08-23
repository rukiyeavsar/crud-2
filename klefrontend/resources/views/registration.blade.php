@extends('layout')
@section('title', 'Registration')
@section('content')
    <div class="container mt-5">
      <div class="row justify-content-center">
      <div class="col-md-6">
        @if($errors->any())
              @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
              @endforeach
          </div>
        @endif

        @if(session()->has('error')) 
          <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        @if(session()->has('success')) 
          <div class="alert alert-success">{{session('success')}}</div>
        @endif
      
        <form action="{{ route('registration.post') }}" method="POST" class="ms-auto me-auto mt-3">
    @csrf
 <div class="mb-3">
    <label class="form-label">Ad - Soyad</label>
    <input type="text" class="form-control" name="name">
  </div>
  <div class="mb-3">
    <label class="form-label">E-posta Adresi</label>
    <input type="text" class="form-control" name="email">
  </div>
  <div class="mb-3">
    <label class="form-label">Şifre</label>
    <input type="password" class="form-control" name="password">
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Tekrar Şifre</label>
    <input type="password" class="form-control" name="password_confirmation">
    @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary">Kayıt Ol</button>
</form>
    </div>
  </div>
  </div>
@endsection