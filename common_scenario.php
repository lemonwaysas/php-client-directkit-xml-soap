<?php
require_once "./includes.php";

$client = new SoapClient(DIRECTKIT_WS."?wsdl", array("trace"=>true, "exceptions"=>true));

// ---------- Register a Payer Wallet ----------
$payerWallet = uniqid("PHP-PAYER-");

$response = $client->RegisterWallet(array(
    "wlLogin" 						=> LOGIN,
    "wlPass" 						=> PASSWORD,
    "language" 						=> LANGUAGE,
    "version" 						=> VERSION,
    "walletIp" 						=> getUserIP(),
    "walletUa" 						=> UA,
    "wallet" 						=> $payerWallet,
    "clientMail" 					=> $payerWallet . "@lemonway.com",
	"clientFirstName" 				=> "Payer",
	"clientLastName" 				=> "Payer"
));
//print the response
echo "---------- Payer Wallet created: " . $payerWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// ---------- GetWalletDetails with wallet ID ----------
$response = $client->GetWalletDetails(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "wallet" 	=> $payerWallet
));
//print the response
echo "---------- Payer Wallet: " . $payerWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// ---------- Register a Receiver Wallet ----------
$receiverWallet = uniqid("PHP-RECEIVER-");

$response = $client->RegisterWallet(array(
    "wlLogin" 						=> LOGIN,
    "wlPass" 						=> PASSWORD,
    "language" 						=> LANGUAGE,
    "version" 						=> VERSION,
    "walletIp" 						=> getUserIP(),
    "walletUa" 						=> UA,
    "wallet" 						=> $receiverWallet,
    "clientMail" 					=> $receiverWallet . "@lemonway.com",
	"clientFirstName" 				=> "Receiver",
	"clientLastName" 				=> "Receiver"
));
//print the response
echo "---------- Receiver Wallet created: " . $receiverWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// ---------- GetWalletDetails with email ----------
$response = $client->GetWalletDetails(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "email" 	=> $receiverWallet . "@lemonway.com"
));
//print the response
echo "---------- Receiver Wallet: " . $receiverWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// --------- Update email for Receiver Wallet ----------
$response = $client->UpdateWalletDetails(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "wallet" 	=> $receiverWallet,
    "newEmail" 	=> "new-" . $receiverWallet . "@lemonway.com"
));
//print the response
echo "---------- Update email of Receiver: " . $receiverWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// ---------- Receiver Wallet with the new email ----------
$response = $client->GetWalletDetails(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "wallet" 	=> $receiverWallet
));
//print the response
echo "---------- Receiver Wallet " . $receiverWallet . " with the new email ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// --------- Register a card for Payer Wallet ----------
$response = $client->RegisterCard(array(
    "wlLogin" 		=> LOGIN,
    "wlPass" 		=> PASSWORD,
    "language" 		=> LANGUAGE,
    "version" 		=> VERSION,
    "walletIp" 		=> getUserIP(),
    "walletUa" 		=> UA,
    "wallet" 		=> $payerWallet,
    "cardType" 		=> "1",
    "cardNumber" 	=> "5017670000006700",
    "cardCode" 		=> "123",
    "cardDate" 		=> "12/2026"
));
//print the response
echo "---------- Card registered for Payer " . $payerWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

$cardId = $response->RegisterCardResult->CARD->ID;

