<?php 

namespace App\Controllers;

use Model\Category;
use Model\Ticket;
use Model\Service;
use Model\SubCategory;

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
            $email = test_input($_POST['email']);

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
        $ticket->email = $email;

        $ticket = $ticket->save();


        // mail('zundel.stephane@sfr.fr', 'Support Informatique : '. $category . '-' . $subCategory , $desc , 'From : test.test@saint-louis.fr');

        $serviceName = Service::find($service)->nom_service;

        $subCategory = SubCategory::find($ticket->sous_category_id);
        $category = Category::find($subCategory->category_id);

        $recipient = 'informatique@ville-saint-louis.fr';
        $mailSubject = 'Nouveau ticket Support informatique dans [' . $category->nom . '.' . $subCategory->nom .']';
        $bodyText = "$subject \r\n $subCategory->nom \r\n $desc \r\n $nom $prenom - Servie $serviceName \r\n Envoyé le $ticket->date";
        $bodyHtml = "<h1>$subCategory->nom</h1>
        <h2> $subject </h2> $desc <br><br><a href='mailto:$ticket->prenom%20$ticket->nom<$ticket->email>
    ?subject=Re:%20" . str_replace(' ', ' %20', $ticket->subject) . "'>
    $nom $prenom </a> - Service $serviceName <br><br> Envoyé le $ticket->date";

    sendMail($recipient, $mailSubject, $bodyText, $bodyHtml);

    header('Location:'.route('index').'?success=1');
    }
    }
