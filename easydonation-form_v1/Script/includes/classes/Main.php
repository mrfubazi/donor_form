<?php

include '../../../configuration.php';

class Main {

    public function sendMailTo($data, $flag) {
        /*         * ** Data to be send** */

        if ($flag == 1) {// $flag=1 for Reccurring and paypal 
            $customMsg = explode("---", $data['custom']);
            $sendDate = array();
            $sendDate['fname'] = $customMsg[0];
            $sendDate['lname'] = $customMsg[1];
            $sendDate['paymentType'] = $customMsg[2];
            $sendDate['email'] = $customMsg[3];
            $sendDate['phone'] = $customMsg[4];
            $sendDate['address'] = $customMsg[5];
            $sendDate['note'] = $customMsg[6];
            $sendDate['itemName'] = $data['item_name'];
            $sendDate['cardNumber'] = NA;
            $sendDate['cardType'] = NA;
            $sendDate['paymentDate'] = date("Y-m-d", strtotime($data[payment_date]));
            $sendDate['transactionStatus'] = $data['payment_status'];
            if (count($customMsg) == 8) {
                $sendDate['noOfCycle'] = NA;
                $sendDate['cycle'] = NA;
            } else {
                $sendDate['noOfCycle'] = $customMsg[7];
                $sendDate['cycle'] = $data['transaction_subject'];
                $sendDate['subscr'] = $data['subscr_id'];
            }
            $sendDate['transactionId'] = $data[txn_id];
        } else if ($flag == 2 || $flag == 3 || $flag==5) {// $flag=2 for credit card and $flag=3 for banking transfer
           if($flag==5){
               $nameArr=  explode(" ", $data['name']);
               $sendDate['fname'] = $nameArr[0];
               $sendDate['lname'] = $nameArr[1];
           }else{
               $sendDate['fname'] = $data['fname'];
               $sendDate['lname'] = $data['lastName'];
           }
            
            if ($flag == 2 || $flag==5) {
                $sendDate['cardNumber'] = $data['creditCardNumber'];
               if($flag==5){
                $sendDate['cardType'] = VISA;   
               }else{
                 $sendDate['cardType'] = $data['creditCardType'];  
               }
                
                $sendDate['csv'] = $data['csv'];
                if($flag==5){
                    $sendDate['expDate'] = $data['month']."/".$data['year'];
                }else{
                    $sendDate['expDate'] = $data['expDate'];
                }
                
                $sendDate['paymentType'] = "Credit card";
                if($flag==5){
                     $sendDate['paymentDate'] = date("Y-m-d");
                }else{
                $sendDate['paymentDate'] = date("Y-m-d", strtotime($data['paymentDate']));
                }
                if($flag==5){
                    if($data['status']=="succeeded"){
                    $sendDate['transactionStatus'] =COMPLETED ;
                    }else{
                      $sendDate['transactionStatus'] =PENDING ;  
                    }
                }else{
                  $sendDate['transactionStatus'] = COMPLETED;  
                }
                
                $sendDate['transactionId'] = $data[txn_id];
                if($flag!=5){
                $sendDate['bussiness'] = $data[bussiness];
                }
            } else {
                $sendDate['cardNumber'] = NA;
                $sendDate['cardType'] = NA;
                $sendDate['csv'] = NA;
                $sendDate['expDate'] = NA;
                $sendDate['paymentType'] = BANKTRANSFER;
                $sendDate['paymentDate'] = date("Y-m-d");
                $sendDate['transactionStatus'] = PENDING;
                $sendDate['transactionId'] = NA;
            }
            $sendDate['email'] = $data['email'];
            $sendDate['phone'] = $data['phone'];
            $sendDate['address'] = $data['address'];
            $sendDate['note'] = $data['note'];
            $sendDate['noOfCycle'] = NA;
            $sendDate['cycle'] = NA;
        }
        $sendDate['currency'] = $data['mc_currency'];
        $sendDate['amount'] = $data[mc_gross];
        $sendDate['paymentMode'] = NULL;

        /*         * ** End Data to be Send*** */


        /*         * **Mail Id Details*** */
        $ato = ADMINEMAILID;
        $cto = $sendDate['email'];
        /*         * * End mail ** */

        /*         * **Msg to Send*** */
        if ($flag != 3) {
            $msgSendToAdmin = $this->DesignMsg($sendDate, 1);
            //$msgSendToBeno = $msgSendToAdmin;
            $msgSendToBeno.=$this->DesignMsg($sendDate, 2);
        } else {
            $msgSendToAdmin = $this->DesignMsg($sendDate, 1);
            $msgSendToBeno = $this->DesignMsg($sendDate, 2);
        }
        /*         * * End Msg to Send *** */

        /*         * * Subjects Information ** */
        $adminSub = SUBJECTTOADMIN;
        $benovelentSub = SUBJECTTOBENOVELENT;
        /*         * * End Subjects infomation** */


        /*         * ** Header Information *** */
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From:' . FROMEMAILID . '\r\n';
        /*         * ** Header Information *** */

        if (!isset($cto)) {
            unset($ato);
        }
          if ($ato != "" && $cto != "" && $sendDate['amount'] != "") {
        if (mail($ato, $adminSub, $msgSendToAdmin, $headers)) {
            mail($cto, $benovelentSub, $msgSendToBeno, $headers);
            if ($ato != "" && $cto != "" && $sendDate['amount'] != "") {
                $this->insertInCSV($sendDate, $flag);
            }
            //unset($ato);
            //unset($cto);
        } else {
            echo MAINPAGEERROR;
        }
         //exit();
          }
       
    }

// Function To Send Mail 
    function DesignMsg($data, $for) {

        $fullName = $data['fname'] . " " . $data['lname'];
        $fileName = $_SESSION['language'] . "-template.html";
        $file = file_get_contents(SITEPATH . "includes/mailTemplates/" . $fileName);
        $file = str_replace('[USERNAME]', $fullName, $file);
        $file = str_replace('[CURRENCY]', $data['currency'], $file);
        if ($data['paymentType'] == BANKTRANSFER) {
            
            $file = str_replace(ORDERID . ':[ORDERID]', "", $file);
           
        } else {
            $file = str_replace('[ORDERID]', $data['transactionId'], $file);
        }
        if ($data['paymentType'] == BANKTRANSFER) {
            $file = str_replace('display:none', 'display:block', $file);
            $file = str_replace('[border: 1px solid #cfcfcf;]', '', $file);
            $file = str_replace('[lpayableto]', LPAYABLETO, $file);
            $file = str_replace('[lbankname]', LBANKNAME, $file);
            $file = str_replace('[laccountnumber]', LACCOUNTNUMBER, $file);
            $file = str_replace('[lbranchcode]', LBRANCHCODE, $file);
            $file = str_replace('[ipayableto]', IPAYABLETO, $file);
            $file = str_replace('[ibankname]', IBANKNAME, $file);
            $file = str_replace('[iaccountnumber]', IACCOUNTNUMBER, $file);
            $file = str_replace('[ibic]', IBIC, $file);
            $file = str_replace('[ibranchcode]', IBRANCHCODE, $file);
            $file = str_replace('[istreetaddress]', ISTREETADDRESS, $file);
            $file = str_replace('[ipostaladdress]', IPOSTALCODE, $file);
            $file = str_replace('[itelephonenumber]', ITELEPHONE, $file);
            $file = str_replace('[ifaxnumber]', IFAXNUMBER, $file);
        } else {
            $file = str_replace('[border: 1px solid #cfcfcf;]', 'border: 1px solid #cfcfcf;', $file);
        }
        if ($for == 1) {
            $file = str_replace('[none]', 'block', $file);
            $file = str_replace('[EMAIL]', $data['email'], $file);
            $file = str_replace('[PHONE]', $data['phone'], $file);
            $file = str_replace('[ADDRESS]', $data['address'], $file);
            $file = str_replace('[PAYMENTMODE]', $data['paymentType'], $file);
        } else {
            $file = str_replace('[none]', 'none !important', $file);
        }
        $file = str_replace('[DATE]', $data['paymentDate'], $file);
        $file = str_replace('[CURRENCYSIGN]', getCurrencySymbol($data['currency']), $file);
        $file = str_replace('[AMOUNT]', $data['amount'], $file);

        return $file;
    }

// End Function To Send Mail 

// Function To insert data in csv File
    private function insertInCSV($data, $flag) {

        if (file_exists("../../order_history/" . TRANDETAILPAGENAME . ".csv")) {

            if ($flag == 2) {
                $data['paymentMode'] = NULL;
            }

            $cvvArr = array(
                ucwords($data['fname']),
                ucwords($data['lname']),
                $data['email'],
                $data['address'],
                $data['note'],
                $data['phone'],
                $data['amount'],
                $data['paymentType'],
                $data['paymentMode'],
                $data['transactionId'],
                $data['paymentDate'],
                $data['currency'],
                $data['cycle'],
                $data['noOfCycle'],
                $data['transactionStatus'],
                $data['cardNumber'],
                $data['cardType'],
                $data['subscr']
            );

            $fp = fopen("../../order_history/" . TRANDETAILPAGENAME . ".csv", "a");
            fputcsv($fp, $cvvArr);
            return 1;
        } else {


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
            if ($flag == 2) {
                if ($flag == 2) {
                    $data['paymentType'] = NULL;
                    $data['paymentMode'] = NULL;
                    $data['cycle'] = NULL;
                    $data['noOfCycle'] = NULL;
                }
            }
            $cvvArrData = array(
                ucwords($data['fname']),
                ucwords($data['lname']),
                $data['email'],
                $data['address'],
                $data['note'],
                $data['phone'],
                $data['amount'],
                $data['paymentType'],
                $data['paymentMode'],
                $data['transactionId'],
                $data['paymentDate'],
                $data['currency'],
                $data['cycle'],
                $data['noOfCycle'],
                $data['transactionStatus'],
                $data['cardNumber'],
                $data['cardType'],
                $data['subscr']
            );

            $fp = fopen("../../order_history/" . TRANDETAILPAGENAME . ".csv", "a");
            fputcsv($fp, $cvvArrHead);
            fputcsv($fp, $cvvArrData);
        }
        fclose($fp);
        return 1;
    }

}
// End Function To insert data in csv File
?>