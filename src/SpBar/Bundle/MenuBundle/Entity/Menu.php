<?php
namespace SpBar\Bundle\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
/**
* @ORM\Entity
* @ORM\Table(name="spbar_menu")
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
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent")
     **/
    private $child;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="child")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     **/
    private $parent;

    /**
    * @ORM\Column(type="integer", nullable=true)
    */
    protected $depth;
    
    /**
    * @Assert\NotBlank(message="Url cannot be empty")
    * @ORM\Column(name="menu_type", type="string")
    */
    protected $menuType;

    public function __construct() {
        $this->child = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = ucfirst($name);
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

    public function setParent(Menu $p)
    {
        $this->parent = $p;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setChild($id)
    {
        $this->child = $id;
    }

    public function getChild()
    {
        return $this->child;
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