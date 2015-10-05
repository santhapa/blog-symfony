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

	public function getConfigs($default=false)
	{
		return $this->em->getRepository("SpBarBlogBundle:Config")->findBy(array('default'=> $default));
	}

	public function getConfigBySlug($slug)
	{
		return $this->em->getRepository("SpBarBlogBundle:Config")->findOneBy(array('slug'=>$slug));
	}

	public function updateDefaults($defaults)
	{
		foreach ($defaults as $key => $value) {
			$config = $this->getConfigBySlug($key);
			$config->setContent($value);
			$this->updateConfig($config, FALSE);
		}
		$this->em->flush();
		return true;
	}

	public function removeConfig(Config $config)
	{
		$this->em->remove($config);
		$this->em->flush();

		return;
	}
}