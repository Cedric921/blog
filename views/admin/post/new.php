<?php

use App\Auth;
use App\HTML\Form;
use App\Connection;
use App\Model\Post;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\Validators\PostValidator;

Auth::check();

$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();

$errors = [];
$item = new Post();
$item->setCreatedAt(date('Y-m-d H:i:s'));

if(!empty($_POST)){

    
    $pdo = Connection::getPDO();
    $table = new PostTable($pdo);


    $v = new PostValidator($_POST, $table, $item->getID(), $categories);

    App\Data::hydrate($item, $_POST, ['name', 'slug','content', 'created_at']);

    if ($v->validate()) {
        # code...
        $table->createPost($item);
        header('Location: ' . $router->url('admin_posts') .'?created=1');
        exit();
    } else{
        $errors = $v->errors() ;
    }
    //$post->content($_POST['content']);
}

$form = new Form($item, $errors);

?>

<?php if(!empty($errors)) :?>
    <div class="alert alert-danger">L'article' n'a pas ete enregistree</div>
<?php endif?>
<div class="container">
    <h2>Publication d'un article</h2>
    <?php require('_form.php') ?>
</div>