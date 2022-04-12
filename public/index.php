<?php
    require __DIR__ . '/vendor/autoload.php';
    
    $router = new \Bramus\Router\Router();
    $router->setBasePath("/");

    $envFile = Dotenv\Dotenv::createArrayBacked(__DIR__)->load();
    $env = fn($key) => $envFile[$key];

    $subdomains = array_slice(explode('.', $_SERVER['HTTP_HOST']), 0, -2);    

    //php api routes
    $router->mount("/api", function() use($router, $env) {
        header('Content-Type: application/json; charset=utf-8');
        require_once(__DIR__ . "/router/api.php");
    });

    $router->set404('/api(/.*)?', function() {
        header('HTTP/1.1 404 Not Found');
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode([
            "status" => 404,
            "status_text" => "route not defined"
        ]);
    });

    //route to all pages -> index.html -> sveltekit router
    $router->all("/.*", function() {
        header('Content-Type: text/html; charset=utf-8');
        require_once(__DIR__ . '/app.html');
    });

    $router->run();
