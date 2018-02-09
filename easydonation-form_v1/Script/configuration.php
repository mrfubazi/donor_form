<?php

/* -----------------------
 * ERROR REPORTING ON/OFF
 * -----------------------
 */
    error_reporting(0);
 /* -----------------------
 * ERROR REPORTING END
 * -----------------------
 * 
 */




/*
 * ---------------------------------------------------------------
 * SITE PATH
 * ---------------------------------------------------------------
 */
$serverName = $_SERVER["SERVER_NAME"];

$sitePath = "https://" . $serverName.'';
$docRoot = $_SERVER["DOCUMENT_ROOT"].'';

/*
 * -----------------------------------------------------------------
  END SITE PATH
 * ---------------------------------------------------------------
 */

/*
 * ---------------------------------------------------------------
 * LICENCE KEY 
 * ---------------------------------------------------------------
 */
$licenceKey = "";
/*
 * -----------------------------------------------------------------
  END LICENCE KEY
 * ---------------------------------------------------------------
 */


/*
 * ---------------------------------------------------------------
 * Installation Process Check  
 * ---------------------------------------------------------------
 */
$installed ='0';
/*
 * -----------------------------------------------------------------
  END Installation Process Check 
 * ---------------------------------------------------------------
 */

/*
 * ---------------------------------------------------------------
 * RETURN URL FROM PAYPAL
 * ---------------------------------------------------------------
 */
$returnUrl = $sitePath . "donation-payment-success.php";
/*
 * -----------------------------------------------------------------
  END RETURN URL  FROM PAYPAL
 * ---------------------------------------------------------------
 */



/*
 * ---------------------------------------------------------------
 * CANCEL URL FROM PAYPAL
 * ---------------------------------------------------------------
 */
$cancelUrl = $sitePath . "donation-payment-fail.php";
/*
 * -----------------------------------------------------------------
  END CANCEL URL  FROM PAYPAL
 * ---------------------------------------------------------------
 */


/*
 * ---------------------------------------------------------------
 * NOTIFY URL FROM PAYPAL
 * ---------------------------------------------------------------
 */
$notifyUrlForRec = $sitePath . "includes/payment/recurring/notify.php";  // For recurring payment
$notifyUrlForPaypal = $sitePath . "includes/payment/paypal/notify.php";  // For paypal payment
/*
 * -----------------------------------------------------------------
  END NOTIFY URL  FROM PAYPAL
 * ---------------------------------------------------------------
 */

/*
 * ---------------------------------------------------------------
 * NUMBER OF CYCLE
 * ---------------------------------------------------------------
 */
$numberOfCycle = 12;
/*
 * -----------------------------------------------------------------
  END NUMBER OF CYCLE
 * ---------------------------------------------------------------
 */

/*
 * ---------------------------------------------------------------
 * DONATION AMOUNT STATIC VALUES
 * ---------------------------------------------------------------
 *  Here , In this array you can add many values but it does not allow characters
 * 
 */
$donationAmount = array(10, 12, 14,16,18,20,22,24,26);
/*
 * -----------------------------------------------------------------
  END DONATION AMOUNT STATIC VALUES
 * ---------------------------------------------------------------
 */


/*
 * ---------------------------------------------------------------
 * EMAIL SETTINGS
 * ---------------------------------------------------------------
 */
$adminEmailId = '[ADMINEMAILID]';// Admin email id
$fromEmailId = '[SITEEMAILID]';//USer Email id





/*
 * -----------------------------------------------------------------
  END EMAIL SETTINGS
 * ---------------------------------------------------------------
 */



/*
 * ---------------------------------------------------------------
 * PAYMENT METHODS LIKE PAYPAL , CREDIT CARDS ETC
 * ---------------------------------------------------------------
 * You can only assign true or false to array
 *
 */
$paymentMethods = array(
    "recurring" => '[RECURRING]',
    "paypal" => '[STANDARD]',
    "creditCard" => '[CREDITCARD]',
    "bankingTransfer" => '[BANKTRANSFER]',
    "StripePay" => '[STRIPEPAY]' 
);
/*
 * -----------------------------------------------------------------
  END PAYMENT METHODS LIKE PAYPAL , CREDIT CARDS ETC
 * ---------------------------------------------------------------
 */



