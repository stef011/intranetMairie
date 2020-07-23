<?php 

namespace App\Controllers;

use Model\SubCategory;
use Model\Tutorial;

class ApiController{
    public function tutos()
    {
        $tutoriels = Tutorial::search(($_POST['search'] ?? ''))->filter(['ID_ETAT_TUTORIEL' => 1]);
        $response = '';
        $modals = '';
        
        foreach ($tutoriels as $tutoriel) {
            $response .= '<li><a type="button" data-toggle="modal"
                    data-target="#Modal'.$tutoriel->ID_TUTORIEL.'">'.$tutoriel->NOM_TUTORIEL.'</a></li>';

            $modals .= <<<END
                <div class="modal fade" id="Modal$tutoriel->ID_TUTORIEL" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalTitle$tutoriel->ID_TUTORIEL">$tutoriel->NOM_TUTORIEL</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            $tutoriel->DESCRIPTION_TUTORIEL
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
                </div>
            END;
        }

        echo $response . "|" . $modals;

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
