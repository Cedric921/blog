<?php

use App\HTML\Form;
use App\Validator;
use App\Connection;
use App\Table\PostTable;
use App\Validators\PostValidator;

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;

$errors = [];

if(!empty($_POST)){

    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getID());
    App\Data::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);

    if ($v->validate()) {
        # code...
        $postTable->updatePost($post);
        $success = true;
    } else{
        $errors = $v->errors() ;
    }
    //$post->content($_POST['content']);
}

$form = new Form($post, $errors);

?>

<?php if($success) :?>
    <div class="alert alert-success">L'article a ete bien modifie</div>
<?php endif?>
<?php if(!empty($errors)) :?>
    <div class="alert alert-danger">L'article n'a pas ete modifie</div>
<?php endif?>
<div class="container">
    <h2>Editer l'article <?= $post->getName() ?></h2>
    
    <form action="" method="post">

        <?= $form->input('name', 'titre') ?>
        <?= $form->input('slug', 'url') ?>
        <?= $form->textarea('content', 'contenu') ?>
        <?= $form->input('created_at', 'Date de publication') ?>

        
        <button class="btn btn-primary">Modifier</button>
    </form>
</div>