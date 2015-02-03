<?php

namespace Blog\PostBundle\Controller;

use Blog\PostBundle\Entity\Post;
use Blog\PostBundle\Entity\Comment;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\Tools\Pagination\Paginator;

class PostController extends Controller
{

	public function indexAction()
	{
		$data['list'] = null;

		$posts = $this->getDoctrine() 
						->getManager()
						->getRepository('BlogPostBundle:Post')
						->getActivePosts();

		if($posts)
		{
			$data['list'] = true;
			$data['posts'] = $posts;
		}

		$data['title'] = "Blog Posts";

		return $this->render('BlogPostBundle::post/index_post.html.twig', $data);
	}

	
	public function dashboardPostAction($curPage=1)
	{
		$data['list'] = null;

		$rpp = 5;
		$posts = $this->getDoctrine()
						->getManager()
						->getRepository('BlogPostBundle:Post')
						//->findAll();
						->getAllPosts($rpp, $curPage);

		$posts = new Paginator($posts, $fetchJoinCollection = true);
		$totalPage = ceil(count($posts)/$rpp);

		if($curPage>$totalPage)
			throw $this->createNotFoundException("No posts found");
			

			
		//config variables for paginator class
		$config['base_url'] = $this->generateUrl('postDashPage');
		$config['total_count'] = count($posts);
		$config['rpp'] = $rpp;
		//$pagination = $this->getPagination($curPage, $baseUrl, $totalPage);

		$paginator = new \Common\Utility\Paginator($config);
		$pages = $paginator->getPages($curPage);

		if($posts)
		{
			$data['list'] = true;
			$data['posts'] = $posts;
		}

		$data['pages'] = $pages;
		$data['title'] = "All Posts - Admin Area";

		return $this->render('BlogPostBundle::post/dashboard_post.html.twig', $data);
	}

	public function authorPostAction($slug)
	{
		$data['list'] = null;

		$posts = $this->getDoctrine()
						->getManager()
						->getRepository('BlogPostBundle:Post')
						->getAuthorActivePosts($slug);

		if($posts)
		{
			$data['list'] = true;
			$data['posts'] = $posts;
		}

		$data['title'] = "Author Posts";

		return $this->render('BlogPostBundle::post/author_post.html.twig', $data);

	}

	public function singlePostAction($slug)
	{
		$entityManager = $this->getDoctrine()-> getManager();

		$post = $entityManager->getRepository('BlogPostBundle:Post')
								->getPostById($slug);
		
		$comments = $post->getComments();
		
		if (!$post) 
        {
            throw $this->createNotFoundException('No post found for id '.$slug);
        }

        

        $data['post'] =$post;
        $data['comments'] = $comments;
		$data['title'] = $post->getTitle();

		return $this->render('BlogPostBundle::post/single_post.html.twig', $data);
	}

	public function createPostAction()
	{

		$errors = null;

		if(isset($_POST['createPost']))
		{
			$post = new Post();

			$post->setTitle($_POST['title']);
			$post->setContent($_POST['content']);
			$post->setDateTime(new \DateTime("now"));
			$post->setActive($_POST['active']);

			//using validator for validation defining rules in validation.yml
			//$validator = $this->get('validator');
			//$errors = $validator->validate($post);
			//var_dump($errors); 

			if(!$errors)
			{
				echo "hello";
				$entityManager = $this->getDoctrine() ->getManager();

				$author = $entityManager->find("BlogUserBundle:User", $this->getUser()->getId());
				$post->setAuthor($author);

				$entityManager->persist($post);
				$entityManager->flush();

				return $this->redirect($this->generateUrl('postPage'));
			}			
		}
		
		$data['errors'] = $errors;
		$data['title'] = "New Post";
		
		return $this->render('BlogPostBundle::post/create_post.html.twig', $data);
	}

	public function editPostAction($slug)
	{
		$entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository('BlogPostBundle:Post')
                    ->find($slug);

        if (!$post) 
        {
            throw $this->createNotFoundException('No user found for id '.$slug);
        }

        if(isset($_POST['updatePost']))
        {
        	$post->setTitle($_POST['title']);
        	$post->setContent($_POST['content']);
        	$post->setActive($_POST['active']);

    		$entityManager->flush();
        	return $this->redirect($this->generateUrl('postDashPage'));
        }

        $data['post'] = $post;
		$data['title'] = "Edit Post";

		return $this->render('BlogPostBundle::post/edit_post.html.twig', $data);
	}

	public function deletePostAction($slug)
	{
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository('BlogPostBundle:Post')
                    ->find($slug);

        if (!$post) 
        {
            throw $this->createNotFoundException('No user found for id '.$slug);
        }

        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('postDashPage'));
	}
}
