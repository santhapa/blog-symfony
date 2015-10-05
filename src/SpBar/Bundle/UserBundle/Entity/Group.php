<?php

namespace SpBar\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
* @ORM\Entity
* @ORM\Table(name="spbar_groups")
* @UniqueEntity("slug")
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
    * @Gedmo\Slug(fields={"name"}, separator="_", updatable=false)
    * @ORM\Column(type="string", length=255, unique=true)
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
