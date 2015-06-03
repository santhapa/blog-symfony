<?php

namespace SpBar\Bundle\BlogBundle\Form\Type\Post;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

use SpBar\Bundle\BlogBundle\Model\TemplateManager;
use SpBar\Bundle\BlogBundle\Model\PostManager;
use SpBar\Bundle\BlogBundle\Model\CategoryManager;

use SpBar\Bundle\BlogBundle\Form\EventListener\DefaultCategorySubscriber;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class NewFormType extends AbstractType
{   
    protected $tm;

    protected $cm;

    protected $authorizer;

    protected $token;

    public function __construct(TemplateManager $tm, CategoryManager $cm, $auth=null, $token=null)
    {
        $this->tm = $tm;
        $this->cm = $cm;
        $this->authorizer = $auth;
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $postType = $this->tm->getTemplatesByType('postType');
        $generalPost = $this->tm->getTemplateBySlug('general');

        $builder->add('title', 'text', array(
                        'label' => 'Title of the Post',
                        'attr' => array('placeholder'=>"Title of the Post"),
                        'required'=>true
                    ))
                // ->add('content', 'textarea', array(
                //         'label' => 'Content',
                //         'attr' => array("class"=>"ckeditor"),
                //         'required'=>true
                //     ))
                ->add('content', 'ckeditor', array(
                    'config' => array(
                        'filebrowser_image_browse_url' => array(
                            'route'            => 'elfinder',
                            'route_parameters' => array('instance' => 'ckeditor'),
                        ),
                    ),
                ))
                ->add('postType', 'entity', array(
                        'label' => 'Post Type',
                        'attr' => array('class'=>'spbar-post-type'),
                        'class' => 'SpBarBlogBundle:Template',
                        'property' => 'name',
                        'choices' => $postType,                        
                        'preferred_choices' => array($generalPost),
                        'data' => $generalPost,
                        'expanded' => true,
                        'multiple' => false,
                        'required' => true
                    ))

                // ->add('image', 'file')
                // ->add('meta','elfinder', array('instance'=>'form', 'enable'=>true, 'required'=> false))
                ->add('metas', 'spbar_blog_post_meta', array(
                        'attr' => array('class'=>'spbar-meta'),
                        'required'=> false
                    ))
                ->add('category', 'entity', array(
                        'label' => 'Category',
                        'class'=> 'SpBarBlogBundle:Category',
                        'property'=> 'name',
                        'empty_data'=> 'Uncategorized',
                        'expanded' => true,
                        'multiple' => true,
                        'required' => true
                    ))                
                ->add('tags', 'spbar_blog_post_tag', array(
                        'required'=>false
                    ))
                ->add('status', 'choice', array(
                        'label' => 'Publish',
                        'choices' => PostManager::$newPostStatus,
                        'data' => '1',
                        'required' => true
                    ))
        ;

        if($this->authorizer->isGranted('ROLE_BLOG_ADMIN'))
        {
            $builder->add('author', 'entity', array(
                    'class' => 'SpBarUserBundle:User',
                    'property' => 'username',
                    'placeholder' => 'Select Author',
                    'data' => $this->token->getToken()->getUser(),
                    'required' => true
                ));
        }

        // $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        // $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

        $builder->addEventSubscriber(new DefaultCategorySubscriber($this->cm));

    }

    // protected function addElements(FormInterface $form, $postType = null) {

    //     if($postType->getSlug() == 'audio_post') {
    //         // Fetch the cities from specified province
    //         $label = "Select Audio File";
    //     }elseif ($postType->getSlug() == 'video_post') {
    //         $label = "Upload video file";
    //     }else{
    //         $label = "Set Featured Image";
    //     }

    //     // Add the city element
    //     $form->add('metas', 'spbar_blog_post_meta', array(
    //                     'label'=> $label,
    //                     'required'=> false
    //                 ));
    // }


    // function onPreSubmit(FormEvent $event) {
    //     $form = $event->getForm();
    //     $data = $event->getData();

    //     // Note that the data is not yet hydrated into the entity.
    //     // $province = $this->em->getRepository('NoxLogicDemoBundle:Province')->find($data['province']);
    //     // $this->addElements($form, $province);

    //     $postType = $this->tm->getTemplateById($data['postType']);
    //     $this->addElements($form, $postType);
    // }


    // function onPreSetData(FormEvent $event) {
    //     $post = $event->getData();
    //     $form = $event->getForm();

    //     // We might have an empty account (when we insert a new account, for instance)
    //     // $province = $account->getCity() ? $account->getCity()->getProvince() : null;
    //     // $this->addElements($form, $province);
    //     $postType = $post->getPostType() ? $post->getPostType() : $this->tm->getTemplateBySlug('general');
    //     $this->addElements($form, $postType);
    // }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'spbar_blog_post_new';
    }
}
