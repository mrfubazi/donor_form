<?php

session_start();
include 'configuration.php';
include 'includes/functions/autoload.php';
global $valuesInXml;
global $xml;

//Setting default language 
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = "en";
}
if (isset($_POST['language']) && $_POST['language'] != "") {
    $_SESSION['language'] = $_POST['language'];
}
include "includes/languages/" . $_SESSION['language'] . ".php";
//End Setting default language 

//Validation For site config url
if($installed){

$requestedPath='https://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
if($sitePath."index.php"!=$requestedPath){
$install=simplexml_load_file('includes/install/info.xml');

$install->is_install=0;
$install->asXML('includes/install/info.xml');
$instFile=  file_get_contents('includes/install/config-templates.php');
$instFile = str_replace('[REQUESTURL]', "", $instFile);
$instFile = str_replace('[INSTALLED]', '0', $instFile);
file_put_contents('configuration.php', $instFile);
sleep(5);
$redirectPath="https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
header('location:'.$redirectPath); 
}}
//Validation For site config url




// Validation for Currency Dropdown
if (file_exists('includes/dropdownXml/currency.xml')) {
    $xml = (array) simplexml_load_file('includes/dropdownXml/currency.xml');
     $valuesInXml = count($xml['value']);
    $nameInXml = count($xml['name']);
    if ($valuesInXml != $nameInXml) {
        echo CURRENCYNOTFOUNDERROR;
        exit();
    }
}
$selected = "";

if (in_array(DEFAULT_CURRENCY, $xml['value'])) {
    $selected = DEFAULT_CURRENCY;
    $selected_currency_sign = $xml['sign'][array_search(DEFAULT_CURRENCY, $xml['value'])];
} else {
    $selected = $xml['value'][0];
    $selected_currency_sign = $xml['sign'][0];
}
// End Validation for Currency Dropdown

// Validation for Language dropdown 
if (file_exists('includes/dropdownXml/language.xml')) {
    $languageXml = (array) simplexml_load_file('includes/dropdownXml/language.xml');
    $idInXml = count($languageXml['id']);
    $LnameInXml = count($languageXml['name']);
    $keywordInXml = count($languageXml['keyword']);
    if ($idInXml != $LnameInXml) {
        echo LANGUAGEVARIABLEERROR;
        exit();
    }
}
// End Validation for Language dropdown 

// Validation For Donation Amount Button 
for ($i = 0; $i < count($donationAmount); $i++) {

    if (!is_numeric($donationAmount[$i])) {
        echo DONATIONAMOUNTERROR;
        exit();
    }
}
//  End Validation For Donation Amount Button 

// Setting Current Year 
$currentYear = Date("Y");
//  End Setting Current Year



//Setting javascript variable
echo "<script>amount=" . $donationAmount[0] . "</script>";
echo "<script>i_first='" . NAME . "'</script>";
echo "<script>i_last='" .LNAME. "'</script>";
echo "<script>i_address='" .ADDRESS. "'</script>";
echo "<script>Coutlang='" .$_SESSION['language']. "'</script>";
echo "<script>selectPaymetType='".SELECTPAYMENTTYPE."'</script>";
echo "<script>paymentMethods='".json_encode($paymentMethods)."'</script>";
echo "<script>baseurl='".$sitePath."'</script>";
//End Setting javascript variable

//For Enabling blocks

if($paymentMethods['paypal']==FALSE && $paymentMethods['creditCard']==FALSE && $paymentMethods['bankingTransfer']==FALSE){
   echo '<script>blockToEnable =1;</script>'; 
}else{
    echo '<script>blockToEnable =2;</script>';
}



//End For Enabling blocks


// Validation for Payment Methods
if (count($paymentMethods) != 5) {
    echo PAYMENTVARIABLEERROR;
    exit();
} elseif (!isset($paymentMethods['recurring'])) {

    echo PAYMENTVARIABLFORRECCURRINGEERROR;
    exit();
} elseif (!isset($paymentMethods['paypal'])) {
    echo PAYMENTVARIABLFORPAYPALEERROR;
    exit();
} elseif (!isset($paymentMethods['creditCard'])) {
    echo PAYMENTVARIABLFORCREDITEERROR;
    exit();
} elseif (!isset($paymentMethods['bankingTransfer'])) {
    echo PAYMENTVARIABLFORBANKINGEERROR;
    exit();
}elseif (!isset($paymentMethods['StripePay'])) {
    echo PAYMENTVARIABLFORSTRIPEERROR;
    exit();
}

if(!($paymentMethods['recurring'] || $paymentMethods['paypal'] || $paymentMethods['creditCard'] ||$paymentMethods['bankingTransfer'] || $paymentMethods['StripePay']  )){
   echo ALLPAYMENTMETHODSCANNOTBEFALSE; 
   exit();
}
//  End Validation for Payment Methods


if($paymentMethods['creditCard']==TRUE){
     $creditCard="active";
     
 }else if($paymentMethods['bankingTransfer']==TRUE){
     $banktransfer="active";
     
 }else if($paymentMethods['paypal']==TRUE){
     $paypal="active";
     
 }else if($paymentMethods['StripePay']==TRUE){
     $StripePay="active";
 }

?>
