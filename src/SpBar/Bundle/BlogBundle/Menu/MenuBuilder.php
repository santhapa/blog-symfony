<?php

namespace SpBar\Bundle\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'sidebar-menu');

        $menu->addChild('Dashboard', array('uri' => '#'))
            ->setChildrenAttribute('icon', 'fa-dashboard');

        $menu->addChild('Blog', array('uri'=>'#'))
            ->setChildrenAttribute('icon', 'fa-folder')
            ->setAttribute('class', 'treeview');
            $this->addSubMenuBlog($menu['Blog']);
 
        return $menu;
    }

    public function addSubMenuBlog($blog)
    {
        $blog->addChild('Configuration', array('uri'=> '#'))
            ->setChildrenAttribute('icon', 'fa-gears')
            ->setAttribute('class', 'treeview');
            $blog['Configuration']->addChild('Settings', array('route'=>'sp_blog_config_index'))
                ->setChildrenAttribute('icon', 'fa-circle-o');
            $blog['Configuration']->addChild('Themes', array('route'=>'sp_blog_theme_index'))
                ->setChildrenAttribute('icon', 'fa-circle-o');

        $blog->addChild('Posts', array('uri'=>'#'))
            ->setChildrenAttribute('icon', 'fa-edit')
            ->setAttribute('class', 'treeview');
            $blog['Posts']->addChild('Post', array('route'=>'sp_blog_post_index'))
                ->setChildrenAttribute('icon', 'fa-circle-o');
            $blog['Posts']->addChild('Category', array('route'=> 'sp_blog_category_index'))
                ->setChildrenAttribute('icon', 'fa-circle-o');

        $blog->addChild('Users', array('uri'=> '#'))
            ->setChildrenAttribute('icon', 'fa-user')
            ->setAttribute('class', 'treeview');
            $blog['Users']->addChild('User', array('route'=> 'sp_user_index'))
                ->setChildrenAttribute('icon', 'fa-circle-o');
            $blog['Users']->addChild('Group', array('route'=> 'sp_user_group_index'))
                ->setChildrenAttribute('icon', 'fa-circle-o');

        return $blog;
    }
 
    /*public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
 
        /*
        You probably want to show user specific information such as the username here. That's possible! Use any of the below methods to do this.
 
        if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {} // Check if the visitor has any authenticated roles
        $username = $this->container->get('security.context')->getToken()->getUser()->getUsername(); // Get username of the current logged in user
 
        */    
        /*$menu->addChild('User', array('label' => 'Hi visitor'))
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'icon-user');
 
        $menu['User']->addChild('Edit profile', array('route' => 'publicHomepage'))
            ->setAttribute('icon', 'icon-edit');
 
        return $menu;
    }*/
}