<?php

namespace SpBar\Bundle\MenuBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

class PageMenuFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pageMenu', 'entity', array(
                        'label' => 'Page',
                        'class'=> 'SpBarBlogBundle:Page',
                        'property'=> 'title',
                        'expanded' => true,
                        'multiple' => true,
                        'required' => true
                    ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'spbar_menu_page';
    }
}
