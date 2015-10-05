<?php

namespace SpBar\Bundle\BlogBundle\Twig;

class BlogExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('excerpt', array($this, 'truncateContent')),
            new \Twig_SimpleFunction('minifyTitle', array($this, 'getMinifiedTitle')), 
            new \Twig_SimpleFunction('is_home', array($this, 'isHomeUrl')), 
            // new \Twig_SimpleFunction('featuredImage', array($this, 'showFeaturedImage')),
        );
    }

    public function truncateContent($text, $length=500) {
        $filtered = preg_replace('/(<img[^>]+>)/i', '[IMAGE]', $text);
        $output = substr($filtered, 0, $length);

        return $output;
    }

    public function getMinifiedTitle($title, $length=null, $minify = true)
    {
        if($minify==false)
        {
            return $title;
        }
        if(strlen($title) >= $length)
        {
            return substr($title, 0, $length)."...";
        }else{
            return $title;
        }
    }
    public function isHomeUrl($route)
    {
        if($route == 'sp_blog_front_home_index')
        {
            return true;
        }else{
            return false;
        }
    }

    // public function showFeaturedImage($path)
    // {
    //     if(!$path || $path==null)
    //     {
    //         return 'blog/images/featured/default.jpg';
    //     }else{
    //         return 'uploads/elfinder/featured/'.
    //     }
    // }



    public function getName()
    {
        return 'spbar.blog_extension';
    }
}