<?php
    require __DIR__ . '/vendor/autoload.php';

    /** force https function module */
    $forceHttps = require __DIR__ . '/lib/https.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    use Medoo\Medoo;

    /** set router of PHP api */
    $router = new \Bramus\Router\Router();
    $router->setBasePath("/");

    /** get env file content */
    $envFile = Dotenv\Dotenv::createArrayBacked(__DIR__)->load();
    function env($key, $default = null) {
        global $envFile;

        if(isset($envFile[$key])) {
            return $envFile[$key];
        }

        return $default;
    }

    /** force https */
    if(filter_var(env("FORCE_HTTPS", true), FILTER_VALIDATE_BOOLEAN)) {
        $forceHttps();
    }

    /** error reporting settings */
    if(!filter_var(env("ERROR_REPORTING", true), FILTER_VALIDATE_BOOLEAN)) {
        error_reporting(0);
    }

    /** create database connection with Medoo and \Delight\Auth\Auth */
    $database = $auth = null;
    if(filter_var(env("DB_ENABLED", true), FILTER_VALIDATE_BOOLEAN)) {
        /** Medoo database connection */
        $database = new Medoo(require_once(__DIR__ . "/database/config.php"));

        /** PDO database connection */
        try {
            $db = new DatabaseConnection(env("DB_PORT") . ':host=' . env("DB_HOST") . ';dbname=' . env("DB_NAME"), env("DB_USER"), env("DB_PASS"));
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error!: " . $e->getMessage() . "<br/>");
        }

        /** create \Delight\Auth\Auth instance on PDO database connection */
        $auth = new \Delight\Auth\Auth($db);
    }

    /** get all subdomains */
    $subdomains = array_slice(explode('.', $_SERVER['HTTP_HOST']), 0, -2);

    /** api routes */
    $router->mount("/api", function() use($router, $database, $subdomains) {
        header('Content-Type: application/json; charset=' . env("CHARSET"));

        /** routes for PHP api are defined in /public/router/api.php */
        require_once(__DIR__ . "/router/api.php");
    });

    /** 404 api route */
    $router->set404('/api(/.*)?', function() {
        header('HTTP/1.1 404 Not Found');
        header('Content-Type: application/json; charset=' . env("CHARSET"));

        /** return 404 response */
        echo json_encode([
            "status" => 404,
            "status_text" => "route not defined"
        ]);
    });

    /** client routes -> app.html -> Svelte client router */
    $router->all("/.*", function() {
        header('Content-Type: text/html; charset=' . env("CHARSET"));

        /** always use app.html and Svelte client side router */
        require_once(__DIR__ . '/index.html');
    });

    /** run router -> run whole application */
    $router->run();
