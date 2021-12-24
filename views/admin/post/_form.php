<form action="" method="POST">
    <?= $form->input('name', 'titre') ?>
    <?= $form->input('slug', 'url') ?>
    <?= $form->textarea('content', 'contenu') ?>
    <?= $form->input('created_at', 'Date de publication') ?>
    <button class="btn btn-primary">
        <?php if($item->getID() !== null) : ?>
            Modifier
        <?php else : ?>
            Creer
        <?php endif ?>
    </button>
</form>