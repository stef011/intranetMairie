<?php 

namespace App\Controllers;

use Model\Administrateur;
use Model\Information;

class IndexController{
    

    public function show()
    {
        $infos = Information::show();
        return view('index', compact('infos'));
    }
}
