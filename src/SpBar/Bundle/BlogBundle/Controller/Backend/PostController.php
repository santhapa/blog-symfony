<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class PostController extends Controller
{
	public function indexAction()
	{
		$postManager = $this->get('spbar.blog_post_manager');

		//new form for post
		$post = $postManager->createPost();
        $form = $this->createForm('spbar_blog_post_new', $post);
        
        //get list of available posts
		$posts = $postManager->getPosts();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addItem("Post");

		return $this->render("SpBarBlogBundle::Backend/Post/index.html.twig", array(
			'page_title' => 'Blog Posts',
            'form' => $form->createView(),
			'posts' => $posts,
			'staticStatus'=> $postManager::$postStatus,
		));
	}

	public function listAction()
	{
		$postManager = $this->get('spbar.blog_post_manager');

		$posts = $postManager->getPosts();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Post", "sp_blog_post_index");
		$breadcrumbs->addItem('List');

		return $this->render("SpBarBlogBundle::Backend/Post/list.html.twig", array(
			'page_title' => 'List of Posts',
			'posts' => $posts,
			'staticStatus'=> $postManager::$postStatus,
		));
	}

	public function newAction(Request $request)
	{
		$postManager = $this->get('spbar.blog_post_manager');
        $post = $postManager->createPost();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $post->setAuthor($user);

        $form = $this->createForm('spbar_blog_post_new', $post);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$postManager->updatePost($post);
    		
    		// creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($post);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $securityIdentity = UserSecurityIdentity::fromAccount($post->getAuthor());

            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OPERATOR);
            $aclProvider->updateAcl($acl);

            $roleIdentity = new RoleSecurityIdentity('ROLE_BLOG_ADMIN');
            $acl->insertObjectAce($roleIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

    		$this->addFlash('success', "Post '{$post->getTitle()}' successfully added.");
		    return $this->redirectToRoute('sp_blog_post_index');
		}


		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Post", "sp_blog_post_index");
		$breadcrumbs->addItem('New');

		return $this->render("SpBarBlogBundle::Backend/Post/new.html.twig", array(
            'form' => $form->createView(), 
            'page_title' =>"New Post",
        ));
	}

	public function editAction(Request $request, $slug)
	{
		$postManager = $this->get('spbar.blog_post_manager');
        $post = $postManager->getPostBySlug($slug);
        if(!$post)
        {
        	$this->addFlash('error', "Post not found.");
		    return $this->redirectToRoute('sp_blog_post_index');
        }

        $authorizationChecker = $this->get('security.authorization_checker');
        // check for edit access
        if (!$authorizationChecker->isGranted("EDIT", $post)) {
            $this->addFlash('error', "Access Denied!");
            return $this->redirectToRoute('sp_blog_post_index');
        }

        $form = $this->createForm('spbar_blog_post_edit', $post);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$postManager->updatePost($post);

    		$this->addFlash('success', "Post '{$post->getTitle()}' successfully updated.");

		    return $this->redirectToRoute('sp_blog_post_index');
		}

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Post", "sp_blog_post_index");
		$breadcrumbs->addItem('Edit');

		return $this->render("SpBarBlogBundle::Backend/Post/edit.html.twig", array(
			'page_title'=>'Edit Blog Post', 
			'form' => $form->createView(),
			'slug' => $slug,
		));
	}

	public function trashAction($slug)
	{
		$postManager = $this->get('spbar.blog_post_manager');
        $post = $postManager->getPostBySlug($slug);
        if(!$post)
        {
        	$this->addFlash('error', "Post not found.");
		    return $this->redirectToRoute('sp_blog_post_index');
        }

        $authorizationChecker = $this->get('security.authorization_checker');
        // check for edit access
        if (!$authorizationChecker->isGranted("UNDELETE", $post)) {
            $this->addFlash('error', "Access Denied!");
            return $this->redirectToRoute('sp_blog_post_index');
        }

        $post->setStatus($postManager::POST_STATUS_TRASH);
        $postManager->updatePost($post);
        $this->addFlash('success', "Post '{$post->getTitle()}' has been moved to trash.");

		return $this->redirectToRoute('sp_blog_post_index');
	}

	public function deleteAction($slug)
	{
		$postManager = $this->get('spbar.blog_post_manager');
        $post = $postManager->getPostBySlug($slug);
        if(!$post)
        {
        	$this->addFlash('error', "Post not found.");
		    return $this->redirectToRoute('sp_blog_post_index');
        }

        $authorizationChecker = $this->get('security.authorization_checker');
        // check for edit access
        if (!$authorizationChecker->isGranted("DELETE", $post)) {
            $this->addFlash('error', "Access Denied!");
            return $this->redirectToRoute('sp_blog_post_index');
        }

        $title = $post->getTitle();
        $postManager->removePost($post);
        $this->addFlash('success', "Post '{$title}' has been deleted.");

		return $this->redirectToRoute('sp_blog_post_index');
	}

	public function moderateAction(Request $request, $slug)
	{
		$postManager = $this->get('spbar.blog_post_manager');
		$post = $postManager->getPostBySlug($slug);
		if(!$post)
        {
        	$this->addFlash('error', "Post not found.");
		    return $this->redirectToRoute('sp_blog_post_index');
        }

        $authorizationChecker = $this->get('security.authorization_checker');
        // check for edit access
        if (!$authorizationChecker->isGranted("OPERATOR", $post)) {
            $this->addFlash('error', "Access Denied!");
            return $this->redirectToRoute('sp_blog_post_index');
        }

        $commentManager = $this->get('spbar.blog_comment_manager');
        $comment = $commentManager->createComment();

        $form = $this->createForm('spbar_blog_comment', $comment);

		return $this->render("SpBarBlogBundle::Backend/Post/moderate.html.twig", array(
			'page_title'=>'Moderate Comment',
			'post' => $post,
			'form' => $form->createView(),
			'parentId' => null,
		));
	}

}