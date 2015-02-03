<?php

namespace Blog\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
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

        $data['title'] = "Admin Dashboard";

        return $this->render('BlogUserBundle:Admin:index.html.twig', $data);
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

            return $this->redirect($this->generateUrl('adminIndexPage'));
        }
		
        $data['title'] = "Edit User";
        $data['user'] = $user;

        return $this->render('BlogUserBundle:Admin:edit_user.html.twig', $data);
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

        return $this->redirect($this->generateUrl('adminIndexPage'));
	}

}