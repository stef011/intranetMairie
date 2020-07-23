<?php 

namespace App\Controllers;

use Model\Agent;

class AnnuaireController
{
    public function index()
    {
        $search = $_GET['search'] ?? '';
        $searchUri = $search != '' ? '&search='.$search : '';
        
        $agents = Agent::search($search);
        
        $sort = $_GET['sort'] ?? '';

        // SwitchCase pour définir le tri
        switch ($sort) { 
            case 'name':
                $agents->orderBy(['nom'=>'asc']);
            break;
            case 'aname':
                $agents->orderBy(['nom'=>'desc']);
            break;
            case 'surname':
                $agents->orderBy(['prenom'=>'asc']);
            break;
            case 'asurname':
                $agents->orderBy(['prenom'=>'desc']);
            break;
            case 'function':
                $agents->orderBy(['fonction'=>'asc']);
            break;
            case 'afunction':
                $agents->orderBy(['fonction'=>'desc']);
            break;
            case 'service':
                $agents->orderBy(['service'=>'asc', 'chef_de_service'=>'desc']);
            break;
            case 'aservice':
                $agents->orderBy(['service'=>'desc', 'chef_de_service' => 'desc']);
            break;
            
            default:
                $agents->orderBy(['service'=>'asc', 'chef_de_service'=>'desc', 'nom'=>'asc']);
            break;
        }

        $tableau_accents = array( 'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A',
        'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O',
        'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
        'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o',
        'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', '('=>'', ')'=>'' );

        return view('annuaire.index', compact(['agents', 'search', 'searchUri', 'sort', 'tableau_accents']));
    }
}
