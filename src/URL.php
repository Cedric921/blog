<?php 

namespace App;

/**
 * cette methode nous aide a nous permet de recuperer l'entier( la valeur du parametre $name ) passee dans l'url, pour afficher les
 * post a la page correspondant a ce int (ex; les posts de la page 2)
 */
class URL{
    public static function getInt(string $name, ?int $default = null): ?int{

        if (!isset($_GET[$name])) return $default;
        if($_GET[$name] === '0') return 0;
     
        if(!filter_var($_GET[$name], FILTER_VALIDATE_INT)){
            throw new \Exception("le parametre  $name dans l'url n'est pas un entier");  
        }
        return (int) $_GET[$name];
         
    }


    /**
     * cette methode nous aidera dans la pagination, 
     */

    public static function getPositiveInt(string $name, ?int $default = null): ?int {
        $param = self::getInt($name, $default);
        if ($param !== null && $param <= 0) {
            throw new \Exception("le parametre  $name dans l'url n'est pas un entier positif");
        }
        return $param;
    }
}