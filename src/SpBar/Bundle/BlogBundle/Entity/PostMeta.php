<?php

namespace SpBar\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use SpBar\Bundle\BlogBundle\Entity\Post;

/**
* @ORM\Table(name="spbar_blog_posts_meta")
* @ORM\Entity
*/
class PostMeta
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
    protected $source;

    /**
    * @ORM\ManyToMany(targetEntity="Post", mappedBy="meta", cascade={"persist"})
    **/
    protected $post;

    public function __construct()
    {
        $this->post = new ArrayCollection();
    }
  
    public function getId()
    {
        return $this->id;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function addPost(Post $post)
    {
        $this->post[] = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
}
