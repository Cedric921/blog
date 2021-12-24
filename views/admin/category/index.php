<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;


Auth::check();


$title = " Gestions des categories des articles ";
$pdo = Connection::getPDO();

/**
 * @var Post
 */
$items = (new CategoryTable($pdo))->all();

$link = $router->url('admin_categories');
?>

<?php if (isset($_GET['delete'])): ?>
    <div class="alert alert-success">L'enregistrement a ete bien supprime</div>
<?php endif ?>

<table class="table table-hover">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>URL</th>
        <th>
            <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary btn-sm">Nouveau</a>
        </th>
    </thead>
    <tbody>
        <?php foreach($items as $item): ?>
        <tr>
            <td>#<?= $item->getId() ?></td>
            <td>
                <a href="<?= $router->url('admin_category', ['id' => $item->getId()])?>"><?= e($item->getName()) ?></a>
            </td>
            <td><?= $item->getSlug() ?></td>
            <td>
                <a class="btn btn-primary btn-sm" href="<?= $router->url('admin_category', ['id' => $item->getId()])?>">Editer</a>
                <form method="post" action="<?= $router->url('admin_category_delete', ['id' => $item->getId()])?>" style="display:inline;" >
                    <button type="submit" onsubmit="return confirm('Voulez-vous nvraiment effectuer cette action')" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
