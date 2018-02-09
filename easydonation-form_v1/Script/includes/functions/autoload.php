<?php

function __autoload($class_name) {
    $file = '../../classes/' . $class_name . '.php';
    if (file_exists($file))
        require_once($file);
    else
        die(FILENOTFOUND);
}

/**
 * Function to get form action
 * 
 * @access public
 * @param int $mode
 * @return string 
 * 
 */
function getFormAction($mode) {
    if ($mode == 1) {
        return FORLIVEURL;
    } else {
        return FORSANDURL;
    }
}

/* End */

/**
 * Function to get display text for credit card 
 * 
 * @access public
 * @param int $mode
 * @return string 
 * 
 */
function getDispayTextForCreditCard($mode) {

    if ($mode !== 1) {
        return CREDITCARDMSG;
    } else {
        return "";
    }
}

/* End */

/**
 * Function to get name
 * 
 * @access public
 * @param no parameter
 * @return string 
 * 
 */
function getName() {
    if (isset($_GET['name'])) {
        return $_GET['name'];
    } else if (isset($_REQUEST['custom'])) {
        $custArr = explode("---", $_REQUEST['custom']);
        $fName = $custArr[0];
        $lName = $custArr[1];
        $fullName = $fName . " " . $lName;
        return $fullName;
    } else if (isset($_SESSION['creditcardsession'])) {
        return $_SESSION['creditcardsession'][fname];
    }
}

/* End */

/**
 * Function to get currency
 * 
 * @access public
 * @param no parameter
 * @return string 
 * 
 */
function getCurrency() {
    if (isset($_GET['currency'])) {
        return $_GET['currency'];
    } else if (isset($_REQUEST['custom'])) {
        return $_REQUEST['mc_currency'];
    } else if (isset($_SESSION['creditcardsession'])) {

        return $_SESSION['creditcardsession']['mc_currency'];
    }
}

/* End */

/**
 * Function to get Transaction Id
 * 
 * @access public
 * @param no parameter
 * @return string 
 * 
 */
function getTransactionId() {

    if (isset($_REQUEST['custom'])) {
        $custom = $_REQUEST['custom'];
        $data = explode("---", $custom);
        if (count($data) == 8) {
            return $_REQUEST['txn_id'];
        } else {
            include 'configuration.php';
            $tranId = '';
            if (($fp = fopen(SITEPATH . "includes/order_history/" . TRANDETAILPAGENAME . ".csv", "r")) !== FALSE) {
                $row = 1;
                while ($data = fgetcsv($fp, 10000, ",")) {
                    if ($row != 1) {
                        if (trim($data[17]) == $_REQUEST['subscr_id']) {
                            $tranId = $data[9];
                            $tranStatus = $data[14];
                        }
                    } $row++;
                }
            } else {
                echo FILENOTFOUND;
            }
            if ($tranId == '') {
                $tranId = UPDATEDATBASE;
            }
            return $tranId;
        }
    } else if (isset($_SESSION['creditcardsession'])) {
        return $_SESSION['creditcardsession']['txn_id'];
    }
}

/* End */

/**
 * Function to get Transaction Date 
 * 
 * @access public
 * @param no parameter
 * @return string 
 * 
 */
function getTransactionDate() {
    if (isset($_GET[amount]) || isset($_GET['mc_gross'])) {
        return Date("Y-M-d");
    } else if (isset($_REQUEST['custom'])) {
        $custom = $_REQUEST['custom'];
        $data = explode("---", $custom);


        if (count($data) == 8) {
            return date("Y-M-d", strtotime($_REQUEST['payment_date']));
        } else {
            return date("Y-M-d", strtotime($_REQUEST['subscr_date']));
        }
    } else if (isset($_SESSION['creditcardsession'])) {
        return date("Y-M-d", strtotime($_SESSION['creditcardsession']['paymentDate']));
    }
}

/* End */

/**
 * Function to get Transaction Amount
 * 
 * @access public
 * @param no parameter
 * @return string 
 * 
 */
