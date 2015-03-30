<?php
	namespace Blog\PostBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;	
    use Doctrine\Common\Collections\ArrayCollection;
    use Blog\UserBundle\Entity;

	/**
	* @ORM\Entity
	* @ORM\Table(name="tbl_comments")
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
		*@ORM\Column(type="string")
		**/
		protected $comment;

		/**
        *@ORM\Column(type="datetime", name="date_time")
        **/ 
        protected $dateTime;

		/**
		*@ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
		*@ORM\JoinColumn(nullable=true, onDelete="SET NULL")
		**/
		protected $post;

		/**
		*@ORM\ManyToOne(targetEntity="\Blog\UserBundle\Entity\User", inversedBy="comments")
		*@ORM\JoinColumn(nullable=true, onDelete="SET NULL")
		**/
		protected $user;

		public function getId()
		{
			return $this->id;
		}

		public function setComment($comment)
		{
			$this->comment = $comment;
		}

		public function getComment()
		{
			return $this->comment;
		}

		public function setDateTime($date)
        {
           $this->dateTime = $date;
        }

        public function getDateTime()
        {
            return $this->dateTime;
        }

		public function setUser($user)
        {
            $user->addComment($this);
            $this->user = $user;
        }

        public function getUser()
        {
            return $this->user;
        }

        public function setPost($post)
        {
            $post->addPostComments($this);
            $this->post = $post;
        }

        public function getPost()
        {
            return $this->post;
        }		

	}

?>