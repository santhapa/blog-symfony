<?php

namespace SpBar\Bundle\MenuBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

class MenuFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                        'label' => 'Menu Name',
                        'required'=>true
                    ))
                ->add('url', 'text', array(
                        'label' => 'Url',
                        'required'=>true
                    ))
                ->add('menuType', 'text', array(
                        'label' => 'Menu Type',
                        'read_only'=>true,
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
        return 'spbar_menu';
    }
}
