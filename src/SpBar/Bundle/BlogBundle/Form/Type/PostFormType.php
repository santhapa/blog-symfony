<?php

namespace SpBar\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

use SpBar\Bundle\BlogBundle\Model\ThemeManager;
use SpBar\Bundle\BlogBundle\Model\PostManager;

class PostFormType extends AbstractType
{   
    protected $tm;

    public function __construct(ThemeManager $tm)
    {
        $this->tm = $tm;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $singleType = $this->tm->getThemesByType('single');

        $postTypes = array();
        foreach ($singleType as $theme) {
            $postTypes[$theme->getSlug()] = $theme->getName();
        }

        $builder->add('title', 'text', array(
                        'label' => 'Title of the Post',
                        'attr' => array('placeholder'=>"Title of the Post"),
                        'required'=>true
                    ))
                // ->add('content', 'textarea', array(
                //         'label' => 'Content',
                //         'attr' => array("class"=>"ckeditor"),
                //         'required'=>true
                //     ))
                ->add('content', 'ckeditor', array(
                    'config' => array(
                        'filebrowser_image_browse_url' => array(
                            'route'            => 'elfinder',
                            'route_parameters' => array('instance' => 'ckeditor'),
                        ),
                    ),
                ))
                ->add('postType', 'choice', array(
                        'label' => 'Post Type',
                        'choices' => $postTypes,
                        'expanded' => true,
                        'multiple' => false,
                        'preferred_choices' => array('general_post'),
                        'data' => 'general_post',
                        'required' => true
                    ))
                // ->add('image', 'file')
                // ->add('image','elfinder', array('instance'=>'form', 'enable'=>true))
                ->add('status', 'choice', array(
                        'label' => 'Publish',
                        'choices' => PostManager::$newPostStatus,
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
        return 'spbar_blog_post';
    }
}
