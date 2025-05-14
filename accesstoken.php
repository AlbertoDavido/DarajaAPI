<?php
$consumerkey="kCLIAqjGPC6jh3ZGkhg5SgrbOhplhBf2mSwOyPrlwbe5QT41";//consumer key from Daraja API
$consumersecret="7ZZg4TO88uR2nncXWF5i9uvrPzx0MAFjG1sFuEO5sKsqzeWfsgXI0Nn58W0JMkEe";//consumer secret from Daraja API
$access_token_url="https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";//OAuth token endpoint for the sandbox.
$headers=['Content-Type:application/json; charset=utf8'];
$curl=curl_init($access_token_url);
curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($curl,CURLOPT_HEADER,FALSE);
curl_setopt($curl,CURLOPT_USERPWD,$consumerkey . ':' . $consumersecret);
$result=curl_exec($curl);
$status=curl_getinfo($curl,CURLINFO_HTTP_CODE);
$result=json_decode($result);
echo $access_token=$result->access_token;
curl_close($curl);












