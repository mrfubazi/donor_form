donationType = '';
currencyCode='';
paymentType=2;
payOpt='';
gloAmount=amount;
paymentMethods = JSON.parse(paymentMethods);

$(document).ready(function() {
    $("#donate-btn").click(function() {
        if(validatePaymentType() ||(validateCurrencyCode() & validateName() & validatelastName() & validateEmail() & validatePhone() & validateAddress() & validateNumberOfCycle() & validateCycle()  )){
            /* Reccuring payment*/
            if(paymentType==1){
                              
                if (validateCurrencyCode() & validateName() & validatelastName() & validateEmail() & validatePhone() & validateAddress() & validateNumberOfCycle() & validateCycle() &  validatePaymentType()) {
                     var donationAmt=$.trim(amount);
                     
                    $("#donation-amount-value").val(donationAmt);
                    $("#formData").submit();
                    $('#popupWait').fadeIn();
                }
                   
            }/*End Reccuring payment*/
        
            /* Code For One Time Payment */
            else if(paymentType==2){
                if(validatePaymentOption() | ( validateCurrencyCode()  & validateName() & validatelastName() & validateEmail() & validatePhone() & validateAddress() )){
                    var paymentOption=$(".pay-mod span.active").attr("id");
                    /* Code for payment through credit card */ 
                    if(paymentOption==2 ){
                        if(validateCurrencyCode() & validateName() & validatelastName() & validateEmail() & validatePhone() & validateAddress() & validateCardType() & validateCreditCard() & validateExpiryDate() & validateCVV()){
                            var cre_amt=$.trim(amount);
                            var creditCardNumber=$.trim($("#creditCardNumber").val());
                            var creditCardType=$("#cardType").val();
                            var csv=$.trim($("#cardVeriNum").val());
                            var expMnth=$("#expMonth").val();
                            var currencyCode=$("#currency").val(); 
                            var expYr=$("#expYear").val();
                            var expDate=expMnth+expYr;
                            var cre_email=$("#email").val();
                            var cre_phone=$("#phone").val();
                            var fname=$("#name").val();
                            var lastName=$("#last_name").val();
                            var cre_address=$("#message").val();
                            var cre_note=$("#add-note").val();
                            $.ajax({
                                type:"POST",
                                url:baseurl+"includes/payment/credit_card/creditCardPayment.php",
                                dataType:"html",
                                data:{
                                    fname: fname,
                                    lastName: lastName,
                                    creditCardType: creditCardType,
                                    creditCardNumber: creditCardNumber,
                                    mc_gross: cre_amt,
                                    expDate: expMnth + expYr,
                                    csv: csv,
                                    mc_currency:currencyCode,
                                    email:cre_email,
                                    phone:cre_phone,
                                    address:cre_address,
                                    note:cre_note,
                                    language:Coutlang
                                },
                            
                                beforeSend:function(){
                                    $('#popupWait').fadeIn();  
                                },
                                success: function(response) {
                                    $('#popupWait').fadeOut();  
                                    data=response.split('###')
				    console.log(data)		
                                    if ($.trim(data[0]) == 'Success') {
                                        setTimeout(function(){
                                            window.location.href = baseurl+'donation-payment-success.php';
                                        }, 4000);
                                 
                                    } else {
                                        window.location.href = baseurl+'donation-payment-fail.php';
                                    }
                                }
                            });
                        }
                    }
                    /* End Code For payment through credit card*/ 
                  
                    /* Code For Stripe Payment */
                    if(paymentOption==4 ){ 
                        if(validateCurrencyCode() & validateName() & validatelastName() & validateEmail() & validatePhone() & validateAddress() & validateCardType() & validateCreditCard() & validateExpiryDate() & validateCVV()){
//                            var cre_amt=$.trim(amount);
//                            var creditCardNumber=$.trim($("#creditCardNumber").val());
//                            var creditCardType=$("#cardType").val();
//                            var csv=$.trim($("#cardVeriNum").val());
//                            var expMnth=$("#expMonth").val();
//                            var currencyCode=$("#currency").val(); 
//                            var expYr=$("#expYear").val();
//                            var expDate=expMnth+expYr;
//                            var cre_email=$("#email").val();
//                            var cre_phone=$("#phone").val();
//                            var fname=$("#name").val();
//                            var lastName=$("#last_name").val();
//                            var cre_address=$("#message").val();
//                            var cre_note=$("#add-note").val();
//                            $.ajax({
//                                type:"POST",
//                                url:baseurl+"includes/payment/stripe/StripePayGForm.php",
//                                dataType:"html",
//                                data:{
//                                    fname: fname,
//                                    lastName: lastName,
//                                    name:fname+" "+lastName,
//                                    creditCardType: creditCardType,
//                                    creditCardNumber: creditCardNumber,
//                                    mc_gross: cre_amt,
//                                    expMonth: expMnth,
//                                    expYear:  expYr,
//                                    csv: csv,
//                                    mc_currency:currencyCode,
//                                    email:cre_email,
//                                    phone:cre_phone,
//                                    address:cre_address,
//                                    note:cre_note,
//                                    language:Coutlang
//                                },
//                            
//                                beforeSend:function(){
//                                    $('#popupWait').fadeIn();  
//                                },
//                                success: function(response) {
//                                    alert(response); return false;
//                                    $('#popupWait').fadeOut();  
//                                    data=response.split('###')
//                                    if (data[0] == 'Success') {
//                                        setTimeout(function(){
//                                            window.location.href = baseurl+'donation-payment-success.php';
//                                        }, 4000);
//                                 
//                                    } else {
//                                        window.location.href = baseurl+'donation-payment-fail.php';
//                                    }
//                                }
//                            });
                            document.getElementById('formData').action='includes/payment/stripe/StripePayGForm.php'
                            document.getElementById('pay-mod').value='4' ; 
                            var onetime_currCode=$('#currency').val();
                            var onetime_amt=$.trim(amount);
                            $("#donation-amount-value").val(onetime_amt);
                            $("#formData").submit();
                            $('#popupWait').fadeIn();



                        }
                    }
                    /* End  Code For Stripe Payment */
                
                
                
                
                    /*  Code For payment through Paypal */
                    else if(paymentOption==1){
                        if(validateCurrencyCode() & validateName() & validatelastName() & validateEmail() & validatePhone() & validateAddress()){
                            var onetime_currCode=$('#currency').val();
                            var onetime_amt=$.trim(amount);
                            $("#donation-amount-value").val(onetime_amt);
                            $("#formData").submit();
                            $('#popupWait').fadeIn();
                            
                        }
                    }/* End   Code For payment through Paypal */
                
                    /* Code For payment using Bancking */
                    else if(paymentOption==3){
                        if(validateCurrencyCode() & validateName() & validatelastName() & validateEmail() & validatePhone() & validateAddress()){
                            var b_name=$("#name").val();
                            var b_lastName=$("#last_name").val();
                            var b_clientMail=$("#email").val();
                            var b_amt=$.trim(amount);
                            var b_donationType="One Time donation";
                            var b_currency=$("#currency").val();
                            var b_phone=$("#phone").val();
                            var b_address=$("#message").val();
                            var b_note=$("#add-note").val();
                            $.ajax({
                                type: "POST",
                                url: baseurl + "includes/payment/bankingtransfer/bankingTransferProcess.php",
                                dataType: "html",
                                data: {
                                    fname: b_name,
                                    lastName: b_lastName,
                                    donationType: b_donationType,
                                    mc_gross: b_amt,
                                    mc_currency: b_currency,
                                    email: b_clientMail,
                                    phone: b_phone,
                                    address: b_address,
                                    note: b_note,
                                    language:Coutlang
                                },
                                beforeSend: function() {
                                    $('#popupWait').fadeIn();
                                },
                                success: function(response) { 
                                    $('#popupWait').fadeIn();
                                    window.location.href=baseurl+'donation-payment-success.php?amount='+b_amt+'&currency='+b_currency+'&name='+b_name+" "+b_lastName;                         
                                }
                            });
                        }
                    }
                                        
                /* End Code for Bancking transfer */
                }
            }
          
        }

    });
    
});

    
/* Code for getting Currency Code*/
    
