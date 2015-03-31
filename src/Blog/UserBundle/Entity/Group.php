<?php

namespace Blog\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_fos_group")
 */
class Group extends BaseGroup
{
    /**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
 	*/
    protected $id;

    /**
    * @ORM\Column(type="string")
    */
    protected $slug;
    
    public function setSlug($slug)
    {
    	$this->slug = $slug;
    }

    public function getSlug()
    {
    	return $this->slug;
    }
}
