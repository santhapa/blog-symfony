<?php

namespace SpBar\Bundle\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
