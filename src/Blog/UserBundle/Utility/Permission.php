<?php

namespace Blog\UserBundle\Utility;

class Permission{

	//container service
	private $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function isGranted()
	{
		$request = $this->container->get('request');
		$routeName = $request->get('_route');

		$role = 'ROLE_'.strtoupper($routeName);

		if($this->container->get('security.authorization_checker')->isGranted($role))
			return true;
		else 
			return false;
	}

}

?>