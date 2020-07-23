<?php 

namespace Model;

use App\Core\Collection;


class Agent extends Model
{

    protected static $index = 'id_u';

    protected static $table = 'agents';

    protected static $search_columns = 'prenom, nom, description, num_bureau, tel_int, tel_ext, adresse_postal, fonction, service, societe';

    protected static $columns = 'id_u, identifiant, prenom, nom, description, num_bureau, tel_int, tel_ext,
    adresse_mail, adresse_postal, fonction, service, localisation, batiment, etage, chef_de_service,
    societe, date_debut_contrat, nom_photo, nom_mail_photo';


    public static function all()
    {
        self::connect();
        $sql = "SELECT id_u, identifiant, prenom, nom, description, num_bureau, tel_int, tel_ext, adresse_mail, adresse_postal, fonction, service, localisation, batiment, etage, chef_de_service,
        societe, date_debut_contrat, nom_photo, nom_mail_photo FROM " . static::$table . " WHERE aff_u = 0" ;
        $req = self::$conn->prepare($sql);
        $req->execute();
        foreach ($req->fetchAll() as $value) {
            $result[] = self::morph($value);
        }


        return new Collection($result);
    }


    /** 
     * Request on the database, order results
     * 
     * @var array An array of columns and directions. Ex: ['name' => 'asc', 'surname' => 'desc']
     */
    public static function orderBy($sorts)
    {
        self::connect();
        $sql = "SELECT id_u, identifiant, prenom, nom, description, num_bureau, tel_int, tel_ext, adresse_mail,
        adresse_postal, fonction, service, localisation, batiment, etage, chef_de_service,
        societe, date_debut_contrat, nom_photo, nom_mail_photo FROM " . static::$table . "WHERE aff_u = 0 ORDER BY ";
        
        $i = 0;
        foreach ($sorts as $key => $sort) {
            if ($i == 0) {
                $sql .= $key . " " . $sort;
            }else{
                $sql .= ", ". $key . " " . $sort;
            }
            $i++;
        }

        $req = self::$conn->prepare($sql);
        $req->execute();
        foreach ($req->fetchAll() as $value) {
            $result[] = self::morph($value);
        }

        return new Collection($result);

    }





    public static function search($search)
    {
        self::connect();

        $result= [];

        if ($search == '') {
            return static::all();
        }
        $columns_sql = 'SELECT column_name FROM information_schema.columns WHERE table_name = "' . static::$table . '"';

        $stmt = self::$conn->prepare($columns_sql);
        $stmt->execute();

        $fetchedCol = $stmt->fetchAll();

        if(static::$search_columns == ''){
            static::$search_columns = '';
            foreach($fetchedCol as $value){
                static::$search_columns .= $value['column_name'] . ', ';
            }
            static::$search_columns = trim(static::$search_columns, ", ");
        }

        if(static::$columns == ''){
            static::$columns = '';
            foreach($fetchedCol as $value){
                static::$columns .= $value['column_name'] . ', ';
            }
            static::$columns = trim(static::$search_columns, ", ");
        }


        // static::$search_columns = implode(', ',array_slice(explode(', ', static::$search_columns), 0, 18));

        $search = explode(' ', $search);

        $regex = "(.*(";
        $i=0;
        foreach ($search as $value) {
            $i++;
            $regex .= $value . "|";
        }
        $regex = trim($regex, '|');
        $regex .= ").*){" . $i . ",}";

        // $sql = 'SELECT '. static::$index . ' as id, CONCAT(' . static::$search_columns . ') as concatenate FROM ' . static::$table . ' WHERE id_u = 20' ;        
        $sql = 'SELECT '. static::$columns .' FROM ' . static::$table . ' JOIN (SELECT '. static::$index . ' as id, CONCAT(' . static::$search_columns . ') as concatenate FROM ' . static::$table . ') as T ON T.id = ' . static::$table . '.' . static::$index . ' WHERE T.concatenate REGEXP :regex AND aff_u = 0' ;        

        $stmt = self::$conn->prepare($sql);
        $stmt->execute(['regex' =>$regex]);

        // dd($stmt->fetchAll(), $regex, static::$search_columns );

        foreach ($stmt->fetchAll() as $key => $value) {
            $result[] = self::morph($value);
        }

        return new Collection($result);
    }

}
