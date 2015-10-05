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

    	$categoryManager = $this->get('spbar.blog_category_manager');
    	$categorys = $categoryManager->getCategorys();

    	$pageManager = $this->get('spbar.blog_page_manager');
    	$pages = $pageManager->getPages();

    	//form for adding custom menu type
    	$menu = $menuManager->createMenu();
    	$menu->setMenuType('Custom');
        $form = $this->createForm('spbar_menu', $menu);
        $categoryForm = $this->createForm('spbar_menu_category', null);
        $pageForm = $this->createForm('spbar_menu_page', null);

        return $this->render('SpBarMenuBundle:Menu:index.html.twig', array(
        	'page_title' => 'Menu',
			'menus' => $menus,
			'categorys'=> $categorys,
			'pages'=> $pages,
            'form' => $form->createView(),
            'categoryForm' => $categoryForm->createView(),
			'pageForm' => $pageForm->createView()
        ));
    }

    public function editAction(Request $request, $id)
    {
    	$menuManager = $this->get('spbar.menu_manager');
    	$menu = $menuManager->getMenuById($id);
        $menuUrl = $menu->getUrl();

    	$form = $this->createForm('spbar_menu', $menu);

	    $form->handleRequest($request);

        if ($form->isValid()) {
            if($menu->getMenuType()!= 'Custom')
            {
                $menu->setUrl($menuUrl);
            }
    		$menuManager->updateMenu($menu);   
            
			return $this->redirectToRoute('sp_menu_index');
        }

    	return $this->render('SpBarMenuBundle:Menu:edit.html.twig', array(
        	'page_title' => 'EditMenu',
			'form' => $form->createView(),
        	'menu' => $menu
        ));
    }
}
