<?php

namespace SpBar\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Entity
* @ORM\Table(name="spbar_users")
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
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="created_at", type="datetime")
    */
    protected $createdAt;

    //personal informations

    /**
    * @Assert\NotBlank(groups={"Profile"})
    * @ORM\Column(name="firstname", type="string", length=100, nullable=true)
    */
    protected $firstname;

    /**
    * @Assert\NotBlank(groups={"Profile"})
    * @ORM\Column(name="lastname", type="string", length=100, nullable=true)
    */
    protected $lastname;

    /**
    * @Assert\NotBlank(groups={"Profile"})
    * @ORM\Column(name="date_of_birth", type="datetime", nullable=true)
    */
    protected $dateOfBirth;

    /**
    * @Assert\NotBlank(groups={"Profile"})
    * @Assert\Choice(choices={"Male", "Female"}, message="Invalid selection of gender.")
    * @ORM\Column(name="gender", type="string", nullable=true)
    */
    protected $gender;

    /**
    * Assert\Regex(pattern="/^([+]([0-9])*([\\(][0-9]+[\\)])*?)*$/", message="The number typed is invaild.", groups={"Profile"})
    * @ORM\Column(name="phone_number", type="string", nullable=true)
    */
    protected $phoneNumber;

    /**
    * Assert\Regex(pattern="/^([+][0-9]+)*$/", message="The number typed is invaild.", groups={"Profile"})
    * @ORM\Column(name="mobile_number", type="string", nullable=true)
    */
    protected $mobileNumber;

    /**
    * @Assert\NotBlank(groups={"Profile"})
    * @ORM\Column(name="address", type="string", length=255, nullable=true)
    */
    protected $address;

    /**
    * @ORM\Column(name="biography", type="text", length=255, nullable=true)
    */
    protected $biography;

    /**
    * @ORM\Column(name="website", type="string", length=100, nullable=true)
    */
    protected $website;

    //social informations
    /**
    * @ORM\Column(name="facebook_id", type="string",length=100, nullable=true)
    */
    protected $facebookId;

    /**
    * @ORM\Column(name="gplus_id", type="string",length=100, nullable=true)
    */
    protected $gplusId;

    /**
    * @ORM\Column(name="twitter_id", type="string",length=100, nullable=true)
    */
    protected $twitterId;

    /**
    * @ORM\ManyToMany(targetEntity="SpBar\Bundle\UserBundle\Entity\Group")
    * @ORM\JoinTable(name="spbar_user_group",
    *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
    * )
    */
    protected $groups;

    /*******************************files to be changed*******************************************/
        /** 
        *ORM\OneToMany(targetEntity="\Blog\PostBundle\Entity\Post", mappedBy="author")
        */
        // protected $post_author = null;

        /**
        *ORM\OneToMany(targetEntity="\Blog\PostBundle\Entity\Comment", mappedBy="user")
        */
        // protected $comments;

        public function __construct()
        {
            parent::__construct();
            // $this->post_author = new ArrayCollection();
            // $this->comments = new ArrayCollection();
        }
    /*******************************files to be changed*******************************************/

    public function getId()
    {
        return $this->id;
    }

    public function setCreatedAt($datetime)
    {
        $this->createdAt = $datetime;    
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setFirstname($fname)
    {
        $this->fname = ucfirst($fname);
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = ucfirst($lastname);
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getName()
    {
        return $this->firstname." ".$this->lastname;
    }

    public function setDateOfBirth($dob)
    {
        $this->dateOfBirth= $dob;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setPhoneNumber($pnum)
    {
        $this->phoneNumber = $pnum;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setMobileNumber($mnum)
    {
        $this->mobileNumber = $mnum;
    }

    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    public function setAddress($addr)
    {
        $this->address = $addr;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setBiography($bio)
    {
        $this->biography = $bio;
    }

    public function getBiography()
    {
        return $this->biography;
    }
    
    public function setWebsite($webs)
    {
        $this->website = $webs;
    }

    public function getWebsite()
    {
        return $this->website;
    }
    
    public function setFacebookId($fid)
    {
        $this->facebookId = $fid;
    }

    public function getFacebookId()
    {
        return $this->facebookId;
    }
    
    public function setGplusId($gid)
    {
        $this->gplusId = $gid;
    }

    public function getGplusId()
    {
        return $this->gplusId;
    }
    
    public function setTwitterId($tid)
    {
        $this->twitterId = $tid;        
    }

    public function getTwitterId()
    {
        return $this->twitterId;
    }

    public function setGroups($groups)
    {
            $this->addGroup($groups);
    }

    /*******************************files to be changed*******************************************/
        // public function addPostAuthor($post)
        // {
        //     $this->post_author[] = $post;
        // }

        // public function addComment($comment)
        // {
        //     $this->comments[] = $comment;
        // }
    /*******************************files to be changed*******************************************/
}

