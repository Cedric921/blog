<?php
namespace App;

use PDO;

class Connection{

    /**
     * cette methode nous permet de nous connecter a une base de donnees 
     */

    public static function getPDO(): PDO {
        return new PDO('mysql:dbname=blog;host=127.0.0.1', 'root', '',[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ]);
    }
}