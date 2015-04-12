<?php

namespace SpBar\Bundle\UserBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController
{
    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        // if (!is_object($user) || !$user instanceof UserInterface) {
        if (false === $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $formFactory = $this->get('fos_user.profile.form.factory');
        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $this->addFlash('success', "Your profile has been updated.");
            return $this->redirectToRoute('sp_user_profile');
        }

        return $this->render('SpBarUserBundle:Backend/Profile:edit.html.twig', array(
            'form' => $form->createView(),
            'page_title' => "Edit Profile"
        ));
    }
}
