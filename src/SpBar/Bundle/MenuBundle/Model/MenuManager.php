<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\Menu;

class MenuManager
{
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createMenu()
	{
		return new Menu();
	}

	public function updateMenu(Menu $menu, $flush=true)
	{
		$this->em->persist($menu);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeMenu(Menu $menu)
	{
		$this->em->remove($menu);
		$this->em->flush();

		return;
	}

	public function getMenuById($id)
	{
		return $this->em->getRepository("SpBarBlogBundle:Menu")->findOneBy(array('id'=>$id));
	}

	public function getMenu()
	{
		return $this->em->getRepository("SpBarBlogBundle:Menu")->findBy(array(), array('order'=>'asc'));
	}
}