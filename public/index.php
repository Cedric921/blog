<?php

require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));


/**
 * ici on creer une instance pour le debugger
 */
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if (isset($_GET['page']) && $_GET['page'] === '1') {
   $uri = $_SERVER['REQUEST_URI'];
   $get = $_GET;
   unset($get['page']);
   $uri = explode('?', $uri)[0];
   $query = http_build_query($get);
   if (!empty($query)) {
        $uri = $uri . '?' . $query;
   }
   header('Location: '. $uri);
   http_response_code(301);
   exit();
}

$router = new App\Router(dirname(__DIR__) . '/views');

$router
   ->get('/', 'post/index', 'home')
   ->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
   ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
   ->match('/login', 'auth/login', 'login')
   ->post('/logout' , 'auth/logout', 'logout')
   //ADMIN
   //gestion des articles
   ->get('/admin', 'admin/post/index', 'admin_posts')
   ->match('/admin/post/[i:id]', 'admin/post/edit' , 'admin_post')
   ->post('/admin/post/[i:id]/delete', 'admin/post/delete' , 'admin_post_delete')
   ->match('/admin/post/new', 'admin/post/new' , 'admin_post_new')
   //gestion des categories
   ->get('/admin/categories', 'admin/category/index', 'admin_categories')
   ->match('/admin/category/[i:id]', 'admin/category/edit' , 'admin_category')
   ->post('/admin/category/[i:id]/delete', 'admin/category/delete' , 'admin_category_delete')
   ->match('/admin/category/new', 'admin/category/new' , 'admin_category_new')
   //api routes
   ->match('/api/post/read_all', 'api/post/read', 'api_readAll_post')
   ->match('/api/post/read_one/[i:id]', 'api/post/single_read', 'api_readOne_post')
   ->match('/api/post/create', 'api/post/create', 'api_create_post')
   ->post('/api/post/update/[i:id]', 'api/post/update', 'api_update_post')
   ->post('/api/post/delet/[i:id]', 'api/post/delete', 'api_delete_post')
   ->run();
