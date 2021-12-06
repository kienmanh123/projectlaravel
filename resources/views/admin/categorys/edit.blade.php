@extends('admin.layout.app')
@section('content')
<div class="row">
    @include('includes.message')
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">chỉnh sửa danh mục</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <form role="form" method="post" action="{{ route('auth.category.update',[$category['id]])}}">
                    @csrf
                    <input type="hidden" name="_token" value="MR4uZuV4jWArJG8aiVhErX9zphyX6DHDmuwPT4XT">                    <div class="box-body" style="">
                                                <div class="form-group  ">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" class="form-control" value="{{ old('name',$category['name']) }}" name="name" placeholder="Tên danh mục">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Danh mục cha</label>
                            <select class="form-control" name="parent_id">
                                <option value="">Chọn danh mục cha</option>
                                @foreach ($categoryParent as $key => $cat)
                            <option value="{{ $cat->id }}"@if($cat->id == $category['parent_id'])$selected @endif>{{$cat ->name}}</option>
                                 @endforeach                                 
                              </select>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                    </div>
                </form>
              </div>
        </div>
    </div>
@stop