<?php
namespace SpBar\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
/**
* @ORM\Entity
* @ORM\Table(name="spbar_blog_page")
*/
class Page
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
    * @Assert\NotBlank(message="Title cannot be empty")
	* @ORM\Column(type="string")
	*/
    protected $title;

    /**
    * @Assert\NotBlank(message="Content cannot be empty")
	* @ORM\Column(type="text")
	*/
    protected $content;

    /**
    * @Assert\NotBlank(message="Page template must be defined")
    * @ORM\Column(type="string")
    */
    protected $template;
    
    /**
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="created_at", type="datetime")
    */
    protected $createdAt;

    /**
    * @ORM\Column(type="integer")
    **/
    protected $status;

    /**
    * slug of the name field for retaining
    * @Gedmo\Slug(fields={"title"}, separator="_", updatable=false)
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $slug;

    /**
    * @ORM\Column(name="featured_image", type="string", nullable=true)
    **/
    protected $featuredImage;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return  $this->content;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setCreatedAt($date)
    {
       $this->createdAt = $date;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }
    public function setFeaturedImage($path)
    {
        $this->featuredImage = $path;
    }
}
