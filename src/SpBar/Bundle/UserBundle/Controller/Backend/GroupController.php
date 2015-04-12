<?php

namespace SpBar\Bundle\UserBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\GroupController as BaseController;

use SpBar\Bundle\UserBundle\Entity\Group;


class GroupController extends BaseController
{

    public function indexAction()
    {
        $groupManager = $this->get('fos_user.group_manager');
        //for new group
        $group = $groupManager->createGroup('');
        $form = $this->createForm('spbar_user_group', $group);

        //list of groups
        $groups = $this->get('fos_user.group_manager')->findGroups();

        $breadcrumbs = $this->container->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
        $breadcrumbs->addItem("Group");

        return $this->render('SpBarUserBundle:Backend/Group:index.html.twig', array(
            'groups' => $groups,
            'page_title' => "User Groups",
            'form' => $form->createView(),
        ));
    }
    /**
     * Show all groups
     */
    public function listAction()
    {
        $groups = $this->get('fos_user.group_manager')->findGroups();

        $breadcrumbs = $this->container->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
        $breadcrumbs->addRouteItem("Group", "sp_user_group_index");
        $breadcrumbs->addItem("List");   

        return $this->render('SpBarUserBundle:Backend/Group:list.html.twig', array(
            'groups' => $groups,
            'page_title' => "List of User Groups",
        ));
    }

    /**
     * Edit one group, show the edit form
     */
    public function editAction(Request $request, $slug)
    {
        $group = $this->getDoctrine()->getManager()->getRepository('SpBarUserBundle:Group')->findOneBy(array('slug' => $slug));

       	$form = $this->createForm('spbar_user_group', $group);
		$form->setData($group);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $groupManager = $this->get('fos_user.group_manager');
            $groupManager->updateGroup($group);

            $this->addFlash('success', "Group {$group->getName()} has been successfully updated.");   
            return $this->redirectToRoute('sp_user_group_index');
        }

        $breadcrumbs = $this->container->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
        $breadcrumbs->addRouteItem("Group", "sp_user_group_index");
        $breadcrumbs->addItem("Edit");   

        return $this->render('SpBarUserBundle:Backend/Group:edit.html.twig', array(
            'form'      => $form->createview(),
            'page_title' => "Edit Group",
            'group' => $group,
        ));
    }

    /**
     * Show the new form
     */
    public function newAction(Request $request)
    {
    	$groupManager = $this->get('fos_user.group_manager');
        $group = $groupManager->createGroup('');

        $form = $this->createForm('spbar_user_group', $group);

        $form->handleRequest($request);

    	if ($form->isValid()) {
		    $groupManager->updateGroup($group);
            $this->addFlash('success', "New group {$group->getName()} has been successfully added.");   

		    return $this->redirectToRoute('sp_user_group_index');
		}

        $breadcrumbs = $this->container->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
        $breadcrumbs->addRouteItem("Group", "sp_user_group_index");
        $breadcrumbs->addItem("New");   

        return $this->render('SpBarUserBundle:Backend/Group:new.html.twig', array(
            'form' => $form->createview(),
            'page_title' => "Add User Group"
        ));
    }

    /**
     * Delete one group
     */
    public function deleteAction(Request $request, $slug)
    {
        $group = $this->getDoctrine()->getManager()->getRepository('SpBarUserBundle:Group')->findOneBy(array('slug' => $slug));

        if(!$group)
        {
            $this->addFlash('error', "Group not found.");
            return $this->redirectToRoute('sp_user_group_index');
        }
        $groupName = $group->getName();

        $this->get('fos_user.group_manager')->deleteGroup($group);
        $this->addFlash('success', "Group {$groupName} has been deleted.");

        return $this->redirectToRoute('sp_user_group_index');
    }

    public function permissionAction($slug)
    {
        $group = $this->getDoctrine()->getManager()->getRepository('SpBarUserBundle:Group')->findOneBy(array('slug' => $slug));
    	$dbRoles = $group->getRoles();

    	$em = $this->getDoctrine() ->getManager();
	    $routes = $em->getRepository('SpBarUserBundle:Route')->getRoutesArray();

    	if(isset($_POST['addPermission']))
	    {
	    	// foreach ($dbRoles as $role) {
	    	// 	$group->removeRole($role);
	    	// }

	    	// foreach ($_POST['roles'] as $newRole) {
	    	// 	$group->addRole($newRole);
	    	// }
            $group->setRoles(isset($_POST['roles'])?$_POST['roles']:array());
            $group->addRole('ROLE_'.str_replace(" ", "_", $group->getName()));

            $groupManager = $this->get('fos_user.group_manager');
            $groupManager->updateGroup($group);

    		return $this->redirectToRoute('listGroupPage');
	    }
    	
    	return $this->render('SpBarUserBundle:Backend/Group:group_permission.html.twig', array(
            'routes' => $routes,
        	'roles' =>$dbRoles,
        	'group_name' => $group->getName(),
        ));
    }
}
