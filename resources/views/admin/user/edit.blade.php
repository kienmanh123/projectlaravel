@extends('admin.layout.app')
@section('content')
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Sửa tài khoản</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <form action="{{route('admin.user.update',[$user['id']])}}" method="post">
                @csrf
            <!-- /.box-header -->
            <div class="box-body">
                @include('includes.message')
                <div class="form-group">
                    <label for="exampleInputEmail1">Tên tài khoản</label>
                     <input type="text" class="form-control"  name="name" placeholder="Tên tài khoản" value="{{old('name',$user['name'])}}">
                </div>
                <div class="form-group" @if($errors->has('email')) has-error @endif>
                    <label for="exampleInputEmail1">Email</label>
                     <input type="text" class="form-control"  name="email" placeholder="Email" value="{{old('email',$user['email'])}}">
                </div>
                <div class="form-group" @if($errors->has('number_phone')) has-error @endif>
                    <label for="exampleInputEmail1">Số điện thoại</label>
                     <input type="text" class="form-control"  name="number_phone" placeholder="Vui lòng nhập số điện thoại" value="{{old('number_phone',$user['number_phone'])}}">
                </div>
                <div class="form-group" @if($errors->has('date_of_birth')) has-error @endif>
                    <label for="exampleInputEmail1">Ngày sinh</label>
                     <input type="text" class="form-control"  name="date_of_birth" placeholder="Vui lòng nhập ngày sinh" value="{{old('date_of_birth'),date('d-m-y',strtoTime(str_replace('-','/',$user['date_of_birth'])))}}" data-inputmask="'alias':'dd/mm/yy'">
                </div>
                <div class="form-group" @if($errors->has('gender')) has-error @endif>
                    <label for="exampleInputEmail1">Giới tính </label>
                        <select class="form-control" name="gender">
                            @foreach(config('constant.gender') as $key=>$value)
                                <option value="{{$key}}" @if (old('gender',$user['gender']) ==$key) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group" @if($errors->has('address')) has-error @endif>
                    <label for="exampleInputEmail1">Địa chỉ</label>
                     <input type="text" row="3"class="form-control"  name="address" placeholder="Vui lòng nhập địa chỉ" value="{{old('address',$user['address'])}}">
                </div>
                <div class="form-group" >
                    <label for="exampleInputEmail1"> Quyền</label>
                        <select class="form-control" name="role">
                            @foreach(config('constant.role') as $key=>$value)
                                <option value="{{$key}}" @if (old('role',$user['role'])==$key) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
           <button class="btn btn-primary">Sửa mới</button>
            </div>
            </form>
          </div>
          <script>
              $(document).ready(function(){
                  $(['data-mask']).inputmask();
              }

              );
          </script>
@stop