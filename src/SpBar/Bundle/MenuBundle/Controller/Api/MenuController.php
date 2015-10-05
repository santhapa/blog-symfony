<?php

namespace SpBar\Bundle\MenuBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Util\Codes;

use Symfony\Component\HttpFoundation\Request;

use Rest\ApiBundle\Entity\Post;
use Rest\ApiBundle\Form\PostType;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class MenuController extends FOSRestController
{

    /**
     * List all menus.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     */
    // get_menus [GET] /menus
    public function getMenusAction()
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->getMenu();

        $view = $this->view($menu, Codes::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Create menu with custom url form
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Returns menu form for custom url.",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     */
    // new_menus [GET] /menus/new
    public function newMenusAction()
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->createMenu();

        $menu->setMenuType('Custom');
        $form = $this->createForm('spbar_menu', $menu);
        // $form = $this->get('form.factory')->createNamed('', "spbar_menu", $menu);

        $view = $this->view($form, Codes::HTTP_OK )
            ->setTemplate("SpBarMenuBundle:Menu/Form:new.html.twig")
            ->setTemplateVar('form')
            ->setTemplateData(array('menu' => $menu))
        ;

        return $this->handleView($view);
    }

     /**
     * Create a menu with custom url
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new menu.",
     *   input = "SpBar\Bundle\MenuBundle\Form\Type\MenuFormType",
     *   statusCodes = {
     *     201 = "Returned when menu is created",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     */
    // post_menus [POST] /menus
    public function postMenusAction(Request $request)
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->createMenu();

        $menu->setMenuType('Custom');
        $form = $this->createForm('spbar_menu', $menu);
        // $form = $this->get('form.factory')->createNamed('', "spbar_menu", $menu);

        $form->bind($request);

        if ($form->isValid()) {
            $menu->setMenuType('Custom');
            $menuManager->updateMenu($menu);

            $li = $this->get('twig')->render('SpBarMenuBundle:Menu:menu_content_loop.html.twig', array('menu'=>$menu));

            $ret = array('li'=> $li);

            return $this->view($li, Codes::HTTP_CREATED);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST )
            ->setTemplate("SpBarMenuBundle:Menu/Form:new.html.twig")
            ->setTemplateVar('form')
            ->setTemplateData(array('menu' => $menu))
        ;

        return $this->handleView($view);
    }

    /**
     * Update existing menu.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Displays form for edit",
     *   statusCodes = {
     *     200 = "Returned when successfull"
     *   }
     * )
     */
    // edit_menu [GET] /menus/{id}/edit
    public function editMenuAction($id)
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->getMenuById($id);

        $form = $this->createForm('spbar_menu', $menu);
        // $form = $this->get('form.factory')->createNamed('', "spbar_menu", $menu);

        $view = $this->view($form, Codes::HTTP_OK )
            ->setTemplate("SpBarMenuBundle:Menu/Form:edit.html.twig")
            ->setTemplateVar('form')
            ->setTemplateData(array('menu' => $menu))
        ;

        return $this->handleView($view);
    }

    /**
     * Update existing menu.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "SpBar\Bundle\MenuBundle\Form\Type\MenuFormType",
     *   statusCodes = {
     *     200 = "Returned when edited successfully",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     */
    // put_menus [PUT] /menus/{id}
    public function putMenusAction(Request $request, $id)
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->getMenuById($id);
        $menuUrl = $menu->getUrl();

        $form = $this->createForm('spbar_menu', $menu);
        // $form = $this->get('form.factory')->createNamed('', "spbar_menu", $menu);

        $form->bind($request);

        if ($form->isValid()) {
            if($menu->getMenuType()!= 'Custom')
            {
                $menu->setUrl($menuUrl);
            }
            $menuManager->updateMenu($menu);

            return $this->view($menu, Codes::HTTP_OK);
        }else{
             $view = $this->view($form, Codes::HTPP_BAD_REQUEST )
                ->setTemplate("SpBarMenuBundle:Menu/Form:edit.html.twig")
                ->setTemplateVar('form')
                ->setTemplateData(array('menu' => $menu))
            ;
        }

        return $this->handleView($view);
    }

    /**
     * Deletes the Menu of submitted id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Delete a Menu for a given id",
     *   output = "Rest\ApiBundle\Entity\Post",
     *   statusCodes = {
     *     204 = "Returned when deleted successfully",
     *     404 = "Returned when the post is not found"
     *   }
     * )
     * Delete action
     */
    // delete_menu  [DElETE] /menus/{id}
    public function deleteMenuAction($id)
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->getMenuById($id);

        if(!$menu)
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        
        $menuManager-> removeMenu($menu);

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }

     /**
     * Create a menu with categories
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new menu from category.",
     *   input = "SpBar\Bundle\MenuBundle\Form\Type\CategoryMenuFormType",
     *   statusCodes = {
     *     201 = "Returned when menu is created",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     */
    // post_menus_categorys [POST] /menus
    public function postMenusCategorysAction(Request $request)
    {
        $form = $this->createForm('spbar_menu_category', null);
        $form->bind($request);

        if ($form->isValid()) {
            $menuManager = $this->get('spbar.menu_manager');
            $data = $form->get('categoryMenu')->getData();

            $li = '';
            foreach ($data as $cat) {
                $menu = $menuManager->createMenu();
                $menu->setName($cat->getName());
                $menu->setUrl($this->generateUrl('sp_blog_front_home_category', array('cat_slug'=> $cat->getSlug())));
                $menu->setMenuType('Category');

                $menuManager->updateMenu($menu);

                $li .= $this->get('twig')->render('SpBarMenuBundle:Menu:menu_content_loop.html.twig', array('menu'=>$menu));
            }

            $view = $this->view($li, Codes::HTTP_CREATED);
        }else{
            $view = $this->view($form, Codes::HTTP_BAD_REQUEST )
                ->setTemplate("SpBarMenuBundle:Menu/Form:category.html.twig")
                ->setTemplateVar('form')
                ->setTemplateData(array('menu' => $menu));
        }
        return $this->handleView($view);
    }

    /**
     * Create a menu with pages
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new menu from page.",
     *   input = "SpBar\Bundle\MenuBundle\Form\Type\PageMenuFormType",
     *   statusCodes = {
     *     201 = "Returned when menu is created",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     */
    // post_menus_pages [POST] /menus
    public function postMenusPagesAction(Request $request)
    {
        $form = $this->createForm('spbar_menu_page', null);
        $form->bind($request);

        if ($form->isValid()) {
            $menuManager = $this->get('spbar.menu_manager');

            $pages = $form->get('pageMenu')->getData();

            $li = '';
            foreach ($pages as $page) {
                $menu = $menuManager->createMenu();
                $menu->setName($page->getTitle());
                $menu->setUrl($this->generateUrl('sp_blog_front_home_page', array('page_slug'=> $page->getSlug())));
                $menu->setMenuType('Page');

                $menuManager->updateMenu($menu);

                $li .= $this->get('twig')->render('SpBarMenuBundle:Menu:menu_content_loop.html.twig', array('menu'=>$menu));
            }

            $view =  $this->view($li, Codes::HTTP_CREATED);
        }else{
            $view = $this->view($form, Codes::HTTP_BAD_REQUEST )
                ->setTemplate("SpBarMenuBundle:Menu/Form:page.html.twig")
                ->setTemplateVar('form')
                ->setTemplateData(array('menu' => $menu));
        }

        return $this->handleView($view);
    }

     /**
     * Saves a menu order - works only with nested sortable
     * @ApiDoc(
     *   resource = true,
     *   description = "Save menu order.",
     *   statusCodes = {
     *     200 = "Returned when saved successfully",
     *     400 = "Returned when there  is error"
     *   }
     * )
     *
     * @var Request $request
     * @return View|array
     */
    
    public function postMenusOrdersAction(Request $request)
    {
        $menuManager = $this->get('spbar.menu_manager');

        try {
            $menus = $this->get('request')->request->all();

            foreach ($menus as $mm) {
                $i= 0;
                foreach ($mm as $id => $parent) {
                    $i++;
                    $menu = $menuManager->getMenuById($id);
                    $menu->setMenuOrder($i);
                    // if($parent != 'null' ){
                    //     $menu->setParent($menuManager->getMenuById($parent));
                    //     $hello = $parent;
                    // }else{
                    //     $hello= $parent;
                    //     $menu->setParent(null);
                    // }
                    if($parent != 'null' ){
                        $menu->setParent($menuManager->getMenuById($parent));
                    }else{
                        $menu->setParent(null);
                    }
                    $menuManager->updateMenu($menu, false);
                }   
            }
            $this->getDoctrine()->getManager()->flush();

            $view = $this->view('OK' , Codes::HTTP_OK);            
        } catch (\Exception $e) {
            $view = $this->view(null , Codes::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
