<?php 
namespace Model;

class Information extends Model{
    protected static $table = 'information';
    protected static $index = 'ID_Info';

    public static function show()
    {
        return self::rawSql('SELECT * FROM information WHERE affichage = 1 ORDER BY ID_Info DESC');
    }
}
