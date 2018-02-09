
    <body onload="initialLook()">
              <div style="text-align:center">
                      <span class="">
                               <a style="text-decoration:none;" href="includes/order_history/ordersdetail/displayOrderHistory.php">View Transaction History</a>
                      </span>
              </div>
        <div class="form-container">

            <!-- Header -->
            <div class="donate-heading">
                <h2><?php echo TITLE;?></h2>
                <?php if(MULTILINGUAL){?>
                <div class="lang">
                    <!--check-->
                    <form id="lang" action="" method="post"> 
                         
                    <select style="width:200px" class="tech" name="language" id="tech" onchange="defineLang()"> 
                        <?php 
                          $slang= (isset($_POST['language'])? $_POST['language']:(isset($_SESSION['language'])?$_SESSION['language']:NULL));
                          
                        echo getLanguageInDropDown($slang);?>
                        
                    </select> 
                    </form>    
                    

                </div>
                <?php } ?>
            </div>
            

            <!-- Content -->
            <div class="form-content"> 
                <div id="popupWait" ><b><img src="<?php SITEPATH ?>assets/images/preloader.gif" /></b></div>
                <div class="modal donate-form">
                    <div class="modal-dialog">
                        <div class="modal-body">                    
                            <!--               form Start     -->
                            <form action="includes/payment/index.php" method="post" enctype="multipart/form-data" name="frmdata" id="formData">
                              
                                 <input type="hidden" name="pLang" id="pLang" value="<?php echo $_SESSION['language']?>"/>
                                <!--  Currency Select box Division -->
                                
                                <div class="select-country">
                                    <div class="form-group  ">
                                        <div class="dropdown">
                                            <select name="currency" id="currency" class="selectBox" onchange="changeCurrencySignAndAmount(this.value)">
                                                <?php echo getCurrencyInDropDown();?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <!--     End Currency Select Box-->

                                <!--  Donation Amounts tag-->
                                <div class="content-inner-section">
                                    <div class="row">                            
                                        <div class="form-group ">
                                            <fieldset>
                                                <legend><?php echo DONATIONTEXT; ?></legend>
                                                <div class="choose-pricing">
                                                    <div class="btn-group">
                                                        <?php for ($i = 0; $i < count($donationAmount); $i++) {
                                                            if ($i == 0) {
                                                                ?>
                                                                <button type="button" class="btn btn-default active selectvalue">
                                                                <?php echo $donationAmount[$i]; ?>
                                                                </button>
                                                                <?php } else { ?>
                                                                <button type="button" class="btn btn-default selectvalue">
                                                                <?php echo $donationAmount[$i]; ?>                                                
                                                                </button>
                                                            <?php }
                                                        }
                                                        ?>
                                                        <!--                                            <button type="button" class="btn btn-default selectvalue">
<?php echo $donationAmount[2]; ?>
                                                                                                    </button>-->
                                                        <input type="text" placeholder="<?php echo CUSTOM; ?>" name="donation-amount" class="inpt-first form-control " id="donation-amount" onclick="if (this.defaultValue==this.value) this.value=''" onblur="if (this.value=='') this.value=this.defaultValue" value="<?php echo CUSTOM;?>">
                                                        <input type="hidden" name="donation-amount-value"  id="donation-amount-value" value=""/>
                                                    </div>                                        
                                                    <div class="money-donate">
