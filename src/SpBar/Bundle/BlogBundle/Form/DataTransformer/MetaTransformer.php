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
    }

    /**
     * Transforms a string (source) to an object (meta).
     */
    public function reverseTransform($source)
    {
        if (!$source) {
            return null;
        }
        $meta = new ArrayCollection();

        foreach (explode(',', $source) as $src) {

            $mt = $this->pm->getPostMetaBySource($src);

            if (null === $mt) {
                $mt = $this->pm->createPostMeta();
                $mt->setSource($src);
                $this->pm->updatePostMeta($mt, false);
            }

            $meta[] = $mt;
        }
        return $meta;
    }
}