<?php
session_start();
include '../../configuration.php';
include '../functions/autoload.php';
include '../languages/'.$_SESSION['language'].'.php';

//echo "<pre>";
//print_r($_POST);  die;
// Creating CSV File if not exist
createFile($orderHistory['name']);
// End Creating CSV File if not exist



// Setting custom variable for paypal and Reccuring form
if($_POST['paymentType']==1){
    $paymentType=RECCURING;
    $custome=$_POST['name']."---".$_POST['last_name']."---".$paymentType."---".$_POST['email']."---".$_POST['phone']."---".$_POST['address']."---".$_POST['notes']."---".$_POST['nubOfCycle']."---".$_POST['pLang'];
}else{
    $paymentType=PAYPAL;
    $custome=$_POST['name']."---".$_POST['last_name']."---".$paymentType."---".$_POST['email']."---".$_POST['phone']."---".$_POST['address']."---".$_POST['notes']."---".$_POST['pLang'];
}
//  End Setting custom variable for paypal and Reccuring form
?>
<html>
    <head>
       <link href='<?php SITEPATH ?>assets/css/styles.css' rel="stylesheet" type="text/css"/>
        <title><?php echo PAMENTREQUESTSERVICE;?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    </head>
    <body>
      <?php if($_POST['paymentType']==1){
     include 'recurring/recurringForm.php';          
      }else if($_POST['paymentType']==2 && $_POST['pay-mod']!=4){
          include 'paypal/paypalForm.php'; 
      }else if($_POST['pay-mod']==4){
          include 'stripe/StripePayGForm.php';
      }
      ?>
    <script type="text/javascript"> 
          document.getElementById("popupWait").style.display="block";
          document.paymentForm.submit();
    </script>
    </body>
 </html>


