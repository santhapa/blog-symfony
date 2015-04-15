<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class CommentController extends Controller
{
	// public function indexAction()
	// {
	// 	$commentManager = $this->get('spbar.blog_comment_manager');

	// 	//new form for comment
	// 	$comment = $commentManager->createComment();
 //        $form = $this->createForm('spbar_blog_comment_new', $comment);
        
 //        //get list of available comments
	// 	$comments = $commentManager->getComments();

	// 	$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	//     $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	//     $breadcrumbs->addItem("Blog");
	//     $breadcrumbs->addItem("Comment");

	// 	return $this->render("SpBarBlogBundle::Backend/Comment/index.html.twig", array(
	// 		'page_title' => 'Blog Comments',
 //            'form' => $form->createView(),
	// 		'comments' => $comments,
	// 		'commentStatus'=> $commentManager::$commentStatus,
	// 	));
	// }

	// public function listAction()
	// {
	// 	$commentManager = $this->get('spbar.blog_comment_manager');

	// 	$comments = $commentManager->getComments();

	// 	$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	//     $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	//     $breadcrumbs->addItem("Blog");
	//     $breadcrumbs->addRouteItem("Comment", "sp_blog_comment_index");
	// 	$breadcrumbs->addItem('List');

	// 	return $this->render("SpBarBlogBundle::Backend/Comment/list.html.twig", array(
	// 		'page_title' => 'List of Comments',
	// 		'comments' => $comments,
	// 		'commentStatus'=> $commentManager::$commentStatus,
	// 	));
	// }

	/*
	* $post variable here is the slug value of the parent post
	*/
	public function newAction(Request $request)
	{
		$post = $this->get('spbar.blog_post_manager')->getPostBySlug($request->query->get('post'));
		if(!$post)
		{
			throw $this->createNotFoundException('Post not found');
		}

        $user = $this->get('security.token_storage')->getToken()->getUser();
        if(!$user)
        {
        	$this->addFlash('commentError', "Please login first to comment!");
        	return $this->redirectToRoute('sp_blog_public_singlePost', array('slug'=> $post->getSlug()));
        }

		$commentManager = $this->get('spbar.blog_comment_manager');
        $comment = $commentManager->createComment();

        //Set post Id and user id
        $comment->setPost($post);
        $comment->setUser($user);

        $form = $this->createForm('spbar_blog_comment', $comment);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$commentManager->updateComment($comment);
    		
    		// creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($comment);
            $acl = $aclProvider->createAcl($objectIdentity);

			//grant edit, view and delete permission
			$builder = new MaskBuilder();
			$builder
			    ->add('view')
			    ->add('edit')
			    ->add('delete');
			$mask = $builder->get();
            // assign to user commenting(currently looged in user)
            $securityIdentity = UserSecurityIdentity::fromAccount($user);
            $acl->insertObjectAce($securityIdentity, $mask);
            $aclProvider->updateAcl($acl);

            $securityIdentity = UserSecurityIdentity::fromAccount($post->getAuthor());
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OPERATOR);
            $aclProvider->updateAcl($acl);

            $roleIdentity = new RoleSecurityIdentity('ROLE_BLOG_ADMIN');
            $acl->insertObjectAce($roleIdentity, MaskBuilder::MASK_MASTER);
            $aclProvider->updateAcl($acl);

		    return $this->redirectToRoute('sp_blog_public_singlePost', array('slug'=> $post->getSlug()));
		}

		return $this->render("SpBarBlogBundle::Backend/Comment/new.html.twig", array(
            'form' => $form->createView(),
            'parentPost' => $post->getSlug(),
        ));
	}

	public function editAction(Request $request, $id)
	{
		$commentManager = $this->get('spbar.blog_comment_manager');
        $comment = $commentManager->getCommentBySlug($slug);
        if(!$comment)
        {
        	$this->addFlash('error', "Comment not found.");
		    return $this->redirectToRoute('sp_blog_comment_index');
        }

        $form = $this->createForm('spbar_blog_comment_edit', $comment);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$commentManager->updateComment($comment);

    		$this->addFlash('success', "Comment '{$comment->getTitle()}' successfully updated.");

		    return $this->redirectToRoute('sp_blog_comment_index');
		}

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Comment", "sp_blog_comment_index");
		$breadcrumbs->addItem('Edit');

		return $this->render("SpBarBlogBundle::Backend/Comment/edit.html.twig", array(
			'page_title'=>'Edit Blog Comment', 
			'form' => $form->createView(),
			'slug' => $slug,
		));
	}

	public function deleteAction(Request $request)
	{
		$commentManager = $this->get('spbar.blog_comment_manager');
		$id = $request->query->get('id');
        $comment = $commentManager->getCommentById($id);
        $postSlug = $comment->getPost()->getSlug();
        if(!$comment)
        {
        	$this->addFlash('error', "Comment not found.");
		    return $this->redirectToRoute('sp_blog_post_index');
        }
        $user = trim($comment->getUser()->getName()) ? : $comment->getUser()->getUsername();
        $commentManager->removeComment($comment);
        $this->addFlash('success', "Comment 'by {$user}' has been deleted.");

		return $this->redirectToRoute('sp_blog_post_moderate', array('slug'=> $postSlug));
	}

	/*
	* Section for post moderate section for admin or author to reply on comments
	*/
	public function replyAction(Request $request)
	{
		$post = $this->get('spbar.blog_post_manager')->getPostBySlug($request->query->get('post'));
		if(!$post)
		{
			throw $this->createNotFoundException('Post not found');
		}

		$authorizationChecker = $this->get('security.authorization_checker');
        // check for delete access
        if (!$authorizationChecker->isGranted("EDIT", $post)) {
            $this->addFlash('error', "You are not allowed to access that post!");
            return $this->redirectToRoute('sp_blog_post_index');
        }

        //get instance of currently logged in user
        $user = $this->get('security.token_storage')->getToken()->getUser();

		$commentManager = $this->get('spbar.blog_comment_manager');
        $comment = $commentManager->createComment();

        $form = $this->createForm('spbar_blog_comment', $comment);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
	        //Set post Id and user id
	        $comment->setPost($post);
	        $comment->setUser($user);
    		$commentManager->updateComment($comment);
    		
    		// creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($comment);
            $acl = $aclProvider->createAcl($objectIdentity);

			//grant edit, view and delete permission
			$builder = new MaskBuilder();
			$builder
			    ->add('view')
			    ->add('edit')
			    ->add('delete');
			$mask = $builder->get();
            // assign to user commenting(currently looged in user)
            $securityIdentity = UserSecurityIdentity::fromAccount($user);
            $acl->insertObjectAce($securityIdentity, $mask);
            $aclProvider->updateAcl($acl);

            $securityIdentity = UserSecurityIdentity::fromAccount($post->getAuthor());
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OPERATOR);
            $aclProvider->updateAcl($acl);

            $roleIdentity = new RoleSecurityIdentity('ROLE_BLOG_ADMIN');
            $acl->insertObjectAce($roleIdentity, MaskBuilder::MASK_MASTER);
            $aclProvider->updateAcl($acl);

		    return $this->redirectToRoute('sp_blog_post_moderate', array('slug'=> $post->getSlug()));
		}

		return $this->render("SpBarBlogBundle::Backend/Comment/reply.html.twig", array(
            'form' => $form->createView(),
            'post' => $post,
        ));
	}

}