<?php 

namespace App\Controllers;

use Model\Category;
use Model\Ticket;
use Model\Service;

class SupportController {

    public function index($error = '')
    {
        $categories = Category::all();
        $services = Service::all();

        view('support.index', compact('categories', 'services', 'error'));
    }

    public function post()
    {
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            if ($data != '') {
               return $data;
            } else {
               return (new SupportController)->index('Veuillez compléter tous les champs !');
            }
            // return $data;
        }

        // function notnull($data){
        // }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = test_input($_POST['nom']);
            $prenom = test_input($_POST['prenom']);
            $service = test_input($_POST['service']);
            $category = test_input($_POST['category']);
            $subCategory = test_input($_POST['sub-category']);
            $subject  = test_input($_POST['subject']);
            $desc = test_input($_POST['desc']);

        } else{
            return $this->index();
        }
        
        $ticket = new Ticket;
        $ticket->subject = $subject;
        $ticket->description = $desc;
        $ticket->sous_category_id = $subCategory;
        $ticket->nom = $nom;
        $ticket->prenom = $prenom;
        $ticket->service_id = $service;

        $ticket->save();

        header('Location:'.route('index').'?success=1');
    }
}
