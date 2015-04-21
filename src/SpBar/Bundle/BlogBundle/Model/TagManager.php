<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\Tag;

class TagManager
{
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createTag()
	{
		return new Tag();
	}

	public function updateTag(Tag $tag, $flush=true)
	{
		$this->em->persist($tag);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeTag(Tag $tag)
	{
		$this->em->remove($tag);
		$this->em->flush();

		return;
	}

	public function getTagById($id)
	{
		return $this->em->getRepository("SpBarBlogBundle:Tag")->findOneBy(array('id'=>$id));
	}

	public function getTagByName($name)
	{
		return $this->em->getRepository("SpBarBlogBundle:Tag")->findOneBy(array('name'=>$name));
	}
}