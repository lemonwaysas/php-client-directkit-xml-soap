<?php
define('DIRECTKIT_WS', 'https://sandbox-api.lemonway.fr/mb/demo/dev/directkitxml/Service.asmx');
define('LOGIN', 'society');
define('PASSWORD', '123456');
define('VERSION', '1.8');
define('LANGUAGE', 'en');
define('UA', isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'ua');
define('DIRECTKIT_WSDL', DIRECTKIT_WS."?wsdl");
/**
 * Get real IP
 * @return real IP
 */
function getUserIP() {
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = "127.0.0.1";
    }
    return $ip;
}

/**
* check if service is online. This method is useless.
* you should simple try catch the "SoapFault" exception when calling "new SoapClient()" and other services
*/
function checkServiceOnline() {
    $options = array(
        CURLOPT_URL            => DIRECTKIT_WSDL,
        CURLOPT_CONNECTTIMEOUT => 60,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_HEADER         => true,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_AUTOREFERER    => true,
    );
    
    $ch = curl_init();
    curl_setopt_array( $ch, $options );
    $response = curl_exec($ch); 
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ( $httpCode == 200 ){
        return true;
    } else {
        $errmsg = "Service unavailable: ".$httpCode." - ".curl_error($ch);
        throw new Exception($errmsg);
    }
}

// if your SoapClient return a fatal error which you couldn't catch it, you can handle the Soap error specifically like this:
// set_error_handler('handlePhpErrors');
// function handlePhpErrors($errno, $errmsg, $filename, $linenum, $vars) {
//     if (stristr($errmsg, "SoapClient::SoapClient")) {
//          error_log($errmsg); // silently log error
//          return; // skip error handling
//     }
// }