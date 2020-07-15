<?php 

namespace App\Controllers;

use App\Auth;
use App\Router\Router;

class AdminController 
{
    public function index()
    {
        // Auth::authenticate(['login' => 'admin', 'password' => '€-Louis2020']);
        if (Auth::user() == null) {
            return view('admin.login');
        }
        return view('admin.index');
    }

    public function login()
    {
        $credentials =['login'=>$_POST['login'],'password'=> $_POST['password']];
        if(Auth::authenticate($credentials)){
            header('Location: ' . route('admin.index'));
        }
        
    }

    public function logout()
    {
        Auth::logout();
        header('Location: '. route('index'));
    }
}