$("#currency").on('change', function() {
    var txt = $(this).val();        
    currencyCode = txt;     
        
});
    
$("#currency").on("change",function(){
    var currency=  $("#currency").val();
    
    if(currency!=""){
         $("#currency_chzn .chzn-single").css('border-color', '');
        $("#currency").css('border-color', '');
    }
});
    
    
   
/* End Code for getting Currency Code */               
 
 /*Enabling block By default*/
 if(blockToEnable==1){
     var element = document.getElementById("recurring-not-allow");
         element.classList.add("active");
         document.getElementById("radio-rec").checked=true; 
         enableBlock(1);
 }
     
 
 
 /*Enabling block By default*/
 
 
    
/*  Code for getting Amount */                  
$(".selectvalue").click(function() {
    $('input[name="amount"]').val('');
    amount = $(this).html();
    $("#amountToShow").text($.trim(amount));
});

/* End  Code for getting Amount */                                    
    
/*  Validation for Amount */                      
$('input[name="donation-amount"]').on('keyup', function() {
    validateAmount();
});

$("#donation-amount").on("focus",function(){
   $('.choose-pricing .btn-group .btn').removeClass('active'); 
   $('.choose-pricing .btn-group .inpt-first').addClass('active'); 
   $("#amountToShow").html("--");
});

