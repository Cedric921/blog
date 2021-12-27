<?php

use App\Auth;
use App\HTML\Form;
use App\Validator;
use App\Connection;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\Validators\PostValidator;

Auth::check();

$pdo = Connection::getPDO();
$table = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$item = $table->find($params['id']);
$categoryTable->hydratePosts([$item]);
$success = false;

$errors = [];

if(!empty($_POST)){

    Validator::lang('fr');
    $v = new PostValidator($_POST, $table, $item->getID(),$categories);
    App\Data::hydrate($item, $_POST, ['name', 'content', 'slug', 'created_at']);

    if ($v->validate()) {
        # code...
        $table->updatePost($item, $_POST['categories_ids']);
        $categoryTable->hydratePosts([$item]);
        $success = true;
    } else{
        $errors = $v->errors() ;
    }
    //$post->content($_POST['content']);
}

$form = new Form($item, $errors);

?>

<?php if($success) :?>
    <div class="alert alert-success">L'article a ete bien modifie</div>
<?php endif?>
<?php if(!empty($errors)) :?>
    <div class="alert alert-danger">L'article n'a pas ete modifie</div>
<?php endif?>
<div class="container">
    <h2>Editer l'article <?= $item->getName() ?></h2>
    
    <?php require('_form.php') ?>
</div>