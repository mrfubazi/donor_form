<form action="<?php   echo getFormAction($paymentMode); ?>" method="post" id="one-time-donate" name="paymentForm">
     <div id="popupWait" ><b><img src="<?php SITEPATH ?>assets/images/preloader.gif" /></b></div>
    <!-- Identify your business so that you can collect the payments. -->
    <input type="hidden" name="business" value="<?php echo $bussinessAccount ;?>">
    <!-- Specify a Donate button. -->
    <input type="hidden" name="cmd" value="_donations">
    <!-- Specify details about the contribution -->
    <input type="hidden" name="item_name" value='<?php echo  ITEMNAME; ?>' id="onetime_item_name">
    <input type="hidden" name="currency_code" id="onetime_currencyCode"  value='<?php echo $_POST["currency"];?>'>
    <input type="hidden" name="amount" id="onetime_amount" value='<?php echo $_POST["donation-amount-value"];?>'>
    <input type="hidden" name="custom" id="onetime_choose-custom" value='<?php echo $custome ?>'>
    <input type="hidden" name="rm" value="2">
     <input name="lc" type="hidden" value="<?php echo $_POST['pLang']; ?>" id="lc_paypal"/>
    <input type="hidden" name="notify_url" id="notify-url" value="<?php echo $notifyUrlForPaypal;?>">
    <input type="hidden" name="return" id="return-url" value="<?php echo $returnUrl;?>">
    <input type="hidden" name="cancel_return"  value="<?php echo $cancelUrl;?>"> 
</form>
