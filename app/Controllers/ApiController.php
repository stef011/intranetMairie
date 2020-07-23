<?php 

namespace App\Controllers;

use Model\SubCategory;
use Model\Tutorial;

class ApiController{
    public function tutos()
    {
        $tutoriels = Tutorial::search(($_POST['search'] ?? ''))->filter(['ID_ETAT_TUTORIEL' => 1]);
        $response = '';
        
        foreach ($tutoriels as $tutoriel) {
            $response .= '<li><a href="'.route('tutoriel', ['id' => $tutoriel->ID_TUTORIEL]).'"
                    target="_blank">'.$tutoriel->NOM_TUTORIEL.'</a></li>';
        }

        echo $response;

    }

    public function subCategories()
    {
        $sousCats = SubCategory::filter(['category_id' => ($_POST['cat'] ?? '')]);
        $response = '';

        foreach ($sousCats as $sousCat) {
            $response .= '<option value="'. $sousCat->id .'">'. $sousCat->nom .'</option>' . "\n";
        }
        echo $response;
    }
}

?>
