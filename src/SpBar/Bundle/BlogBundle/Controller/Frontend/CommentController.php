<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/*
* This class is mostly for commenting on post for public
*/ 
class CommentController extends Controller
{
	public function newAction(Request $request)
	{
        if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
        	$this->addFlash('error', "Please login first to comment!");
        	return $this->redirectToRoute('sp_user_frontend_login');
        }

		$post = $this->get('spbar.blog_post_manager')->getPostBySlug($request->query->get('post'));
		if(!$post)
		{
			throw $this->createNotFoundException('Post not found');
		}

		$user = $this->get('security.token_storage')->getToken()->getUser();

		$parentId = null;
        if($request->query->get('parent'))
        {
        	$parentId = $request->query->get('parent');
        }
        
    	if ($request->isMethod('POST')) 
    	{
    		$commentManager = $this->get("spbar.blog_comment_manager");
    		$comment = $commentManager->createComment();

    		if($parentId)
	        {
	        	$comment->setParent($commentManager->getCommentById($parentId));
	        }

	        //Set post Id and user id
	        $comment->setPost($post);
	        $comment->setUser($user);
	        $comment->setContent($request->request->get('content'));

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
		return $this->render("SpBarBlogBundle::Frontend/Comment/new.html.twig", array(
            'postSlug' => $post->getSlug(),
            'parentId' => $parentId,
        ));
	}

	public function editAction(Request $request)
	{
		$id = $request->query->get('id');
		$commentManager = $this->get('spbar.blog_comment_manager');
        $comment = $commentManager->getCommentById($id);
        if(!$comment)
        {
		    throw $this->createNotFoundException('Comment not found');
        }

        if(!$this->get('security.authorization_checker')->isGranted('EDIT', $comment))
		{
			throw $this->createAccessDeniedException('Access Denied');
		}

    	if ($request->isMethod('POST')) 
    	{
    		$comment->setContent($request->request->get('content'));
    		$commentManager->updateComment($comment);

		    return $this->redirectToRoute('sp_blog_front_post_singlePost', array('slug'=> $comment->getPost()->getSlug()));
		}
		return $this->render("SpBarBlogBundle::Frontend/Comment/edit.html.twig", array(
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
        	throw $this->createNotFoundException('Comment not found');
        }

        if(!$this->get('security.authorization_checker')->isGranted('DELETE', $comment))
		{
			throw $this->createAccessDeniedException('Access Denied');
		}
		
        $postSlug = $comment->getPost()->getSlug();
        $commentManager->removeComment($comment);

		return $this->redirectToRoute('sp_blog_front_post_singlePost', array('slug'=> $postSlug));
	}
}