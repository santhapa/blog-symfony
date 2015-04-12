<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\Comment;

class CommentManager
{
	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createComment()
	{
		return new Comment();
	}

	public function updateComment(Comment $comment, $flush=true)
	{
		$this->em->persist($comment);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removeComment(Comment $comment)
	{
		$this->em->remove($comment);
		$this->em->flush();

		return;
	}

	public function getComments()
	{
		return $this->em->getRepository("SpBarBlogBundle:Comment")->findAll();
	}

	public function getCommentsByType($type)
	{
		return $this->em->getRepository("SpBarBlogBundle:Comment")->findBy(array('type' => $type));

	}

	public function getCommentBySlug($slug)
	{
		return $this->em->getRepository("SpBarBlogBundle:Comment")->findOneBy(array('slug'=>$slug));
	}
}
