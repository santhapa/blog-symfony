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
* @ORM\HasLifecycleCallbacks
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
    * @ORM\Column(name="date_of_birth", type="date", nullable=true)
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
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    protected $image;

    /**
    * @Assert\File(maxSize="6000000",
    * mimeTypes = {"image/jpg", "image/png", "image/jpeg"},
    * mimeTypesMessage = "Please upload a valid image")
    */
    private $tempImage;

    private $temp;

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
        *@ORM\OneToMany(targetEntity="SpBar\Bundle\BlogBundle\Entity\Post", mappedBy="author")
        */
        protected $posts = null;

        /**
        *@ORM\OneToMany(targetEntity="SpBar\Bundle\BlogBundle\Entity\Comment", mappedBy="user")
        */
        protected $comments;

        public function __construct()
        {
            parent::__construct();
            $this->posts = new ArrayCollection();
            $this->comments = new ArrayCollection();
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
        $this->firstname = ucfirst($fname);
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
        public function setPosts($post)
        {
            $this->posts[] = $post;
        }

        public function setComments($comment)
        {
            $this->comments[] = $comment;
        }
    /*******************************files to be changed*******************************************/

    public function getImage()
    {
        return $this->image;
    }


    public function setTempImage($image = null)
    {
        $this->tempImage = $image;
        // check if we have an old image path
        if (isset($this->image)) {
            // store the old name to delete after the update
            $this->temp = $this->image;
            $this->image = null;
        } else {
            $this->image = 'initial';
        }
    }

    public function getTempImage()
    {
        return $this->tempImage;
    }

    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preUpload()
    {
        if (null !== $this->getTempImage()) {
            // do whatever you want to generate a unique name
            $imageName = sha1(uniqid(mt_rand(), true));
            $this->image = $imageName.'.'.$this->getTempImage()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getTempImage()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getTempImage()->move($this->getUploadRootDir(), $this->image);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->tempImage = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $image = $this->getAbsolutePath();
        if ($image) {
            unlink($image);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->image
            ? null
            : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebPath()
    {
        return null === $this->image
            ? null
            : $this->getUploadDir().'/'.$this->image;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/profile';
    }
}

