<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\Category;

class CategoryManager
{
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createCategory()
	{
		return new Category();
	}

	public function updateCategory(Category $category, $flush=true)
	{
		$this->em->persist($category);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeCategory(Category $category)
	{
		$this->em->remove($category);
		$this->em->flush();

		return;
	}

	public function getCategorys()
	{
		return $this->em->getRepository("SpBarBlogBundle:Category")->findAll();
	}

	public function getCategoryBySlug($slug)
	{
		return $this->em->getRepository("SpBarBlogBundle:Category")->findOneBy(array('slug'=>$slug));
	}
}