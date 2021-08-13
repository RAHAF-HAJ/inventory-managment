<?php

namespace App\Controller\API\V1;

class ApiController
{
    public function __construct()
    {
        $p = $_GET['p'];
        $p = explode('/', rtrim($p, '/'));
        $controllerName = $p[0];
        $action = $p[1];
        $controller = '\App\Controller\\' . ucfirst($controllerName) . 'Controller';
        $controller = new  $controller();
        $controller->$action();
        exit();
    }
}
