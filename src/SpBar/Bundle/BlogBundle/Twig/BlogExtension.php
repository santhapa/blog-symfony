<?php

namespace SpBar\Bundle\BlogBundle\Twig;

class BlogExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('excerpt', array($this, 'truncateContent')),
        );
    }

    public function truncateContent($text, $length=500) {
        $filtered = preg_replace('/(<img[^>]+>)/i', '[IMAGE]', $text);
        $output = substr($filtered, 0, $length);

        return $output;
    }

    public function getName()
    {
        return 'spbar.blog_extension';
    }
}