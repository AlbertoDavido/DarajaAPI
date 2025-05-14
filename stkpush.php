<?php
include "accesstoken.php";
// 1. Credentials
$consumerKey = 'kCLIAqjGPC6jh3ZGkhg5SgrbOhplhBf2mSwOyPrlwbe5QT41';
$consumerSecret = '7ZZg4TO88uR2nncXWF5i9uvrPzx0MAFjG1sFuEO5sKsqzeWfsgXI0Nn58W0JMkEe';
$shortCode = '174379'; // Sandbox Shortcode
$passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'; // Get from Daraja portal
$phoneNumber = '254115079563'; // Test number
$amount = '1'; // Amount in KES

// 2. Get Access Token
$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
$result = curl_exec($curl);
$result = json_decode($result);
$access_token = $result->access_token;
curl_close($curl);

// 3. Prepare STK Push Request
$timestamp = date('YmdHis');
$password = base64_encode($shortCode . $passkey . $timestamp);

$stkPushUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $stkPushUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);

$callbackUrl = 'https://your-ngrok-url.ngrok.io/callback'; // Replace with your own URL

$postData = [
    'BusinessShortCode' => $shortCode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $amount,
    'PartyA' => $phoneNumber,
    'PartyB' => $shortCode,
    'PhoneNumber' => $phoneNumber,
    'CallBackURL' => $callbackUrl,
    'AccountReference' => 'TestRef001',
    'TransactionDesc' => 'Testing STK Push from PHP'
];

curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #: " . $err;
} else {
    echo "STK Push Request Sent Successfully:\n";
    echo $response;
}



















































