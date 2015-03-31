<?php

namespace Blog\PostBundle\Controller;

use Blog\PostBundle\Entity\Comment;
use Blog\PostBundle\Entity\Post;
use Blog\UserBundle\Entity\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class CommentController extends Controller
{

	public function createCommentAction()
	{

		if(isset($_POST['addComment']))
		{
			$comment = new Comment();

			$comment->setComment($_POST['commentText']);
			$comment->setDateTime(new \DateTime("now"));

			$entityManager = $this->getDoctrine()->getManager();

			$postId = $entityManager->find("BlogPostBundle:Post", $_POST['postId']);
			$comment->setPost($postId);

			if($this->get("security.authorization_checker")->isGranted('IS_AUTHENTICATED_FULLY'))
			{
				$user = $this->get('security.token_storage')->getToken()->getUser();
				$comment->setUser($user);
			}

			$entityManager->persist($comment);
			$entityManager->flush();

			if($this->get("security.authorization_checker")->isGranted('IS_AUTHENTICATED_FULLY'))
			{
				// creating the ACL
	            $aclProvider = $this->get('security.acl.provider');
	            $objectIdentity = ObjectIdentity::fromDomainObject($comment);
	            $acl = $aclProvider->createAcl($objectIdentity);

	            // retrieving the security identity of the currently logged-in user
	            $user = $this->get('security.token_storage')->getToken()->getUser();
	            $securityIdentity = UserSecurityIdentity::fromAccount($user);

	            //grant every access
	            $builder = new MaskBuilder();
				$builder
				    ->add('view')
				    ->add('edit')
				    ->add('delete')
				    ->add('undelete');
				$mask = $builder->get();
	            $acl->insertObjectAce($securityIdentity, $mask);
	            $aclProvider->updateAcl($acl);

	            $roleIdentity = new RoleSecurityIdentity('ROLE_ADMIN');
	            //grant every access
	            $builder = new MaskBuilder();
				$builder
				    ->add('view')
				    ->add('edit')
				    ->add('delete')
				    ->add('undelete');
				$mask = $builder->get();
	            $acl->insertObjectAce($roleIdentity, $mask);
	            $aclProvider->updateAcl($acl);
	        }

			return $this->redirect($this->generateUrl('singlePostPage',  array('slug' => $_POST['postId'])));
		}
	}

	public function deleteCommentAction($slug)
	{
        $entityManager = $this->getDoctrine() -> getManager();
        $comment = $entityManager->getRepository('BlogPostBundle:Comment')
        				->find($slug);


        $authorizationChecker = $this->get('security.authorization_checker');

        // check for delete access
        if (!$authorizationChecker->isGranted("DELETE", $comment) || !$authorizationChecker->isGranted("ROLE_ADMIN")) {
            throw new \Exception("Not allowed!");
        }

        $postId = $comment->getPost() ->getId();

        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('singlePostPage', array('slug' => $postId )));
	}

}

?>