function getAmount() {
    if (isset($_GET[amount])) {
        $SignC = getCurrencySymbol($_GET['currency']);
        $r_str = $SignC . " " . $_GET['amount'];
        return $r_str;
    } else if (isset($_GET['mc_gross'])) {
        $SignC = getCurrencySymbol($_GET['currency']);
        $r_str = $SignC . " " . $_GET['mc_gross'];
        return $r_str;
    } else if (isset($_REQUEST['custom'])) {
        $custom = $_REQUEST['custom'];
        $data = explode("---", $custom);


        if (count($data) == 8) {
            $SignC = getCurrencySymbol($_REQUEST['mc_currency']);
            $r_str = $SignC . " " . $_REQUEST['mc_gross'];
            return $r_str;
        } else {
            $SignC = getCurrencySymbol($_REQUEST['mc_currency']);
            $r_str = $SignC . " " . $_REQUEST['mc_amount3'];


            return $r_str;
        }
    } else if (isset($_SESSION['creditcardsession'])) {
        $SignC = getCurrencySymbol($_SESSION['creditcardsession']['mc_currency']);
        $r_str = $SignC . " " . $_SESSION['creditcardsession']['mc_gross'];
        return $r_str;
    }
}

/* End */

/**
 * Function to get Bank Detail
 * 
 * @access public
 * @param no parameter
 * @return HTML 
 * 
 */
function getBankDetails() {
    $bankDetail.='<table class="bankDetail">
                                <tr><td><strong>' . LOCALPAYMENT . '</strong></td></tr><tr></tr><tr></tr><tr></tr>
                                <tr><td><label>' . PAYABLETO . '</label><span>: &nbsp;' . LPAYABLETO . '</span></td></tr>
                                <tr><td><label>' . BANKNAME . '</label><span>: &nbsp;' . LBANKNAME . '</span></td></tr>
                                <tr><td><label>' . ACCOUNTNUMBER . '</label> <span>: &nbsp;' . LACCOUNTNUMBER . '</span></td></tr>
                                <tr><td><label>' . BRANCHCODE . '</label> <span>: &nbsp;' . LBRANCHCODE . '</span></td></tr>
                                <tr><td></td></tr><tr></tr><tr></tr><tr></tr><tr></tr>
                                <tr><td><strong>' . INTERNATIONALPAYMENT . '</strong></td></tr><tr></tr><tr></tr><tr></tr>
                                <tr><td><label>' . PAYABLETO . '</label><span>: &nbsp;' . IPAYABLETO . '</span></td></tr>
                                <tr><td><label>' . BANKNAME . '</label><span>: &nbsp;' . IBANKNAME . '</span></td></tr>
                                <tr><td><label>' . BIC . '</label> <span>: &nbsp;' . IBIC . '</span></td></tr>
                                <tr><td><label>' . IBANNUMBER . '</label> : &nbsp;' . IACCOUNTNUMBER . '</span></td></tr>
                                <tr><td><label>' . STREETADDRESS . '</label><span>: &nbsp;' . ISTREETADDRESS . '</span></td></tr>
                                <tr><td><label>' . POSTALADDRESS . '</label> <span>: &nbsp;' . IPOSTALCODE . '</span></td></tr>
                                <tr><td><label>' . TELEPHONENUMBER . '</label> <span>: &nbsp;' . ITELEPHONE . '</span></td></tr>
                                <tr><td><label>' . FAXNUMBER . '</label> <span>: &nbsp;' . IFAXNUMBER . '</span></td></tr>
                                <tr><td><label>' . BRANCHCODE . '</label> <span>: &nbsp;' . IBRANCHCODE . '</span></td></tr>
                                <tr><td> </td></tr></table>';
    return $bankDetail;
    exit();
}

/* End */

/**
 * Function to get language name by code
 * 
 * @access public
 * @param sting $code
 * @return string $language 
 * 
 */
