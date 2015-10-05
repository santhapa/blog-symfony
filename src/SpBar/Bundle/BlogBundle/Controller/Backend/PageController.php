<?php 

namespace SpBar\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class PageController extends Controller
{
	public function indexAction()
	{
		$pageManager = $this->get('spbar.blog_page_manager');

		//new form for page
		$page = $pageManager->createPage();
        $form = $this->createForm('spbar_blog_page', $page);
        
        //get list of available pages
		$pages = $pageManager->getPages();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addItem("Page");

		return $this->render("SpBarBlogBundle::Backend/Page/index.html.twig", array(
			'page_title' => 'Blog Pages',
            'form' => $form->createView(),
			'pages' => $pages,
			'staticStatus'=> $pageManager::$pageStatus,
		));
	}

	public function listAction()
	{
		$pageManager = $this->get('spbar.blog_page_manager');

		$pages = $pageManager->getPages();

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Page", "sp_blog_page_index");
		$breadcrumbs->addItem('List');

		return $this->render("SpBarBlogBundle::Backend/Page/list.html.twig", array(
			'page_title' => 'List of Pages',
			'pages' => $pages,
			'staticStatus'=> $pageManager::$pageStatus,
		));
	}

	public function newAction(Request $request)
	{
		$pageManager = $this->get('spbar.blog_page_manager');
        $page = $pageManager->createPage();

        $form = $this->createForm('spbar_blog_page', $page);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$pageManager->updatePage($page);
    		
    		// creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($page);
            $acl = $aclProvider->createAcl($objectIdentity);

            $roleIdentity = new RoleSecurityIdentity('ROLE_BLOG_ADMIN');
            $acl->insertObjectAce($roleIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

    		$this->addFlash('success', "Page '{$page->getTitle()}' successfully added.");
		    return $this->redirectToRoute('sp_blog_page_index');
		}


		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Page", "sp_blog_page_index");
		$breadcrumbs->addItem('New');

		return $this->render("SpBarBlogBundle::Backend/Page/new.html.twig", array(
            'form' => $form->createView(), 
            'page_title' =>"New Page",
        ));
	}

	public function editAction(Request $request, $slug)
	{
		$pageManager = $this->get('spbar.blog_page_manager');
        $page = $pageManager->getPageBySlug($slug);
        if(!$page)
        {
        	$this->addFlash('error', "Page not found.");
		    return $this->redirectToRoute('sp_blog_page_index');
        }

        $authorizationChecker = $this->get('security.authorization_checker');
        // check for edit access
        if (!$authorizationChecker->isGranted("EDIT", $page)) {
            $this->addFlash('error', "Access Denied!");
            return $this->redirectToRoute('sp_blog_page_index');
        }

        $form = $this->createForm('spbar_blog_page', $page);

        $form->handleRequest($request);

    	if ($form->isValid()) 
    	{
    		$pageManager->updatePage($page);

    		$this->addFlash('success', "Page '{$page->getTitle()}' successfully updated.");

		    return $this->redirectToRoute('sp_blog_page_index');
		}

		$breadcrumbs = $this->container->get("white_october_breadcrumbs");
	    $breadcrumbs->addItem("Dashboard");
	    $breadcrumbs->addItem("Blog");
	    $breadcrumbs->addRouteItem("Page", "sp_blog_page_index");
		$breadcrumbs->addItem('Edit');

		return $this->render("SpBarBlogBundle::Backend/Page/edit.html.twig", array(
			'page_title'=>'Edit Blog Page', 
			'form' => $form->createView(),
			'slug' => $slug,
		));
	}

	public function trashAction($slug)
	{
		$pageManager = $this->get('spbar.blog_page_manager');
        $page = $pageManager->getPageBySlug($slug);
        if(!$page)
        {
        	$this->addFlash('error', "Page not found.");
		    return $this->redirectToRoute('sp_blog_page_index');
        }

        $authorizationChecker = $this->get('security.authorization_checker');
        // check for edit access
        if (!$authorizationChecker->isGranted("UNDELETE", $page)) {
            $this->addFlash('error', "Access Denied!");
            return $this->redirectToRoute('sp_blog_page_index');
        }

        $page->setStatus($pageManager::PAGE_STATUS_TRASH);
        $pageManager->updatePage($page);
        $this->addFlash('success', "Page '{$page->getTitle()}' has been moved to trash.");

		return $this->redirectToRoute('sp_blog_page_index');
	}

	public function deleteAction($slug)
	{
		$pageManager = $this->get('spbar.blog_page_manager');
        $page = $pageManager->getPageBySlug($slug);
        if(!$page)
        {
        	$this->addFlash('error', "Page not found.");
		    return $this->redirectToRoute('sp_blog_page_index');
        }

        $authorizationChecker = $this->get('security.authorization_checker');
        // check for edit access
        if (!$authorizationChecker->isGranted("DELETE", $page)) {
            $this->addFlash('error', "Access Denied!");
            return $this->redirectToRoute('sp_blog_page_index');
        }

        $title = $page->getTitle();
        $pageManager->removePage($page);
        $this->addFlash('success', "Page '{$title}' has been deleted.");

		return $this->redirectToRoute('sp_blog_page_index');
	}

}