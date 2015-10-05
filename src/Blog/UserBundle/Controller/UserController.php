<?php

namespace Blog\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $data['list'] = null;

        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        if($users)
        {
            $data['users'] = $users;
            $data['list'] = true;
        }

        $data['title'] = "Dashboard: User";

        return $this->render('BlogUserBundle:User:index.html.twig', $data);
    }

    public function editUserAction(Request $request)
	{
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserByUsername($_GET['slug']);

		if(!$user)
		{
			throw $this->createNotFoundException("No user found!");
		}

        if (isset($_POST['updateRole'])) 
        {	
        	foreach ($user->getRoles() as $role) {
        		$user->removeRole($role);
        	}

        	$user->addRole($_POST['roles']);

            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('userIndexPage'));
        }
		
        $data['title'] = "Edit User";
        $data['user'] = $user;

        return $this->render('BlogUserBundle:User:edit_user.html.twig', $data);
	}

	public function deleteUserAction($slug)
	{

     	$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserByUsername($slug);

        if (!$user) 
        {
            throw $this->createNotFoundException('No user found.');
        }

        $deleteId = $user->getId();

        $userManager->deleteUser($user);

        if($this->getUser()->getId() == $deleteId)
        {
            return $this->redirect($this->generateUrl('logout'));
        }

        return $this->redirect($this->generateUrl('userIndexPage'));
	}

    public function assignToGroupAction($user)
    {        
        $userManager = $this->get('fos_user.user_manager');
        $userObj = $userManager->findUserByUsername($user);

        $groups = $this->get('fos_user.group_manager')->findGroups();

        if (isset($_POST['assignGroup'])) {
            $groups = $_POST['groups'];

            foreach ($userObj->getGroups() as $oldGroup) {
                $userObj->removeGroup($oldGroup);
            }

            foreach ($groups as $gid) {
                $group = $this->getDoctrine()->getManager()->getRepository('BlogUserBundle:Group')->find($gid);
                $userObj->addGroup($group);
            }
            $userManager->updateUser($userObj);

            return $this->redirectToRoute('userIndexPage');
        }

        return $this->render('BlogUserBundle:User:user_group_assign.html.twig', array(
            'user' => $userObj,
            'groups' => $groups,
        ));
    }
}