function getLanguageName($langCode) {
    $langFilePath = SITEPATH . "includes/dropdownXml/language.xml";
    if (INSTALLED == 0) {
        $assPath = strstr($_SERVER['REQUEST_URI'], 'includes', true);
        $langFilePath = SITEPATH . $assPath . "includes/dropdownXml/language.xml";
    }
    $crrcyDetail = (array) simplexml_load_file($langFilePath);
    $keyword = $crrcyDetail['keyword'];
    $name = $crrcyDetail['name'];
    $index = array_search($langCode, $keyword);
    if ($index) {
        $langName = $name[$index];
    } else {
        $langName = $name[0];
    }
    return $langName;
}

/**
 * Function to get currency symbol
 * 
 * @access public
 * @param sting $currency
 * @return string $currSign 
 * 
 */
function getCurrencySymbol($currency) {
    $langFilePath = SITEPATH . "includes/dropdownXml/currency.xml";
    if (INSTALLED == 0) {
        $assPath = strstr($_SERVER['REQUEST_URI'], 'includes', true);
        $langFilePath = SITEPATH . $assPath . "includes/dropdownXml/currency.xml";
    }
    $crrcyDetail = (array) simplexml_load_file($langFilePath);
    $value = $crrcyDetail[value];
    for ($i = 0; $i < count($value); $i++) {
        if ($value[$i] == $currency) {
            $CurrSign = $crrcyDetail['sign'][$i];
        }
    }
    return $CurrSign;
}

/* End */

/**
 * Function to get currency in dropdown
 * 
 * @access public
 * @param no parameter
 * @return HTML 
 * 
 */
function getCurrencyInDropDown() {
    global $valuesInXml;
    global $xml;
    $sel1 = "";
    $selected_currency_page = "";
    $currSelectBox = '<option value="">' . SELCURR . '</option>';
    for ($i = 0; $i < $valuesInXml; $i++) {
        if ($_POST['currency'] === $xml[value][$i]) {
            $sel1 = 'selected="selected"';
            $selected_currency_sign = $xml[sign][$i];
            $selected_currency_page = 1;
        } elseif (DEFAULT_CURRENCY === $xml[value][$i]) {
            $sel1 = 'selected="selected"';
            $selected_currency_sign = $xml[sign][$i];
            $selected_currency_page = 1;
        } else {
            $sel1 = "";
        }
        $currSelectBox.= '<option ' . $sel1 . ' value="' . $xml[value][$i] . '">' . $xml[name][$i] . '</option>';
    }
    if (!$selected_currency_page) {
        $selected_currency_sign = "";
    }
    return $currSelectBox;
}

/* End */

/**
 * Function to get Card type 
 * 
 * @access public
 * @param no parameter
 * @return HTML 
 * 
 */
function getCardTypeInDropDown() {
    $cardTypeDropDown = '<option value="">' . SELCARDTYPE . '</option>';
    $cardTypeDropDown.='<option value="VISA">' . VISA . '</option>
        <option value="MasterCard">' . MASTERCARD . '</option> 
        <option value="Discover">' . DISCOVER . '</option> 
        <option value="American Express">' . AMERICANEXP . '</option>';

    return $cardTypeDropDown;
}

/* End */

/**
 * Function to get month in dropdown
 * 
 * @access public
 * @param no parameter
 * @return HTML 
 * 
 */
function getMonthInDrowDown() {
    $selMonthDropDown = '<option value="">' . SELMONTH . '</option>';
    for ($i = 1; $i <= 12; $i++) {
        $selMonthDropDown.= '<option value="' . $i . '">' . $i . '</option>';
    }
    return $selMonthDropDown;
}

/* End */

/**
 * Function to get cycle in dropdown
 * 
 * @access public
 * @param no parameter
 * @return HTML 
 * 
 */
function getCycleInDropDown() {
    $cycleDrowDown = '<option value="">' . SELECTCYCLE . '</option>';
    $cycleDrowDown.='<option value="Weekly">' . WEEKLY . '</option>
                       <option value="Montly">' . MONTHLY . '</option>
                      <option value="Yearly">' . YEARLY . '</option>';
    return $cycleDrowDown;
}

