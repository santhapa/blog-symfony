<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
	public function indexAction()
	{
		$categoryManager = $this->get('spbar.blog_category_manager');

		//new form for category
		$category = $categoryManager->createCategory();
        $form = $this->createForm('spbar_blog_category', $category);
        
        //get list of available categorys
		$categorys = $categoryManager->getCategorys();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addItem("Category");

		return $this->render("SpBarBlogBundle::Backend/Category/index.html.twig", array(
			'page_title' => 'Post Category',
            'form' => $form->createView(),
			'categorys' => $categorys,
		));
	}

	public function listAction()
	{
		$categoryManager = $this->get('spbar.blog_category_manager');

		$categorys = $categoryManager->getCategorys();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Category", "sp_blog_category_index");
		$breadcrumbs->addItem('List');

		return $this->render("SpBarBlogBundle::Backend/Category/list.html.twig", array(
			'page_title' => 'List of Category',
			'categorys' => $categorys,
		));
	}

	public function newAction(Request $request)
	{
		$categoryManager = $this->get('spbar.blog_category_manager');
        $category = $categoryManager->createCategory();

        $form = $this->createForm('spbar_blog_category', $category);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$categoryManager->updateCategory($category);
    		$this->addFlash('success', "Category {$category->getName()} successfully added.");

		    return $this->redirectToRoute('sp_blog_category_index');
		}

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Category", "sp_blog_category_index");
		$breadcrumbs->addItem('New');

		return $this->render("SpBarBlogBundle::Backend/Category/new.html.twig", array(
            'form' => $form->createView(), 
            'page_title' =>"Add New Category",
        ));
	}

	public function editAction(Request $request, $slug)
	{
		$categoryManager = $this->get('spbar.blog_category_manager');
        $category = $categoryManager->getCategoryBySlug($slug);
        if(!$category)
        {
        	$this->addFlash('error', "Category not found.");
		    return $this->redirectToRoute('sp_blog_category_index');
        }

        $form = $this->createForm('spbar_blog_category', $category);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$categoryManager->updateCategory($category);

    		$this->addFlash('success', "Category {$category->getName()} successfully updated.");

		    return $this->redirectToRoute('sp_blog_category_index');
		}

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addRouteItem("Dashboard", "adminIndexPage");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Category", "sp_blog_category_index");
		$breadcrumbs->addItem('Edit');

		return $this->render("SpBarBlogBundle::Backend/Category/edit.html.twig", array(
			'page_title'=>'Edit Post Category', 
			'form' => $form->createView(),
			'slug' => $slug,
		));
	}

	public function deleteAction($slug)
	{
		$categoryManager = $this->get('spbar.blog_category_manager');
        $category = $categoryManager->getCategoryBySlug($slug);
        if(!$category)
        {
        	$this->addFlash('error', "Category not found.");
		    return $this->redirectToRoute('sp_blog_category_index');
        }
        $categoryName = $category->getName();
        $categoryManager->removeCategory($category);
        $this->addFlash('success', "Category {$categoryName} has been deleted.");

		return $this->redirectToRoute('sp_blog_category_index');
	}

}