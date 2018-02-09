
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
        <title>Charity</title>	
        <link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/styles.css" />
    </head>
    <body>
        <div id="wrapper">
            <!-- Content Section Starts here -->			
            <div id="main">
                <section class="container" id="page-info">			
                        <div class="payment-success-box  payment-fail">
                            <div><img src="assets/images/cartoon-icon.png" width="111" height="123" title="Transaction failed"/></div>
                            <header class="page-header failed-page-header">
                                <h2><?php echo FAILPAGEMSG;?></h2>
                            </header>
                            <div class="click-section">
                                <a class="btn btn-default btn-again btn-yellow" href="index.php"><?php echo CLICKHERE;?></a>	
                            </div>	
                        </div>
                </section>
            </div>
            <!-- Content Section Starts here -->	
        </div>
    </body>
</html>