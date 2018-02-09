<?php
session_start();
include '../../../configuration.php';


if (!isset($_SESSION['language']))
    {
    $_SESSION['language'] = "en";
    }
include "../../languages/" . $_SESSION['language'] . ".php";
include '../../functions/autoload.php';
$oderObj = new Orderhistory();
$orderData = $oderObj->history($_GET);

$currency_symbol = $oderObj->getCurrencySymbol();
if (isset($_GET[date_from]))
    {
    $_GET[date_from] = date('m/d/Y', $_GET[date_from]);
    }
else
    {
    $_GET[date_from] = '';
    }
if (isset($_GET[date_to]))
    {
    $_GET[date_to] = date('m/d/Y', $_GET[date_to]);
    }
else
    {
    $_GET[date_to] = '';
    }

?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
<?php echo TITLE; ?>
        </title>
        <link type="text/css" href="<?php echo SITEPATH ?>assets/css/reset.css" rel="stylesheet" />
        <link type="text/css" href="<?php echo SITEPATH ?>assets/css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo SITEPATH ?>assets/css/select.css" />
        <link rel="stylesheet" href="<?php echo SITEPATH ?>assets/css/jquery-ui.css" />
        <script type="text/javascript" src="<?php echo SITEPATH ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo SITEPATH ?>assets/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo SITEPATH ?>assets/js/jquery.colorbox.js"></script>
        <script src="<?php echo SITEPATH ?>assets/js/fm.selectator.jquery.js"></script>
        <script src="<?php echo SITEPATH ?>assets/js/ajax.js"></script>
        <script src="<?php echo SITEPATH ?>assets/js/custom.js"></script>

    </head>
    <body>
        <div class="transaction-container">
            <header class="header-transition">
                <h2><?php echo TRANSACTIONDETAIL;?></h2>
                <div class="search-transaction">
                    <form action="<?php echo SITEPATH . 'includes/order_history/ordersdetail/search.php'; ?>" method="get">	
                        <input  class="clsdatefrom" type="text" dtfrom="<?php echo strtotime($_GET['date_from']); ?>" name="date_from" value="<?php echo $_GET['date_from'] ?>" id="datepicker"  placeholder="<?php echo DATE ?>"/>
                        <input class="clsdateto" type="text" dtto="<?php echo strtotime($_GET['date_to']); ?>" name="date_to" value="<?php echo $_GET['date_to'] ?>" id="datepicker1"  placeholder="<?php echo TO ?>"/> 
                        <input type="text" id="searchstr" name="searchName" value="<?php echo ($_GET['searchName'] ? $_GET['searchName'] : SEARCH); ?>"  onblur="if (this.value == '')
                                                            this.value = this.defaultValue" onclick="if (this.defaultValue == this.value)
                                                                        this.value = ''" />
                        <input type="submit" value="<?php echo SEARCH; ?>" name="submit" class="search-btn" />
                    </form>
                </div>

            </header>
            <div class="transaction-content-wrapper">


                <div class="total">
                   <?php echo TOTALTRANSACTION;?> <span class="ordertotal"><?php echo $orderData['total']; ?></span>
                </div>

                <!-- extract payment method -->
                <?php
                $paymentMethodSelect = array();
                if ($paymentMethods['recurring'])
                    {
                    $paymentMethodSelect['RECCURING'] = RECCURING;
                    }
                if ($paymentMethods['paypal'])
                    {
                    $paymentMethodSelect['PAYPAL'] = PAYPAL;
                    }
                if ($paymentMethods['creditCard'])
                    {
                    $paymentMethodSelect['CREDITCARD'] = CREDITCARD;
                    }
                if ($paymentMethods['bankingTransfer'])
                    {
                    $paymentMethodSelect['BANKTRANSFER'] = BANKTRANSFER;
                    }
                ?>
                <div class="right">
                    <select id="select1" name="payment-mode" onChange="filterOrderDetails();">
                        <option value="" ><?php echo ALL ?></option>
<?php
foreach ($paymentMethodSelect as $k => $v)
    {
    echo '<option value="' . $v . '" >' . $v . '</option>';
    }
?>
                    </select>


                    <input value="activate selectator" id="activate_selectator1" class="select-btn-disable" type="button">
                    <select id="select2" name="successful" onChange="filterOrderDetails();">		
                        <option value=""><?php echo ALL; ?></option>	
                        <option  value="1"  data-right="<?php echo $orderData['total']; ?>"><?php echo ALL;?></option>
                        <option  value="2" data-right="<?php echo $orderData['completed']; ?>" class="sucess"><?php echo SUCCESSFUL;?></option>
                        <option  value="3"  data-right="<?php echo $orderData['failed']; ?>" class="failed"><?php echo FAILED;?></option>
                    </select>
                    <input value="activate selectator" id="activate_selectator2" class="select-btn-disable" type="button">
                    <a class="filter-btn" id ="resetbtn" fn="reset" onclick="filterOrderDetails(this.id)"><?php echo CLEARFILTERS;?></a>
                </div>

                <div class="transaction-content">
<?php if (count($orderData['orders']))
    {
    $orderData['orders']=  array_reverse($orderData['orders'],true);
 
    foreach ($orderData['orders'] as $data)
        {
        ?>
                            <div class="transaction-row">
                                <div class="transaction-details">
                                    <div class="price-box-trans">
                                        <i <?php if (strtolower($data[14]) != 'completed')
            {
            echo 'class="trans-failed"';
        } ?>>&nbsp;</i>
                                        <span class="price"><?php   echo $currency_symbol[$data[11]] . "&nbsp;" . number_format($data[6], 2, '.', ''); ?> </span>
                                        <span class="date"><?php echo date('d M Y', strtotime($data[10])); ?></span>
                                    </div>
                                    <div class="name-trans">
                                        <h3><?php echo NAME ; ?> : <?php echo "$data[0]&nbsp$data[1]"; ?> </h3>
                                        <div class="email-order">
                                            <a href="mailto:<?php echo $data[2] ?>" class="email-trans"><?php echo EMAIL ;?> : <?php echo $data[2] ?></a>
                                            <div class="order-tras"><?php echo ORDERID;?> : <?php echo $data[9] ?> <a href="<?php echo SITEPATH . 'includes/order_history/ordersdetail/invoice.php?id=' . $data[9]; ?>" title="View Invoice" class="view-invoice ajax"><?php  echo VIEWINVOICE; ?></a></div>
                                        </div>

                                    </div>

                                </div>
                                <div class="right pay-mod-trans">
                                    <span href="#" class="recurring-btn"><?php echo $data[7]; ?></span>
                                    <div>
        <?php
        $recurring_str = '';
        if (($data[12] != 'NA' && $data[12]!='N / A'))
            {
            $recurring_str = explode('_', $data[12]);
            echo "($recurring_str[0]) Paypal";
            }
        ?></div>
                                </div>
                            </div>	
    <?php
        }
    }
else
    {
    echo '<div class="noresult">'.NORESULTFOUND.'</div>';
}
?>
<?php if (count($orderData['orders']) > 5)
    { ?>
                        <div class="show-more">
                            <span><?php echo SHOWMORE ?></span>
                        </div>	
<?php } ?>	
                </div>

            </div>			
            <input type="hidden" id="siteurl" value="<?php echo SITEPATH; ?>" />

        </div>

    </body>	
</html>


