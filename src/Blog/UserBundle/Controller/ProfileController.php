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
use Blog\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use FOS\UserBundle\Controller\ProfileController as BaseController;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{
    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->getUser();

        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) 
        {
            throw $this->createAccessDeniedException();
        }

        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            return $this->render('BlogUserBundle:Profile:admin_show.html.twig', array(
                'user' => $user
            ));
        }
        
        return $this->render('BlogUserBundle:Profile:show.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        //if (!is_object($user) || !$user instanceof UserInterface) 
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) 
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('profilePage'));
        }

        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            return $this->render('BlogUserBundle:Profile:admin_edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }

        return $this->render('BlogUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
