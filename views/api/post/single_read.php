<?php

    use App\Connection;
    use App\Model\Post;
use App\Table\PostTable;

$pdo = Connection::getPDO();
    $table = new PostTable($pdo);  
    $id = isset($params['id']) ? $params['id'] : die();

    $item = new Post();
    $item = $table->find($id);

    if($item->getName() != null){
        $category= [];

        foreach ($item->getCategories() as $value) {
            $category[] = [
                "id" =>$value->getId(),
                "name" => $value->getName()
            ];
            
        }
        $e = array(
            "id" => $item->getID(),
            "name" => $item->getName(),
            "slug" => $item->getSlug(),
            "content" => $item->getContent(),
            "created" => $item->getCreatedAt(),
            "categories" => $category
        );
        
        echo json_encode($e);
        $category = [];
    }
      
    else{
        http_response_code(404);
        echo json_encode("Employee not found.");
    }
?>