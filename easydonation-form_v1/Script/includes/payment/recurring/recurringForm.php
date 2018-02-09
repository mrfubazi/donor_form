<form action="<?php  echo getFormAction($paymentMode) ?>" method="post" id="recurring-from-data" name="paymentForm">
     <div id="popupWait" ><b><img src="<?php SITEPATH ?>assets/images/preloader.gif" /></b></div>
    <!-- Identify your business so that you can collect the payments. -->
    <input type="hidden" name="business" value="<?php echo $bussinessAccount ;?>" id="business">
    <!-- Specify a Subscribe button. -->
    <input type="hidden" name="cmd" value="_xclick-subscriptions">
    <! -- Identify the subscription. -->
    <input type="hidden" name="item_name" value='<?php echo ITEMNAME; ?>' id="item_name">
    <! -- Set the terms of the regular subscription. -->
    <input type="hidden" name="currency_code" id="currencyCode" value="<?php echo $_POST['currency']?>">
    <input type="hidden" name="a3" id="amount" value='<?php echo $_POST["donation-amount-value"] ;?>'>
    <input type="hidden" name="p3" id="numberOfCycle" value="<?php echo $_POST["nubOfCycle"] ;?>">
    <input type="hidden" name="t3" id="donation-cycle"  value="<?php echo $_POST["cycle"];?>">
      <input name="lc" type="hidden" value='<?php echo $_POST["pLang"];?>' id="lc_reccurring"/>
     <input type="hidden" name="rm" value="2">
    <input type="hidden" name="custom" id="choose-custom-recurring" value="<?php echo $custome ?>">
    <INPUT type="hidden" name="return"  id="auto_return_sand" value="<?php echo $returnUrl;?>">
     <input type="hidden" name="notify_url" id="notify-url-recurring" value="<?php echo $notifyUrlForRec;?>">
    <input type="hidden" name="return_url"  value="<?php echo $returnUrl;?>">
    <input type="hidden" name="cancel_return"  value="<?php echo $cancelUrl;?>"> 
</form>