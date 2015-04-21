<?php

namespace SpBar\Bundle\BlogBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Doctrine\Common\Collections\ArrayCollection;
use SpBar\Bundle\BlogBundle\Model\PostMetaManager;
 
class MetaTransformer implements DataTransformerInterface
{
    private $pm;

    public function __construct(PostMetaManager $pm)
    {
        $this->pm = $pm;
    }

    /**
    * Transforms an object (meta) to a array (source).
    */
    public function transform($metas)
    {
        if(count($metas)==0)
        {
            return;
        }

        $temp = array();
        foreach ($metas as $meta) {
            $temp[] = $meta->getSource();
        }
        return implode(',', $temp);




        // echo "<pre>";
        // print_r($metas);
        // echo "</pre>";
        // // if (!$meta) {
        // //     echo "hello1";
        // //     return "";
        // // }
        // // echo "hello2";
        // // exit;
        // // return $meta->getSource();


        // $newMetas = array();
        // echo "c".count($metas);
        // if(count($metas)==0)
        // {
        //     echo "funny";
        // }
 
        // if (!($metas instanceof ArrayCollection) || $metas==null) {
        //     echo "hello1"; exit;
        //     return new ArrayCollection();
        // }
        // echo "hello2";
 
        // foreach ($metas as $key => $value) {
        //     $newMetas[] = $value;
        // }
        // echo "<pre>";
        // print_r($newMetas);
        // echo "</pre>";
        // exit;
 
        // return new ArrayCollection($newMetas);

    }

    /**
     * Transforms a string (source) to an object (meta).
     */
    public function reverseTransform($source)
    {
        if (!$source) {
            return null;
        }

        $meta = $this->pm->getPostMetaBySource($source);

        if (null === $meta) {
            $meta = $this->pm->createPostMeta();
            $meta->setSource($source);
            $this->pm->updatePostMeta($meta, false);
        }

        return $meta;
    }
}