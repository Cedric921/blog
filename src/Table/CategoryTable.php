<?php

namespace App\Table;

use PDO;
use Exception;
use App\Model\Category;

final class CategoryTable extends Table{
   
    protected $table ='category';
    protected $class = Category::class;


    /**
     * @param App\Model\Post[] $posts
     */
    public function hydratePosts(array $posts) : void{
        $postsById =[];
        foreach ($posts as $post) {
            $post->setCategories([]);
            $postsById[$post->getID()] = $post;
        }

        $categories = $this->pdo->query('
            SELECT c.*, pc.post_id 
            FROM post_category pc
            JOIN category c ON c.id = pc.category_id
            WHERE pc.post_id IN (' . implode(',', array_keys($postsById)) .')
        ')->fetchAll(PDO::FETCH_CLASS, $this->class);

        foreach ($categories as $category) {
            //tres  incoprehensif ici
            $postsById[$category->getPost_id()]->addCategory($category);
        }
    }

    public function list(){
        $categories = $this->all();
        $results = [];
        foreach ($categories as $category) {
            $results[$category->getID()] = $category->getName();
        }
        return $results;
    }

}