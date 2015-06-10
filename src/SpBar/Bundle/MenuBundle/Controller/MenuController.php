<?php

namespace SpBar\Bundle\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    public function indexAction()
    {
    	$menuManager = $this->get('spbar.menu_manager');

    	$menus = $menuManager->getMenu();

        return $this->render('SpBarMenuBundle:Menu:index.html.twig', array(
        	'page_title' => 'Menu',
			'menus' => $menus,
        ));
    }

    public function editAction(Request $request, $id)
    {
    	$menuManager = $this->get('spbar.menu_manager');
    	$menu = $menuManager->getMenuById($id);

    	$form = $this->createForm('spbar_menu', $menu);

		if ($request->getMethod() == 'POST') { // save
	        $form->handleRequest($request);

	        if ($form->isValid()) {
	    		$menuManager->updateMenu($menu);   
	            $response = new Response();
				$response->headers->set('Content-Type', 'text/json');
				$response->setStatusCode(Response::HTTP_OK);
				$response->setContent($menu);

				return $response;
	        }
	    }

    	return $this->render('SpBarMenuBundle:Menu:edit.html.twig', array(
        	'page_title' => 'EditMenu',
			'form' => $form->createView(),
        	'menu' => $menu
        ));
    }
}
