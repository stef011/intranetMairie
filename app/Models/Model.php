<?php 
namespace Model;

use PDO;
use ReflectionClass;
use ReflectionProperty;

abstract class Model implements iModel{

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

    function __construct()
    {
        self::connect();
    }

    /**
     * Finds an entry by its ID.
     * 
     * @param int $id
     * @return Model
     */
    public static function find($id)
    {
        self::connect();
        $sql = "SELECT * FROM " . static::$table . " WHERE " . static::$index . " = ?";
        $req = self::$conn->prepare($sql);
        $req->bindParam(1, $id);
        $req->execute();
        $res = self::morph($req->fetch());
        return $res;
    }

    /**
     * Filters the results in database.
     * 
     * @param array $options
     * @return array
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

        return $result;
    }

    /**
     * Save the Model into the database
     * 
     * @return bool
     */
    public function save()
    {
        $class = new ReflectionClass($this);
        $tableName = static::$table;

        $propsToImplode = array();
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $propertyName = $property->getName();
            $propsToImplode[] = '`'.$propertyName.'` = "'.$this->{$propertyName}.'"';
        }

        $setClause = implode(',',$propsToImplode); // glue all key value pairs together
        $sqlQuery = '';

        if ($this->id > 0) {
            $sqlQuery = 'UPDATE `'.$tableName.'` SET '.$setClause.' WHERE id = '.$this->id;
        } else {
            $sqlQuery = 'INSERT INTO `'.$tableName.'` SET '.$setClause.', id = '.$this->id;
        }

        $result = self::$conn->exec($sqlQuery);

        if (self::$conn->errorCode()) {
            throw new \Exception(self::$conn->errorInfo()[2]);
        }

        return $result;
    }

    /**
     * Use raw sql querry
     * /!\ Be careful, do not enter direct user input.
     * 
     * @param string $statement
     * @return Model
     */
    public static function rawSql($statement){
        self::connect();

        $res = self::$conn->query($statement)->fetchAll();

        foreach ($res as $value) {
            $response[] = self::morph($value);
        }

        return $response;
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
}
