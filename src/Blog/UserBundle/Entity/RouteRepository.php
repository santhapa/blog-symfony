<?php

namespace Blog\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Blog\UserBundle\Entity\Route;

class RouteRepository extends EntityRepository
{
	public function addRoute($controller, $name, $url)
	{
		$route = new Route();

		$route->setController($controller);
		$route->setPathName($name);
		$route->setUrl($url);

		$entityManager = $this->getEntityManager();
		
		$entityManager->persist($route);
	}

	public function getRoutesArray()
	{
		$routes = $this->findBy(array(), array('controllerClass' => 'ASC'));

		$rt = array();
	    foreach ($routes as $route) {
	    	$rt[$route->getController()][$route->getPathName()]['id'] = $route->getId();
	    	$rt[$route->getController()][$route->getPathName()]['name'] = $route->getPathName();
	    	$rt[$route->getController()][$route->getPathName()]['desc'] = $route->getDescription();	    	
	    	$rt[$route->getController()][$route->getPathName()]['url'] = $route->getUrl();
	    }

	    return $rt;
	}

	public function removeRoute($p)
	{
		$route = $this->findOneBy(array('pathName' => $p));

		if($route)
		{
			$entityManager = $this->getEntityManager();
			$entityManager->remove($route);
		}
		

		return;
	}

}