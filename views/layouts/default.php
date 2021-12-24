<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Mon site')?></title>
 
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.min.css">
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navabr-expand-lg navbar-dark bg-dark fixed-top mb-5">
        <a href="#" class="navbar-brand">Mon site</a>
    </nav>
    <div class="container mt-5 pt-4">
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