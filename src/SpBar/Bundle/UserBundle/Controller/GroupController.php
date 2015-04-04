<?php

namespace SpBar\Bundle\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterGroupResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseGroupEvent;
use FOS\UserBundle\Event\GroupEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\UserBundle\Controller\GroupController as BaseController;

use SpBar\Bundle\UserBundle\Entity\Group;


class GroupController extends BaseController
{
    /**
     * Show all groups
     */
    public function listAction()
    {
        $groups = $this->get('fos_user.group_manager')->findGroups();

        return $this->render('BlogUserBundle:Group:list.html.twig', array(
            'groups' => $groups
        ));
    }

    /**
     * Edit one group, show the edit form
     */
    public function editAction(Request $request, $slug)
    {
        $group = $this->getDoctrine()->getManager()->getRepository('BlogUserBundle:Group')->findOneBy(array('slug' => $slug));

       	$form = $this->createForm('blog_user_group', $group);
		$form->setData($group);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $groupManager = $this->get('fos_user.group_manager');
		    $group->setSlug(strtolower(str_replace(" ", "-", $form->get('name')->getData())));
            $groupManager->updateGroup($group);

            return $this->redirectToRoute('listGroupPage');
        }

        return $this->render('BlogUserBundle:Group:edit.html.twig', array(
            'form'      => $form->createview(),
            'group_name'  => $group->getName(),
        ));
    }

    /**
     * Show the new form
     */
    public function newAction(Request $request)
    {
    	$groupManager = $this->get('fos_user.group_manager');
        $group = $groupManager->createGroup('');

        $form = $this->createForm('blog_user_group', $group);

        $form->handleRequest($request);

    	if ($form->isValid()) {
		    $em = $this->getDoctrine()->getManager();
		    $group->setSlug(strtolower(str_replace(" ", "-", $form->get('name')->getData())));
		    $em->persist($group);
		    $em->flush();

		    return $this->redirectToRoute('listGroupPage');
		}

        return $this->render('BlogUserBundle:Group:new.html.twig', array(
            'form' => $form->createview(),
        ));
    }

    /**
     * Delete one group
     */
    public function deleteAction(Request $request, $slug)
    {
        $group = $this->getDoctrine()->getManager()->getRepository('BlogUserBundle:Group')->findOneBy(array('slug' => $slug));
       
        $this->get('fos_user.group_manager')->deleteGroup($group);

        return $this->redirectToRoute('listGroupPage');
    }

    public function groupPermissionAction($slug)
    {
        $group = $this->getDoctrine()->getManager()->getRepository('BlogUserBundle:Group')->findOneBy(array('slug' => $slug));
    	$dbRoles = $group->getRoles();

    	$em = $this->getDoctrine() ->getManager();
	    $routes = $em->getRepository('BlogUserBundle:Route')->getRoutesArray();

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
    	
    	return $this->render('BlogUserBundle:Group:group_permission.html.twig', array(
            'routes' => $routes,
        	'roles' =>$dbRoles,
        	'group_name' => $group->getName(),
        ));
    }
}
