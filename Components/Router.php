<?php

namespace Contacts\Components;

use Exception;

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/Configs/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * @return string
     */
    private function getUri()
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        if (!empty($requestUri)) {
            return trim($requestUri, '/');
        }
    }

    /**
     * @throws /Exception
     */
    public function run()
    {
        if ($this->handleCrossOriginRequest()) {
            return;
        }

        $uri = $this->getUri();
        $routeFound = false;

        foreach ($this->routes as $uriPattern => $path) {

            if (!preg_match("~$uriPattern~", $uri)) {
                continue;
            }

            $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

            $segments = explode('/', $internalRoute);

            $controllerName = ucfirst(array_shift($segments)) . 'Controller';
            $actionName = 'action' . ucfirst(array_shift($segments));

            $parameters = $segments;

            $controllerFile = ROOT . '/Controllers/' . $controllerName . '.php';

            if (!file_exists($controllerFile)) {
                throw new Exception('Controller not found');
            }

            $controllerName = 'Contacts\\Controllers\\' . $controllerName;
            $controllerObject = new $controllerName();
            $result = call_user_func_array([$controllerObject, $actionName], $parameters);

            if ($result) {
                $routeFound = true;
                break;
            }
        }
        if (!$routeFound) {
            throw new Exception('Route not found');
        }
    }

    /**
     * @return bool
     */
    private function handleCrossOriginRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
            return false;
        }
        new JsonResponse('success', '');
        return true;
    }
}