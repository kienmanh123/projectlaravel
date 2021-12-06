@extends('admin.layout.app')
@section('content')
      
        <div class="col-m-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tìm kiếm</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <form action="{{route('admin.user.search')}}"method="GET">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên tài khoản</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Tên tài khoản" value="{{Request::get('name')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Địa chỉ email" value="{{Request::get('email')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Số điện thoại</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Số điện thoại" value="{{Request::get('number_phone')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">    
                        <div class="form-group">
                            <label for="exampleInputEmail1">Quyền</label>
                            <select name="role" class="form-control">
                                @foreach(config('constant.role') as $key =>$value)
                                <option value="{{ $key }}" @if(Request::get('role') == $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"> Tìm kiếm</button>
                </div>
            </form>
          </div>
        </div>
        <div class="col-m-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Danh sacsh tai khoan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <a href="{{route('admin.user.create')}}" class="btn btn-primary pull-right btn-margin-bottom">Thêm tài khoản</a>
            </div>
            <table class="table table-bordered table-responsive">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th>Tên tài khoản</th>
                        <th>Email</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Địa chỉ</th>
                        <th>Quyền</th>
                        <th></th>
                    </tr>
                    @if($users->isEmpty())
                    <tr><td colspan="9" style="text-align:center">Không có bản ghỉ nào</td></tr>
                    @else
                    @foreach($users as $key =>$user)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if($user-> gender==1)
                            <button class="btn btn-xs btn-success">Nam</button>
                            @else
                            <button class="btn btn-xs btn-warning">Nữ</button>
                            @endif
                        </td>
                        <td>{{ date('d/m/Y',strtotime($user->date_of_birth)) }}</td>
                        <td>{{$user->number_phone}}</td>
                        <td>{{$user->address}}</td>
                        <td> 
                            @if($user->role == 1)
                            <button class="btn btn-xs btn-danger">Quản trị viên</button>
                            @else
                            <button class="btn btn-xs btn-success">Người dùng</button>

                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.user.edit',[$user->id])}}" class="btn btn-xs btn-success">Chỉnh sủa</a>
                            <button data-url="{{route('admin.user.delete',[$user->id])}}" class="btn btn-delete btn-danger" >Xóa </button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pull-right">
                    {{$users->appends(request()->query())->links()}}
                </div>
            </div>
          </div>
        </div>
    </div>
    <script>
         $(document).ready(function(){
        $('.btn-delete').click(function(){
          $('.modal-confirm').modal({
            show: true
          });
          $('#form-confirm').attr('action',$(this).attr('data-url'));
        });

        }); 
    </script>
@stop
