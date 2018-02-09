<?php

session_start();
include '../../configuration.php';
include '../functions/autoload.php';
include '../languages/' . $_SESSION['language'] . '.php';
$install = simplexml_load_file('info.xml');
$install->is_install = 1;
$install->asXML('info.xml');
$assoPath = strstr($_SERVER['REQUEST_URI'], 'includes', true);
$instFile = file_get_contents('config-templates.php');
$instFile = str_replace('[REQUESTURL]', $assoPath, $instFile);
$instFile = str_replace('[INSTALLED]', '1', $instFile);
$admin_email_id = isset($_POST['admin_email_id']) ? $_POST['admin_email_id'] : "test@domain.com";
$site_email_id = isset($_POST['site_email_id']) ? $_POST['site_email_id'] : "test_site@domain.com";
$paypalstandard = isset($_POST['paypalstandard']) ? TRUE : FALSE;
$paypalrecurring = isset($_POST['paypalrecurring']) ? TRUE : FALSE;
$creditcard = isset($_POST['creditcard']) ? TRUE : FALSE;
$banktransfer = isset($_POST['banktransfer']) ? TRUE : FALSE;
$stripe = isset($_POST['stripe']) ? TRUE: FALSE;
$languageCode = isset($_POST['language']) ? $_POST['language'] : "en";
$languageName = getLanguageName($languageCode);
$currencyCode = isset($_POST['currency']) ? $_POST['currency'] : "USD";
$currencySymbol = getCurrencySymbol($currencyCode);
$instFile = str_replace('[ADMINEMAILID]', $admin_email_id, $instFile);
$instFile = str_replace('[SITEEMAILID]', $site_email_id, $instFile);
$instFile = str_replace('[RECURRING]', $paypalrecurring, $instFile);
$instFile = str_replace('[STANDARD]', $paypalstandard, $instFile);
$instFile = str_replace('[CREDITCARD]', $creditcard, $instFile);
$instFile = str_replace('[BANKTRANSFER]', $banktransfer, $instFile);
$instFile = str_replace('[STRIPEPAY]', $stripe, $instFile);
$instFile = str_replace('[LANGUAGENAME]',$languageName, $instFile);
$instFile = str_replace('[LANGUAGEKEYWORD]',$languageCode, $instFile);
$instFile = str_replace('[CURRENCYCODE]',$currencyCode, $instFile);
$instFile = str_replace('[CURRENCYSIGN]',$currencySymbol, $instFile);
if (isset($_POST['rewriteurl'])) {
    $rewrite = "Off";
    if (get_rewrite_module_info()) {
        $rewrite = "On";
    }
}
$instFile = str_replace('[REWRITEURL]', $rewrite, $instFile);
$instFile = str_replace('[INSTALLED]', '1', $instFile);
file_put_contents('../../configuration.php', $instFile);
header('Location:' . $_SERVER['HTTP_REFERER']);
?>
