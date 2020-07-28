<?php 

namespace Model;

class Tutorial extends Model
{
    protected static $table = "tutoriel";
    protected static $index = 'id_tutoriel';

    public static function active()
    {
        return Tutorial::filter(['ID_ETAT_TUTORIEL' => 1]);
    }
}
