<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;

use SpBar\Bundle\BlogBundle\Entity\Post;
use SpBar\Bundle\UserBundle\Entity\User;

class PostManager
{	
	const POST_STATUS_PUBLISH = 1;
	const POST_STATUS_DRAFT = 2;
    const POST_STATUS_TRASH = 3;

	public static $newPostStatus = array(
		self::POST_STATUS_DRAFT => 'Save to Draft',
		self::POST_STATUS_PUBLISH	=> 'Publish'
	);

	public static $postStatus = array(
		self::POST_STATUS_DRAFT => 'Draft',
		self::POST_STATUS_PUBLISH => 'Published',
		self::POST_STATUS_TRASH => 'Trash'
	);

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
		return $this->em->getRepository("SpBarBlogBundle:Post")->findBy(array(), array('createdAt'=>'desc', 'status'=>'asc'));
	}

	public function getPostBySlug($slug)
	{
		return $this->em->getRepository("SpBarBlogBundle:Post")->findOneBy(array('slug'=>$slug));
	}

	public function getPostsByAuthor(User $user)
	{
		return $this->em->getRepository("SpBarBlogBundle:Post")->findBy(array('author'=>$user), array('createdAt'=>'desc'));
	}
}