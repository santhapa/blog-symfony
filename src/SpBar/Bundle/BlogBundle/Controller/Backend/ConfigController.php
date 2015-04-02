<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfigController extends Controller
{
	public function indexAction()
	{
		return $this->listAction();
	}

	public function listAction()
	{
		return $this->render("SpBarBlogBundle::Backend/Config/list.html.twig");
	}

	public function defaultAction()
	{
		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Config", "sp_blog_config_index");
		$breadcrumbs->addItem('Default');

		return $this->render("SpBarBlogBundle::Backend/Config/default.html.twig", array(
            'page_title' =>"Default Configuration",
        ));
	}

	public function newAction(Request $request)
	{
		$configManager = $this->get('spbar.blog_config_manager');
        $config = $configManager->createConfig();

        $form = $this->createForm('spbar_blog_config', $config);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$configManager->updateConfig($config);

		    return $this->redirectToRoute('sp_blog_config_index');
		}

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Config", "sp_blog_config_index");
		$breadcrumbs->addItem('New');

		return $this->render("SpBarBlogBundle::Backend/Config/new.html.twig", array(
            'form' => $form->createview(), 
            'page_title' =>"Add Configuration",
        ));
	}

	public function editAction()
	{
		return $this->render("SpBarBlogBundle::Backend/Config/new.html.twig");
	}

	public function deleteAction()
	{
		return $this->render("SpBarBlogBundle::Backend/Config/edit.html.twig");
	}

}