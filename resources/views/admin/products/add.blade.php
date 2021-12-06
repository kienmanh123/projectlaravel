@extends('admin.layout.app')
@section('content')
<div class="row">
    <div class="col-md-12">
    <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Thêm sản phẩm</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <form action="{{route('admin.product.add.post')}}" method="POST" enctype="multipart/form-data">
                     @csrf
                <!-- /.box-header -->
                <div class="box-body">
                @include('includes.message')
                <div class="form-group" @if($errors->has('name')) has-error @endif>
                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                     <input type="text" class="form-control"  name="name" placeholder="Tên sản phẩm" value="{{old('name')}}">
                </div>
                <div class="form-group" @if($errors->has('category_id')) has-error @endif>
                    <label for="exampleInputEmail1">Danh mục</label>
                    <select name="category_id" class="form-control select2" style="width:100%">
                    @foreach($categorys as $item)
                    <option value="{{$item->id}}" @if($item->id ==old('category_id')) selected @endif> {{$item->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group" @if($errors->has('number')) has-error @endif>
                    <label for="exampleInputEmail1">Số lượng </label>
                     <input type="text" class="form-control"  name="number" placeholder="Nhập số lượng" value="{{old('number')}}">
                </div>
                <div class="form-group" @if($errors->has('price')) has-error @endif>
                    <label for="exampleInputEmail1">Giá tiền  </label>
                     <input type="text" class="form-control"  name="price" placeholder="Nhập giá tiền " value="{{old('price')}}">
                </div>
                <div class="form-group" @if($errors->has('status_hight_light')) has-error @endif>
                    <label for="exampleInputEmail1">sản phẩm top</label>
                    <br>
                     <input type="checkbox"  name="status_hight_light" value="1" @if(old('status_hight_light') == 1) checked @endif>
                </div>
                <div class="form-group" @if($errors->has('img')) has-error @endif>
                    <label for="exampleInputEmail1">Hình ảnh</label>
                     <input multiple type="file" class="form-control" id="file-input" name="img[]">
                    <div id="preview"></div>
                </div>
                <div class="form-group" @if($errors->has('description')) has-error @endif>
                    <label for="exampleInputEmail1">Hình ảnh</label>
                    <br>
                    <textarea name="description" id="editor1" cols="80" rows="10">{{old('description')}}</textarea>
                </div>    

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer ">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
         </div>
            </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('editor1');
        function previewImages() {
            var $preview = $('#preview').empty();
            if (this.files) $.each(this.files, readAndPreview);
            function readAndPreview(i, file) {
                if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                    return alert(file.name +" is not an image");
                } // else...
            
                var reader = new FileReader();

                $(reader).on("load", function() {
                    $preview.append($("<img/>", {src:this.result, height:100}));
                });

                reader.readAsDataURL(file);
            }
        }
        $('#file-input').on("change", previewImages);
    });
</script>
@stop