<?php

namespace SpBar\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildGeneralForm($builder, $options);
        $this->buildSocialForm($builder, $options);

        // $builder->add('image', 'file', array(
        //             'label' => "Profile Image"
        //         ));

        $builder->add('username','text', array(
                    'label'=>'Username',
                    'read_only' => true,
                ));

        $builder->add('current_password', 'password', array(
                        'label' => 'Current Password',
                        'mapped' => false,
                        'invalid_message' => "Wrong password!",
                        'constraints' => new UserPassword(),
                        'required' => true
                    ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('Profile'),
        ));
    }

    protected function buildGeneralForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'text', array(
                    'label'=>"First Name",
                    'required' => true
                ))
                ->add('lastname', 'text', array(
                    'label'=>"Last Name",
                    'required'=> true
                ))
                ->add('email', 'email',array(
                    'label' => 'Email Address',
                    'read_only' => true,
                ))
                ->add('dateOfBirth', 'date', array(
                    'input'  => 'datetime',
                    'widget' => 'single_text',
                    'label'=>"Date of Birth",
                    'required' => true
                ))
                ->add('gender', 'choice', array(
                    'label'=>"Gender",
                    'choices'=> array('Male'=>'Male', 'Female'=>'Female'),
                    'required' => true
                ))
                ->add('phoneNumber', 'text', array(
                    'label'=>"Telephone Number",
                    'required' => false
                ))
                ->add('mobileNumber', 'text', array(
                    'label'=>"Mobile Number",
                    'required' => false
                ))
                ->add('address', 'text', array(
                    'label'=>"Address",
                    'required' => true
                ))
                ->add('biography', 'textarea', array(
                    'label'=>"Biography",
                    'required' => false
                ))
                ->add('website', 'text', array(
                    'label'=>"Website",
                    'required' => false
                ))
        ;
    }

    protected function buildSocialForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('facebookId', 'text', array(
                    'label'=>"Facebook Url",
                    'required' => false
                ))
                ->add('gplusId', 'text', array(
                    'label'=>"Google Plus Url",
                    'required' => false
                ))
                ->add('twitterId', 'text', array(
                    'label'=>"Twitter Url",
                    'required' => false
                ))
        ;
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'spbar_user_profile';
    }
}