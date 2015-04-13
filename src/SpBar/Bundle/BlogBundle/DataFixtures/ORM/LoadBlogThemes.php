<?php
namespace SpBar\Bundle\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadBlogThemes extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $themeManager = $this->container->get('spbar.blog_theme_manager');
        $themes = array(
                array('name'=>'Fullwidth Single Column' ,'template'=> 'fullwidth_1col.html.twig' , 'type'=> 'index'),
                array('name'=>'Fullwidth Two Column' ,'template'=> 'fullwidth_2col.html.twig' , 'type'=> 'index'),
                array('name'=>'Fullwidth Three Column' ,'template'=> 'fullwidth_3col.html.twig' , 'type'=> 'index'),
                array('name'=>'Fullwidth Four Column' ,'template'=> 'fullwidth_4col.html.twig' , 'type'=> 'index'),
                array('name'=>'With Left Sidebar' ,'template'=> 'with_leftsidebar.html.twig' , 'type'=> 'index'),
                array('name'=>'With Right Sidebar' ,'template'=> 'with_rightsidebar.html.twig' , 'type'=> 'index'),
                array('name'=>'Audio Post' ,'template'=> 'audio_type.html.twig' , 'type'=> 'single'),
                array('name'=>'Gallery Post' ,'template'=> 'gallery_type.html.twig' , 'type'=> 'single'),
                array('name'=>'Quote Post' ,'template'=> 'quote_type.html.twig' , 'type'=> 'single'),
                array('name'=>'Slideshow Post' ,'template'=> 'slideshow_type.html.twig' , 'type'=> 'single'),
                array('name'=>'Video Post' ,'template'=> 'video_type.html.twig' , 'type'=> 'single'),
                array('name'=>'General Post' ,'template'=> 'general.html.twig' , 'type'=> 'single'),
            );

        foreach ($themes as $themeArr) {
            $theme = $themeManager->createTheme();
            $theme->setName($themeArr['name']);
            $theme->setTemplate($themeArr['template']);
            $theme->setType($themeArr['type']);

            $themeManager->updateTheme($theme);

            if($themeArr['name'] == 'Fullwidth Single Column')
            {
                $this->addReference('blog-default-theme', $theme);
            }
        }
       
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}