// --------- Pay with the registered card into Payer Wallet ----------
$response = $client->MoneyInWithCardId(array(
    "wlLogin" 		=> LOGIN,
    "wlPass" 		=> PASSWORD,
    "language" 		=> LANGUAGE,
    "version" 		=> VERSION,
    "walletIp" 		=> getUserIP(),
    "walletUa" 		=> UA,
    "wallet" 		=> $payerWallet,
    "cardId" 		=> $cardId,
    "amountTot" 	=> "100.00",
    "amountCom" 	=> "10.00",
    "comment" 		=> "(PHP tuto) MoneyInWithCardId 100.00€ to Payer"
));
//print the response
echo "---------- MoneyInWithCardId: 100.00€ to Payer " . $payerWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// --------- Payer Wallet after the payment with card: 100.00 - 10.00 = 90.00 (€) ----------
$response = $client->GetWalletDetails(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "wallet" 	=> $payerWallet
));
//print the response
echo "---------- Payer Wallet credited: " . $payerWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// --------- Payer send 10.00€ to Receiver ----------
$response = $client->SendPayment(array(
    "wlLogin" 		=> LOGIN,
    "wlPass" 		=> PASSWORD,
    "language" 		=> LANGUAGE,
    "version" 		=> VERSION,
    "walletIp" 		=> getUserIP(),
    "walletUa" 		=> UA,
    "debitWallet" 	=> $payerWallet,
    "creditWallet" 	=> $receiverWallet,
    "amount" 		=> "10.00",
    "message" 		=> "(PHP tuto) SendPayment 10.00€ from Payer to Receiver"
));
//print the response
echo "---------- SendPayment: 10.00€ from Payer " . $payerWallet . " to Receiver " . $receiverWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// --------- Payer Wallet after the transaction: 80.00€ ----------
$response = $client->GetWalletDetails(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "wallet" 	=> $payerWallet
));
//print the response
echo "---------- Payer Wallet debited: " . $payerWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// --------- Receiver Wallet after the transaction: 10.00€ ----------
$response = $client->GetWalletDetails(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "wallet" 	=> $receiverWallet
));
//print the response
echo "---------- Receiver Wallet debited: " . $receiverWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// --------- Receiver register an IBAN ----------
$response = $client->RegisterIBAN(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "wallet" 	=> $receiverWallet,
    "holder" 	=> "Receiver Receiver",
    "bic" 		=> "ABCDEFGHIJK",
    "iban" 		=> "FR1420041010050500013M02606",
    "dom1" 		=> "UNEBANQUE MONTREUIL",
    "dom2" 		=> "56 rue de Lays",
    "comment" 	=> "(PHP tuto) Register IBAN"
));
//print the response
echo "---------- Receiver Wallet: " . $receiverWallet . " register an IBAN ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// --------- Receiver Wallet with an IBAN registered ----------
$response = $client->GetWalletDetails(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "wallet" 	=> $receiverWallet
));
//print the response
echo "---------- Receiver Wallet " . $receiverWallet . " with an IBAN ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

$ibanId = $response->GetWalletDetailsResult->WALLET->IBANS->IBAN->ID;

// Receiver do a Money Out with the registered IBAN
$response = $client->MoneyOut(array(
    "wlLogin" 			=> LOGIN,
    "wlPass" 			=> PASSWORD,
    "language" 			=> LANGUAGE,
    "version" 			=> VERSION,
    "walletIp" 			=> getUserIP(),
    "walletUa" 			=> UA,
    "wallet" 			=> $receiverWallet,
    "amountTot" 		=> "10.00",
    "message" 			=> "(PHP tuto) Money Out 10.00€",
    "ibanId" 			=> $ibanId,
    "autoCommission" 	=> "1"
));
//print the response
echo "---------- Money Out: Receiver takes 10.00 € from Receiver Wallet " . $receiverWallet . " ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";

// ---------  Receiver Wallet after the Money Out: 0.00€ ----------
$response = $client->GetWalletDetails(array(
    "wlLogin" 	=> LOGIN,
    "wlPass" 	=> PASSWORD,
    "language" 	=> LANGUAGE,
    "version" 	=> VERSION,
    "walletIp" 	=> getUserIP(),
    "walletUa" 	=> UA,
    "wallet" 	=> $receiverWallet
));
//print the response
echo "---------- Receiver Wallet " . $receiverWallet . " after Money Out ----------";
echo "<pre>".json_encode($response, JSON_PRETTY_PRINT)."</pre>";
?>