<?php

namespace Blog\PostBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Blog\UserBundle\Entity\User;

class PostRepository extends EntityRepository
{

	public function getAllPosts($limit=10, $curPage= 1)
	{
		return $this->getEntityManager()
					->createQuery('
						SELECT p from  BlogPostBundle:Post p
						order by p.dateTime desc')
					->setFirstResult($limit * ($curPage-1))
                    ->setMaxResults($limit);
	}

	public function getActivePosts()
	{
		return $this->getEntityManager()
					->createQuery('
						SELECT p, a from BlogPostBundle:Post p 
						join p.author a
						where p.active = :status 
						order by p.dateTime desc')
					->setParameter('status', '1')
					->getResult();
	}

	public function getAuthorActivePosts($author)
	{
		return $this->getEntityManager()
					->createQuery('
						SELECT p, a from BlogPostBundle:Post p
						join p.author a
						where p.active = :status and a.id = :author
						order by p.dateTime desc')
					->setParameter('status', '1')
					->setParameter('author', $author)
					->getResult();
	}

	public function getPostById($id)
	{
		return $this->getEntityManager()
					->createQuery('
						SELECT p, c from BlogPostBundle:Post p
						left join p.comments c
						where p.id = :id')
					->setParameter('id', $id)
					->getOneOrNullResult();
	}

}