$("#donation-amount").on("focusout",function(){
   var amttocheck = $.trim($('input[name=donation-amount]').val());
   if(amttocheck==""){
     $('.choose-pricing .btn-group button:first-child').addClass('active');   
     $('.choose-pricing .btn-group .inpt-first').removeClass('active');
     $("#amountToShow").html(gloAmount);
   }
   
   
});
/* End Validation for Amount */             
    
/*  Validation for Currency Code */    
function validateCurrencyCode() {
    var currency = $("#currency").val();
    if (currency =='') {
        $("#currency_chzn .chzn-single").css('border-color', 'red');
        $("#currency").css('border-color', 'red');
        return false;
    } else {
        $("#currency_chzn .chzn-single").css('border-color', '');
        $("#currency").css('border-color', '');
        return true;
    }
}
    
/* End Validation for Currency Code */


/*  Validation for Payment Type */   
function validatePaymentType(){
    paymentType=$('input[name=paymentType]:radio:checked').val();
    if(paymentType==null){
        $("#payment-type-error").html("Please Select Payment Type");
        return false;
    }else{
        $("#payment-type-error").html("");
        return true; 
    }
}
    
$('input[name=paymentType]').on('click',function(){
    $("#payment-type-error").html("");
});
  
$("input[name=paymentType]:radio").on("click",function(){ 
    var message_val=  $("input[name=paymentType]:radio:checked").val();
    if(message_val==2){
        var checkFrCre=$("#paymentOption").val();
        if(checkFrCre==2){
            if(paymentMethods.creditCard)
           document.getElementById("credit_card_info").style.display="block";
        }else{
             if(paymentMethods.creditCard)
            document.getElementById("credit_card_info").style.display="none";
        }
    }
});
/*  End Validation for Payment Type */

    
/*Validation for Donation Amount */    
  function validateAmount() {
    if(isNaN($.trim($('input[name=donation-amount]').val()))){
      $('input[name=donation-amount]').val("");
        
    }else{
        var amt = $('input[name=donation-amount]').val();
    if (amt !='') {
        if(amt.length>16){
            amt=amt.substr(0,16);
            $("#donation-amount").val(amt);
        }
        amount = amt;
        $("#amountToShow").html($.trim(amount));
        return true;
    } else {
        amount = gloAmount;
        $("#amountToShow").html("--");
        return true;
      }   
    }
} 
   
   
/* End Validation for Donation Amount */                      


                     
/*     Function to validate Cycle (Weekly , Monthly , yearly) */
function validateCycle(){
    var cycle= $("#cycle").val();
    if(cycle==''){
        $('#cycle_chzn .chzn-single').css('border-color', 'red');
        $('#cycle').css('border-color', 'red');
        return fales;
    }else{
        $('#cycle_chzn .chzn-single').css('border-color', '');
        $('#cycle').css('border-color', '');
        return true;
    }
}
    
