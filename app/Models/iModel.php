<?php 

namespace Model;

interface iModel{
    public static function find(Int $id);
    public function save();
    public function filter($options = []);
    public static function morph(array $object);
}
