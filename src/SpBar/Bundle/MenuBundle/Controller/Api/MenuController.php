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
     * Post action
     * @var Request $request
     * @var integer $id Id of the entity
     * @return View|array
     */
    public function editAction(Request $request, $id)
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->getMenuById($id);
        $menuUrl = $menu->getUrl();

        $form = $this->createForm('spbar_menu', $menu);
        $form->bind($request);

        if ($form->isValid()) {
            if($menu->getMenuType()!= 'Custom')
            {
                $menu->setUrl($menuUrl);
            }
            $menuManager->updateMenu($menu);

            return $this->view($menu, Codes::HTTP_OK);
        }

        return array(
            'form' => $form
        );
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
     *
     * @var Request $request
     * @return View|array
     */
    
    public function newAction(Request $request)
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->createMenu();

        $menu->setMenuType('Custom');
        $form = $this->createForm('spbar_menu', $menu);
        $form->bind($request);

        if ($form->isValid()) {
            $menu->setMenuType('Custom');
            $menuManager->updateMenu($menu);

            $li = '<li class="sortable" id="menu-'. $menu->getId() .'">
                    <div class="row ns-row">
                        <div class="col-xs-12 col-md-9 ns-title">'. $menu->getName().'</div>
                        <div class="col-xs-12 col-md-3 ns-actions"><span class="pull-right">
                            <em>('. $menu->getMenuType() .')</em>&emsp;
                            <a class="edit-menu" href="'. $this->generateUrl("sp_menu_edit", array("id"=> $menu->getId())) .'" title="Edit"><img alt="Edit" src="'.$this->get("templating.helper.assets")->getUrl("menu/images/edit.png").'"></a>
                            <a class="delete-menu" href="'.$this->generateUrl("sp_api_menu_delete", array("id"=> $menu->getId())).'" title="Delete"><img alt="Delete" src="'.$this->get("templating.helper.assets")->getUrl("menu/images/cross.png").' "></a>
                        </span></div>
                    </div>
                </li>';

            $ret = array('menu'=>$menu, 'li'=> $li);

            return $this->view($ret, Codes::HTTP_CREATED);
        }

        return array(
            'form' => $form,
            'menu' => $menu
        );
    }

    public function newCategoryAction(Request $request)
    {
        $menuManager = $this->get('spbar.menu_manager');

        if($request->getMethod() == 'POST' && !empty($request->request->get('category_menu'))){
            $cat_selected = $request->request->get('category_menu');
            $categoryManager = $this->get('spbar.blog_category_manager');

            $li = '';
            foreach ($cat_selected as $cat_slug) {
                $cat = $categoryManager->getCategoryBySlug($cat_slug);
                $menu = $menuManager->createMenu();

                $menu->setName($cat->getName());
                $menu->setUrl($this->generateUrl('sp_blog_front_home_category', array('cat_slug'=> $cat_slug)));
                $menu->setMenuType('Category');

                $menuManager->updateMenu($menu);

                $li .= '<li class="sortable" id="menu-'. $menu->getId() .'">
                    <div class="row ns-row">
                        <div class="col-xs-12 col-md-9 ns-title">'. $menu->getName().'</div>
                        <div class="col-xs-12 col-md-3 ns-actions"><span class="pull-right">
                            <em>('. $menu->getMenuType() .')</em>&emsp;
                            <a class="edit-menu" href="'. $this->generateUrl("sp_menu_edit", array("id"=> $menu->getId())) .'" title="Edit"><img alt="Edit" src="'.$this->get("templating.helper.assets")->getUrl("menu/images/edit.png").'"></a>
                            <a class="delete-menu" href="'.$this->generateUrl("sp_api_menu_delete", array("id"=> $menu->getId())).'" title="Delete"><img alt="Delete" src="'.$this->get("templating.helper.assets")->getUrl("menu/images/cross.png").' "></a>
                        </span></div>
                    </div>
                </li>';

            }
            $ret = array('menu'=>$menu, 'li'=> $li);

            return $this->view($ret, Codes::HTTP_CREATED);
        }
    }

    public function newPageAction(Request $request)
    {
        $menuManager = $this->get('spbar.menu_manager');

        if($request->getMethod() == 'POST' && !empty($request->request->get('page_menu'))){
            $page_selected = $request->request->get('page_menu');
            $pageManager = $this->get('spbar.blog_page_manager');

            $li = '';
            foreach ($page_selected as $page_slug) {
                $page = $pageManager->getPageBySlug($page_slug);
                $menu = $menuManager->createMenu();
                
                $menu->setName($page->getTitle());
                $menu->setUrl($this->generateUrl('sp_blog_front_home_page', array('page_slug'=> $page_slug)));
                $menu->setMenuType('Page');

                $menuManager->updateMenu($menu);

                $li .= '<li class="sortable" id="menu-'. $menu->getId() .'">
                    <div class="row ns-row">
                        <div class="col-xs-12 col-md-9 ns-title">'. $menu->getName().'</div>
                        <div class="col-xs-12 col-md-3 ns-actions"><span class="pull-right">
                            <em>('. $menu->getMenuType() .')</em>&emsp;
                            <a class="edit-menu" href="'. $this->generateUrl("sp_menu_edit", array("id"=> $menu->getId())) .'" title="Edit"><img alt="Edit" src="'.$this->get("templating.helper.assets")->getUrl("menu/images/edit.png").'"></a>
                            <a class="delete-menu" href="'.$this->generateUrl("sp_api_menu_delete", array("id"=> $menu->getId())).'" title="Delete"><img alt="Delete" src="'.$this->get("templating.helper.assets")->getUrl("menu/images/cross.png").' "></a>
                        </span></div>
                    </div>
                </li>';

            }
            $ret = array('menu'=>$menu, 'li'=> $li);

            return $this->view($ret, Codes::HTTP_CREATED);
        }
    }

    /**
     * List all menus.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @return array
     *
     * @Rest\View()
     */
    public function listAction()
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->getMenu();

        return array(
            'menu' => $menu,
        );
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
     * @var integer $id Id of the entity
     * @return View
     */
    public function deleteAction($id)
    {
        $menuManager = $this->get('spbar.menu_manager');
        $menu = $menuManager->getMenuById($id);

        $menuManager-> removeMenu($menu);

        return $this->view(null, Codes::HTTP_NO_CONTENT);
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
    
    public function saveOrderAction(Request $request)
    {
        $menuManager = $this->get('spbar.menu_manager');

        if($request->getMethod() == 'POST'){
            $menus = $this->get('request')->request->all();

            foreach ($menus as $mm) {
                $i= 0;
                foreach ($mm as $id => $parent) {
                    $i++;
                    $menu = $menuManager->getMenuById($id);
                    $menu->setMenuOrder($i);
                    if($parent != 'null' ){
                        $menu->setParent($menuManager->getMenuById($parent));
                        $hello = $parent;
                    }else{
                        $hello= $parent;
                        $menu->setParent(null);
                    }
                    $menuManager->updateMenu($menu, false);
                }   
            }
            $this->getDoctrine()->getManager()->flush(); 

            return $this->view('OK' , Codes::HTTP_OK);
        }
    }
}
