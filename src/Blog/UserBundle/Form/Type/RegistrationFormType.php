<?php

namespace Blog\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('roles', 'collection', array(
                    'label' => 'Select Role',
                    'type'   => 'choice',
                    'options'  => array(
                        'choices'  => array(
                            'ROLE_ADMIN' => 'Admin',
                            'ROLE_AUTHOR'     => 'Author',
                            'ROLE_USER'    => 'User'
                        )
                    )));
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