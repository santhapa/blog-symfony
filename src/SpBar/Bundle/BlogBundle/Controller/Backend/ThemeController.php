<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ThemeController extends Controller
{
	public function indexAction()
	{
		$themeManager = $this->get('spbar.blog_theme_manager');

		//new form for theme
		$theme = $themeManager->createTheme();
        $form = $this->createForm('spbar_blog_theme', $theme);
        
        //get list of available themes
		$themes = $themeManager->getThemes();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addItem("Theme");

		return $this->render("SpBarBlogBundle::Backend/Theme/index.html.twig", array(
			'page_title' => 'Blog Themes',
            'form' => $form->createView(),
			'themes' => $themes,
		));
	}

	public function listAction()
	{
		$themeManager = $this->get('spbar.blog_theme_manager');

		$themes = $themeManager->getThemes();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Theme", "sp_blog_theme_index");
		$breadcrumbs->addItem('List');

		return $this->render("SpBarBlogBundle::Backend/Theme/list.html.twig", array(
			'page_title' => 'List of Themes',
			'themes' => $themes,
		));
	}

	public function newAction(Request $request)
	{
		$this->addFlash('error', "Adding theme is disabled for now.");
		return $this->redirectToRoute('sp_blog_theme_index');

		// $themeManager = $this->get('spbar.blog_theme_manager');
  //       $theme = $themeManager->createTheme();

  //       $form = $this->createForm('spbar_blog_theme', $theme);

  //       $form->handleRequest($request);

  //   	if ($form->isValid()) 
  //   	{
  //   		$themeManager->updateTheme($theme);
  //   		$this->addFlash('success', "Theme {$theme->getName()} successfully added.");

		//     return $this->redirectToRoute('sp_blog_theme_index');
		// }

		// $breadcrumbs = $this->container->get("white_october_breadcrumbs");
	 //    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	 //    $breadcrumbs->addItem("Blog");
	 //    $breadcrumbs->addRouteItem("Theme", "sp_blog_theme_index");
		// $breadcrumbs->addItem('New');

		// return $this->render("SpBarBlogBundle::Backend/Theme/new.html.twig", array(
  //           'form' => $form->createView(), 
  //           'page_title' =>"Add New Theme",
  //       ));
	}

	public function editAction(Request $request, $slug)
	{
		// $themeManager = $this->get('spbar.blog_theme_manager');
  //       $theme = $themeManager->getThemeBySlug($slug);
  //       if(!$theme)
  //       {
  //       	$this->addFlash('error', "Theme not found.");
		//     return $this->redirectToRoute('sp_blog_theme_index');
  //       }

  //       $form = $this->createForm('spbar_blog_theme', $theme);

  //       $form->handleRequest($request);

  //   	if ($form->isValid()) 
  //   	{
  //   		$themeManager->updateTheme($theme);

  //   		$this->addFlash('success', "Theme {$theme->getName()} successfully updated.");

		//     return $this->redirectToRoute('sp_blog_theme_index');
		// }

		// $breadcrumbs = $this->container->get("white_october_breadcrumbs");
	 //    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	 //    $breadcrumbs->addItem("Blog");
	 //    $breadcrumbs->addRouteItem("Theme", "sp_blog_theme_index");
		// $breadcrumbs->addItem('Edit');

		// return $this->render("SpBarBlogBundle::Backend/Theme/edit.html.twig", array(
		// 	'page_title'=>'Edit Blog Theme', 
		// 	'form' => $form->createView(),
		// 	'slug' => $slug,
		// ));
		$this->addFlash('error', "Updating theme is disabled for now.");
		return $this->redirectToRoute('sp_blog_theme_index');
	}

	public function deleteAction($slug)
	{
		// $themeManager = $this->get('spbar.blog_theme_manager');
  //       $theme = $themeManager->getThemeBySlug($slug);
  //       if(!$theme)
  //       {
  //       	$this->addFlash('error', "Theme not found.");
		//     return $this->redirectToRoute('sp_blog_theme_index');
  //       }
  //       $themeName = $theme->getName();
  //       $themeManager->removeTheme($theme);
  //       $this->addFlash('success', "Theme {$themeName} has been deleted.");

        $this->addFlash('error', "Deleting theme is disabled for now.");
		return $this->redirectToRoute('sp_blog_theme_index');
	}

}