/* End */

/**
 * Function to get currency in dropdown
 * 
 * @access public
 * @param no parameter
 * @return HTML 
 * 
 */
function getNumberOfCycle() {
    $numberOfCycleDrowDown = '<option value="">' . NOCYCLE . '</option>';
    for ($i = 1; $i <= NUMBEROFCYCLE; $i++) {
        $numberOfCycleDrowDown.= '<option value="' . $i . '">' . $i . '</option>';
    }
    return $numberOfCycleDrowDown;
}

/* End */

/**
 * Function to get language in dropdown
 * 
 * @access public
 * @param string $lang
 * @return HTML 
 * 
 */
function getLanguageInDropDown($lang) {
    $langFilePath = SITEPATH . "includes/dropdownXml/language.xml";
    if (INSTALLED == 0) {
        $langFilePath = SITEPATH . $_SERVER['REQUEST_URI'] . "includes/dropdownXml/language.xml";
    }
    $langDetail = (array) simplexml_load_file($langFilePath);
    $keyword = $langDetail['keyword'];
    $langDropDown = '<option value="" >Select Language</option>';
    for ($i = 0; $i < count($keyword); $i++) {
        if ($keyword[$i] == $lang) {
            $langDropDown.='<option selected="selected" value="' . $keyword[$i] . '" data-image="./assets/images/' . $langDetail['imagename'][$i] . '">' . $langDetail[name][$i] . '</option>';
        } else {
            $langDropDown.='<option  value="' . $keyword[$i] . '" data-image="./assets/images/' . $langDetail['imagename'][$i] . '">' . $langDetail[name][$i] . '</option>';
        }
    }
    return $langDropDown;
}

/**
 * Function to add header content
 * 
 * @access public
 * @param no parameter
 * @return HTML 
 * 
 */
function headContent() {
    include '../../assets/css/styles.css';
}

/* End */

/**
 * Function to create record file
 * 
 * @access public
 * @param string $filename
 * @return HTML 
 * 
 */
function createFile($filename) {

    if (!file_exists(ORDERCSVPATH . $filename . ".csv")) {
        touch(ORDERCSVPATH . $filename . ".csv");
        $cvvArrHead = array(
            NAME,
            LNAME,
            EMAIL,
            ADDRESS,
            ADDITIONALNOTE,
            PHONE,
            DONATIONAMOUNT,
            PAYMENTTYPE,
            PAYMENTMODE,
            TRANSACTIONID,
            TRANSACTIONDATE,
            CURRENCY,
            CYCLETYPE,
            NUMBEROFCYCLETEXT,
            TRANSACTIONSTATUS,
            CARDNUMBER,
            CARDTYPE,
            SUBSCRIID
        );
        $fp = fopen("../order_history/" . TRANDETAILPAGENAME . ".csv", "a");
        fputcsv($fp, $cvvArrHead);
        fclose($fp);
    }
    return true;
}

/* End */

/**
 * Function to get rewriting information of server
 * 
 * @access public
 * 
 * @param no parameter
 * 
 * @return Boolean 
 */
function get_rewrite_module_info1() {
    return in_array('mod_rewrite', apache_get_modules());
}

function get_rewrite_module_info() {
    $rewrite = FALSE;
    $server_api = php_sapi_name();
    if ($server_api == 'apache2handler') {
        if (in_array('mod_rewrite', apache_get_modules())) {
            $rewrite = TRUE;
        }
    } else if (preg_match('/^cgi.*/', $server_api)) {
        $rewrite = FALSE;
    }
    
    return $rewrite;
}

/**
 * Function to redirecting one page to another page 
 * 
 * @access public
 * @param string $page
 * @return void
 * 
 */
function redirect($page) {
    if (!headers_sent())
        header("location:$page");
    else
        echo "<script>window.location.href='$page'</script>";
}

/*End*/
