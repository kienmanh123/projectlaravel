@extends('home.layout.app')
@section('breadcrumbs')
    @include('home.includes.breadcrumbs',array("title"=>"Đăng kí tài khoản","url" => route('home.register')) )
@endsection
@section('content')
<div class="products-content contact-us">
    <div class="row">
        <div class="form-main">
            <div class="section-title">
                <h2>Đăng nhập</h2>
            </div>
            @include('includes.message')
            <form action="{{ route('home.register.post')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Tên</label>
                    <input type="text" class="form-control" placeholder="Tên" name="name" value="{{ old('name')}}">
                </div>
                <div class="form-group">
                    <label for="">Địa chỉ email</label>
                    <input type="text" class="form-control" placeholder="Địa chỉ emal" name="email" value="{{ old('email')}}">
                </div>
                <div class="form-group">
                    <label for="">Mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password')}}">
                </div>
                <div class="form-group">
                    <label for="">Số điện thoại</label>
                    <input type="text" class="form-control" placeholder="Số điện thoại" name="number_phone" value="{{ old('number_phone')}}">
                </div>
                <div class="form-group">
                    <label for="">Ngày sinh</label>
                    <input type="text" class="form-control" placeholder="Ngày sinh" name="date_of_birth" value="{{ old('date_of_birth')}}">
                </div>
                <div class="form-group">
                    <label for="">Giới tính</label><br>
                    <input type="radio" name="gender" value="1" checked>Nam
                    <input type="radio" name="gender" value="2" checked>Nữ
                </div>
                <div class="form-group">
                    <label for="">Địa chỉ </label>
                    <input type="text" class="form-control" placeholder="Địa chỉ" name="address" value="{{ old('address')}}">
                </div>
                <button type="submit" class="btn">Đăng kí</button>
            </form>
        </div>
    </div>
</div>
@stop