<?php

namespace Blog\PostBundle\Controller;

use Blog\PostBundle\Entity\Comment;
use Blog\PostBundle\Entity\Post;
use Blog\UserBundle\Entity\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

			$user = $this->get('security.context')->getToken()->getUser();

			if($user)
			{
				$userId = $entityManager->find("BlogUserBundle:User", $user->getId());
				$comment->setUser($userId);
			}
				

			
			$entityManager->persist($comment);
			$entityManager->flush();

			return $this->redirect($this->generateUrl('singlePostPage',  array('slug' => $_POST['postId'])));
		}
	}

	public function deleteCommentAction($slug)
	{
        $entityManager = $this->getDoctrine() -> getManager();
        $comment = $entityManager->getRepository('BlogPostBundle:Comment')
        				->find($slug);

        $postId = $comment->getPost() ->getId();

        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('singlePostPage', array('slug' => $postId )));
	}

}

?>