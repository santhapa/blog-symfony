<?php
namespace SpBar\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use SpBar\Bundle\BlogBundle\Entity\Category;
use SpBar\Bundle\BlogBundle\Entity\PostMeta;
use SpBar\Bundle\BlogBundle\Entity\Tag;

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
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="created_at", type="datetime")
    */
    protected $createdAt;

    /**
    * @ORM\ManyToOne(targetEntity="Template")
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

    // *
    // * @ORM\Column(type="string", length=255, name="featured_image")
    
    // protected $featuredImage;

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
    * @ORM\ManyToMany(targetEntity="Category", inversedBy="posts")
    * @ORM\JoinTable(name="spbar_post_category")
    **/
    protected $category;

    /**
    * @ORM\ManyToMany(targetEntity="PostMeta", inversedBy="post")
    * @ORM\JoinTable(name="spbar_posts_meta")
    **/
    protected $meta;

    protected $metas;

    /**
    * @ORM\ManyToMany(targetEntity="Tag", inversedBy="post")
    * @ORM\JoinTable(name="spbar_posts_tag")
    **/
    protected $tag;

    protected $tags;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->meta = new ArrayCollection();
        $this->tag = new ArrayCollection();
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

    public function setMetas($metas)
    {
        if(!$metas)
            return;

        foreach ($this->meta as $meta) {
            $this->removeMeta($meta);
        }
        
        foreach ($metas as $meta) {
            $this->addMeta($meta);
        }
    }

    public function getMetas()
    {
        return $this->meta ?: $this->meta = new ArrayCollection();
    }

    public function addMeta(PostMeta $meta)
    {
        if(!$this->getMetas()->contains($meta))
        {
            $meta->addPost($this);
            $this->meta[] = $meta;
        }
        return $this;        
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function removeMeta(PostMeta $meta)
    {
        if ($this->getMetas()->contains($meta)) {
            $this->getMetas()->removeElement($meta);
        }
        return $this;
    }

    public function setTags($tags)
    {
        if(!$tags)
            return;

        foreach ($this->tag as $tag) {
            $this->removeTag($tag);
        }
        
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    public function getTags()
    {
        return $this->tag ?: $this->tag = new ArrayCollection();
        // return $this->tags;
    }

    public function addTag(Tag $tag)
    {
        if(!$this->getTags()->contains($tag))
        {
            $tag->addPost($this);
            $this->tag[] = $tag;
        }
        return $this;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function removeTag(Tag $tag)
    {
        if ($this->getTags()->contains($tag)) {
            $this->getTags()->removeElement($tag);
        }
        return $this;
    }

    // public function getFeaturedImage()
    // {
    //     return $this->featuredImage;
    // }
    // public function setFeaturedImage($path)
    // {
    //     $this->featuredImage = $path;
    // }
}
