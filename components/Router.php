<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * function getURI
     * Return request string
     * */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        // Получить строку запроса к серверу
        $uri = $this->getURI();

        // Проверить наличие такого запроса в routers.php
        foreach ($this->routes as $uriPattern => $path) {

            // Сравниваем $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {

                // Определить какой контроллер
                //и action обрабатывают запрос
                $segments = explode('/', $path);

                $controllersName = array_shift($segments) . 'Controller';
                $controllersName = ucfirst($controllersName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                // Подключить файл класса контроллер
                $controllerFile = ROOT . '/controllers/' . $controllersName . '.php';

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);

                }

                // Создать объект, вызвать метод (т.е. action)

                $controllerObject = new $controllersName;
                $result = $controllerObject->$actionName();
                if ($result != null) {
                    break;
                }
            }
        }
    }
}
