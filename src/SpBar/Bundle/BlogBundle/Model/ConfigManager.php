<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\Config;

class ConfigManager
{
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function get($slug)
	{
		$config = $this->em->getRepository("SpBarBlogBundle:Config")->findOneBy(array('slug' => $slug));

		return $config->getContent();
	}

	public function createConfig()
	{
		return new Config();
	}

	public function updateConfig(Config $config, $flush=true)
	{
		$this->em->persist($config);
		if($flush)
		{
			$this->em->flush();
		}

		return;
	}

	public function getConfigs()
	{
		return $this->em->getRepository("SpBarBlogBundle:Config")->findAll();
	}

	public function getConfigBySlug($slug)
	{
		return $this->em->getRepository("SpBarBlogBundle:Config")->findOneBy(array('slug'=>$slug));
	}
}