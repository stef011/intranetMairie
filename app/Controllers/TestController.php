<?php 

namespace App\Controllers;

class TestController {

    public function show()
    {
        $toto = '37';
        return view('toto', compact('toto'));
    }
}
