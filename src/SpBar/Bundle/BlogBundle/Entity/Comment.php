<?php
namespace SpBar\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
* @ORM\Entity
* @ORM\Table(name="spbar_blog_post_comments")
*/
class Comment
{

	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
	*@ORM\Column(type="text")
	**/
	protected $content;

	/**
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="comment_at", type="datetime")
    */
    protected $commentAt;

/*====================================================================================*/
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="parent")
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $parent;
/*======================================================================================*/

	/**
	*@ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
	*@ORM\JoinColumn(nullable=true, onDelete="CASCADE")
	**/
	protected $post;

	/**
	*@ORM\ManyToOne(targetEntity="SpBar\Bundle\UserBundle\Entity\User", inversedBy="comments")
	*@ORM\JoinColumn(nullable=true, onDelete="SET NULL")
	**/
	protected $user;

	public function __construct() {
        $this->children = new ArrayCollection();
    }

	public function getId()
	{
		return $this->id;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setCommentAt($date)
    {
       $this->commentAt = $date;
    }

    public function getCommentAt()
    {
        return $this->commentAt;
    }

    public function setParent(Comment $cmt)
    {
    	$this->parent = $cmt;
    }

    public function getParent()
    {
    	return $this->parent;
    }

    public function setChildren($id)
    {
    	$this->children = $id;
    }

    public function getChildren()
    {
    	return $this->children;
    }

	public function setUser($user)
    {
        $user->setComments($this);
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setPost($post)
    {
        $post->setComments($this);
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }		

}

?>