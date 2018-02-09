<?php
session_start();
include 'includes/functions/autoload.php';
include 'configuration.php';
include 'includes/languages/'.$_SESSION['language'].".php";

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title><?php echo TITLE;?></title>
        <link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/styles.css" />
    </head>
    <body>
        <?php
        session_start();
        ?>
        <div id="main">
            <section class="container container" id="page-info">
                <div class="row">
                    <!-- Table Section Start Here -->
                    <div class="payment-success-box">
                        <div><img src="assets/images/cartoon-icon.png" width="" height="" title=""/></div>
                        <div class="page-header">
                            <h2><?php echo THANKSMSG;?></h2>
                        </div>
                        <div class="transition-content">
                            <p class="name"><?php echo DEAR."  " ?><strong><?php echo  getName();?>,</strong></p>
                            <p>  <?php echo SUCESSDISPLAYMSG; ?>  <strong> <?php echo BELOWAREYOURAMOUNTTRNASACTIONDETAILS; ?> </strong> </p>
                            <div class="transition-detail">
                                <div class="donate-value-section">
                                    <a href="#" class="left active"><?php echo getCurrency(); ?></a>
                                    <span class="right">
                                    <?php if(!isset($_GET['amount'])){?>
                                        <a href="#"><?php echo ORDERID." : ";?><?php if(isset($_GET['amount'])){ echo "NA";}else if(isset ($_GET['txn_id'])){ echo $_GET['txn_id'];}else{echo getTransactionId();} ?></a>
                                      <?php }?> 
                                        <a href="#" class="last"><?php echo getTransactionDate(); ?></a>
                                    </span>
                                </div>
                                <div class="money-donate">
                                    <span><?php echo getAmount(); ?></span>  </div>
                                <?php if(isset($_GET['amount'])){
                                          echo getBankDetails();
                                    
                                    } 
                                       ?>
                                <p><?php echo ISTHERESOMETHINGTOSAHARE ?></p>
                                <p><?php echo FEEDBACKTO;?><strong><a href="#">XYZ.Com</a></strong></p>
                            </div>
                            <div class="social">
                                <span><?php echo SHAREFORMAILHELP;?></span>	
                                <ul>
                                    <li><a href="#"><img src="assets/images/facebook.jpg" width="23" height="23" alt="Facebook" title="Facebook" /></a></li>
                                    <li><a href="#"><img src="assets/images/linkedin.jpg" width="23" height="23" alt="Linkedin" title="Linkedin" /></a></li>
                                    <li><a href="#"><img src="assets/images/twitter.jpg" width="23" height="23" alt="Twitter" title="Twitter" /></a></li>
                                    <li><a href="#"><img src="assets/images/google-plus.jpg" width="23" height="23" alt="Google plus" title="Google plus" /></a></li>
                                </ul>
                            </div>
                        </div>
                        </section>
                    </div>
                    </body>
                    </html>
