<?php

use App\Auth;
use App\HTML\Form;
use App\Validator;
use App\Connection;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

Auth::check();

$pdo = Connection::getPDO();
$table = new CategoryTable($pdo);
$item = $table->find($params['id']);
$success = false;

$fields = ['name', 'slug'];
$errors = [];

if(!empty($_POST)){

    Validator::lang('fr');
    $v = new CategoryValidator($_POST, $table, $item->getID());
    App\Data::hydrate($item, $_POST, $fields);

    if ($v->validate()) {
        # code...
        $table->update([
            'name' => $item->getName(),
            'slug' =>$item->getSlug()
        ], $item->getID());
        $success = true;
    } else{
        $errors = $v->errors() ;
    }
    //$post->content($_POST['content']);
}

$form = new Form($item, $errors);

?>

<?php if($success) :?>
    <div class="alert alert-success">La categorie a ete bien modifie</div>
<?php endif?>
<?php if(!empty($errors)) :?>
    <div class="alert alert-danger">La categorie n'a pas ete modifie</div>
<?php endif?>
<div class="container">
    <h2>Editer l'article <?= e($item->getName()) ?></h2>
    
    <?php require('_form.php') ?>
</div>