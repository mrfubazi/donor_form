
<?php
require_once 'stripe/lib/Stripe.php';

if ($_POST['StripeSubmit']) {
    
  Stripe::setApiKey("sk_test_b5EzdFNRohtmWuFtbZwF7bMi");
  $error = '';
  $success = '';
  try {
    if (!isset($_POST['stripeToken']))
      throw new Exception("The Stripe Token was not generated correctly");
  //exit;
    $payment=Stripe_Charge::create(array("amount" => $_POST['amount'],
                                "currency" => strtolower($_POST['currency']),
                                "card" => $_POST['stripeToken']));
                                echo "<pre>";
                    print_r($payment);
                    echo "</pre>";
    $success = 'Your payment was successful.';
  }
  catch (Exception $e) {
    $error = $e->getMessage();
  }
}

?>


      
        <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
       
        <script type="text/javascript">
            // this identifies your website in the createToken call below
            Stripe.setPublishableKey('pk_test_gObShk36KPVDgkQfufub6W5k');

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
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

       
                $("#payment-form").submit(function(event) { alert(123);
                   
                });
           
        </script>


      
        <!-- to display errors returned by createToken -->
        <span class="payment-errors"><?= $error ?></span>
        <span class="payment-success"><?= $success ?></span>
        <form action="" method="POST" id="payment-form" name="paymentForm">
            <div id="popupWait" ><b><img src="<?php SITEPATH ?>assets/images/preloader.gif" /></b></div> 
         <input type="hidden" name="name"  class="card-holder-name"  value="<?php echo $_POST['name'].' '.$_POST['last_name'];?>"/>
         <input type="hidden" name="address" class="address"  value="<?php echo $_POST['address'];?>"/>
         <input type="hidden" name="city" class="city"  value="test"/>
         <input type="hidden" name="zip" class="zip"  value="2145545"/>
         <input type="hidden" name="state" class="state"  value="UP"/>
         <input type="hidden" name="country" class="country"  value="IN"/>
         <input type="hidden" name="email" class="email form-control" value="<?php echo $_POST['email'];?>">
         <input type="hidden" name="phone" class="phone form-control" value="<?php echo $_POST['phone'];?>">
         <input type="hidden" name="currency" class="currency form-control" value="<?php echo $_POST['currency'];?>">
         <input type="hidden" name="amount" class="amount form-control" value="<?php echo $_POST['donation-amount-value'];?>">
         <input type="hidden" name="language" class="language form-control" value="<?php echo $_POST['pLang'];?>">
         <input type="hidden" name="card-number" class="card-number"  value="<?php echo $_POST['cardNumber'];?>"/>
         <input type="hidden" name="card-cvc" class="card-cvc" value="<?php echo $_POST['cardVeriNum'];?>" />
         <?php if($_POST['month']<10){
             $_POST['month']="0".$_POST['month'];
         }?>
         
         <input type="hidden" name="card-expiry-month"  class="card-expiry-month" value="<?php echo $_POST['month'];?>"/>
         <input type="hidden" name="card-expiry-year"  class="card-expiry-year" value="<?php echo $_POST['year'];?>"/>
         <button type="submit"  value="Submit" class="submit-button" name="StripeSubmit"></button>
        </form>
        
  

