<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfigController extends Controller
{
	public function indexAction()
	{
		$configManager = $this->get('spbar.blog_config_manager');

		//form for new config
		$config = $configManager->createConfig();
        $form = $this->createForm('spbar_blog_config', $config);

		//list of blog configs
		$configs = $configManager->getConfigs();

		//list of default configs
		$defalutConfigs = $configManager->getConfigs(true);
		$templates = $this->get('spbar.blog_template_manager')->getTemplatesByType('index');

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addItem("Config");

		return $this->render("SpBarBlogBundle::Backend/Config/index.html.twig", array(
			'page_title' => 'Blog Configurations',
			'form' => $form->createView(),
			'configs' => $configs,
			'defaults' => $defalutConfigs, 'templates' => $templates,
		));
	}

	public function listAction()
	{
		$configManager = $this->get('spbar.blog_config_manager');
		$configs = $configManager->getConfigs();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Config", "sp_blog_config_index");
		$breadcrumbs->addItem('List');

		return $this->render("SpBarBlogBundle::Backend/Config/list.html.twig", array(
			'page_title' => 'List of Configuration',
			'configs' => $configs,
		));
	}

	public function defaultAction(Request $request)
	{
		$configManager = $this->get('spbar.blog_config_manager');

		if($request->request->all())
		{
			$ret = $configManager->updateDefaults($request->request->all());
			if($ret)
			{
				$this->addFlash('success', "Default configs are successfully updated.");
				return $this->redirectToRoute('sp_blog_config_index');
			}else{
				$this->addFlash('error', "Having trouble updating.");
			}
		}

		$defalutConfigs = $configManager->getConfigs(true);

		$templates = $this->get('spbar.blog_template_manager')->getTemplatesByType('index');

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Config", "sp_blog_config_index");
		$breadcrumbs->addItem('Default');

		return $this->render("SpBarBlogBundle::Backend/Config/default.html.twig", array(
            'page_title' =>"Default Configuration",
            'defaults' => $defalutConfigs,
            'templates' => $templates,
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

    		$this->addFlash('success', "New config {$config->getName()} has been added successfully");
		    return $this->redirectToRoute('sp_blog_config_index');
		}

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Config", "sp_blog_config_index");
		$breadcrumbs->addItem('New');

		return $this->render("SpBarBlogBundle::Backend/Config/new.html.twig", array(
            'form' => $form->createView(), 
            'page_title' =>"Add Configuration",
        ));
	}

	public function editAction(Request $request, $slug)
	{
		$configManager = $this->get('spbar.blog_config_manager');
        $config = $configManager->getConfigBySlug($slug);

        $form = $this->createForm('spbar_blog_config', $config);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$configManager->updateConfig($config);

    		$this->addFlash('success', "Config {$config->getName()} has been updated successfully");
		    return $this->redirectToRoute('sp_blog_config_index');
		}

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Config", "sp_blog_config_index");
		$breadcrumbs->addItem('Edit');
		return $this->render("SpBarBlogBundle::Backend/Config/edit.html.twig", array(
			'page_title' => "Edit Configuation",
			'form' => $form->createView(),
			'slug' => $slug,
		));
	}

	public function deleteAction($slug)
	{
		$configManager = $this->get('spbar.blog_config_manager');
        $config = $configManager->getConfigBySlug($slug);

        if(!$config)
        {
        	$this->addFlash('error', "Configuration not found.");
		    return $this->redirectToRoute('sp_blog_config_index');
        }
        $configName = $config->getName();
        $configManager->removeConfig($config);

        $this->addFlash('success', "Config {$configName} has been deleted.");
		return $this->redirectToRoute('sp_blog_config_index');
	}

}