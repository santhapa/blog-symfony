<?php

	namespace Blog\UserBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use Doctrine\Common\Collections\ArrayCollection;

	/**
	* @ORM\Entity(repositoryClass="Blog\UserBundle\Entity\RouteRepository")
	* @ORM\Table(name="tbl_routes")
	*/
	class Route{

		/**
		* @ORM\Column(type="integer")
		* @ORM\Id
		* @ORM\GeneratedValue(strategy="AUTO")
		*/
		protected $id;

		/**
		* @ORM\Column(type="string", name="controller_class")
		*/
	    protected $controllerClass;

	    /**
		* @ORM\Column(type="string", name="path_name")
		*/
	    protected $pathName;

	    /**
		* @ORM\Column(type="string", name="url")
		*/
	    protected $url;

	    /**
		* @ORM\Column(type="string" , nullable=true)
		*/
	    protected $description;

	    public function getId()
	    {
	    	return $this->id;
	    }

	    public function setPathName($pathName)
	    {
	    	$this->pathName = $pathName;
	    }

	    public function getPathName()
	    {
	    	return $this->pathName;
	    }

	    public function setController($class)
	    {
	    	$this->controllerClass = $class;
	    }

	    public function getController()
	    {
	    	return $this->controllerClass;
	    }

	    public function setDescription($desc)
	    {
	    	$this->description = $desc;
	    }

	    public function getDescription()
	    {
	    	return $this->description;
	    }

	    public function setUrl($url)
	    {
	    	$this->url = $url;
	    }

	    public function getUrl()
	    {
	    	return $this->url;
	    }

	}