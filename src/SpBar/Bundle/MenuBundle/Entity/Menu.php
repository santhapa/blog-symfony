<?php
namespace SpBar\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
/**
* @ORM\Entity
* @ORM\Table(name="spbar_blog_menu")
*/
class Menu
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
    * @Assert\NotBlank(message="Name cannot be empty")
	* @ORM\Column(type="string")
	*/
    protected $name;

    /**
    * @Assert\NotBlank(message="Url cannot be empty")
    * @ORM\Column(type="string")
    */
    protected $url;

    /**
	* @ORM\Column(type="integer", nullable=true)
	*/
    protected $order;

    /**
    * @ORM\Column(name="parent_id", type="integer", nullable=true)
    */
    protected $parentId;

    /**
    * @ORM\Column(type="integer", nullable=true)
    */
    protected $depth;
    
    /**
    * @Assert\NotBlank(message="Url cannot be empty")
    * @ORM\Column(name="menu_type", type="string")
    */
    protected $menuType;

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

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($o)
    {
        $this->order = $o;
    }

    public function setParentId($pid)
    {
        $this->parentId = $pid;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setDepth($d)
    {
        $this->depth = $d;
    }

    public function getDepth()
    {
        return $this->depth;
    }

    public function setMenuType($mt)
    {
        $this->menuType = $mt;
    }

    public function getMenuType()
    {
        return $this->menuType;
    }
}
