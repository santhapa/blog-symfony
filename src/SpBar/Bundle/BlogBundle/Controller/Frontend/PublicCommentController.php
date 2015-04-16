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
class PublicCommentController extends Controller
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

    	if ($request->isMethod('POST')) 
    	{
    		$commentManager = $this->get("spbar.blog_comment_manager");
    		$comment = $commentManager->createComment();
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

		    return $this->redirectToRoute('sp_blog_publicpost_singlePost', array('slug'=> $post->getSlug()));
		}
	}

	public function editAction()
	{
		return $this->render("SpBarBlogBundle::Frontend/PublicComment/new.html.twig");
	}

	public function deleteAction()
	{
		return $this->render("SpBarBlogBundle::Frontend/PublicComment/new.html.twig");
	}
}