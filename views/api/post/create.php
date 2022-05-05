<?php

    use App\Connection;
    use App\Model\Post;
    use App\Table\PostTable;

    $pdo = Connection::getPDO();

    $table = new PostTable($pdo);
    $item = new Post();

    $item->setCreatedAt(date('Y-m-d H:i:s'));

    $data = json_decode(file_get_contents("php://input"));

    $item->setName($data->name);
    $item->setContent($data->content);
    $item->setSlug($data->slug);
    $category = null;
    $categories = $data->categories;

    foreach ($categories as $value) {
        $category = (array) $value;
    }
 
    
    if($table->createPost($item, $category)){
        echo 'Employee created successfully.';
    } else{
        echo 'Employee could not be created.';
    }
?>