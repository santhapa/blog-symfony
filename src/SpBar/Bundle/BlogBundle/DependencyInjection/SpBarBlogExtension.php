<?php

namespace SpBar\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SpBarBlogExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        //load custom services from custom directory
        $serviceLoader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $serviceLoader->load('config_services.yml');
        $serviceLoader->load('template_services.yml');
        $serviceLoader->load('post.yml');        
        $serviceLoader->load('page.yml');        
        $serviceLoader->load('tag.yml');
        $serviceLoader->load('post_meta.yml');
        $serviceLoader->load('comment.yml');
        $serviceLoader->load('category.yml');
        $serviceLoader->load('menu.yml');
    }
}
