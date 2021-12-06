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
            <form action="{{route('admin.customer.search')}}"method="GET">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên khách hàng</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"  name="name"placeholder="Tên khách hàng" value="{{Request::get('name')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Địa chỉ Email</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="email" placeholder="Địa chỉ email" value="{{Request::get('email')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Số điện thoại</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Số điện thoại" value="{{Request::get('phone')}}">
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
              <h3 class="box-title">Danh sách khách hàng</h3>

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
                        <th>Tên khách hàng</th>
                        <th>Địa chỉ Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                    @if($customers->isEmpty())
                    <tr><td colspan="9" style="text-align:center">Không có bản ghỉ nào</td></tr>
                    @else
                    @php $page = Request::get('page') ? Request::get('page') : 1  @endphp
                    @foreach( $customers as $key => $customer)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$customer->name}}</td>
                        <td>{{$customer->email}}</td>
                        <td>{{$customer->phone}}</td>
                        <td>{{$customer->address}}</td>
                        <td>{{$customer->created_at}}</td>
                        <td>
                            <button data-url="{{route('admin.customer.delete',[$customer->id])}}" class="btn btn-delete btn-danger" >Xóa </button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pull-right">
                    {{$customers->appends(request()->query())->links()}}
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
