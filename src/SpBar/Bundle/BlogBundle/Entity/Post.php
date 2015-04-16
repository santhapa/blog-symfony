<?php
namespace SpBar\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use SpBar\Bundle\BlogBundle\Entity\Category;

/**
* @ORM\Entity
* @ORM\Table(name="spbar_blog_posts")
*/
class Post
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
	* @ORM\Column(type="string")
	*/
    protected $title;

    /**
	* @ORM\Column(type="text")
	*/
    protected $content;
    
    /**
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="created_at", type="datetime")
    */
    protected $createdAt;

    /**
    * @ORM\ManyToOne(targetEntity="Theme")
    */
    protected $postType;

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
    * @ORM\Column(type="string", length=255, name="featured_image")
    */
    protected $featuredImage;

    /**
    *@ORM\ManyToOne(targetEntity="SpBar\Bundle\UserBundle\Entity\User", inversedBy="posts")
    *@ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    protected $author;

    /**
    *@ORM\OneToMany(targetEntity="Comment", mappedBy="post")
    */
    protected $comments;

    /**
    * @Assert\NotBlank(message="At least one category is required!")
    * @ORM\ManyToMany(targetEntity="Category", inversedBy="posts")
    * @ORM\JoinTable(name="spbar_post_category")
    **/
    protected $category;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->category = new ArrayCollection();
    }

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

    public function setPostType($pt)
    {
        $this->postType = $pt;
    }

    public function getPostType()
    {
        return $this->postType;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setAuthor($author)
    {
        $author->setPosts($this);
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setComments($comment)
    {
        $this->comments[] = $comment;
    }

    public function getComments()
    {
        return $this->comments;
    }        

    public function addCategory(Category $cat)
    {
        $cat->addPosts($this);
        $this->category[] = $cat;
    }

    public function getCategory()
    {
        return $this->category;
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
