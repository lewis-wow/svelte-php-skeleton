<?php
    require __DIR__ . '/vendor/autoload.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    use Medoo\Medoo;
    
    $router = new \Bramus\Router\Router();
    $router->setBasePath("/");

    $envFile = Dotenv\Dotenv::createArrayBacked(__DIR__)->load();
    function env($key) {
        global $envFile;
        return $envFile[$key];
    }

    $database = null;
    if(filter_var(env("DB_ENABLED"), FILTER_VALIDATE_BOOLEAN)) {
        $database = new Medoo(require_once(__DIR__ . "/database/config.php"));
    }

    $subdomains = array_slice(explode('.', $_SERVER['HTTP_HOST']), 0, -2);    

    //php api routes
    $router->mount("/api", function() use($router, $database, $subdomains) {
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

    //route to all pages -> index.html -> Svelte router
    $router->all("/.*", function() {
        header('Content-Type: text/html; charset=utf-8');
        require_once(__DIR__ . '/app.html');
    });

    $router->run();
