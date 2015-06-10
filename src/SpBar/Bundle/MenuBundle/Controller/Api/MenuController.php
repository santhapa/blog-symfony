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

        $form = $this->createForm('spbar_menu', $menu);
        $form->bind($request);

        if ($form->isValid()) {
            $menuManager->updateMenu($menu);

            return $this->view($menu, Codes::HTTP_OK);
        }

        return array(
            'form' => $form
        );
    }


    /**
     * Create a menu
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

        $form = $this->createForm('spbar_menu', $menu);
        $form->bind($request);

        if ($form->isValid()) {
            $menuManager->updateMenu($menu);

            return $this->view($menu, Codes::HTTP_CREATED);
        }

        return array(
            'form' => $form,
            'menu' => $menu
        );
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
}
