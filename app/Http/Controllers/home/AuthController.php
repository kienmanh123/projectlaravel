<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Home\RegisterRequest;
use App\User;
class AuthController extends Controller
{
    public function login(){
        return view('home.auth.login');
    }
    public function postLogin(Request $request){
        $input = $request->all();
        $credentails = $request->only('email','password');
        $remember = $request->filled('remember');
    if(Auth::attempt($credentails,$remember)){
        toastr()->success('Chào mừng'.Auth::user()->name.'Đăng nhập thành công!','thành công!',['timeOut => 4000']);
        return redirect()->route('home');
    }else{
        return redirect()->route('home.login')
            ->withErrors(['Tài khoản hoặc mật khẩu không chính xác']);
    }   }
    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
    public function register(){
        return view('home.auth.register');
    }
    public function postRegister(RegisterRequest $request){ 
        $inputData = $request->all();
        $user = new User();
        $user->name = $inputData['name'];
        $user->email = $inputData['email'];
        $user->number_phone = $inputData['number_phone'];
        $user->date_of_birth = date("Y-m-d" , strtotime(str_replace('/','-',$inputData['date_of_birth'])));
        $user->gender = $inputData['gender'];
        $user->address = $inputData['address'];
        $user->role = 2;
        $user->password = Hash::make($inputData['password']);
        $res = $user->save();
        if($res){
            toastr()->success('đăng ký thành công','Thành Công!',['timeOut' =>4000]);
            return redirect()->route('home');
        }
        abort(500);
    }
}
