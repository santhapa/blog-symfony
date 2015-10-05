<?php

namespace SpBar\Bundle\UserBundle\Controller\Backend;

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

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) 
        {
            $user->setEnabled(false);
            $role = "ROLE_". strtoupper($form->get('groups')->getData()->getSlug());
            $user->addRole($role);
            $userManager->updateUser($user);

            $request->getSession()->getFlashBag()->add('success', "New User {$user->getUsername()} has been created successfully.");
            return $this->redirect($this->generateUrl('sp_user_index'));
        }

        $breadcrumbs = $this->container->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Dashboard", "");
        $breadcrumbs->addRouteItem("User", "sp_user_index");
        $breadcrumbs->addItem("New");

        return $this->render('SpBarUserBundle:Backend/Registration:register.html.twig', array(
            'form' => $form->createView(),
            'page_title'=>"Add User"
        ));
    }
}
