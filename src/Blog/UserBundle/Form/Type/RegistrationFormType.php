<?php

namespace Blog\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder
            ->add('username', 'text', array(
                'label' => 'Username:', 
                'invalid_message' => 'Username not available!',
                'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Password:'),
                'second_options' => array('label' => 'Confirm Password:'),
                'invalid_message' => 'Password mismatch!'))
            ->add('name' , 'text', array('label'=> 'Name:'))
            ->add('email', 'email', array('label' => 'Email Id:', 'translation_domain' => 'FOSUserBundle'))
            ->add('groups', 'entity', array(
                    'class'=> 'Blog\UserBundle\Entity\Group',
                    'property' => 'name'
                ));
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
        return 'blog_user_registration';
    }
}