<?php

namespace App\Http\Controllers\Home;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\CheckOutRequest;
use App\Product;
use App\User;
use App\Order;
use App\PayOrder;
use App\Mail\SendMail;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function index(){
        return view('home.cart.index');
    }

    public function addCart(Request $request ,$id){
        $product = Product::with('images')->where('id',$id)->first();
        if($request->has('quant') && ($request['quant'][$product->id] > $product->number)){
            toastr()->error(' sản phẩm trong kho không đủ !' ,'Lỗi !' );
        }else{
            if($product->number == 0){
                toastr()->error('Sản phẩm hết hàng !','Lỗi !');
            } else {
               $cart = Cart::add([
                'id' => $product->id, 
                'name' => $product->name, 
                'qty' => $request->has('quant') ? $request['quant'][$product->id] : 1 , 
                'price' =>  $product->price, 
                'options' => [
                    'image' => $product->images->first()->name,
                    'slug' =>$product->slug
                ]]);
                if($cart){
                    toastr()->success('Thêm vào giỏ hàng thành công!', 'Thành Công!');
                }
           }
        }
        return redirect()->route('home');
    }
    public function delete($id){
        Cart::remove($id);
        toastr()->success('Xóa sản phẩm thành công!', 'Thành Công!');
        return redirect()->route('home');
    }
    public function deleteAll(){
        Cart::destroy();
        toastr()->success('Xóa giỏ hàng thành công!', 'Thành Công!');
        return redirect()->route('home.cart');

    }
    public function updateCart(Request $request ){
        $input = $request->all();
        foreach($input['quant'] as $key => $qty){
            Cart::search(function($catItem,$rowId) use($key,$qty){
                if($rowId === $key){
                    return Cart::update($rowId,['qty' => $qty]);
                }
            });
        }
    }
    public function checkout(){
        return view('home.cart.checkout');
    }
    public function addCheckout(CheckOutRequest $request){
        $inputData = $request->all();  
        $codeOrder = $this->generateRandomString() ;
        DB::beginTransaction();
        try {
             if(Cart::count() == 0){
                toastr()->error('Chưa có sản phẩm nào trong giỏ hàng ! ', 'Lỗi !');
                return redirect()->route('home');
             }
             if(isset($inputData['createUser'])){
                $user = User::where('email',$inputData['email'])->first();
                if(!$user){
                    $user = new User();
                    $user->name = $inputData['name'];
                    $user->email = $inputData['email'];
                    $user->number_phone = $inputData['number_phone'];
                    $user->gender = '1';
                    $user->address = $inputData['address'];
                    $user->role ='2';
                    $user->password = Hash::make('123456');
                    $res = $user->save();
                }
             }
             $customer = Customer ::where('email',$inputData['email'])->first();
             $idCustomer = $customer ? $customer->id : '';
             if (!$customer) {
                $customer = new Customer();
                $customer->name = $inputData['name'];
                $customer->email = $inputData['email'];
                $customer->phone = $inputData['phone'];
                $customer->address = $inputData['address'];
                $customer->note = $inputData['note'] = '' ? $inputData['note'] : '';
                $resCustomer = $customer->save();
                $idCustomer = $customer->id;
             }
             $order = new Order();
             $order->code = $codeOrder;
             $order->status = 1;
             $resOder = $order->save();
             $idOder = $order->id;
             foreach(Cart::content() as $cart){
                $payOrder = new PayOrder();
                $payOrder->pay_qty = $cart->qty;
                $payOrder->pay_subtotal = ($cart->qty * $cart->price);
                $payOrder->pay_price = $cart->price;
                $payOrder->customer_id = $idCustomer;
                $payOrder->product_id = $cart->id;
                $payOrder->order_id = $idOder;
                $payOrder->save();
                $product = Product::find($cart->id);
                $product->status = ($product->number - $cart->qty) == 0 ? 2:1;
                $product->number = ($product->number -$cart->qty);
                $product->save();
             }
             if($resOder){
                Mail::to($inputData['email'])->send(new SendMail(
                    [
                        'orderCode' => $codeOrder,
                        'cartData' => Cart::content(),
                        'customer' => $inputData
                    ]
                    ));
                DB::commit();
                toastr()->success('Thanh toán thành công !' , 'Thành công !');
                Cart::destroy();
                return redirect()->route('home');
             }
        }catch(Exception $e){
            toastr()->error('Thanh toán không thành công !' , 'Lỗi !');
            Cart::rollBack();
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
}
