<?php
    //https://stackoverflow.com/questions/85816/how-can-i-force-users-to-access-my-page-over-https-instead-of-http
    function isSecure() {
        return (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443
        || (
                (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            || (!empty($_SERVER['HTTP_X_FORWARDED_SSL'])   && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
            )
        );
    }

    return function () {
        if (!isSecure()) {
            header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], TRUE, 301);
            exit;
        }
    };