$("#cycle").on("change",function(){
    var cycle_v=  $("#cycle").val();
    if(cycle_v!=""){
        $("#cycle").css('border-color', '');
    }else{
         $("#cycle").css('border-color', 'red');
    }
})
    
/*  End    Function to validate Cycle (Weekly , Monthly , yearly) */
    
/* Function to validate Payment Option */
function validatePaymentOption(){
    var cycle= $("#paymentOption").val();
    if(cycle==''){
        $('#paymentOption').css('border-color', 'red');
        return fales;
    }else{
        $('#paymentOption').css('border-color', '');
        return true;
    }
}                         
          
$("#paymentOption").on("change",function(){
    var paymentoption_val=  $("#paymentOption").val();
    if(paymentoption_val!=""){
        $("#paymentOption").css('border-color', '');
    }
});      
          
          
/* End Function to validate Payment Option */

 /* Function to  changing Currency Sign */
function changesign(){
    var  _curValue=$("#currency").val()
    changeCurrencySignAndAmount(_curValue);
    return true;
} 
/* End Function to  changing Currency Sign */

/*  Function to validate number of cycle */
 function validateNumberOfCycle(){
    var num_cycle= $('#num_cycle').val();
    if(num_cycle==''){
        $('#num_cycle_chzn .chzn-single').css('border-color', 'red');
        $('div #num_cycle').css('border-color', 'red');
        return false;
    }else{
        $('#num_cycle_chzn .chzn-single').css('border-color', '');
        $('div #num_cycle').css('border-color', '');
        return true;
    }
}

$("#num_cycle").on("change",function(){
    var num_cycle_v=  $("#num_cycle").val();
    if(num_cycle_v!=""){
        $("#num_cycle").css('border-color', '');
    }
});
/* End Function to validate number of cycle */


/*  Function to validate the Name */
function validateName() {
    var name = $('input[name="name"]').val();
     if (name ==i_first ) {
        $("#name").css('border-color', 'red');
        return false;
    } else {
        $("#name").css('border-color', '');
        return true;
    }
}   
    
$("#name").on("keyup",function(){
    var name_val=  $("#name").val();
    if(name_val!="First Name"){
        $("#name").css('border-color', '');
    }
});
/* End Function to validate the Name */


/*  Function to validate the Last Name */
function validatelastName() {
    var name = $('input[name="last_name"]').val();
    if (name ==i_last) {
        $("#last_name").css('border-color', 'red');
        return false;
    } else {
        $("#last_name").css('border-color', '');
        return true;
    }
}
    
$("#last-name").on("keyup",function(){
    var lastname_val=  $("#last-name").val();
    if(lastname_val!="Last Name"){
        $("#last-name").css('border-color', '');
    }
});
    
    
/* End  Function to validate the Last Name */
    
/*  Function to validate Email Id  */   
function validateEmail() {
    var email = $('input[name="email"]').val();
    var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (email == '') {
        $("#email").css('border-color', 'red');
        return false;
    } else if (pattern.test(email)) {
        $("#email").css('border-color', '');
        return true;
    } else {
        $("#email").css('border-color', 'red');
        return false;
    }
}
    
