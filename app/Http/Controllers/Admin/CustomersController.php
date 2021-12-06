<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
class CustomersController extends Controller
{
    public function index(){
        $customers=Customer::orderby('id','desc')->paginate(20);
        return view('admin.customer.index',['customers' =>$customers]);
    }
    public function search(Request $request){
        $inputData =$request->all();
        $customers =Customer::orderBy('id','desc');
        if(isset($inputData['name'])&&$inputData['name']!= ''){
            $users=$customers->where('name','like','%'.$inputData['name'].'%');
        }
        if(isset($inputData['email'])&&$inputData['email']!= ''){
            $users=$customers->where('email','like','%'.$inputData['email'].'%');
        }
        if(isset($inputData['phone'])&&$inputData['phone']!= ''){
            $users=$customers->where('phone','like','%'.$inputData['phone'].'%');
        }
        $customers=Customer::orderby('id','desc')->paginate(20);
        return view('admin.customer.index',['customers' =>$customers]);
    }
    public function delete($id){
        $customer =Customer::find($id)->delete();
        return redirect()->route('admin.customer');
    }
}
