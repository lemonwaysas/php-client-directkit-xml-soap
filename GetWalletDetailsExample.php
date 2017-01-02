<?php
require_once "./includes.php";
try {
    $client = new SoapClient(DIRECTKIT_WSDL, array("trace"=>false, "exceptions"=>true));
    $response = $client->GetWalletDetails(array(
            "wlLogin" => LOGIN,
            "wlPass" => PASSWORD,
            "language" => LANGUAGE,
            "version" => VERSION,
            "walletIp" => getUserIP(),
            "walletUa" => UA,
            "wallet" => "8888"
        ));

    echo "---------- Wallet 8888: ----------";
    echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

    $response_error = $client->GetWalletDetails(array(
            "wlLogin" => LOGIN,
            "wlPass" => PASSWORD,
            "language" => LANGUAGE,
            "version" => VERSION,
            "walletIp" => getUserIP(),
            "walletUa" => UA,
            "wallet" => "NotExist"
        ));

    echo "---------- Wallet NotExist: ----------";
    echo "<pre>".json_encode($response_error, JSON_PRETTY_PRINT)."</pre>";
}
catch (SoapFault $e) 
{
    //die(var_dump($e));
    die("Something wrong with the webservice");
}