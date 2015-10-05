<?php

namespace SpBar\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{
    protected $authorizer;

    public function __construct($auth=null)
    {
        $this->authorizer = $auth;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder
            ->add('username', 'text', array(
                    'label' => 'Username', 
                    'invalid_message' => 'Username already used!',
                    'required'=>true
                ))
            ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Confirm Password'),
                    'invalid_message' => 'Password mismatch!',
                    'required'=>true
                ))
            ->add('email', 'email', array(
                    'label' => 'Email Address',
                    'required'=>true
                ));
        if($this->authorizer->isGranted('ROLE_BLOG_ADMIN'))
        {
            $builder->add('groups', 'entity', array(
                'class'=> 'SpBar\Bundle\UserBundle\Entity\Group',
                'property' => 'name'
            ));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'spbar_user_registration';
    }
}