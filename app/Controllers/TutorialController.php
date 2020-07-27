<?php 

namespace App\Controllers;

use Model\Administrateur;
use Model\Tutorial;

class TutorialController
{
    public function index()
    {
        $tutorials = Tutorial::all();
        return view('tutorial.index', compact('tutorials'));
    }

    public function show($id)
    {
        $tutoriel = Tutorial::find($id);
        $admin = Administrateur::find($tutoriel->ID_ADMINISTRATEUR);

        view('tutorial.show', compact('tutoriel', 'admin'));
    }
}
