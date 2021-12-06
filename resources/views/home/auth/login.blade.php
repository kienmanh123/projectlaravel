@extends('home.layout.app')
@section('breadcrumbs')
    @include('home.includes.breadcrumbs',array("title"=>"Đăng nhập","url" => route('home.login')) )
@endsection
@section('content')
<div class="products-content contact-us">
    <div class="row">
        <div class="form-main">
            <div class="section-title">
                <h2>Đăng nhập</h2>
            </div>
            @include('includes.message')
            <form action="{{ route('home.login.post')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Địa chỉ email</label>
                    <input type="text" class="form-control" placeholder="Địa chỉ emal" name="email">
                </div>
                <div class="form-group">
                    <label for="">Mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Password" name="password">
                </div>
                <div class="form-group">
                    <input type="check-box" class="form-check-input" name="remember">
                    <label class="form-check-input">Địa chỉ email</label>
                </div>
                <button type="submit" class="btn">Đăng nhập</button>
            </form>
        </div>
    </div>
</div>
@stop