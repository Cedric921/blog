<?php

namespace App;

class Data{

    public static function hydrate($object, $data, array $fields){
        foreach ($fields as $field) {
            $method = "set". ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ',$field))));
            $object->$method($data[$field]);
        }
    }
}