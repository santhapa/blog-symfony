<?php

namespace Blog\ReportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GenerateReportFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                'label' => 'Report Name:', 
                'invalid_message' => 'Report name must be unique for slug value!'))
                ->add('description', 'text', array(
                    'label' => 'Description:',
                    'required' => false))
                ->add('sqlQuery', 'textarea' ,array(
                    'label' => 'SQL Query:'));
    }

    public function getName()
    {
        return 'generate_report';
    }

}