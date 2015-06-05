<?php

namespace SpBar\Bundle\BlogBundle\Model;

use Doctrine\ORM\EntityManager;
use SpBar\Bundle\BlogBundle\Entity\Page;

class PageManager
{
	const PAGE_STATUS_PUBLISH = 1;
	const PAGE_STATUS_DRAFT = 2;
    const PAGE_STATUS_TRASH = 3;

    const PAGE_TEMPLATE_FULLWIDTH = 'fullwidth';
    const PAGE_TEMPLATE_LEFTSIDEBAR = 'leftsidebar';
    const PAGE_TEMPLATE_RIGHTSIDEBAR = 'rightsidebar';

	public static $status_pageForm = array(
		self::PAGE_STATUS_DRAFT => 'Save to Draft',
		self::PAGE_STATUS_PUBLISH	=> 'Publish'
	);

	public static $pageStatus = array(
		self::PAGE_STATUS_DRAFT => 'Draft',
		self::PAGE_STATUS_PUBLISH => 'Published',
		self::PAGE_STATUS_TRASH => 'Trash'
	);

	public static $pageTemplate = array(
		self::PAGE_TEMPLATE_FULLWIDTH => 'Fullwidth',
		self::PAGE_TEMPLATE_LEFTSIDEBAR => 'With Left Sidebar',
		self::PAGE_TEMPLATE_RIGHTSIDEBAR => 'With Right Sidebar'
	);

	protected $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function createPage()
	{
		return new Page();
	}

	public function updatePage(Page $page, $flush=true)
	{
		$this->em->persist($page);
		if($flush)
		{
			$this->em->flush();
		}
	}

	public function removePage(Page $page)
	{
		$this->em->remove($page);
		$this->em->flush();

		return;
	}

	public function getPages()
	{
		return $this->em->getRepository("SpBarBlogBundle:Page")->findBy(array(), array('createdAt'=>'desc', 'status'=>'asc'));
	}

	public function getPageBySlug($slug)
	{
		return $this->em->getRepository("SpBarBlogBundle:Page")->findOneBy(array('slug'=>$slug));
	}
}