<?php
namespace SpBar\Bundle\BlogBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use SpBar\Bundle\BlogBundle\Model\CategoryManager;

class DefaultCategorySubscriber implements EventSubscriberInterface
{
	protected $cm; 

	public function __construct(CategoryManager $cm)
	{
		$this->cm = $cm;
	}
    public static function getSubscribedEvents()
    {
        return array(FormEvents::POST_SUBMIT => 'postSubmit');
    }

    public function postSubmit(FormEvent $event)
    {
        $post = $event->getData();
        $form = $event->getForm();

        $cat = $this->cm->getCategoryBySlug('uncategorized');

        if (count($post->getCategory())==0) {
            $post->addCategory($cat);
        }
    }
}