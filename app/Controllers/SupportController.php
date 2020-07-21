<?php 

namespace App\Controllers;

use Model\Category;
use Model\Ticket;
use Model\Service;

class SupportController {

    public function index()
    {
        $categories = Category::all();
        $services = Service::all();

        view('support.index', compact('categories', 'services'));
    }

    public function post()
    {

        $ticket = new Ticket;
        
    }
}
