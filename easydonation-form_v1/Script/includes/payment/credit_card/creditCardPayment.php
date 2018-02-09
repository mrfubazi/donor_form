<?php 
session_start();

/* This is must to include here*/
include '../../../configuration.php';
include '../../functions/autoload.php';
include "../../languages/".$_POST['language'].".php";
$_SESSION['language']=$_POST['language'];
$mainObj=new Main();

/******************************/

$sandbox = TRUE;

// Set PayPal API version and credentials.
$api_version = '95.0';
$api_endpoint = $sandbox ? $apiEndPointA : $apiEndPointB;
$api_username = $sandbox ? $apiUserName : 'LIVE_USERNAME_GOES_HERE';
$api_password = $sandbox ? $apiPassword : 'LIVE_PASSWORD_GOES_HERE';
$api_signature = $sandbox ? $apiSignature : 'LIVE_SIGNATURE_GOES_HERE';

// benevolent Account Detail
$amount = trim($_POST['mc_gross']);
$creditCardNumber = trim($_POST['creditCardNumber']);
$creditCardType = trim($_POST['creditCardType']);
$csv = trim($_POST['csv']);
$expdate = trim($_POST['expDate']);
$currencyCode=$_POST['mc_currency'];

//End 

$request_params = array
                    (
                    'METHOD' => 'DoDirectPayment',
                    'USER' => $api_username,
                    'PWD' => $api_password,
                    'SIGNATURE' => $api_signature,
                    'VERSION' => $api_version,
                    'PAYMENTACTION' => 'Sale',                  
                    'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
                    'CREDITCARDTYPE' =>$creditCardType,
                    'ACCT' => $creditCardNumber,                       
                    'EXPDATE' => $expdate,          
                    'CVV2' => $csv,                                       
                    'AMT' => $amount,
                    'CURRENCYCODE' => $currencyCode,
                    'DESC' => 'Testing Payments Pro'
                    );




$nvp_string = '';
foreach($request_params as $var=>$val)
{
    $nvp_string .= '&'.$var.'='.urlencode($val);   
}

$curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $api_endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
 
$result = curl_exec($curl);    
curl_close($curl);


$nvp_response_array = parse_str($result);
$_SESSION['amount']=$AMT;
echo $ACK.'###'.$AMT;
$_POST['paymentDate']=$TIMESTAMP;
$_POST[txn_id]=$TRANSACTIONID;
    $_SESSION["creditcardsession"]=$_POST;
if($ACK=="Success"){
    $mainObj->sendMailTo($_POST,2);
}else{
    echo FAIL;
}



?>