/*
 * ---------------------------------------------------------------
 * REWRITE URL
 * ---------------------------------------------------------------
 * You can Give values "On" or "Off" to $rewriteUrl
 * 
 * CONDITION FOR REWRITE URL 
 *              if your server supports rewrite url , then for checking your all transaction  , you have to type url in the
 *              browser your site define in configuration followed by :-> transdetail
 *              Example: norefresh.thesparxitsolutions.com/rocks_anuj/charityplugin_new-amar/transdetail
 *                 
 *                if your server does not support rewrite url  then for checking your all transaction  , you have to type url in the
 *                browser your site define in configuration followed by :->includes/order_history/ordersdetail/displayOrderHistory.php 
 *                Example:norefresh.thesparxitsolutions.com/rocks_anuj/charityplugin_new-amar/includes/order_history/ordersdetail/displayOrderHistory.php 
 */
$rewriteUrl = "[REWRITEURL]";
/*
 * -----------------------------------------------------------------
  END  REWRITE URL
 * ---------------------------------------------------------------
 */


/*
 * ---------------------------------------------------------------
 * BANK DETAILS
 * ---------------------------------------------------------------
 * 
 */
$localBankInfo = array("payableto" => "authority name",
    "bankname" => "bank name" ,
    "accountnumber" => "account number",
    "branchcode" => "branch code",
);


$internationalBankInfo = array(
    "payableto" => "international authority name",
    "bankname" => "international bank name",
    "bic" => "bic code ",
    "accountnumber" => "account number",
    "branchcode" => "branch code",
    "streetaddress" => "Street address ",
    "postaladdress" => "postal code ",
    "telephonenumber" => "telephone number",
    "faxnumber" => "fax number",
);

/*
 * -----------------------------------------------------------------
  End BANK DETAILS
 * ---------------------------------------------------------------
 */

/*
 * ---------------------------------------------------------------
 * TRANSACTION DETAIL PAGE NAME
 * ---------------------------------------------------------------
 */
$orderHistory = array("name" => "transactionDetails");


/*
 * -----------------------------------------------------------------
  END TRANSACTION DETAIL PAGE NAME
 * ---------------------------------------------------------------
 */


/*
 * ---------------------------------------------------------------
 * DEFAULT LANGUAGE
 * ---------------------------------------------------------------
 */
$defaulLanguage = array(
    "name" => "[LANGUAGENAME]",
    "keyword" => "[LANGUAGEKEYWORD]"
);

/*
 * -----------------------------------------------------------------
  END DEFAULT LANGUAGE
 * ---------------------------------------------------------------
 */

/*
 * ---------------------------------------------------------------
 * DEFAULT CURRENCY
 * ---------------------------------------------------------------
 * List of currency code  for country 
 * -------------------------------------------------------------
 * CODE        For CURRENCY
 * INR         INR - Indian Rupe
 * USD         USD - U.S. Dollars
 * AUD         AUD - Australian Dollars
 * BRL         BRL - Brazilian Reais
 * GBP         GBP - British Pounds
 * HKD         HKD - Hong Kong Dollars
 * HUF         HUF - Hungarian Forints
 * ILS         ILS - Israeli New Shekels
 * JPY         JPY - Japanese Yen
 * MYR         MYR - Malaysian Ringgit
 * MXN         MXN - Mexican Pesos
 * TWD         TWD - New Taiwan Dollars
 * NZD         NZD - New Zealand Dollars
 * NOK         NOK - Norwegian Kroner
 * PHP         PHP - Philippine Pesos
 * PLN         PLN - Polish Zlotys
 * RUB         RUB - Russian Rubles
 * SGD         SGD - Singapore Dollars
 * SEK         SEK - Swedish Kronor
 * CHF         CHF - Swiss Francs
 * THB         THB - Thai Baht
 * TRY         TRY - Turkish Liras
 * 
 */

