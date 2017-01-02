<?php
require_once "./includes.php";

$client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));

$response = $client->GetWalletTransHistory(array(
        "wlLogin" => LOGIN,
        "wlPass" => PASSWORD,
        "language" => LANGUAGE,
        "version" => VERSION,
        "walletIp" => getUserIP(),
        "walletUa" => UA,
        "wallet" => "8888"
    ));


//print the response
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

/*
 {
    "GetWalletTransHistoryResult": {
        "TRANS": {
            "HPAY": [
                {
                    "ID": "3627",
                    "DATE": "03\/05\/2016 14:36:04",
                    "SEN": "",
                    "REC": "8888",
                    "DEB": "0.00",
                    "CRED": "12.00",
                    "COM": "0.00",
                    "MSG": "",
                    "STATUS": "4",
                    "EXTRA": {
                        "IS3DS": "1",
                        "CTRY": "",
                        "AUTH": ""
                    },
                    "INT_MSG": "05-99-51-ERR_PSP_REFUSED",
                    "MLABEL": "",
                    "TYPE": "0",
                    "MTOKEN": "f49fac0fcdb949539671b27aadd51c43"
                },
  ....
 */
?>