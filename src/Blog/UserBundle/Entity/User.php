<?php 
    namespace Blog\UserBundle\Entity;

    use FOS\UserBundle\Model\User as BaseUser;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;

    use Doctrine\Common\Collections\ArrayCollection;
    use Blog\PostBundle\Entity;

    /**
    * @ORM\Entity
    * @ORM\Table(name="tbl_fos_users")
    */
    class User extends BaseUser
    {
        /**
        * @ORM\Column(type="integer")
        * @ORM\Id
        * @ORM\GeneratedValue(strategy="AUTO")
        */
        protected $id;

        /**
        * @ORM\Column(type="string", nullable=true)
        *
        * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
        * @Assert\Length(
        *     min=3,
        *     max="255",
        *     minMessage="The name is too short.",
        *     maxMessage="The name is too long.",
        *     groups={"Registration", "Profile"}
        * )
        */
        protected $name;

         /**
        * @ORM\ManyToMany(targetEntity="Blog\UserBundle\Entity\Group")
        * @ORM\JoinTable(name="tbl_user_group",
        *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
        *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
        * )
        */
        protected $groups;

        /** @ORM\OneToMany(targetEntity="\Blog\PostBundle\Entity\Post", mappedBy="author")
        **/
        protected $post_author = null;

        /**
        *@ORM\OneToMany(targetEntity="\Blog\PostBundle\Entity\Comment", mappedBy="user")
        */
        protected $comments;


        public function __construct()
        {
            parent::__construct();

            $this->post_author = new ArrayCollection();
            $this->comments = new ArrayCollection();

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

        public function addPostAuthor($post)
        {
            $this->post_author[] = $post;
        }

        public function addComment($comment)
        {
            $this->comments[] = $comment;
        }

        public function setGroups($groups)
        {
                $this->addGroup($groups);
        }
}
