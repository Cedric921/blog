<?php
    
    use App\Connection;
    use App\Model\Post;
    use App\Table\PostTable;

    $pdo = Connection::getPDO();

    $table = new PostTable($pdo);
    $item = new Post();

    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->setName($data->name);
    $item->setContent($data->content);
    $item->setSlug($data->slug);
    $item->setCreatedAt(($data->created)->date_format('Y-m-d H:i:s'));
    $category = null;
    $categories = $data->categories;

    foreach ($categories as $value) {
        $category = (array) $value;
    }
    
    if($table->updatePost($item, $category)){
        echo json_encode("Employee data updated.");
    } else{
        echo json_encode("Data could not be updated");
    }
?>