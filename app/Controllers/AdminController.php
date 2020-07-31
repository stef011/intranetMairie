<?php 

namespace App\Controllers;

use App\Auth\Auth;
use App\Router\Router;
use Model\Category;
use Model\SubCategory;
use Model\Ticket;

class AdminController 
{
    public function index()
    {
        // Auth::authenticate(['login' => 'admin', 'password' => '€-Louis2020']);
        if (Auth::user() == null) {
            return view('admin.login');
        }
        $admin = Auth::user();
        if (in_array($admin->LOGIN_ADMIN, ['admin', 'informatique'])) {
            header('Location: '. route('admin.tickets'));
        }
        return view('admin.index', compact('admin'));
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

    public function tickets()
    {
        if (Auth::user() == null) {
            return view('admin.login');
        }
        $admin = Auth::user();
        $tickets = Ticket::all()->orderBy(['state_id'=>'asc']);
        $cats = Category::all();
        $subCats = SubCategory::all();
        $showSub = isset($_GET['subCat']) ? SubCategory::find($_GET['subCat']) : '';

        return view('admin.tickets', compact('admin', 'tickets', 'cats', 'subCats', 'showSub'));
    }
}
