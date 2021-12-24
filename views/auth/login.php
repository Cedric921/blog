<?php

use App\HTML\Form;
use App\Connection;
use App\Model\User;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;


$user = new User();
$errors = [];

if(!empty($_POST)){
    $user->setUsername($_POST['username']);
    $errors['password'] = 'identifiant ou mot de passe incorrect';

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        
        
        $table = new  UserTable(Connection::getPDO());
        try{
            $u = $table->findByUsername($_POST['username']);
            if($u){

                if(password_verify($_POST['password'], $u->getPassword()) === true ){
                    
                    session_start();
                    $_SESSION['auth'] = $u->getID();
    
                    header('Location: ' . $router->url('admin_posts'));
                    exit();
                }
            }
            else{
                
            }
            
        } catch(NotFoundException $e){
           
        }
    }
}

$form = new Form($user,$errors);
?>
<h1>Se connecter</h1>

<?php if(isset($_GET['forbidden'])): ?>
<div class="alert alert-danger">
    Vous ne pouvez pas acceder a cette page
</div>
<?php endif ?>

<form action="<?= $router->url('login') ?>" method="post">
    <?= $form->input('username', 'nom d\'utilisateur' )?>
    <?= $form->input('password', 'mot de passe' )?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
