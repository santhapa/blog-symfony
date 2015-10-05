<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            //dependency bundles
            new FOS\UserBundle\FOSUserBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new FM\ElfinderBundle\FMElfinderBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            // new JMS\SerializerBundle\JMSSerializerBundle(),

            // new Sonata\CoreBundle\SonataCoreBundle(),
            // new Sonata\BlockBundle\SonataBlockBundle(),
            // new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            // new Sonata\AdminBundle\SonataAdminBundle(),
            // new Sonata\MediaBundle\SonataMediaBundle(),
            // new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),

            //my bundles
            // new Blog\UserBundle\BlogUserBundle(),
            // new Blog\PublicBundle\BlogPublicBundle(),
            // new Blog\PostBundle\BlogPostBundle(),
            // new Blog\AdminBundle\BlogAdminBundle(),

            new SpBar\Bundle\BlogBundle\SpBarBlogBundle(),
            new SpBar\Bundle\UserBundle\SpBarUserBundle(),
            new SpBar\Bundle\MenuBundle\SpBarMenuBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
