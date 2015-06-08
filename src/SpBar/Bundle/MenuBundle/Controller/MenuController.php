<?php

namespace SpBar\Bundle\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller
{
    public function indexAction()
    {
        return $this->render('SpBarMenuBundle:Menu:index.html.twig');
    }
}
