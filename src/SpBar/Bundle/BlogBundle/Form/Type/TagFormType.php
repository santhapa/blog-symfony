<?php

namespace SpBar\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use SpBar\Bundle\BlogBundle\Form\DataTransformer\TagTransformer;
use SpBar\Bundle\BlogBundle\Model\TagManager;

class TagFormType extends AbstractType
{
    private $tm;

    public function __construct(TagManager $tm)
    {
        $this->tm = $tm;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new TagTransformer($this->tm);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected tag does not exist',
             // 'data_class' => 'SpBar\Bundle\BlogBundle\Entity\Tag',
        ));
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'spbar_blog_post_tag';
    }
}