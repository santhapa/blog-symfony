<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\PostMeta;

class PostMetaManager
{
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createPostMeta()
	{
		return new PostMeta();
	}

	public function updatePostMeta(PostMeta $postMeta, $flush=true)
	{
		$this->em->persist($postMeta);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removePostMeta(PostMeta $postMeta)
	{
		$this->em->remove($postMeta);
		$this->em->flush();

		return;
	}

	public function getPostMetaById($id)
	{
		return $this->em->getRepository("SpBarBlogBundle:PostMeta")->findOneBy(array('id'=>$id));
	}

	public function getPostMetaBySource($src)
	{
		return $this->em->getRepository("SpBarBlogBundle:PostMeta")->findOneBy(array('source'=>$src));
	}
}