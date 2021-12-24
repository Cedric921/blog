<?php
$categories =[];

foreach($post->getCategories() as $category){
    $url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
    $categories[] = <<<HTML
       <a href="{$url}">{$category->getName()}</a> 
HTML;
}

?>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
        <p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>
        <?php if(!empty($post->getCategories())): ?>
            :: 
            <?= implode(',',$categories) ?>
        <?php endif ?>
        
        <p><?= $post->getExcerpt() ?></p>
        <p>
            <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary btn-sm">voir plus</a>
        </p>
    </div>
</div>