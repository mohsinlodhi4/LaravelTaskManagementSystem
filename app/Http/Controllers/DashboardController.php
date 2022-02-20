<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{

    function __construct()
    {
        return $this->middleware('auth')->except(['index']);
    }

    function index(){
        return view('home');
    }

    // Emplolyer Dashboard
    function dashboard(){
        $user = auth()->user();
        if($user->role_id==1)
            return view("dashboardEmployer",["user"=>$user]);
        elseif($user->role_id==2){
            return view("dashboardEmployee",["user"=>$user]);
        }
        else    
            return redirect()->to('/');

    }


    function logout(){
        auth()->logout();
        return redirect()->to('/');
    }
}
