
<body onload="popupLook()">


    <div id="fade" class="black_overlay">

        <div class="white_content">
            <form action="includes/install/index.php" method="post" name="install_f" id = "install_f" >
                <fieldset>

                    <h2>XYZ.Com - Make a Donation</h2>

                    <div class="box-content">

                        <div class="box box-1 active" id="box-1">
                            <h3>Admin Detail</h3>
                            <span class="row">
                                <label>Admin Email Id</label>
                                <input type="text" placeholder="Admin Email Id" name="admin_email_id" id="admin_email_id" value="" />
                            </span>
                            <span class="row">
                                <label>Site Email Id</label>
                                <input type="text" placeholder="Site Email Id" name="site_email_id" id="site_email_id" value="" />
                            </span>

                        </div>

                        <div class="box box-2 inactive" id="box-2">
                            <div class="payment-gateway">
                                <h3>Payment Gateway Information</h3>
                                <span class="row">

                                    <label><input type="checkbox"  name="paypal" value="1"  class="parentCheckBox" id="paypal"/> Paypal(Standard Or recurrsive)</label>
                                    <span class="paypal-mode">
                                        <label><input type="checkbox"  name="paypalrecurring" value="1" class="childCheckBox" />  Paypal Recurring Payment</label> 
                                        <label><input type="checkbox"  name="paypalstandard" value="1"  class="childCheckBox"/>  Paypal Standard payment</label>
                                    </span>

                                </span>
                                <span class="row">
                                    <label><input type="checkbox"  name="creditcard" value="2"  id="creditcard"/> Credit Card</label>

                                </span>
                                <span class="row">
                                    <label><input type="checkbox"  name="banktransfer" value="1" id="banktransfer" /> Bank Transfer</label>

                                </span>
                                <span class="row">
                                    <label><input type="checkbox"  name="stripe" value="1"  id="stripe"/> Stripe Payment Gateway</label>

                                </span>
                            </div>
                            <span></span>
                        </div>

                        <div class="box box-3 inactive" id="box-3">
                            <h3>Select Default Language</h3>
                            <div class="language">
                                <span class="row">
                                    <label>Select Language</label>
                                    <select style="width:100px !important; display: inline-block;" class="tech" name="language" id="tech" onchange="defineLang()"> 
                                        <?php
                                        $slang = (isset($_POST['language']) ? $_POST['language'] : (isset($_SESSION['language']) ? $_SESSION['language'] : NULL));

                                        echo getLanguageInDropDown($slang);
                                        ?>

                                    </select>
                                </span>
                            </div>

                        </div>
                        <div class="box box-4 inactive" id="box-4">
                            <h3>Select Default Currency</h3>
                            <span class="row">
                                <label>Currency</label>
                                <select name="currency" id="currency" class="selectBox" onchange="changeCurrencySignAndAmount(this.value)">
                                    <?php echo getCurrencyInDropDown(); ?>
                                </select>
                            </span>

                        </div>

                        <div class="box box-5 inactive" id="box-5">
                            <div class="payment-gateway">
                                <h3>Rewriting Url</h3>
                                <span class="row">
                                    <label><input type="checkbox"  name="rewriteurl" value="1" /> Rewrite Url</label>
                                </span>
                                <div class="payment-info">
                                    <p>It is a way of implementing URL mapping or routing within a web application. This modification  is called URL rewriting</p>
                                    <h1>Your System Url Rewriting Information </h1>
                                    <?php
                                    $rewrite = FALSE;
                                    $server_api = php_sapi_name();
                                    if ($server_api == 'apache2handler') {
                                        if (in_array('mod_rewrite', apache_get_modules())) {
                                            $rewrite = TRUE;
                                        }
                                    } else if (preg_match('/^cgi.*/', $server_api)) {
                                        $rewrite = FALSE;
                                    }
                                    if ($rewrite) {
                                        $response = "enable .";
                                    } else {
                                        $response = "disable . Please contact your host provider to enable it";
                                    }
                                    ?>
                                    <p class="last">Url Rewriting in your system is <?php echo $response; ?> </p>
                                </div>

                            </div>
                        </div>
                        <div class="box box-6 inactive" id="box-6">
                            <div class="loader-box">
                                <img src="assets/images/loader.gif" title="wait till process completion"/>

                            </div>
                        </div>



                    </div>

                    <div class="btn-box">

                        <input type="button" class="next" value="Next" />
                    </div>

                </fieldset>
            </form>	


        </div>


    </div>

    <?php include 'includes/footer.php'; ?>   
</body>
