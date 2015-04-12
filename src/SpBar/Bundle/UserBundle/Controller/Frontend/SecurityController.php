<?php

namespace SpBar\Bundle\UserBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class PublicSecurityController extends BaseController
{
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }
}
