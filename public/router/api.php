<?php

    $router->all("/test", function() {
        echo json_encode([
            "message" => "hello api",
        ]);
    });
