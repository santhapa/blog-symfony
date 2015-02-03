<?php

namespace Blog\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Blog\ReportBundle\Entity\ReportRepository")
 * @ORM\Table(name="tbl_reports")
 */
class Report{
	
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique = true)
     */
    private $slug;
    
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $description;
    
    /**
     * @ORM\Column(type="text", name="sql_query")
     */
    private $sqlQuery;


	public function id()
	{
	    return $this->id;
	}

	public function getDescription()
	{
	    return $this->description;
	}

	public function setDescription($description)
	{
	    $this->description = $description;
	}
	
	public function getName()
	{
	    return $this->name;
	}

	public function setName($name)
	{
	    $this->name = $name;
	}

	public function getSqlQuery()
	{
	    return $this->sqlQuery;
	}

	public function setSqlQuery($sqlquery)
	{
	    $this->sqlQuery = $sqlquery;
	}
	
	public function getSlug(){
		return $this->slug;
	}

	public function setSlug($slug)
	{
		$this->slug = $slug;
	}

}