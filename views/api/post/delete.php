<?php
    use App\Table\PostTable;
    use App\Model\Post;
    use  App\Connection;



    $pdo = Connection::getPDO();

    $table = new PostTable($pdo);
    $id = isset($params['id']) ? $params['id'] : die();
    
    $item = new Post();
    $item = $table->find($id);
    
    //$data = json_decode(file_get_contents("php://input"));
    
    //$item->id = $data->id;
    
    $table->delete($id);
    echo "delete with succes";
?>