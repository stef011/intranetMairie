<?php 
namespace Model;

use PDO;

abstract class Model implements iModel{
    protected static $conn;
    protected static $table;
    protected static $index = 'id';

    public static function find(Int $id)
    {
        self::connect();
        $sql = "SELECT * FROM " . static::$table . " WHERE " . static::$index . " = ?";
        $req = self::$conn->prepare($sql);
        $req->bindParam(1, $id);
        $req->execute();
        $res = $req->fetch();
        return $res;
    }
    
    public static function connect()
    {
        if(!static::$table){
            static::$table = substr(strrchr(static::class, '\\'), 1) . 's';
        }
        try {
            self::$conn = new PDO($_ENV['DB_CONNECTION'] . ":host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'] . ";charset=utf8", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
