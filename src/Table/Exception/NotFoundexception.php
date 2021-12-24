<?php 
namespace App\Table\Exception;

use Exception;

class NotFoundException extends Exception{
    public function __construct(string $table, $id){
        $this->message = " Aucune enregistrement ne correspond A L'ID $id dans la table $table";
    }
}