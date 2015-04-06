<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\Post;

class PostManager
{
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createPost()
	{
		return new Post();
	}

	public function updatePost(Post $post, $flush=true)
	{
		$this->em->persist($post);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removePost(Post $post)
	{
		$this->em->remove($post);
		$this->em->flush();

		return;
	}

	public function getPosts()
	{
		return $this->em->getRepository("SpBarBlogBundle:Post")->findAll();
	}

	public function getPostBySlug($slug)
	{
		return $this->em->getRepository("SpBarBlogBundle:Post")->findOneBy(array('slug'=>$slug));
	}
}