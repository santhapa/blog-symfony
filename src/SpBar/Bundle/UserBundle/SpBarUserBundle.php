<?php

namespace SpBar\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SpBarUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
