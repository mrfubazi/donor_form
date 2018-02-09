<?php
session_start();
include '../../../configuration.php';
if (!isset($_SESSION['language'])){
    $_SESSION['language'] = "en";}
include "../../languages/" . $_SESSION['language'] . ".php";
include '../../functions/autoload.php';
$oderObj = new Orderhistory();
$orderData = $oderObj->history($_POST);
$currency_symbol = $oderObj->getCurrencySymbol();
$invoiceId = $_GET['id'];
if (array_key_exists($invoiceId, $orderData['orders']))
    {
    $popupdata = $orderData['orders'][$invoiceId];
    }
else
    {

    echo INVALIDINVOICEID;
    }
?>
<div id='homer' style="background:url(<?php echo SITEPATH . 'assets/images/popupBackground.png' ?>) right center no-repeat #ececec; height:auto; width:auto; padding:30px 10px;">
    <strong><?php echo NAME;?> : </strong><?php echo "$popupdata[0]&nbsp;$popupdata[1]"; ?><br/>
    <strong><?php echo EMAIL;?> :</strong> <?php echo "$popupdata[2]"; ?><br/>
    <strong><?php echo ADDRESS;?> :</strong> <?php echo "$popupdata[3]"; ?><br/>
    <strong><?php echo PHONE;?> :</strong> <?php echo "$popupdata[5]"; ?><br/>
    <strong><?php echo DONATIONAMOUNT;?>:</strong> <?php echo $currency_symbol[$popupdata[11]] . "&nbsp;" . number_format($popupdata[6], 2, '.', ''); ?><br/>
    <strong><?php echo PAYMENTTYPE;?>:</strong> <?php echo $popupdata[7]; ?>&nbsp;<?php
    $recurring_str = '';
    if (($popupdata[12] != 'NA'))
        {
        $recurring_str = explode('_', $popupdata[12]);
        echo "($recurring_str[0]) Paypal";
        }
    ?><br/>
    <strong><?php echo TRANSACTIONID;?> :</strong><?php echo $popupdata[9]; ?><br/>
    <strong><?php echo TRANSACTIONDATE;?> :</strong><?php echo date('d M Y', strtotime($popupdata[10])); ?><br/>
    <strong><?php echo TRANSACTIONSTATUS;?> :</strong><?php echo $popupdata[14]; ?>
</div>

