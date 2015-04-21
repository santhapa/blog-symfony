<?php

namespace SpBar\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use SpBar\Bundle\BlogBundle\Entity\Post;

/**
* @ORM\Table(name="spbar_blog_post_tag")
* @ORM\Entity
*/
class Tag
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
    * @ORM\ManyToMany(targetEntity="Post", mappedBy="tag", cascade={"persist"})
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

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
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
