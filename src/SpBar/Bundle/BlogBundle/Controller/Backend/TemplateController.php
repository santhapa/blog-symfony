<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TemplateController extends Controller
{
	public function indexAction()
	{
		$templateManager = $this->get('spbar.blog_template_manager');

		//new form for template
		$template = $templateManager->createTemplate();
        $form = $this->createForm('spbar_blog_template', $template);
        
        //get list of available templates
		$templates = $templateManager->getTemplates();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addItem("Template");

		return $this->render("SpBarBlogBundle::Backend/Template/index.html.twig", array(
			'page_title' => 'Blog Templates',
            'form' => $form->createView(),
			'templates' => $templates,
		));
	}

	public function listAction()
	{
		$templateManager = $this->get('spbar.blog_template_manager');

		$templates = $templateManager->getTemplates();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Template", "sp_blog_template_index");
		$breadcrumbs->addItem('List');

		return $this->render("SpBarBlogBundle::Backend/Template/list.html.twig", array(
			'page_title' => 'List of Templates',
			'templates' => $templates,
		));
	}

	public function newAction(Request $request)
	{
		$this->addFlash('error', "Adding template is disabled for now.");
		return $this->redirectToRoute('sp_blog_template_index');

		// $templateManager = $this->get('spbar.blog_template_manager');
  //       $template = $templateManager->createTemplate();

  //       $form = $this->createForm('spbar_blog_template', $template);

  //       $form->handleRequest($request);

  //   	if ($form->isValid()) 
  //   	{
  //   		$templateManager->updateTemplate($template);
  //   		$this->addFlash('success', "Template {$template->getName()} successfully added.");

		//     return $this->redirectToRoute('sp_blog_template_index');
		// }

		// $breadcrumbs = $this->container->get("white_october_breadcrumbs");
	 //    $breadcrumbs->addItem("Dashboard");
	 //    $breadcrumbs->addItem("Blog");
	 //    $breadcrumbs->addRouteItem("Template", "sp_blog_template_index");
		// $breadcrumbs->addItem('New');

		// return $this->render("SpBarBlogBundle::Backend/Template/new.html.twig", array(
  //           'form' => $form->createView(), 
  //           'page_title' =>"Add New Template",
  //       ));
	}

	public function editAction(Request $request, $slug)
	{
		// $templateManager = $this->get('spbar.blog_template_manager');
  //       $template = $templateManager->getTemplateBySlug($slug);
  //       if(!$template)
  //       {
  //       	$this->addFlash('error', "Template not found.");
		//     return $this->redirectToRoute('sp_blog_template_index');
  //       }

  //       $form = $this->createForm('spbar_blog_template', $template);

  //       $form->handleRequest($request);

  //   	if ($form->isValid()) 
  //   	{
  //   		$templateManager->updateTemplate($template);

  //   		$this->addFlash('success', "Template {$template->getName()} successfully updated.");

		//     return $this->redirectToRoute('sp_blog_template_index');
		// }

		// $breadcrumbs = $this->container->get("white_october_breadcrumbs");
	 //    $breadcrumbs->addItem("Dashboard");
	 //    $breadcrumbs->addItem("Blog");
	 //    $breadcrumbs->addRouteItem("Template", "sp_blog_template_index");
		// $breadcrumbs->addItem('Edit');

		// return $this->render("SpBarBlogBundle::Backend/Template/edit.html.twig", array(
		// 	'page_title'=>'Edit Blog Template', 
		// 	'form' => $form->createView(),
		// 	'slug' => $slug,
		// ));
		$this->addFlash('error', "Updating template is disabled for now.");
		return $this->redirectToRoute('sp_blog_template_index');
	}

	public function deleteAction($slug)
	{
		// $templateManager = $this->get('spbar.blog_template_manager');
  //       $template = $templateManager->getTemplateBySlug($slug);
  //       if(!$template)
  //       {
  //       	$this->addFlash('error', "Template not found.");
		//     return $this->redirectToRoute('sp_blog_template_index');
  //       }
  //       $templateName = $template->getName();
  //       $templateManager->removeTemplate($template);
  //       $this->addFlash('success', "Template {$templateName} has been deleted.");

        $this->addFlash('error', "Deleting template is disabled for now.");
		return $this->redirectToRoute('sp_blog_template_index');
	}

}