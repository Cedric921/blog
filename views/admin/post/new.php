<?php

use App\HTML\Form;
use App\Validator;
use App\Connection;
use App\Model\Post;
use App\Table\PostTable;
use App\Validators\PostValidator;

$errors = [];
$item = new Post();

if(!empty($_POST)){

    
    $pdo = Connection::getPDO();
    $table = new PostTable($pdo);

    Validator::lang('fr');
    $v = new PostValidator($_POST, $table, $item->getID());

    App\Data::hydrate($item, $_POST, ['name', 'slug','content', 'created_at']);

    if ($v->validate()) {
        # code...
        $table->create([
            'name' => $item->getName(),
            'slug' => $item->getSlug(),
            'content' => $item->getContent(),
            'created_at' => $item->getCreatedAt()
        ]);
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