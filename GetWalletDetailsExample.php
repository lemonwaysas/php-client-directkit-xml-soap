<?php
require_once "./includes.php";

$client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exception"=>0));

$response = $client->GetWalletDetails(array(
        "wlLogin" => LOGIN,
        "wlPass" => PASSWORD,
        "language" => "fr",
        "version" => VERSION,
        "walletIp" => getUserIP(),
        "walletUa" => UA,
        "wallet" => "8888"
    ));


//print the response
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre";
/*
 {
    "GetWalletDetailsResult": {
        "WALLET": {
            "ID": "8888",
            "BAL": "622.00",
            "NAME": "Barack OBAMA",
            "EMAIL": "hduong8888@lemonway.fr",
            "DOCS": {},
            "IBANS": {},
            "STATUS": "6",
            "BLOCKED": "0",
            "SDDMANDATES": {},
            "LWID": "45",
            "CARDS": {
                "CARD": {
                    "ID": "16",
                    "EXTRA": {
                        "IS3DS": "0",
                        "CTRY": "",
                        "AUTH": "585314",
                        "NUM": "501767XXXXXX6700",
                        "EXP": "05\/2019",
                        "TYP": "CB"
                    }
                }
            }
        }
    }
}
 */



$response_error = $client->GetWalletDetails(array(
        "wlLogin" => LOGIN,
        "wlPass" => PASSWORD,
        "language" => "fr",
        "version" => VERSION,
        "walletIp" => getUserIP(),
        "walletUa" => UA,
        "wallet" => "NotExist"
    ));
//print the response
echo "<pre>".json_encode($response_error, JSON_PRETTY_PRINT)."</pre>";
/*
{
    "GetWalletDetailsResult": {
        "E": {
            "Error": "",
            "Code": "147",
            "Msg": "Identifiant inexistant",
            "Prio": "2"
        }
    }
}
*/