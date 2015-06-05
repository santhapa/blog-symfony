<?php

namespace SpBar\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

use SpBar\Bundle\BlogBundle\Model\PageManager;

class PageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array(
                        'label' => 'Title of the Page',
                        'attr' => array('placeholder'=>"Title of the Page"),
                        'required'=>true
                    ))
                ->add('content', 'ckeditor', array(
                    'config' => array(
                        'filebrowser_image_browse_url' => array(
                            'route'            => 'elfinder',
                            'route_parameters' => array('instance' => 'ckeditor'),
                        ),
                    ),
                ))
                ->add('featuredImage', 'hidden', array(
                        'attr' => array('class'=>'spbar-page-featured-image'),
                        'required'=> false
                    ))
                ->add('template', 'choice', array(
                        'label' => 'Page Template',
                        'choices' => PageManager::$pageTemplate,
                        // 'data' => 'fullwidth',
                        'required' => true
                    ))
                ->add('status', 'choice', array(
                        'label' => 'Publish',
                        'choices' => PageManager::$status_pageForm,
                        'data' => '1',
                        'required' => true
                    ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'spbar_blog_page';
    }
}
