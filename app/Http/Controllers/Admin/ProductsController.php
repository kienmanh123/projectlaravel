<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Image;
use App\Product;
use App\Http\Requests\Admin\ProductRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index(){
        $categorys = Category::get();
        $products = Product::with('category')->orderBy('id','desc')->paginate(20);
        return view('admin.products.index',['categorys'=>$categorys,'products' =>$products]);
    }
    public function search(Request $request){
        $inputData = $request->all();
        $products = Product::select(['products.*','categorys.name as category_name'])
        ->join('categorys','categorys.id','=','products.category_id');
        if(isset($inputData['code'])&&$inputData['code'] !=''){
            $products =$products->where('products.code','like','%'.$inputData['code'].'%');
        }
        if(isset($inputData['name'])&&$inputData['name'] !=''){
            $products =$products->where('products.name','like','%'.$inputData['name'].'%');
        }
        if(isset($inputData['price'])&&$inputData['price'] !=''){
            $products =$products->where(function($query) use($inputData){
                $query->where('products.price','>=',$inputData['price']);
                $query->where('products.price','<=',$inputData['price']);

            });
        }
        if(isset($inputData['status'])&&$inputData['status'] !=''){
            $products =$products->where('products.status','like','%'.$inputData['status'].'%');
        }
        if(isset($inputData['status_hight_light'])&&$inputData['status_hight_light'] !=''){
            $products =$products->where('products.status_hight_light','like','%'.$inputData['status_hight_light'].'%');
        }
        if(isset($inputData['categorys_id'])&&$inputData['categorys_id'] !=''){
            $products =$products->where('products.categorys_id','like','%'.$inputData['categorys_id'].'%');
        }
        $categorys = Category::get();
        $products =$products->orderBY('id','desc')->paginate(20);
        return view('admin.products.index',['categorys'=>$categorys,'products' =>$products]);
    }
    public function add(){
        $categorys = Category::get();
        return view('admin.products.add',['categorys'=>$categorys]);
    }
    public function store(ProductRequest $request){
            $inputData = $request->all();
            DB::beginTransaction();
            try{
                $products = new Product();
                $products->code = $this->generateRandomString();
                $products->name=$inputData['name'];
                $products->slug=Str::slug($inputData['name'],'-');
                $products->status='1';
                $products->category_id=$inputData['category_id'];
                $products->price=$inputData['price'];
                $products->number=$inputData['number'];

                $products->status_hight_light=isset($inputData['status_hight_light'])?$inputData['status_hight_light'] : 2;
                $products->description=$inputData['description'];
                $products->user_id=auth()->user()->id;
                $res = $products->save();
                $id = $products->id;
                $data =[];
                if($request->hasFile('img')){
                    foreach($inputData['img'] as $file){
                        $name = time().'.'.$file->getClientOriginalName();
                        $file->move(public_path().'/uploads/products/',$name);
                        $data[] =[
                            'product_id' =>$id,
                            'name' =>$name
                        ];
                    }
                }
                $img = Image::insert($data);
                if($res && $img){
                    DB::commit();
                    return redirect()->route('admin.product');
                }
                abort(500);
            }catch(Exception $e){
                   DB::rollBack();
            }
    }
    function generateRandomString($length = 10 ){
        $characters ='0123456789abcdefsjkhuyotgmflxw';
        $charactersLength =strlen($characters);
        $randomString ='';
        for ($i=0; $i < $length ; $i++) { 
            $randomString .=$characters[rand(0,$charactersLength -1)];
        }
        return '#'.strtoupper($randomString);
    }
    public function detail($id){
        $categorys = Category::get();
        $product =Product::with('images')->find($id);
        return view('admin.products.edit',['categorys'=>$categorys,'product' =>$product]);
    }
    public function update(ProductRequest $request ,$id){
        $inputData = $request->all();
        DB::beginTransaction();
        try{
            $product =Product::find($id);
            $product->name=$inputData['name'];
            $product->slug= Str::slug($inputData['name'],'-');
            $product->category_id=$inputData['category_id'];
            $product->number=$inputData['number'];
            $product->price=$inputData['price'];
            $product->status_hight_light=isset($inputData['status_hight_light'])?$inputData['status_hight_light'] : 2;
            $product->description=$inputData['description'];
            $product->user_id=auth()->user()->id;
            $res = $product->save();
            $id = $product->id;
            $data =[];
            if($request->hasFile('img')){
                Image::where('product_id',$id)->delete();
                foreach($inputData['img'] as $file){
                    $name = time().'.'.$file->getClientOriginalName();
                    $file->move(public_path().'/uploads/products/',$name);
                    $data[] =[
                        'product_id' =>$id,
                        'name' =>$name
                    ];
                }
            }
            $img = Image::insert($data);
            if($res && $img){
                DB::commit();
                return redirect()->route('admin.product');
            }
            abort(500);
        }catch(Exception $e){
               DB::rollBack();
        }
    }
    public function delete($id){ 
        $product =Product::where('id',$id)->delete();
        return redirect()->route('admin.product');

    }
    
}
