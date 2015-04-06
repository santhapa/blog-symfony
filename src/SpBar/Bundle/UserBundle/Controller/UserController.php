<?php

namespace SpBar\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        //create new user
        $formFactory = $this->get('fos_user.registration.form.factory');
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $form = $formFactory->createForm();
        $form->setData($user);

        //list of users
        $em = $this->getDoctrine()->getManager();
        $activeUser = $em->getRepository('SpBarUserBundle:User')->findBy(array('enabled'=> true), array('username'=>'asc'));
        $inactiveUser = $em->getRepository('SpBarUserBundle:User')->findBy(array('enabled'=> false), array('username'=>'asc'));

        $breadcrumbs = $this->container->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
        $breadcrumbs->addItem("User");

        return $this->render('SpBarUserBundle:User:index.html.twig', array(
            'page_title'=>"SpBar User",
            'activeUsers'=> $activeUser,
            'inactiveUsers'=> $inactiveUser,
            'form' => $form->createView(),
        ));
    }

    public function listAction()
    {   
        // $userManager = $this->get('fos_user.user_manager');
        // $users = $userManager->findUsers();
        $em = $this->getDoctrine()->getManager();
        $activeUser = $em->getRepository('SpBarUserBundle:User')->findBy(array('enabled'=> true), array('username'=>'asc'));
        $inactiveUser = $em->getRepository('SpBarUserBundle:User')->findBy(array('enabled'=> false), array('username'=>'asc'));

        $breadcrumbs = $this->container->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
        $breadcrumbs->addRouteItem("User", "sp_user_index");
        $breadcrumbs->addItem("List");

        return $this->render('SpBarUserBundle:User:list.html.twig', array(
            'page_title'=>"List of User",
            'activeUsers'=> $activeUser,
            'inactiveUsers'=> $inactiveUser,
        ));
    }

    public function enableAction($user)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($user);

        if(!$user)
        {
            $this->addFlash('error', "User not found.");
            return $this->redirectToRoute('sp_user_index');
        }

        if($user->isEnabled())
        {
            $this->addFlash('info', "User {$user->getUsername()} account is already enabled.");
            return $this->redirectToRoute('sp_user_index');
        }

        //enable the user account
        $user->setEnabled(true);
        $userManager->updateUser($user);

        $this->addFlash('success', "User '{$user->getUsername()}' account has been enabled.");
        return $this->redirectToRoute('sp_user_index');
    }

    public function disableAction($user)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($user);

        if(!$user)
        {
            $this->addFlash('error', "User not found.");
            return $this->redirectToRoute('sp_user_index');
        }

        if(!$user->isEnabled())
        {
            $this->addFlash('info', "User {$user->getUsername()} account is already disabled.");
            return $this->redirectToRoute('sp_user_index');
        }

        //enable the user account
        $user->setEnabled(false);
        $userManager->updateUser($user);

        $this->addFlash('success', "User '{$user->getUsername()}' account has been disabled.");
        return $this->redirectToRoute('sp_user_index');
    }

    public function editAction(Request $request, $user)
	{
		$userManager = $this->get('fos_user.user_manager');
		$userObj = $userManager->findUserByUsername($user);

		if(!$userObj)
		{
			$this->addFlash('error', "User not found.");
            return $this->redirectToRoute('sp_user_index');
		}

        $form = $this->createForm('spbar_user_edit', $userObj);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($userObj);

            $this->addFlash('success', "User '{$userObj->getUsername()}' has been successfully updated.");
            return $this->redirectToRoute('sp_user_index');
        }

        $breadcrumbs = $this->container->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
        $breadcrumbs->addRouteItem("User", "sp_user_index");
        $breadcrumbs->addItem("Edit");

        return $this->render('SpBarUserBundle:User:edit.html.twig', array(
            'form' => $form->createView(),
            'page_title'=>"Edit User",
            'user'=> $userObj,
        ));
	}

	public function deleteAction($user)
	{
     	$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserByUsername($user);

        if(!$user)
        {
            $this->addFlash('error', "User not found.");
            return $this->redirectToRoute('sp_user_index');
        }

        $username = $user->getUsername();
        $userManager->deleteUser($user);

        $this->addFlash('success', "User {$username} has been deleted.");
        return $this->redirectToRoute('sp_user_index');
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
