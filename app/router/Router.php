<?php

namespace RouterNamespace;

class Router
{
    private $routes;
    private $url;

    public function __construct()
    {
        $this->routes = [];
        $this->url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }
    public function get(string $path, callable $callback)
    {
        $this->routes["GET"][$path] = $callback;
    }

    public function post(string $path, callable $callback): void
    {
        $this->routes["POST"][$path] = $callback;
    }

    public function put(string $path, callable $callback): void
    {
        $this->routes["PUT"][$path] = $callback;
    }

    public function DELETE(string $path, callable $callback): void
    {
        $this->routes["DELETE"][$path] = $callback;
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $this->url;

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $callback) {
                // Utilisation de la fonction 'preg_match' pour comparer les URL avec des expressions régulières
                if (preg_match("#^" . $route . "$#", $path, $matches)) {
                    array_shift($matches); // Suppression du premier élément qui contient l'URL complète
                    $callback(...$matches); // Appel de la fonction de rappel avec les paramètres capturés
                    return;
                }
            }
        }

        echo "404 Not Found";
    }
}
