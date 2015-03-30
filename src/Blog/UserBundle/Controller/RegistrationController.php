<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Blog\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        $authorizer = $this->container->get('security.authorization_checker');
        if($authorizer->isGranted('IS_AUTHENTICATED_FULLY') && !$authorizer->isGranted('ROLE_ADMIN'))
            return $this->redirect($this->generateUrl('publicHomepage'));
        $formFactory = $this->get('fos_user.registration.form.factory');
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEnabled(true);

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) 
        {
            // if(!$form->get('roles')->getData())
            //     $user->addRole('ROLE_USER');
            $userManager->updateUser($user);

            // $user->addGroup($form->get('groups')->getData());
            // $userManager->updateUser($user);

            if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
                return $this->redirect($this->generateUrl('userIndexPage'));
            else
                return $this->redirect($this->generateUrl('loginPage'));
        }

        if($authorizer->isGranted('ROLE_ADMIN'))
        {
            return $this->render('BlogUserBundle:Registration:admin_register.html.twig', array(
                'form' => $form->createView(),
            ));
        }
            

        return $this->render('BlogUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
