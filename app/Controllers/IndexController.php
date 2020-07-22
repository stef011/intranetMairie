<?php 

namespace App\Controllers;

use Model\Administrateur;
use Model\Information;

class IndexController{
    

    public function show()
    {
        $success = $_GET['success'] ?? '';
        $infos = Information::show();
        return view('index', compact('infos', 'success'));
    }
}
