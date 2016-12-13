<?php
define('DIRECTKIT_WS', 'https://sandbox-api.lemonway.fr/mb/demo/dev/directkitxml/Service.asmx');
define('LOGIN', 'society');
define('PASSWORD', '123456');
define('VERSION', '1.8');
define('LANGUAGE', 'en');
define('UA', isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'ua');

/**
 * Get real IP
 * @return real IP
 */
function getUserIP() {
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}
?>
