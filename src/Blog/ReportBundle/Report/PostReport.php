<?php

namespace Blog\ReportBundle\Report;

use Velvel\ReportBundle\Builder\BaseReportBuilder;
use Doctrine\ORM\QueryBuilder;

class PostReport extends BaseReportBuilder
{
    /**
     * Configures builder
     * 
     * This method configures the ReportBuilder. It has to return
     * a configured Doctrine QueryBuilder.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder
     * 
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function configureBuilder(QueryBuilder $queryBuilder)
    {
        $queryBuilder
            ->select('p.title, p.content, u.name, p.active')
            ->from('BlogPostBundle:Post', 'p')
            ->innerJoin('BlogUserBundle:User', 'u')
            ->groupBy('p.id')
            ->add('where', 'p.dateTime > :from AND p.dateTime < :to');;
        return $queryBuilder;
    }

    /**
     * Configures parameters
     *
     * This method configures parameters, which will be passed to
     * the QueryBuilder and the Form too, so the users (admins) can
     * change them.
     *
     * @return array
     */
    public function configureParameters()
    {
        $parameters = array(
            'from' => array(
                'value'   => new \DateTime('yesterday'), // default value
                'type'    => 'date', // form type
                'options' => array('label' => 'From'), // form options
            ),
            'to'   => array(
                'value'   => new \DateTime('now'),
                'type'    => 'date',
                'options' => array('label' => 'To'),
            ),
        );
        return $parameters;
    }

    /**
     * Configures modifiers
     *
     * If an element in the select statement returns an object without
     * a __toString() method implemented, it needs a modifier to be set.
     *
     * @return array
     */
    public function configureModifiers()
    {
        $modifiers = array(
            'checkoutDate' => array(
                'method' => 'format', // method to be called on the object
                'params' => array('Y/m/d H:i:s'), // method parameters in an array
            ),
        );

        return $modifiers;
    }
}