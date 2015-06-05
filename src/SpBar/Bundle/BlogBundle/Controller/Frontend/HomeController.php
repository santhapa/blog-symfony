<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
* This class is mostly for posts for public view
*/ 
class HomeController extends Controller
{
	public function indexAction(Request $request)
	{
		$posts = $this->getPosts($request);

	    $breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Home", "sp_blog_front_home_index");
	    // $breadcrumbs->addRouteItem("Blog", "sp_blog_front_home_index");

		return $this->render("SpBarBlogBundle::Frontend/index.html.twig", array(
			'posts'=>$posts,
			'page_title'=> 'Blog',
		));
	}

	

	public function singleAction(Request $request, $slug)
	{
		$postManager = $this->get('spbar.blog_post_manager');
		$post = $postManager->getPostBySlug($slug);

		$commentManager = $this->get('spbar.blog_comment_manager');
        $comment = $commentManager->createComment();
		$form = $this->createForm('spbar_blog_comment', $comment);

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Home", "sp_blog_front_home_index");
	    $breadcrumbs->addRouteItem("Blog", "sp_blog_front_home_index");

		return $this->render("SpBarBlogBundle::Frontend/single.html.twig", array(
			'post'=>$post,
			'form' => $form->createView(),
			'page_title'=> $post->getTitle(),
		));
	}

	public function authorAction(Request $request, $author)
	{
		$user = $this->get('fos_user.user_manager')->findUserByUsername($author);
		if (!$user) {
			throw $this->createNotFoundException();
		}
		$authorName = trim($user->getName()) ? $user->getName() : $user->getUsername();

		$posts = $this->getPosts($request, array('author'=>$user));

	    $breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Home", "sp_blog_front_home_index");
	    $breadcrumbs->addItem("Author");

		return $this->render("SpBarBlogBundle::Frontend/index.html.twig", array(
			'posts'=>$posts,
			'page_title'=> $authorName,
		));
	}

	public function getPosts($request, $array= null)
	{
		$postManager = $this->get('spbar.blog_post_manager');
		if(!$array)
			$dbPosts = $postManager->getPosts();
		if($array && array_key_exists('author', $array))
		{
			$dbPosts = $postManager->getPostsByAuthor($array['author']);
		}
		

		$paginator  = $this->get('knp_paginator');
	    $posts = $paginator->paginate(
	        $dbPosts,
	        $request->query->get('page', 1)/*page number*/,
	        $this->get('spbar.blog_config_manager')->get('post_per_page')/*limit per page*/
	    );

	    return $posts;
	}

	// public function authorPostAction(Request $request, $user)
	// {	
	// 	$user = $this->get('fos_user.user_manager')->findUserByUsername($user);
	// 	if (!$user) {
	// 		throw $this->createNotFoundException();
	// 	}
	// 	$author = trim($user->getName()) ? $user->getName() : $user->getUsername();

	// 	$postManager = $this->get('spbar.blog_post_manager');
	// 	$dbPosts = $postManager->getPostsByAuthor($user);

	// 	$paginator  = $this->get('knp_paginator');
	//     $posts = $paginator->paginate(
	//         $dbPosts,
	//         $request->query->get('page', 1)/*page number*/,
	//         $this->get('spbar.blog_config_manager')->get('post_per_page')/*limit per page*/
	//     );

	// 	$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	//     $breadcrumbs->addRouteItem("Home", "sp_blog_front_home_index");
	//     $breadcrumbs->addRouteItem("Blog", "sp_blog_front_home_index");

	// 	return $this->render("SpBarBlogBundle::Frontend/Post/index.html.twig", array(
	// 		'posts'=>$posts,
	// 		'page_title'=> "Posts By: {$author}",
	// 	));
	// }
}