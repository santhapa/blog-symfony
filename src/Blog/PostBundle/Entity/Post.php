<?php
	namespace Blog\PostBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;
    use Blog\UserBundle\Entity;


	/**
	* @ORM\Entity(repositoryClass = "Blog\PostBundle\Entity\PostRepository")
	* @ORM\Table(name="tbl_posts")
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
		* @ORM\Column(type="string")
		*/
	    protected $content;
        
        /**
        *@ORM\Column(type="datetime", name="date_time")
        **/ 
        protected $dateTime;

	    /**
        *@ORM\ManyToOne(targetEntity="\Blog\UserBundle\Entity\User", inversedBy="post_author")
        *@ORM\JoinColumn(nullable=true, onDelete="SET NULL")
		*/
	    protected $author;

        /**
        *@ORM\Column(type="boolean")
        **/
        protected $active;

        /**
        *@ORM\OneToMany(targetEntity="Comment", mappedBy="post")
        */
        protected $comments;

        public function __construct()
        {
            $this->comments = new ArrayCollection();
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

        public function setAuthor($author)
        {
            $author->addPostAuthor($this);
            $this->author = $author;
        }

        public function getAuthor()
        {
            return $this->author;
        }

        public function setDateTime($date)
        {
           $this->dateTime = $date;
        }

        public function getDateTime()
        {
            return $this->dateTime;
        }

        public function setActive($status)
        {
            $this->active = $status;
        }

        public function getActive()
        {
            return $this->active;
        }	

        public function addPostComments($comment)
        {
            $this->comments[] = $comment;
        }

        public function getComments()
        {
            return $this->comments;
        }
        
}
