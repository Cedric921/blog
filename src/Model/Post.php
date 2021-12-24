<?php 

namespace App\Model;
use App\Helpers\Text;
use DateTime;

class Post{
    private $id;
    private $name;
    private $content;
    private $slug;
    private $created_at;

    private $categories = [];

    public function __construct(){

    }

    public function getID(): ?int{
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name; 
    }
    public function getExcerpt(): ?string {
        if($this->content === null){
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 60))); 
    }

    public function getFormattedContent(): ?string{
        return nl2br(e($this->content)); 
    } 
    public function getCreatedAt(): DateTime {
        return new DateTime($this->created_at); 
    }

    public function getSlug(): ?string {
        return $this->slug;
    }

    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }

    /**
     * @return Category[]
     */ 
    public function getCategories() : array
    {
        return $this->categories;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }
    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }


    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt(string $date)
    {
        $this->created_at = $date;

        return $this;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */ 
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}

?>