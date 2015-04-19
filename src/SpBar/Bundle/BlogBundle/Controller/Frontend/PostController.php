<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
* This class is mostly for posts for public view
*/ 
class PostController extends Controller
{
	public function indexAction(Request $request)
	{
		$postManager = $this->get('spbar.blog_post_manager');
		
		if ($request->query->get('author')) {
			$user = $this->get('fos_user.user_manager')->findUserByUsername($request->query->get('author'));
			if (!$user) {
				throw $this->createNotFoundException();
			}
			$author = trim($user->getName()) ? $user->getName() : $user->getUsername();
			$dbPosts = $postManager->getPostsByAuthor($user);
			$title = "Posts By: {$author}";
		}else
		{
			$dbPosts = $postManager->getPosts();
			$title = "Blog";
		}

		$paginator  = $this->get('knp_paginator');
	    $posts = $paginator->paginate(
	        $dbPosts,
	        $request->query->get('page', 1)/*page number*/,
	        $this->get('spbar.blog_config_manager')->get('post_per_page')/*limit per page*/
	    );

	    $breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Home", "sp_blog_front_post_index");
	    $breadcrumbs->addRouteItem("Blog", "sp_blog_front_post_index");

		return $this->render("SpBarBlogBundle::Frontend/Post/index.html.twig", array(
			'posts'=>$posts,
			'page_title'=> $title,
		));
	}

	public function singlePostAction(Request $request, $slug)
	{
		$postManager = $this->get('spbar.blog_post_manager');
		$post = $postManager->getPostBySlug($slug);

		$commentManager = $this->get('spbar.blog_comment_manager');
        $comment = $commentManager->createComment();
		$form = $this->createForm('spbar_blog_comment', $comment);

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Home", "sp_blog_front_post_index");
	    $breadcrumbs->addRouteItem("Blog", "sp_blog_front_post_index");

		return $this->render("SpBarBlogBundle::Frontend/Post/single.html.twig", array(
			'post'=>$post,
			'form' => $form->createView(),
			'page_title'=> $post->getTitle(),
		));
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
	//     $breadcrumbs->addRouteItem("Home", "sp_blog_front_post_index");
	//     $breadcrumbs->addRouteItem("Blog", "sp_blog_front_post_index");

	// 	return $this->render("SpBarBlogBundle::Frontend/Post/index.html.twig", array(
	// 		'posts'=>$posts,
	// 		'page_title'=> "Posts By: {$author}",
	// 	));
	// }
}