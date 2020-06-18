<?php 
namespace Model;

use PDO;
use ReflectionClass;
use ReflectionProperty;

abstract class Model implements iModel{

    protected static $conn;

    protected static $table;

    protected static $index = 'id';

    function __construct()
    {
        self::connect();
    }

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
            }
            $whereClause .= ' AND ' . $key . ' = :' . $key;
            $i++;
        }

        $query = 'SELECT * FROM ' . static::$table . ' WHERE ' . $whereClause;

        var_dump($query);

        $stmt = self::$conn->prepare($query);
        $stmt->execute($options);

        // var_dump($stmt->fetchAll());

        foreach ($stmt->fetchAll() as $value) {
            $result[] = self::morph($value);
        }

        return $result;
    }

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
