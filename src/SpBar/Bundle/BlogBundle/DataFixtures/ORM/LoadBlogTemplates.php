<?php
namespace SpBar\Bundle\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadBlogTemplates extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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
        $templateManager = $this->container->get('spbar.blog_template_manager');
        $templates = array(
                array('name'=>'Fullwidth Single Column' ,'templateFile'=> 'fullwidth_1col.html.twig' , 'type'=> 'index'),
                array('name'=>'Fullwidth Two Column' ,'templateFile'=> 'fullwidth_2col.html.twig' , 'type'=> 'index'),
                array('name'=>'Fullwidth Three Column' ,'templateFile'=> 'fullwidth_3col.html.twig' , 'type'=> 'index'),
                // array('name'=>'Fullwidth Four Column' ,'templateFile'=> 'fullwidth_4col.html.twig' , 'type'=> 'index'),
                array('name'=>'With Left Sidebar' ,'templateFile'=> 'with_leftsidebar.html.twig' , 'type'=> 'index'),
                array('name'=>'With Right Sidebar' ,'templateFile'=> 'with_rightsidebar.html.twig' , 'type'=> 'index'),
                array('name'=>'General' ,'templateFile'=> 'general.html.twig' , 'type'=> 'postType'),
                array('name'=>'Audio' ,'templateFile'=> 'audio_type.html.twig' , 'type'=> 'postType'),
                array('name'=>'Video' ,'templateFile'=> 'video_type.html.twig' , 'type'=> 'postType'),
                array('name'=>'Gallery' ,'templateFile'=> 'gallery_type.html.twig' , 'type'=> 'postType'),
                // array('name'=>'Quote Post' ,'templateFile'=> 'quote_type.html.twig' , 'type'=> 'postType'),
                // array('name'=>'Slideshow Post' ,'templateFile'=> 'slideshow_type.html.twig' , 'type'=> 'postType'),
            );

        foreach ($templates as $templateArr) {
            $template = $templateManager->createTemplate();
            $template->setName($templateArr['name']);
            $template->setTemplate($templateArr['template']);
            $template->setType($templateArr['type']);

            $templateManager->updateTemplate($template);

            if($templateArr['name'] == 'Fullwidth Single Column')
            {
                $this->addReference('blog-default-template', $template);
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