<?php 
namespace Model;

use PDO;
use ReflectionClass;
use ReflectionProperty;
use App\Core\Collection;
use ReflectionObject;

abstract class Model {

    /** 
     * The connection for the Model
     * 
     * @var PDO
     */
    protected static $conn;

    /**
     * The table associated with the model
     * 
     * @var string|null
     */
    protected static $table;

    /**
     * The name of the index column
     * 
     * @var string
     */
    protected static $index = 'id';

    /**
     * The Columns where to search on the table
     * 
     * @var string
     */
    protected static $search_columns;

    /**
     * Te columns of the table
     * 
     * @var string
     */
    protected static $columns;


    function __construct()
    {
        self::connect();
    }

    /**
     * Return all the table
     * @return Collection
     */
    public static function all()
    {
        self::connect();
        $result = [];
        $sql = "SELECT * FROM " . static::$table ;
        $req = self::$conn->prepare($sql);
        $req->bindParam(1, $id);
        $req->execute();
        foreach ($req->fetchAll() as $value) {
            $result[] = self::morph($value);
        }

        return new Collection($result);
    }

    /**
     * Finds an entry by its ID.
     * 
     * @param int $id
     * @return Model
     */
    public static function find($id)
    {
        $res = array();

        if (!is_array($id)) {
            $id = array($id);
        }
        $ids = implode(",",$id);

        self::connect();
        $sql = "SELECT * FROM " . static::$table . " WHERE " . static::$index . " IN (?)";
        $req = self::$conn->prepare($sql);
        $req->bindParam(1, $ids);
        $req->execute();
        $preRes = $req->fetchAll();
        foreach ($preRes as $pre) {
            $res[] = self::morph($pre);
        }
        if (count($res) > 1) {
            return $res;
        }elseif (count($res) == 1) {
            return $res[0];
        }
        return null;
    }

    /**
     * Filters the results in database.
     * 
     * @param array $options
     * @return Collection
     */
    public static function filter($options = [])
    {
        self::connect();

        $result = [];
        $query = '';

        $whereClause = '';

        $i = 0;

        foreach ($options as $key =>$option) {
            if ($i == 0) {
                $whereClause .= $key . ' = :' . $key;
            }else{
                $whereClause .= ' AND ' . $key . ' = :' . $key;
            }
            $i++;
        }

        $query = 'SELECT * FROM ' . static::$table . ' WHERE ' . $whereClause;

        // var_dump($query);

        $stmt = self::$conn->prepare($query);
        $stmt->execute($options);

        // var_dump($stmt->fetchAll());

        foreach ($stmt->fetchAll() as $value) {
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
        $sql = 'SELECT '. static::$columns .' FROM ' . static::$table . ' JOIN (SELECT '. static::$index . ' as id, CONCAT(' . static::$search_columns . ') as concatenate FROM ' . static::$table . ') as T ON T.id = ' . static::$table . '.' . static::$index . ' WHERE T.concatenate REGEXP :regex' ;        

        $stmt = self::$conn->prepare($sql);
        $stmt->execute(['regex' =>$regex]);

        // dd($stmt->fetchAll(), $regex, static::$search_columns );

        foreach ($stmt->fetchAll() as $key => $value) {
            $result[] = self::morph($value);
        }

        return new Collection($result);
    }

    /**
     * Save the Model into the database
     * 
     * @return Model
     */
    public function save()
    {
        $object = new ReflectionObject($this);
        $tableName = static::$table;

        $propsToImplode = array();
        foreach ($object->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $propertyName = $property->getName();
            $propsToImplode[] = '`'.$propertyName.'` = "'.$this->{$propertyName}.'"';
        }

        $setClause = implode(',',$propsToImplode); // glue all key value pairs together
        $sqlQuery = '';

        $index = static::$index;

        if ($this->$index ?? 0 > 0) {
            $sqlQuery = 'UPDATE `'.$tableName.'` SET '.$setClause.' WHERE id = '.$this->id;
        } else {
            $sqlQuery = 'INSERT INTO `'.$tableName.'` SET '.$setClause;
        }

        $result = self::$conn->exec($sqlQuery);


        if (self::$conn->errorCode() != 00000) {
            throw new \Exception(self::$conn->errorInfo()[2]);
        }
        
        return static::lastInserted();
    }

    /**
     * Use raw sql querry
     * /!\ Be careful, do not enter direct user input.
     * 
     * @param string $statement
     * @return Collection
     */
    public static function rawSql($statement){
        self::connect();

        $res = self::$conn->query($statement)->fetchAll();

        foreach ($res as $value) {
            $response[] = self::morph($value);
        }

        return new Collection($response);
    }


    /** 
     * Transforms the returned table from the database into Models table
     * 
     * @param array $object
     * @return array Model
     */
    public static function morph(array $object) {
        $class = new ReflectionClass(get_called_class()); // this is static method that's why i use get_called_class

        $entity = $class->newInstance();

        // foreach($class->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
        //     if (isset($object[$prop->getName()])) {
        //         $prop->setValue($entity,$object[$prop->getName()]);
        //     }
        // }

        foreach ($object as $key => $value) {
            if (!is_int($key)) {
                $entity->$key = $value;
            }
        }

        // $entity->initialize(); // soft magic

        return $entity;
    }


    /**
     *  Connects the model to the database
     * 
     * @return void
     */
    public static function connect()
    {
        if(!static::$table){
            static::$table = strtolower(substr(strrchr(static::class, '\\'), 1)) . 's';
        }
        try {
            self::$conn = new PDO($_ENV['DB_CONNECTION'] . ":host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'] . ";charset=utf8", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);s
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get the last inserted row
     * 
     * @return Collection
     */
    public static function lastInserted()
    {
        
        // $sql = 'SELECT LAST_INSERT_ID() as id';
        // $stmt = self::$conn->prepare($sql);
        // $stmt->execute();
        // dd($stmt->fetch());

        $id = static::$conn->lastInsertId();

        // $id =  self::morph($stmt->fetch());


        return static::find($id);
    }
}
