<?php

namespace App\Table;

use App\Model\Post;
use App\PaginatedQuery;


final class PostTable extends Table{
    protected $table ='post';
    protected $class = Post::class;

    public function createPost(Post $post, array $categories): void{
        $this->pdo->beginTransaction();
        $id = $this->create([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $post->setID($id);
        

        $this->pdo->exec("DELETE FROM post_category WHERE post_id = {$post->getID()}");
        $query = $this->pdo->prepare("INSERT INTO post_category SET post_id =? , category_id =?");
        foreach ($categories as $category) {
            $query->execute([
                $post->getID(),
                $category
            ]);
        }
        $this->pdo->commit();
    }

    public function updatePost(Post $post, array $categories): void{
        /*
            begin transaction pour eviter a ce que la deuxieme requete s'execute au cas le premier a 
            a echouer
        */
        $this->pdo->beginTransaction();
        $this->update([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ], $post->getID());

        $this->pdo->exec("DELETE FROM post_category WHERE post_id = {$post->getID()}");
        $query = $this->pdo->prepare("INSERT INTO post_category SET post_id =? , category_id =?");
        foreach ($categories as $category) {
            $query->execute([
                $post->getID(),
                $category
            ]);
        }
        $this->pdo->commit();

    }

    public function findPaginated(){
        $paginatedQuery = new PaginatedQuery(
            "SELECT *FROM {$this->table} ORDER BY created_at DESC ",
            "SELECT COUNT(id) FROM post",
            $this->pdo
        );
        $posts = $paginatedQuery->getItems(Post::class);

        //ici on hydrate les categories
        /** @var Post[] */ 
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);

        return [$posts, $paginatedQuery];
        
    }

    public function findPaginatedForCategory(int $categoryID){   
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.*
                FROM {$this->table} p
                JOIN post_category pc ON pc.post_id = p.id
                WHERE pc.category_id = {$categoryID}
                ORDER BY created_at DESC 
            ",
            "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryID}"
        );
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);

        return [$posts, $paginatedQuery];
    }

}