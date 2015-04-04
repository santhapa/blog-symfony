<?php 

namespace SpBar\Bundle\BlogBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Entity
* @ORM\Table(name="spbar_blog_users")
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
    * @Assert\NotBlank(groups={"Profile"})
    * Assert\Regex(pattern="/^([+]([0-9])*([\\(][0-9]+[\\)])*?)*$/", message="The number typed is invaild.", groups={"Profile"})
    * @ORM\Column(name="phone_number", type="string", nullable=true)
    */
    protected $phoneNumber;

    /**
    * @Assert\NotBlank(groups={"Profile"})
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
    * @Assert\NotBlank(groups={"Profile"})
    * @ORM\Column(name="biography", type="text", length=255, nullable=true)
    */
    protected $biography;

    /**
    * @Assert\NotBlank(groups={"Profile"})
    * @ORM\Column(name="website", type="string", length=100, nullable=true)
    */
    protected $website;

    //social informations
    /**
    * @Assert\NotBlank(groups={"Profile"})
    * @ORM\Column(name="facebook_id", type="string",length=100, nullable=true)
    */
    protected $facebookId;

    /**
    * @Assert\NotBlank(groups={"Profile"})
    * @ORM\Column(name="gplus_id", type="string",length=100, nullable=true)
    */
    protected $gplusId;

    /**
    * @Assert\NotBlank(groups={"Profile"})
    * @ORM\Column(name="twitter_id", type="string",length=100, nullable=true)
    */
    protected $twitterId;

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
}