<?php ?>
                                                        <span id="displayAmount"><span id="sign"><?php echo $selected_currency_sign; ?></span><span id="amountToShow"><?php echo $donationAmount[0]; ?></span></span>
                                                    </div>                                                      
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div> 

                                    <!-- End Donation Amounts tag-->            

                                    <!--   Payment Type Section-->
                                    <div class="select-payment-type"> 
                                        <fieldset>
                                            <legend class="upper">
                                            <?php echo PAYMENTTYPE; ?>
                                            </legend>
                                            <?php if ($paymentMethods['recurring']) { ?>
                                                    <span class="radio-wrapper req " id="recurring-not-allow"><input type="radio" onclick="enableBlock(1)" name="paymentType" value="1" id="radio-rec"><span><?php echo RECCURING; ?></span> 
                                                        </span>
                                            <?php } ?>
                                            <?php if ($paymentMethods['paypal'] || $paymentMethods['creditCard'] || $paymentMethods['bankingTransfer'] || $paymentMethods['StripePay']) { ?>
                                                <span class="radio-wrapper pay active" id="oneTime-not-allow"><input type="radio" onclick="enableBlock(2)" name="paymentType" value="2" checked><span><?php echo ONETIMEPAYMEMT  ?></span></span>
<?php } ?>
                                            <p style="color:red" id="payment-type-error"></p>
                                        </fieldset>
                                    </div>
                                    <!--    End  Payment Type Section       -->




                                    <!--  Div block for selecting cycle of recurring period -->
                                    <div class="select-payment-container">
                                        <div class="row display cycle" style="display: none" id="cycle_div">
                                            <span class="full"><?php echo SELECTPAYCYCLE;?> </span>
                                            <select name="cycle" id="cycle" class="selectBox" onchange="validateCycle()">
                                                <?php echo getCycleInDropDown(); ?>
                                                
                                            </select>
                                        </div>
                                        <!-- End  Div block for selecting cycle of recurring period -->                



                                        <!--   Div block for selecting number of cycle of recurring period -->

                                        <div class="row display" style="display: none" id="num_cycle_div">
                                            <span class="full"><?php echo SELECTPAYCYCLETIME;?></span>
                                            <select name="nubOfCycle" id="num_cycle" class="selectBox" onchange="validateNumberOfCycle()" >
                                               <?php echo getNumberOfCycle();?>
                                                
                                                
                                                
                                            </select>
                                                                       
                                        </div>
                                    </div>
                                    <!-- End  Div block for selecting number of cycle of recurring period -->

                                    <!--    Div Block for Select payment Option    -->
                                    <div class="row display cycle" style="" id="paymentOption-div">
                                        <div class="payment-mode">
                                            <h3 class="pay-mode-heading"><?php echo SELPAYOPT;?></h3>
                                            <div class="pay-mod">
                                               <?php if($paymentMethods['creditCard']){?>
                                                <span class="link <?php echo $creditCard; ?> creditcard" id="2"><?php echo CREDITCARD;?></span>                                
                                               <?php } ?>
                                                 <?php if($paymentMethods['bankingTransfer']){?>
                                                <span id="3" class="banking-transfer <?php echo $banktransfer; ?>"><?php echo BANKTRANSFER;?></span>
                                                 <?php } ?>
                                                <?php if($paymentMethods['paypal']){?> 
                                                <span id="1" class="paypal <?php echo $paypal; ?>"><?php echo PAYPAL;?></span>
                                                <?php } ?>
                                                <?php if($paymentMethods['StripePay']){?> 
                                                <span id="4" class="link  paypal <?php echo $StripePay; ?>"><?php echo STRIPEPAY;?></span>
                                                <?php } ?>
                                            </div>
                                            <input type="hidden" name="pay-mod" id="pay-mod" value="">
                                            <?php if($paymentMethods['creditCard']){?>
                                            <p id="creMsg"><?php echo getDispayTextForCreditCard($paymentMode); ?></p>
                                            <?php } ?>
                                        </div>                       
                                    </div>
                                    <!--   Div block for Credit Card Detail     -->
                                     <?php if($paymentMethods['creditCard'] || $paymentMethods['StripePay']){?>
                                    <div class="row display cycle"  id="credit_card_info"  >
                                        <span class="full card-type-label"><?php echo CARDTYPE; ?> :</span> <select name="cardType"  id="cardType" class="selectBox" onchange="validateCardType()">
                                           <?php echo getCardTypeInDropDown();?>
                                        </select><br><br>
                                        <span class="full"><?php echo MSGFORCARDDIGIT; ?>:</span>
                                        <div class="credit-card-num">
                                            <input type="text"  name="cardNumber" id="creditCardNumber" value="XXXX-XXXX-XXXX-XXXX" onkeyup="getCardType(this.value)" onblur="getCardType(this.value)"    onclick="if (this.defaultValue==this.value) this.value=''" 
                                                   >
                                            <img src="" width="48" height="30" alt="" id="creditCardImage"/>                            
                                        </div>
                                        <br>
                                        <div class="date-wrapper">
                                            <div class="month">
                                                <span class="full"><?php echo MONTHANDYEAROFEXPIRY; ?>:</span>
                                                <select name="month" id="expMonth" class="selectBox" onchange="validateMonth()">
                                                    
                                                    <?php echo getMonthInDrowDown();?>
                                                  
                                                </select>
                                                <select name="year" id="expYear" class="selectBox" onchange="validateYear()">
                                                    <option value=""><?php echo SELYEAR; ?></option>
                                                    <?php
                                                    for ($i = date("Y"); $i <= date("Y") + 10; $i++) {
                                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="cvn">
                                                <span class="full"><?php echo CARDVERINUM; ?>
                                                    <a href="#" class="tooltip"><img src="assets/images/question-mark.png" width="18" height="18" alt="Question" title="CVV"  /></a>
                                                    <div class="tooltip-hover"><img src="assets/images/cvv_code.jpg" width="280" height="201"></div>
                                                </span>
                                                <input type="password" name="cardVeriNum" id="cardVeriNum"/>                            
                                            </div>
                                        </div>
                                    </div>
                                     <?php } ?>

                                    <!--  benevolent Detail Section -->
                                    <fieldset class="personal-detail">
                                        <legend class="upper"><?php echo PERSONALDETAIL;?></legend>                      	
                                        <div class="row">
                                            <div class="form-group ">
                                                <input type="text" name="name" class="form-control" id="name" value="<?php echo NAME;?>" onclick="if (this.defaultValue==this.value) this.value=''" 
                                                       onblur="if (this.value=='') this.value=this.defaultValue">
                                                <input type="text" name="last_name" class="form-control right" id="last_name" value="<?php echo LNAME;?>" onclick="if (this.defaultValue==this.value) this.value=''" 
                                                       onblur="if (this.value=='') this.value=this.defaultValue">
                                            </div>          
                                        </div>
                                        <div class="row">
                                            <div class="form-group ">
                                                <input type="text" name="email" class="form-control" id="email" value="<?php echo EMAIL;?>" onclick="if (this.defaultValue==this.value) this.value=''" 
                                                       onblur="if (this.value=='') this.value=this.defaultValue">
                                                <input type="text" name="phone" class="form-control right" id="phone" value="<?php echo PHONE;?>" onclick="if (this.defaultValue==this.value) this.value=''" 
                                                       onblur="if (this.value=='') this.value=this.defaultValue">
                                            </div>      
                                        </div>

                                        <div class="row">
                                            <div class="form-group ">
                                                <textarea class="form-control" name="address" id="message" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"><?php echo ADDRESS;?></textarea>
                                                <textarea class="form-control" id="add-note" name="notes" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" ><?php echo ADDITIONALNOTE;?></textarea>

                                            </div>
                                        </div>


                                        <!--  End benevolent Detail Section-->
                                        <div class="row">
                                            <div class="form-group button">
                                                <input type="button" id="donate-btn" value="<?php echo DONATE ?>" class="btn btn-default pull-right">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->      
        </div>

        
        
<?php include 'includes/footer.php'; ?>   
    </body>

