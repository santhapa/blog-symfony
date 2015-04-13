<?php

namespace SpBar\Bundle\UserBundle\Twig;

use SpBar\Bundle\UserBundle\Entity\User;

class UserExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('avatar', array($this, 'getAvatar')),
            new \Twig_SimpleFunction('mavatar', array($this, 'getMaleAvatar')),
            new \Twig_SimpleFunction('favatar', array($this, 'getFemaleAvatar')),
            new \Twig_SimpleFunction('userImage', array($this, 'getUserImage')),
        );
    }

    public function getAvatar($gender) {
        if($gender=='Female')
        {
        	return 'dist/img/favatar.jpg';
        }else
        {
        	return 'dist/img/mavatar.png';
        }
    }

    public function getMaleAvatar()
    {
        return 'dist/img/mavatar.png';
    }

    public function getFemaleAvatar()
    {
        return 'dist/img/favatar.jpg';
    }

    public function getUserImage(User $user=null)
    {
        if(!$user->getImage())
        {
            return $this->getAvatar($user->getGender());
        }
        $profileImage = 'uploads/profile/'.$user->getImage();

        return $profileImage;
    }   

    public function getName()
    {
        return 'spbar.user_extension';
    }
}