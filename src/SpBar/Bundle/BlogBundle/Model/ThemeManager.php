<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\Theme;

class ThemeManager
{
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createTheme()
	{
		return new Theme();
	}

	public function updateTheme(Theme $theme, $flush=true)
	{
		$this->em->persist($theme);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeTheme(Theme $theme)
	{
		$this->em->remove($theme);
		$this->em->flush();

		return;
	}

	public function getThemes()
	{
		return $this->em->getRepository("SpBarBlogBundle:Theme")->findAll();
	}

	public function getThemesByType($type)
	{
		return $this->em->getRepository("SpBarBlogBundle:Theme")->findBy(array('type' => $type));

	}

	public function getThemeBySlug($slug)
	{
		return $this->em->getRepository("SpBarBlogBundle:Theme")->findOneBy(array('slug'=>$slug));
	}
}