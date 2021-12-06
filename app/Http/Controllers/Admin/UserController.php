<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use App\Http\Requests\Admin\UserRequest;
class UserController extends Controller
{
    public function index(){
        $users =User::orderby('id','desc')->paginate(20);
        return view('admin.user.index',['users' =>$users]);
    }
    public function search(Request $request){
        $inputData =$request->all();
        $users =User::select('*')->orderBy('id','desc');
        if(isset($inputData['name'])&&$inputData['name']!= ''){
            $users=$users->where('name','like','%'.$inputData['name'].'%');
        }
        if(isset($inputData['email'])&&$inputData['email']!= ''){
            $users=$users->where('email','like','%'.$inputData['email'].'%');
        }
        if(isset($inputData['number_phone'])&&$inputData['number_phone']!= ''){
            $users=$users->where('number_phone','like','%'.$inputData['number_phone'].'%');
        }
        if(isset($inputData['role'])&&$inputData['role']!= ''){
            $users=$users->where('role',$inputData['role']);
        }
        $users =$users->paginate(1);
        return view('admin.user.index',['users' =>$users]);
    }
    public function create(){
        return view('admin.user.add');
    }
    public function store(UserRequest $request){
        $inputData =$request->all();
        $user =new User();
        $user->name=$inputData['name'];
        $user->email=$inputData['email'];
        $user->number_phone=$inputData['number_phone'];
        $user->date_of_birth=date('Y-m-d',strtoTime(str_replace('/','-',$inputData['date_of_birth'])));
        $user->gender=$inputData['gender'];
        $user->address=$inputData['address'];
        $user->role=$inputData['role'];
        $user->password=Hash::make("123456");
        $res=$user->save();
        if($res){
            return redirect()->route('admin.user');
        }
        abort(500);
    }
    public function detail($id){
        $user = User::find($id);
        return view('admin.user.edit',['user'=>$user]);
    }
    public function update(UserRequest $request,$id){
        $inputData =$request->all();
        $user = User::find($id); 
        $user->name=$inputData['name'];
        $user->email=$inputData['email'];
        $user->number_phone=$inputData['number_phone'];
        $user->date_of_birth=date('Y-m-d',strtoTime(str_replace('/','-',$inputData['date_of_birth'])));
        $user->gender=$inputData['gender'];
        $user->address=$inputData['address'];
        $user->role=$inputData['role'];
        $res=$user->save();
        if($res){
            return redirect()->route('admin.user');
        }
        abort(500);
    }
    public function delete($id){
        $user = User::find($id); 
        return redirect()->route('admin.user');
    }
}
