<?php
require_once "./includes.php";

$client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));

//Get the file content
$buffer = file_get_contents('images/test.jpeg', true);

//Upload File
$response = $client->UploadFile(array(
        "wlLogin" => LOGIN,
        "wlPass" => PASSWORD,
        "language" =>LANGUAGE,
        "version" => VERSION,
        "walletIp" => getUserIP(),
        "walletUa" => UA,
        "wallet" => "8888",
        'fileName' => 'test.jpeg',
        'type' => '0',
        'buffer' => $buffer
    ));

//print the response
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

?>
