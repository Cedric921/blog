<?php

use App\HTML\Form;
use App\Validator;
use App\Connection;
use App\Model\Category;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

$errors = [];
$item = new Category();


if(!empty($_POST)){
    
    
    $pdo = Connection::getPDO();
    $table = new CategoryTable($pdo);

    Validator::lang('fr');
    $v = new CategoryValidator($_POST, $table, $item->getID());

    App\Data::hydrate($item, $_POST, ['name', 'slug']);

    if ($v->validate()) {
        # code...
        $table->create([
            'name' => $item->getName(),
            'slug' => $item->getSlug()
        ]);
        header('Location: ' . $router->url('admin_categories'));
        exit();
    } else{
        $errors = $v->errors() ;
    }
    //$post->content($_POST['content']);
}

$form = new Form($item, $errors);

?>

<?php if(!empty($errors)) :?>
    <div class="alert alert-danger">La categorie n'a pas ete enregistree</div>
<?php endif?>
<div class="container">
    <h2>Creation d'une nouvelle categorie</h2>
    <?php require('_form.php') ?>
</div>