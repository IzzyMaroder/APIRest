<?php
include_once './app/controllers/OrdersController.php';
include_once './app/controllers/ProductsController.php';
include_once './app/controllers/CO2Controller.php';

class Router
{
    protected $routes;

    function load($routes)
    {
        $this->routes = $routes;
    }

    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        throw new Exception('No route defined for this URI.');
    }

    protected function callAction($controller, $action)
    {
        $controller = new $controller;

        if (! method_exists($controller, $action)) {
            throw new Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action();
    }
}


