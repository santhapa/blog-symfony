<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\Template;

class TemplateManager
{
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createTemplate()
	{
		return new Template();
	}

	public function updateTemplate(Template $template, $flush=true)
	{
		$this->em->persist($template);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeTemplate(Template $template)
	{
		$this->em->remove($template);
		$this->em->flush();

		return;
	}

	public function getTemplates()
	{
		return $this->em->getRepository("SpBarBlogBundle:Template")->findAll();
	}

	public function getTemplatesByType($type)
	{
		return $this->em->getRepository("SpBarBlogBundle:Template")->findBy(array('type' => $type));

	}

	public function getTemplateBySlug($slug)
	{
		return $this->em->getRepository("SpBarBlogBundle:Template")->findOneBy(array('slug'=>$slug));
	}

	public function getTemplateById($id)
	{
		return $this->em->getRepository("SpBarBlogBundle:Template")->find($id);
	}
}