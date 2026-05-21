<?php

namespace App\Core;

class MainRouter
{
    private array $routes = [];

    public function get(string $path, array $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post(string $path, array $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }

    private function addRoute(string $method, string $path, array $callback)
    {
        // Convert :param to regex
        $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[$method][] = [
            'pattern'   => $pattern,
            'callback'  => $callback,
            'original'  => $path
        ];
    }

    public function dispatch(string $uri, string $method)
    {
        $uri = $uri === '' ? '/' : $uri;

        if (!isset($this->routes[$method])) {
            http_response_code(404);
            echo "404 - Page not found";
            return;
        }

        foreach ($this->routes[$method] as $route) {
            if (preg_match($route['pattern'], $uri, $matched)) {
                $params = array_filter($matched, 'is_string', ARRAY_FILTER_USE_KEY);

                [$controllerClass, $action] = $route['callback'];
                
                $controller = new $controllerClass();
                
                // Call the method and pass parameters
                $controller->$action($params);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Page not found";
    }

}