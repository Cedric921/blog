<?php

    use App\Table\PostTable;
    use  App\Connection;



    $pdo = Connection::getPDO();

    $table = new PostTable($pdo);
    $posts = $table->all();
    $stmt = 0;

    foreach ($posts as $key => $value) {
        $stmt += 1;
    }


    if($stmt > 0){


        $element = array();
        $element["item_count"] = $stmt;
        $element["posts"] = array();
        $category= [];

        foreach ($posts as $item) {
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

            array_push($element["posts"], $e);
            $category = [];
        }
        echo json_encode($element);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>