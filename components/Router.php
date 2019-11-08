<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include("$routesPath");
    }

    public function run()
    {
        // Получить строку запроса к серверу
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = trim($_SERVER['REQUEST_URI'], '/');
        }
        var_dump($uri);
    }
}