$defaulCurrency = array(
    "code" => "[CURRENCYCODE]",
    "sign" => "[CURRENCYSIGN]"
);


/*
 * -----------------------------------------------------------------
  END DEFAULT CURRENCY
 * ---------------------------------------------------------------
 */




/*
 * ---------------------------------------------------------------
 * BUSSINESS ACCOUNT IN WHICH TRANSACTION WILL BE
 * ---------------------------------------------------------------
 */

$bussinessAccount = "chandra.shekhar1111@sparxtechnologies.com";
$paymentMode = 0; // for live use 1 and for sandbox use 0;
$forLiveUrl = "https://www.paypal.com/cgi-bin/webscr";
$forSandUrl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
/*
 * -----------------------------------------------------------------
  END BUSSINESS ACCOUNT IN WHICH TRANSACTION WILL BE
 * ---------------------------------------------------------------
 */

/*
 * ---------------------------------------------------------------
 * API INFORMATION
 * ---------------------------------------------------------------
 */
$apiEndPointA = "https://api-3t.sandbox.paypal.com/nvp";
$apiEndPointB = "https://api-3t.paypal.com/nvp";
$apiUserName = "chandra.shekhar1111_api1.sparxtechnologies.com";
$apiPassword = "1401375810";
$apiSignature = "AQU0e5vuZCvSg-XJploSa.sGUDlpAG53Kr0CYpbVbFMhahPdznmsDhIk";

/*
 * -----------------------------------------------------------------
  END API INFORMATION
 * ---------------------------------------------------------------
 */
/*
 * ---------------------------------------------------------------
 * Stripe ApiKey and publishableKey
 * ---------------------------------------------------------------
 */
  $Stripe_secreteKey="sk_test_b5EzdFNRohtmWuFtbZwF7bMi";
  $stripe_publishableKey="pk_test_gObShk36KPVDgkQfufub6W5k";

/*
 * -----------------------------------------------------------------
  END Stripe  INFORMATION
 * ---------------------------------------------------------------
 */





/*
 * ---------------------------------------------------------------
 * CONSTANT
 * ---------------------------------------------------------------
 */
define("SITEPATH", $sitePath);
define("RETURNURL", $returnUrl);
define("CANCELURL", $cancelUrl);
define('INSTALLED', $installed);
define('NOTIFYURLFORREC',$notifyUrlForRec);
define('NOTIFYURLFORPAYPAL',$notifyUrlForPaypal);
define("ADMINEMAILID", $adminEmailId);
define("FROMEMAILID", $fromEmailId);
define("FORLIVEURL", $forLiveUrl);
define("FORSANDURL", $forSandUrl);
define("TRANDETAILPAGENAME", $orderHistory["name"]);
define("DOCROOT", $docRoot);
define("ORDERCSVPATH", $docRoot . "includes/order_history/");
define("NUMBEROFCYCLE", $numberOfCycle);
define("DEFAULT_CURRENCY", $defaulCurrency["code"]);
define("DEFAULT_CURRENCY_SIGN", $defaulCurrency["sign"]);
define("IPAYABLETO", $internationalBankInfo["payableto"]);
define("IBANKNAME", $internationalBankInfo["bankname"]);
define("IACCOUNTNUMBER", $internationalBankInfo["accountnumber"]);
define("IBRANCHCODE", $internationalBankInfo["branchcode"]);
define("IBIC", $internationalBankInfo["bic"]);
define("ISTREETADDRESS", $internationalBankInfo["streetaddress"]);
define("IPOSTALCODE", $internationalBankInfo["postaladdress"]);
define("ITELEPHONE", $internationalBankInfo["telephonenumber"]);
define("IFAXNUMBER", $internationalBankInfo["faxnumber"]);
define("LPAYABLETO", $localBankInfo["payableto"]);
define("LBANKNAME", $localBankInfo["bankname"]);
define("LACCOUNTNUMBER", $localBankInfo["accountnumber"]);
define("LBRANCHCODE", $localBankInfo["branchcode"]);
/*
 * -----------------------------------------------------------------
  END CONSTANT
 * ---------------------------------------------------------------
 */
?>

