<?php

namespace SpBar\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        $formFactory = $this->get('fos_user.registration.form.factory');
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEnabled(false);

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) 
        {
            $userManager->updateUser($user);

            $this->addFash('success', "New User {$user->getName()} has been created successfully.");
            return $this->redirect($this->generateUrl('loginPage'));
        }else{
            if($form->isSubmitted())
                $this->addFlash('error',"{$form->getErrors(true)}");
        }

        $breadcrumbs = $this->container->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
        $breadcrumbs->addRouteItem("User", "sp_user_index");
        $breadcrumbs->addItem("New");

        return $this->render('SpBarUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
            'page_title'=>"Add User"
        ));
    }
}
