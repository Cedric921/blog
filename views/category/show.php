<?php 

use App\Connection;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\Model\{Category, Post};

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($id);


if($category->getSlug() !== $slug){
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location :' .$url);
}
$title= " {$category->getName()}";

[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getId());

$link = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);

?>
<h1>Categorie <span  class="text-info "><?= e($title)?></span></h1>
<br>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require dirname(__DIR__) . '/post/card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link)?>
    <?= $paginatedQuery->nextLink($link)?>
</div>