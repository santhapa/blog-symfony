<?php

namespace SpBar\Bundle\MenuBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer as FOSTransformer;

class CategoryMenuFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoryMenu', 'entity', array(
                        'label' => 'Category',
                        'class'=> 'SpBarBlogBundle:Category',
                        'property'=> 'name',
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
        return 'spbar_menu_category';
    }
}
