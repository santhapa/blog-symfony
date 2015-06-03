<?php

namespace SpBar\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use SpBar\Bundle\BlogBundle\Form\DataTransformer\MetaTransformer;
use SpBar\Bundle\BlogBundle\Model\PostMetaManager;

class PostMetaFormType extends AbstractType
{
    private $pm;

    public function __construct(PostMetaManager $pm)
    {
        $this->pm = $pm;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new MetaTransformer($this->pm);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'instance'=>'image_form', 
            'enable'=>true,
            'invalid_message' => 'The selected meta does not exist',
             // 'data_class' => 'SpBar\Bundle\BlogBundle\Entity\PostMeta',
        ));
    }

    public function getParent()
    {
        // return 'elfinder';
        return 'hidden';
    }

    public function getName()
    {
        return 'spbar_blog_post_meta';
    }
}