$("#email").on("keyup",function(){
    var email_val=  $("#email").val();
    if(email_val!=""){
        $("#email").css('border-color', '');
    }
});
    
    
/* End   Function to validate  Email */    
  
/*  Fnction to validate the card Type */
function validateCardType(){
    var cardType=$('#cardType').val();
    if(cardType==''){
        $("#cardType_chzn .chzn-single").css('border-color', 'red');
        $("#cardType").css('border-color', 'red');
        return false;
    }else{
        $("#cardType_chzn .chzn-single").css('border-color', '');
        $("#cardType").css('border-color', '');
        return true;
    }
}
$("#cardType").on("change",function(){
    var cardType_val=  $("#cardType").val();
    if(cardType_val!=""){
        $("#cardType").css('border-color', '');
    }
});
    
    
/* End Fnction to validate the card Type */
               
/*  Fnction to validate the card CardNumber */              
function validateCardNumber(){
    var cardNumber=$('#creditCardNumber').val();
    if(cardNumber==''){
        $("#creditCardNumber").css('border-color', 'red');
        return false;
    }else{
        $("#creditCardNumber").css('border-color', '');
        return true;
    }
}
/* End  Fnction to validate the  CardNumber */              
 
/*  Fnction to validate the Expiry Date */
function validateExpiryDate(){
    var month=$('#expMonth').val();
    var year=$('#expYear').val();
    if(year=='' & month==''){
        $("#expMonth_chzn .chzn-single ").css('border-color', 'red');
        $("#expYear_chzn .chzn-single ").css('border-color', 'red');
        $("#expYear").css('border-color', 'red');
        $("#expMonth").css('border-color', 'red');
        return false;
    }
    else if(year==''){
        $("#expYear").css('border-color', 'red');
        return false;
    }else if(month==''){
        $("#expMonth").css('border-color', 'red');
        return false;
    }else{
        $("#expYear").css('border-color', '');
        $("#expMonth").css('border-color', '');
        return true;
    }
}

function validateMonth(){
  var month=$('#expMonth').val(); 
  if(month==''){
        $("#expMonth_chzn .chzn-single ").css('border-color', 'red');
        $("#expMonth").css('border-color', 'red');
        return false;
  }else{
        $("#expMonth_chzn .chzn-single ").css('border-color', '');
        $("#expMonth").css('border-color', '');
        return true;
    }
}

function validateYear(){
   var year=$('#expYear').val();
    if(year==''){
        $("#expYear_chzn .chzn-single ").css('border-color', 'red');
        $("#expYear").css('border-color', 'red');
    }else{
        $("#expYear_chzn .chzn-single").css('border-color', '');
        $("#expYear").css('border-color', '');
  
    }
}

$("#expYear").on("change",function(){
    var year_val=  $("#expYear").val();
    if(year_val!=""){
        $("#expYear").css('border-color', '');
    }
});
    
$("#expMonth").on("change",function(){
    var month_val=  $("#expMonth").val();
    if(month_val!=""){
        $("#expMonth").css('border-color', '');
    }
});
/* End Function to validate the Expiry Date */               

/*  Function to validate the CVV Number */                             
function validateCVV(){
    var cvvNumber=$("#cardVeriNum").val();
    if(cvvNumber==''){
        $("#cardVeriNum").css('border-color', 'red');
        return false;
    }else if(isNaN(cvvNumber)){
        $("#cardVeriNum").css('border-color', 'red');
        return false;
    }else if(cvvNumber.length>4 || cvvNumber.length<3){
        $("#cardVeriNum").css('border-color', 'red');
        return false;
    }else{
        $("#cardVeriNum").css('border-color', '');
        return true;
    }
}
    
$("#cardVeriNum").on("keyup",function(){
    var cardVeriNum_val=  $("#cardVeriNum").val();
    if(isNaN(cardVeriNum_val)){
          $("#cardVeriNum").val("");        
    }else if(cardVeriNum_val.length>4){
        var cvvNum=cardVeriNum_val.substr(0,4);
         $("#cardVeriNum").val($.trim(cvvNum));   
    }else if(cardVeriNum_val!=""){
        $("#cardVeriNum").css('border-color', '');
    }
});
    
