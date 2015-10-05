<?php

namespace SpBar\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

class TemplateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                        'label' => 'Name',
                        'required'=>true
                    ))
                ->add('templateFile', 'text', array(
                        'label' => 'Template File Name',
                        'required'=>true
                    ))
                ->add('type', 'choice', array(
                        'label' => 'Select Template Type',
                        'choices' => array('postType'=>'Post Type Template', 'index'=>'Index Template'),
                        'placeholder' => "Choose any option",
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
        return 'spbar_blog_template';
    }
}
