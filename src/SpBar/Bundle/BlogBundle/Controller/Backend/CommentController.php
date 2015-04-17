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
        	return $this->redirectToRoute('sp_blog_front_post_singlePost', array('slug'=> $post->getSlug()));
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

		    return $this->redirectToRoute('sp_blog_front_post_singlePost', array('slug'=> $post->getSlug()));
		}

		return $this->render("SpBarBlogBundle::Backend/Comment/new.html.twig", array(
            'form' => $form->createView(),
            'parentPost' => $post->getSlug(),
        ));
	}

	public function editAction(Request $request)
	{
		$id = $request->query->get('id');
		$commentManager = $this->get('spbar.blog_comment_manager');
        $comment = $commentManager->getCommentById($id);
        if(!$comment)
        {
        	$this->addFlash('error', "Comment not found.");
		    return $this->redirectToRoute('sp_blog_post_index');
        }

        if(!$this->get('security.authorization_checker')->isGranted('OPERATOR', $comment->getPost()))
		{
			$this->addFlash('error', "Access Denied!");
			return $this->redirectToRoute('sp_blog_post_index');
		}

        $form = $this->createForm('spbar_blog_comment', $comment);
        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$commentManager->updateComment($comment);

    		$user = trim($comment->getUser()->getName()) ? $comment->getUser()->getName() : $comment->getUser()->getUsername();
    		$this->addFlash('success', "Comment 'by {$user}' has been updated.");
		    return $this->redirectToRoute('sp_blog_post_moderate', array('slug'=> $comment->getPost()->getSlug()));
		}

		return $this->render("SpBarBlogBundle::Backend/Comment/edit.html.twig", array(
			'page_title'=>'Edit Comment', 
			'form' => $form->createView(),
			'comment' => $comment,
		));
	}

	public function deleteAction(Request $request)
	{
		$commentManager = $this->get('spbar.blog_comment_manager');
		$id = $request->query->get('id');
        $comment = $commentManager->getCommentById($id);

        if(!$comment)
        {
        	$this->addFlash('error', "Comment not found.");
		    return $this->redirectToRoute('sp_blog_post_index');
        }

        if(!$this->get('security.authorization_checker')->isGranted('OPERATOR', $comment->getPost()))
		{
			$this->addFlash('error', "Access Denied!");
			return $this->redirectToRoute('sp_blog_post_index');
		}
		
        $postSlug = $comment->getPost()->getSlug();
        $user = trim($comment->getUser()->getName()) ? : $comment->getUser()->getUsername();
        $commentManager->removeComment($comment);
        $this->addFlash('success', "Comment 'by {$user}' has been deleted.");

		return $this->redirectToRoute('sp_blog_post_moderate', array('slug'=> $postSlug));
	}

	/*
	* Section for post moderate section for admin or author to create new comments
	*/
	public function replyAction(Request $request)
	{
		$post = $this->get('spbar.blog_post_manager')->getPostBySlug($request->query->get('post'));
		if(!$post)
		{
			$this->addFlash('error', "Post not found.");
		    return $this->redirectToRoute('sp_blog_post_index');
		}
		if(!$this->get('security.authorization_checker')->isGranted('OPERATOR', $post))
		{
			$this->addFlash('error', "Access Denied!");
			return $this->redirectToRoute('sp_blog_post_index');
		}

        //get instance of currently logged in user
        $user = $this->get('security.token_storage')->getToken()->getUser();

		$commentManager = $this->get('spbar.blog_comment_manager');
        $comment = $commentManager->createComment();

        $parentId = null;
        if($request->query->get('parentId'))
        {
        	$parentId = $request->query->get('parentId');
        }

        $form = $this->createForm('spbar_blog_comment', $comment);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
	        //Set post Id and user id
	        $comment->setPost($post);
	        $comment->setUser($user);
	        if($parentId)
	        {
	        	$comment->setParent($commentManager->getCommentById($parentId));
	        }
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
            'parentId' => $parentId,
        ));
	}

}