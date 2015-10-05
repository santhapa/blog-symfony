<?php

namespace SpBar\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
* Enables selection of template files for blog
* @ORM\Table(name="spbar_blog_template")
* @ORM\Entity
* @UniqueEntity("slug")
*/
class Template
{
    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=255)
    */
    protected $name;

    /**
    * @ORM\Column(name="template_file", type="text")
    */
    protected $templateFile;

    /**
    * @ORM\Column(name="type", type="text")
    */
    protected $type;

    /**
    * slug of the name field for retaining
    * @Gedmo\Slug(fields={"name"}, separator="_", updatable=false)
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $slug;

  
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

    public function setTemplateFile($temp)
    {
    	$this->templateFile = $temp;
    }

    public function getTemplateFile()
    {
    	return $this->templateFile;
    }

    public function setType($tt)
    {
        $this->type = $tt;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
    	return $this->slug;
    }
}