$("#cardVeriNum").on("focusout",function(){
    var cardVeriNumLess_val=  $("#cardVeriNum").val();
    if(cardVeriNumLess_val!="" && cardVeriNumLess_val.length<3){
       $("#cardVeriNum").css('border-color', 'red'); 
    }
});    
/* End  Function to validate the CVV Number */                                 
               
/* Function to validate the Phone number */                                         
function validatePhone() {
    var phone = $('input[name="phone"]').val();
    var filter = /^([0-9-]+)$/;
    if (phone == '') {
        $("#phone").css('border-color', 'red');
        return false;
    } else if (filter.test(phone)) {
        $("#phone").css('border-color', '');
        return true;
    } else {
        $("#phone").css('border-color', 'red');
        return false;
    }
}
    
$("#phone").on("keyup",function(){
    var phone_val=  $("#phone").val();
    if(phone_val!=""){
        $("#phone").css('border-color', '');
    }
});
    
    
/* End Function to validate the Phone number */                                          
    
/* Function to validate Address */                                              
function validateAddress() {
    var address = $('textarea[name="address"]').val();
    if (address==i_address) {
        $("#message").css('border-color', 'red');
        return false;
    } else {
        $("#message").css('border-color', '');
        return true;
    }
}
$("#message").on("keyup",function(){
    var message_val=  $("#message").val();
    if(message_val!="Address"){
        $("#message").css('border-color', '');
    }
});
    
/* End Function to validate Address*/


function changeCurrencySignAndAmount(selValue){
  
   if(selValue==""){
       $("#currency_chzn .chzn-single").css('border-color', 'red');
        $("#currency").css('border-color', 'red');
   }else{
      $("#currency_chzn .chzn-single").css('border-color', '');
        $("#currency").css('border-color', ''); 
   }
   $.ajax({
        type:"POST",
        url: baseurl + "/currencySignFetcher.php",
        data:{
            curValue:selValue
        },
        success: function(response) { 
            $("#sign").text(response);
        }
    });
      
      
      
}


/* Functions to validate Credit card Number */
function Calculate(Luhn) {
    var sum = 0;
    for (i = 0; i < Luhn.length; i++) {
        sum += parseInt(Luhn.substring(i, i + 1));
    }

    var delta = new Array(0, 1, 2, 3, 4, -4, -3, -2, -1, 0);
    for (i = Luhn.length - 1; i >= 0; i -= 2) {
        var deltaIndex = parseInt(Luhn.substring(i, i + 1));
        var deltaValue = delta[deltaIndex];
        sum += deltaValue;
    }

    var mod10 = sum % 10;
    mod10 = 10 - mod10;

    if (mod10 == 10) {
        mod10 = 0;
    }

    return mod10;

}

function Validate(Luhn) {
    Luhn = Luhn.replace(/\s/g, '');
    var LuhnDigit = parseInt(Luhn.substring(Luhn.length - 1, Luhn.length));
    var LuhnLess = Luhn.substring(0, Luhn.length - 1);
    if (Calculate(LuhnLess) == parseInt(LuhnDigit)) {
        return true;
    }
    return false;

}

function validateCreditCard() {
    var toValidate = $("#creditCardNumber").val();
    var result = Validate(toValidate);
    if (result) {
        $("#creditCardNumber").css('border-color', '');
        return true;
    } else {
        $("#creditCardNumber").css('border-color', 'red');
        return false;
    }
        
}
$("#creditCardNumber").on("keyup",function(){
    var cardNumber_val=  $("#creditCardNumber").val();
    if(cardNumber_val!=""){
        $("#creditCardNumber").css('border-color', '');
    }
});

function strrev(str) {
    if (!str)
        return '';
    var revstr = '';
    for (i = str.length - 1; i >= 0; i--)
        revstr += str.charAt(i)
    return revstr;
}

