<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Mon site')?></title>
 
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="d-flex flex-column h-100">


    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <a class="navbar-brand" href="#">
            <span class="text-danger">Mon site</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= $router->url('admin_posts')?>"><i class="fa fa-home mr-1"></i>Articles <span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= $router->url('admin_categories')?>"><i class="fa fa-home mr-1"></i>Categories <span class="sr-only"></span></a>
                </li>

                <li class="nav-item">
                    <form action="<?= $router->url('logout') ?>" method="post" style="display:inline">
                        <button type="submit" class="nav-link text-danger" style="background:transparent; border:none">Se deconnecter</button>
                    </form>
                </li>
                
            </ul>
            
        </div>
    </nav>



    <div class="container mt-5">
        <?= $content ?>
    </div>
    <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
            <?php if(defined('DEBUG_TIME')) : ?>
            <p>Page genere en  <?= round((microtime(true) - DEBUG_TIME) * 1000)?> ms</p>
            <?php endif ?>
        </div>
    </footer>
    
</body>
</html>