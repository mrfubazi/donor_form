<?php
ob_start();
session_start();
include_once '../../../configuration.php';
include '../../functions/autoload.php';
include "../../languages/" . $_POST['pLang'] . ".php";
$_SESSION['language'] = $_POST['pLang'];
$mainObj = new Main();



require 'lib/Stripe.php';
if ($_POST['stripeToken']) {
    Stripe::setApiKey($Stripe_secreteKey);
    $error = '';
    $success = '';
    try {
        if (!isset($_POST['stripeToken']))
            throw new Exception("The Stripe Token was not generated correctly");

        echo "<pre>";
        print_r($_POST);
        $payment = Stripe_Charge::create(array("amount" => $_POST['mc_gross'] * 100,
                    "currency" => $_POST['mc_currency'],
                    "card" => $_POST['stripeToken'],
        ));

        $test = (array) $payment;

        $i = 0;
        foreach ($test as $key => $value) {
            if ($i == 1) {
                $_POST[txn_id] = $value[id];
                $_POST['status'] = $value['status'];
                break;
            }
            $i++;
        }

        $mainObj->sendMailTo($_POST, 5);
        header("Location:" . SITEPATH . "donation-payment-success.php?name=" . $_POST['name'] . "&currency=" . $_POST['mc_currency'] . "&txn_id=" . $_POST['txn_id'] . "&mc_gross=" . $_POST['mc_gross']);
        exit;
    } catch (Exception $e) {

        
        header("Location:" . SITEPATH . "donation-payment-fail.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Easy Donation Stripe Payment</title>
        <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below
            Stripe.setPublishableKey('<?php echo $stripe_publishableKey;?>');

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    //Write your code here
                } else {

                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }

            $(document).ready(function () {
                test();
                function test() {
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                    return false;
                }
            });
        </script>
    </head>
    <body>

       

        <form action="" method="POST" id="payment-form" name="paymentStripeForm"  >
            <input type="hidden" size="20" autocomplete="off" class="card-number" name="creditCardNumber" value="<?php echo $_POST['cardNumber']; ?>" />
            <input type="hidden" size="4" autocomplete="off" class="card-cvc" name="csv" value="<?php echo $_POST['cardVeriNum']; ?>" />
            <input class="email" type="hidden" placeholder="Email" maxlength="65" name="email" value="<?php echo $_POST['email']; ?>" />
<?php
if ($_POST['month'] < 9) {
    $_POST['month'] = "0" . $_POST['month'];
}
?>
            <input type="hidden" size="2" class="card-expiry-month" name="month" value="<?php echo $_POST['month']; ?>" />
            <input type="hidden" size="4" class="card-expiry-year" name='year' value="<?php echo $_POST['year']; ?>" />
            <input type="hidden"  class="address" name="address" value="<?php echo $_POST['address']; ?>" />
            <input type="hidden"  class="name" name="name" value="<?php echo $_POST['name'] . " " . $_POST['last_name']; ?>" />
            <input type="hidden"  class="currency" name="mc_currency" value="<?php echo $_POST['currency']; ?>" />
            <input type="hidden"  class="pLang" name="pLang" value="<?php echo $_POST['pLang']; ?>" />
            <input type="hidden"  class="amount_value" name="mc_gross" value="<?php echo $_POST['donation-amount-value']; ?>" />
            <input type="hidden"  class="phone" name="phone" value="<?php echo $_POST['phone']; ?>" />
        </form>
    </body>
</html>