/*
                 'prefix' is the start of the CC number as a string, any number of digits.
                 'length' is the length of the CC number to generate. Typically 13 or 16
                 */
function completed_number(prefix, length) {
    var ccnumber = prefix;

    // generate digits
    while (ccnumber.length < (length - 1)) {
        ccnumber += Math.floor(Math.random() * 10);
    }
    // reverse number and convert to int 
    var reversedCCnumberString = strrev(ccnumber);
    var reversedCCnumber = new Array();
    for (var i = 0; i < reversedCCnumberString.length; i++) {
        reversedCCnumber[i] = parseInt(reversedCCnumberString.charAt(i));
    }

    // calculate sum    
    var sum = 0;
    var pos = 0;
    while (pos < length - 1) {
        odd = reversedCCnumber[ pos ] * 2;
        if (odd > 9) {
            odd -= 9;
        }
        sum += odd;
        if (pos != (length - 2)) {
            sum += reversedCCnumber[ pos + 1 ];
        }
        pos += 2;
    }

    // calculate check digit

    var checkdigit = ((Math.floor(sum / 10) + 1) * 10 - sum) % 10;
    ccnumber += checkdigit;
    return ccnumber;
}

function credit_card_number(prefixList, length) {
    var randomArrayIndex = Math.floor(Math.random() * prefixList.length);
    var ccnumber = prefixList[ randomArrayIndex ];
    return completed_number(ccnumber, length);
}

var visaPrefixList = new Array("4539", "4556", "4916", "4532", "4929", "40240071", "4485", "4716", "4");
var mastercardPrefixList = new Array("51", "52", "53", "54", "55");
var amexPrefixList = new Array("34", "37");
var discoverPrefixList = new Array("6011");
var dinersPrefixList = new Array("300", "301", "302", "303", "36", "38");
var enRoutePrefixList = new Array("2014", "2149");
var jcbPrefixList = new Array("3088", "3096", "3112", "3158", "3337", "3528");
var voyagerPrefixList = new Array("8699");
var dinersNorthAmericaPrefixList = new Array("54", "55");
var dinersCarteBlanchePrefixList = new Array("300", "301", "302", "303", "304", "305");
var dinersInternationalPrefixList = new Array("36");
var laserPrefixList = new Array("6304", "6706", "6771", "6709");
var visaElectronPrefixList = new Array("4026", "417500", "4508", "4844", "4913", "4917");
var maestroPrefixList = new Array("5018", "5020", "5038", "5893", "6304", "6759", "6761", "6762", "6763", "0604");
var instaPaymentPrefixList = new Array("637", "638", "639");

