<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicController extends Controller
{
	public function indexAction(Request $request)
	{
		$postManager = $this->get('spbar.blog_post_manager');
		$dbPosts = $postManager->getPosts();

		$paginator  = $this->get('knp_paginator');
	    $posts = $paginator->paginate(
	        $dbPosts,
	        $request->query->get('page', 1)/*page number*/,
	        $this->get('spbar.blog_config_manager')->get('post_per_page')/*limit per page*/
	    );

		return $this->render("SpBarBlogBundle::Frontend/Public/index.html.twig", array(
			'posts'=>$posts,
		));
	}

	public function singlePostAction(Request $request, $slug)
	{
		$postManager = $this->get('spbar.blog_post_manager');
		$post = $postManager->getPostBySlug($slug);

		return $this->render("SpBarBlogBundle::Frontend/Public/single_post.html.twig", array(
			'post'=>$post,
		));
	}
}