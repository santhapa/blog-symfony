<?php

namespace SpBar\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

use SpBar\Bundle\BlogBundle\Form\EventListener\ChangeConfigTextareaSubscriber;

class ThemeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                        'label' => 'Name',
                        'required'=>true
                    ))
                ->add('template', 'text', array(
                        'label' => 'Template File Name',
                        'required'=>true
                    ))
                ->add('type', 'choice', array(
                        'label' => 'Slecte Theme Type',
                        'choices' => array('single'=>'Single Post', 'index'=>'Index Post'),
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
        return 'spbar_blog_theme';
    }
}
