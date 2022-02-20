<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{

    function __construct()
    {
        return $this->middleware(['guest']);
    }
    
    function storeEmployee(Request $request){
        $request->validate([
            "employer"=>"required",
            "employee_name"=>"required",
            "employee_email"=>"email|required",
            "employee_password"=>"required",
        ]);
        $user = User::create([
            "name"=>$request["employee_name"],
            "email"=>$request["employee_email"],
            "role_id"=>2,
            "password"=>bcrypt($request["employee_password"]) ,
            "employer_id"=> $request["employer"],
        ]);
        auth()->login($user);

        return redirect()->to('/dashboard');

    }

    function storeEmployer(Request $request){
        $request->validate([
            "name"=>"required",
            "email"=>"email|required",
            "password"=>"required",
        ]);
        $user = User::create([
            "name"=>$request["name"],
            "email"=>$request["email"],
            "role_id"=>1,
            "password"=>bcrypt($request["password"]) ,
        ]);
        auth()->login($user);
        return redirect()->to('/dashboard');
    }

    function loginView(){
        return view('auth.login');
    }

    function registerView(){
        $employers = User::all()->where('role_id',1);
        return view('auth.register',['employers'=>$employers]);
    }

    function loginSubmit(Request $request){
        $request->validate([
            "email"=>"email|required",
            "password"=>"required",
        ]);

        if(auth()->attempt($request->only("email","password"))){
            return redirect()->to('/dashboard');
        }

        return back()->with('error','Invalid Credentials !');
        
    }

    // function logout(){
    //     auth()->logout();
    //     return redirect()->to('/');
    // }
}
