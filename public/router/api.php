<?php

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    use Medoo\Medoo;

    require_once 'lib/bearerToken.php'; //Bearer class

    /** data = POST and GET data sent from client */
    $data = json_decode(file_get_contents('php://input'), true);
    $token = new Bearer(env("JWT_KEY"));

    //test - should be removed!
        $router->all("/test", function() use($data) {
            echo json_encode([
                "message" => "hello api",
                "data" => $data
            ]);
        });
    //!test - should be removed!

    //auth template - should be edited!
    $router->post("/login", function() use($data, $token, $database) {
        $password = password_hash($data["password"], PASSWORD_DEFAULT);

        $result = $database->select("users", ["email", "username"], [
            "email" => $data["email"],
            "password" => $password
        ]);

        $bearerToken = $token->createToken($result);

        echo json_encode([
            "token" => $bearerToken
        ]);
    });

    $router->post("/register", function() use($data, $token, $database) {
        $password = password_hash($data["password"], PASSWORD_DEFAULT);

        $database->insert("users", [
            "email" => $data["email"],
            "username" => $data["username"],
            "password" => $password
        ]);

        $bearerToken = $token->createToken([
            "email" => $data["email"],
            "username" => $data["username"]
        ]);

        echo json_encode([
            "token" => $bearerToken
        ]);
    });

    $router->post("/isLoggedIn", function() use($data, $token, $database) {
        $bearerToken = $token->getToken();

        if(!$bearerToken) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode([
                "status" => 400,
                "status_text" => "no token"
            ]);
            exit;
        }
        //verify token
        $dataFromToken = $token->verifyToken($bearerToken);
        if(!$dataFromToken) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode([
                "status" => 400,
                "status_text" => "no token"
            ]);
            exit;
        }

        echo json_encode([
            "tokenData" => $dataFromToken
        ]);
    });
