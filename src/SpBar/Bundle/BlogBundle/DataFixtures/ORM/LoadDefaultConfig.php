<?php
namespace SpBar\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadDefaultConfig extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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
        $configManager = $this->container->get('spbar.blog_config_manager');
        $configs = array(
                array('name'=>'Post per page' ,'content'=> '10'),
                array('name'=>'Blog Theme' ,'content'=> $this->getReference('blog-default-theme')->getTemplate()),
            );

        foreach ($configs as $configArr) {
            $config = $configManager->createConfig();
            $config->setName($configArr['name']);
            $config->setContent($configArr['content']);
            $config->setDefault(TRUE);

            $configManager->updateConfig($config);
        }
       
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }
}