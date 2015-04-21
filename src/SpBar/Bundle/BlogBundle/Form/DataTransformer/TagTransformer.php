<?php

namespace SpBar\Bundle\BlogBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;
use SpBar\Bundle\BlogBundle\Entity\Tag;

use SpBar\Bundle\BlogBundle\Model\TagManager;
 
class TagTransformer implements DataTransformerInterface
{
    private $tm;

    public function __construct(TagManager $tm)
    {
        $this->tm = $tm;
    }

    /**
    * Transforms an object (tag) to a string (name).
    */
    public function transform($tags)
    {
        if(count($tags)==0)
        {
            return;
        }

        $temp = array();
        foreach ($tags as $tag) {
            $temp[] = $tag->getName();
        }

        return implode(',', $temp);
    }

    /**
     * Transforms a string (name) to an object (tag).
     */
    public function reverseTransform($name)
    {
        if (!$name) {
            return null;
        }

        $tag = new ArrayCollection();

        foreach (explode(',', $name) as $n) {

            $tg = $this->tm->getTagByName($n);

            if (null === $tg) {
                $tg = $this->tm->createTag();
                $tg->setName($n);
                $this->tm->updateTag($tg, false);
            }

            $tag[] = $tg;
        }
        return $tag;
    }
}