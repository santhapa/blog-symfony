<?php

namespace Blog\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Blog\RouteSecureBundle\Entity\Route;

class RouteController extends Controller
{
    public function indexAction()
    {
    	if(isset($_POST['refreshRoutes']))
    		$this->refreshRoutes();

    	//get routes already listed on database
	    $em = $this->getDoctrine() ->getManager();
	    $routes = $em->getRepository('BlogUserBundle:Route')->getRoutesArray();

        return $this->render('BlogUserBundle:Route:index.html.twig', array(
        	'routes' => $routes
        ));
    }

    public function refreshRoutes()
    {
    	//set environment to prod for getting production environment routes
    	$kernel = new \AppKernel('prod', true);
	    $kernel->boot();

	    $router = $kernel->getContainer()->get('router');
	    $allRoutes = $router->getRouteCollection()->all();

	    
	    $routes = array();
	    $routePath = array();
	    foreach ($allRoutes as $route => $params)
	    {
	        $defaults = $params->getDefaults();
	        $url = $params->getPath();

	        if (isset($defaults['_controller']))
	        {
	            $controllerAction = explode(':', $defaults['_controller']);
	            $controller = $controllerAction[0];

	            if (!isset($routes[$controller])) {
	                $routes[$controller] = array();
	            }

	            $routes[$controller][$route]['name']= $route;
	            $routes[$controller][$route]['url']= $url;
	        }
	        $routePath[] = $route;
	    }

	    //get routes already listed on database
	    $em = $this->getDoctrine() ->getManager();
	    $routeObj = $em->getRepository('BlogUserBundle:Route')->findAll();
	    $dbRoutes = array();

	    if($routeObj)
	    {
	    	foreach ($routeObj as $rt) {
		    	$dbRoutes[] = $rt->getPathName();
		    }
	    }

	    foreach ($routes as $c => $rtArray) {
	    	foreach ($rtArray as $r) {
	    		if(!in_array($r['name'], $dbRoutes))
	    		{
	    			$em->getRepository('BlogUserBundle:Route')->addRoute($c, $r['name'], $r['url']);
	    		}
	    	}
	    }

	    //removing old pre-existed routes
    	foreach ($dbRoutes as $dbRt) 
    	{
    		if(!(in_array($dbRt, $routePath)))
    		{
    			$em->getRepository('BlogUserBundle:Route')->removeRoute($dbRt);
    		}
    	}
	    $em->flush();

	    return true;
    }
}
