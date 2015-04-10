<?php

namespace SpBar\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use SpBar\Bundle\BlogBundle\Entity\Post;

/**
* @ORM\Table(name="spbar_blog_category")
* @ORM\Entity
* @UniqueEntity("slug")
*/
class Category
{
    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=255)
    */
    protected $name;

    /**
    * slug of the name field for retaining
    * @Gedmo\Slug(fields={"name"}, separator="_", updatable=false)
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $slug;

    /**
    * @ORM\ManyToMany(targetEntity="Post", mappedBy="category")
    **/
    protected $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }
  
    public function getId()
    {
    	return $this->id;
    }

    public function setName($name)
    {
    	$this->name = $name;
    }

    public function getName()
    {
    	return $this->name;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
    	return $this->slug;
    }

    public function addPosts(Post $post)
    {
        $this->posts[] = $post;
    }

    public function getPosts()
    {
        return $this->posts;
    }
}