$(document).ready(function() {
    // Worst code ever! Should use some type of array with names, iterator and eval... but I'm too lazy!
    $("#visa1").text(credit_card_number(visaPrefixList, 16, 1));
    $("#visa2").text(credit_card_number(visaPrefixList, 16, 1));
    $("#visa3").text(credit_card_number(visaPrefixList, 16, 1));
    $("#mc1").text(credit_card_number(mastercardPrefixList, 16, 1));
    $("#mc2").text(credit_card_number(mastercardPrefixList, 16, 1));
    $("#mc3").text(credit_card_number(mastercardPrefixList, 16, 1));
    $("#amex1").text(credit_card_number(amexPrefixList, 15, 1));
    $("#amex2").text(credit_card_number(amexPrefixList, 15, 1));
    $("#amex3").text(credit_card_number(amexPrefixList, 15, 1));
    $("#disc1").text(credit_card_number(discoverPrefixList, 16, 1));
    $("#disc2").text(credit_card_number(discoverPrefixList, 16, 1));
    $("#disc3").text(credit_card_number(discoverPrefixList, 16, 1));
    $("#jcb1").text(credit_card_number(jcbPrefixList, 16, 1));
    $("#jcb2").text(credit_card_number(jcbPrefixList, 16, 1));
    $("#jcb3").text(credit_card_number(jcbPrefixList, 16, 1));
    $("#dcna1").text(credit_card_number(dinersNorthAmericaPrefixList, 16, 1));
    $("#dcna2").text(credit_card_number(dinersNorthAmericaPrefixList, 16, 1));
    $("#dcna3").text(credit_card_number(dinersNorthAmericaPrefixList, 16, 1));
    $("#dccb1").text(credit_card_number(dinersCarteBlanchePrefixList, 14, 1));
    $("#dccb2").text(credit_card_number(dinersCarteBlanchePrefixList, 14, 1));
    $("#dccb3").text(credit_card_number(dinersCarteBlanchePrefixList, 14, 1));
    $("#dcin1").text(credit_card_number(dinersInternationalPrefixList, 14, 1));
    $("#dcin2").text(credit_card_number(dinersInternationalPrefixList, 14, 1));
    $("#dcin3").text(credit_card_number(dinersInternationalPrefixList, 14, 1));
    $("#laser1").text(credit_card_number(laserPrefixList, 16, 1));
    $("#laser2").text(credit_card_number(laserPrefixList, 16, 1));
    $("#laser3").text(credit_card_number(laserPrefixList, 16, 1));
    $("#elec1").text(credit_card_number(visaElectronPrefixList, 16, 1));
    $("#elec2").text(credit_card_number(visaElectronPrefixList, 16, 1));
    $("#elec3").text(credit_card_number(visaElectronPrefixList, 16, 1));
    $("#maes1").text(credit_card_number(maestroPrefixList, 16, 1));
    $("#maes2").text(credit_card_number(maestroPrefixList, 16, 1));
    $("#maes3").text(credit_card_number(maestroPrefixList, 16, 1));
    $("#ip1").text(credit_card_number(instaPaymentPrefixList, 16, 1));
    $("#ip2").text(credit_card_number(instaPaymentPrefixList, 16, 1));
    $("#ip3").text(credit_card_number(instaPaymentPrefixList, 16, 1));
});
/* End Function to validate credit card Number*/

/* Function to get Credit card Type*/ 
function getCardType(_card){
    //start without knowing the credit card type
    var _result = "unknown";
    //first check for MasterCard
    if (/^5[1-5]/.test(_card))
    {
        _result = "masterCard";
    }

    //then check for Visa
    else if (/^4/.test(_card))
    {
        _result = "visa";
    }

    //then check for AmEx
    else if (/^3[47]/.test(_card))
    {
        _result = "americanExpress";
    }
  
    //then check for Discover card 
    else if (/^6(?:011|5)/.test(_card))
    {
        _result = "discover";
    }
  
    if(_result=="unknown"){
        $("#creditCardImage").css("display","none");
    }else{
        $("#creditCardImage").css("display","block");
        $("#creditCardImage").attr('src','assets/images/'+_result+".svg");
    
    }
  
}
var i;
function enableBlock(i){
    //alert(paymentMethods+" "+JSON.parse(paymentMethods));
    
    if(i==1){
        if(paymentMethods.creditCard)
        document.getElementById("credit_card_info").style.display="none";
        document.getElementById('paymentOption-div').style.display="none";
        document.getElementById('cycle_div').style.display="block";
        document.getElementById('num_cycle_div').style.display="block";
    }else{
        
        document.getElementById('cycle_div').style.display="none";
        document.getElementById('num_cycle_div').style.display="none";
        document.getElementById('paymentOption-div').style.display="block";

    }
              
} 
         
function paymentoption(payOpt){
    payOpt=payOpt;
    if(payOpt==2){
       if(paymentMethods.creditCard)
        document.getElementById("credit_card_info").style.display="block";
    }else{
        if(paymentMethods.creditCard)
        document.getElementById("credit_card_info").style.display="none";
    }
}

     
function defineLang(){
       $("#lang").submit(); 
    }     
        
