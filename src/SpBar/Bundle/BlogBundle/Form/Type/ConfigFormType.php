<?php

namespace SpBar\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

use SpBar\Bundle\BlogBundle\Form\EventListener\ChangeConfigTextareaSubscriber;

class ConfigFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                        'label' => 'Config Name',
                        'required'=>true
                    ))
                ->add('content', 'textarea', array(
                        'label' => 'Content',
                        'required'=>true
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
        return 'spbar_blog_config';
    }
}
