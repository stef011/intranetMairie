<?php 

namespace Model;

interface iModel{
    public static function find(Int $id);
    public function save();
    public static function filter($options = []);
    public static function morph(array $object);
    public static function rawSql($statement);
}
