@extends('home.layout.app')
@section('content')
    @include('home.includes.product-content')
    <div class="product-content">
    <div class="row">
        <div class="col-12">
            <div class="section-title">
                <h2>Sản Phẩm</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="product-info">
                <div class="tab-content" id="myTabContent">
                  
                            <div class="row">
                                @if($products->isEmpty())
                                <div class="col-12">
                                    <p class="text-center" style="margin-top:10px;font-weight:bold;color:orangered">Không có sản phẩm nào</p>
                                </div>
                                @else   
                                    @foreach($products as $prod)
                                     <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                            <div class="single-product">
                                             <div class="product-img">
                                                <a href="">
                                                <img class="default-img" src="{{ asset('uploads/products/'.$prod->images[0]->name) }}" style="height:300px" alt="#">
                                                <img class="hover-img" src="{{ asset('uploads/products/'.$prod->images[0]->name) }}" style="height:300px" alt="#">
                                                @if($prod->status_hight_light == 1)
                                                <span class="out-of-stock">Hot</span>
                                                @else
                                                <span class="new" style="background-color:green;">Mới</span>@endif
                                            </a>
                                            <div class="button-head">
                                                <div class="product-action">
                                                    <a data-toggle="modal" data-target="#exampleModal" title="Xem chi tiết" href="#"><i class=" ti-eye"></i><span>Xem chi tiết</span></a>
                                                    <!-- <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                                    <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a> -->
                                                </div>
                                                <div class="product-action-2">
                                                    <a title="Thêm giỏ hàng" href="#">Thêm giỏ hàng</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3><a href="">{{$prod->name}}</a></h3>
                                            <div class="product-price">
                                                <span style="font-weight:bold;color:orangered">{{number_format($prod->price,0,",",".")}}VND</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    @endforeach
                              
                            </div>
                             {{ $products->appends(request()->query())->links() }}
                            </div>
                            @endif
                    <!--/ End Single Tab -->
                </div>

            </div>
        </div>
    </div>
</div>
    
@stop
