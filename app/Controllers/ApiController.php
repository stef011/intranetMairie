<?php 

namespace App\Controllers;

use Model\Tutorial;

class ApiController{
    public function tutos()
    {
        $tutoriels = Tutorial::search(($_POST['search'] ?? ''));
        $response = '';
        
        foreach ($tutoriels as $tutoriel) {
            $response .= '<li><a href="'.route('tutoriel', ['id' => $tutoriel->ID_TUTORIEL]).'"
                    target="_blank">'.$tutoriel->NOM_TUTORIEL.'</a></li>';
        }

        echo $response;

    }
}

?>
