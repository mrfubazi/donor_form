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
if (empty($_POST['searchName']) || !isset($_POST['searchName']))
    {
    unset($_POST['searchName']);
    }
if (empty($_POST['date_from']) || !isset($_POST['date_from']))
    {
    unset($_POST['date_from']);
    }
if (empty($_POST['date_to']) || !isset($_POST['date_to']))
    {
    unset($_POST['date_to']);
    }
$orderData = $oderObj->history($_POST);
$orderData['orders']=  array_reverse($orderData['orders'],true);
$currency_symbol = $oderObj->getCurrencySymbol();
if (!isset($_POST['resetbtn']) && empty($_POST['resetbtn']))
    {
    foreach ($orderData['orders'] as $key => $data)
        {

        // when paymenttype exists and orderstatus does't
        if (isset($_POST['paymenttype']) && !empty($_POST['paymenttype']) && (!isset($_POST['orderstatus']) || empty($_POST['orderstatus'])))
            {
            if (strtolower($data[7]) != strtolower($_POST['paymenttype']))
                {
                if (strtolower($data[14]) != 'completed')
                    {
                    $orderData['failed'] --;
                    }
                if (strtolower($data[14]) == 'completed')
                    {
                    $orderData['completed'] --;
                    }

                $orderData['total'] --;
                unset($orderData['orders'][$key]);
                }
            }
        // when paymenttype does't exists and orderstatus exists
        if ((!isset($_POST['paymenttype']) || empty($_POST['paymenttype'])) && isset($_POST['orderstatus']) && !empty($_POST['orderstatus']))
            {
            if ($_POST['orderstatus'] == '1')
                {
                
                }
            if ($_POST['orderstatus'] == '2')
                {
                if (strtolower($data[14]) != 'completed')
                    {
                        unset($orderData['orders'][$key]);
                    }
                }
            if ($_POST['orderstatus'] == '3')
                {
                if (strtolower($data[14]) == 'completed')
                    {
                        unset($orderData['orders'][$key]);
                    }
                }
            }

        // when paymenttype and orderstatus exists
        if (isset($_POST['paymenttype']) && !empty($_POST['paymenttype']) && isset($_POST['orderstatus']) && !empty($_POST['orderstatus']))
            {
            if (strtolower($data[7]) != strtolower($_POST['paymenttype']))
                {
                if (strtolower($data[14]) != 'completed')
                    {
                        $orderData['failed'] --;
                    }
                if (strtolower($data[14]) == 'completed')
                    {
                        $orderData['completed'] --;
                    }
                $orderData['total'] --;
                unset($orderData['orders'][$key]);
                }

            if ($_POST['orderstatus'] == '1')
                {
                
                }

            if ($_POST['orderstatus'] == '2')
                {
                if (strtolower($data[14]) != 'completed')
                    {
                        unset($orderData['orders'][$key]);
                    }
                }

            if ($_POST['orderstatus'] == '3')
                {
                if (strtolower($data[14]) == 'completed')
                    {
                        unset($orderData['orders'][$key]);
                    }
                }
            }
        }
    }


$finalResult = array();
$show_key = 'total';
if (isset($_POST['orderstatus']) && !empty($_POST['orderstatus']))
    {
    if ($_POST['orderstatus'] == '2')
        {
        $show_key = 'completed';
        }
    if ($_POST['orderstatus'] == '3')
        {
        $show_key = 'failed';
        }
    }


$finalResult['failed'] = $orderData['failed'];
$finalResult['completed'] = $orderData['completed'];
$finalResult['total'] = $orderData['total'];
$html = '';
if (count($orderData['orders']))
    {
    foreach ($orderData['orders'] as $data)
        {
        $class = '';
        $html.='<div class="transaction-row">
			<div class="transaction-details">
				<div class="price-box-trans">
					<i ';
        if (strtolower($data[14]) != 'completed')
            {
            $class = 'class="trans-failed"';
        }
        $html.=$class . '>&nbsp;</i>
					<span class="price">' . $currency_symbol[$data[11]] . "&nbsp;" . number_format($data[6], 2, '.', '') . '</span>
					<span class="date">' . date('d M Y', strtotime($data[10])) . '</span>
				</div>
				<div class="name-trans">
					<h3>'.NAME.' : ' . $data[0] . '&nbsp' . $data[1] . '</h3>
					<div class="email-order">
						<a href="mailto:' . $data[2] . '"class="email-trans">'.EMAIL.' : ' . $data[2] . '</a>
					<div class="order-tras">'.ORDERID.' : ' . $data[9] . '<a href="' . SITEPATH . 'includes/order_history/ordersdetail/invoice.php?id=' . $data[9] . '" title="View Invoice" class="view-invoice ajax">'.VIEWINVOICE.'</a></div>
					</div>
					
				</div>
				
			</div>
			<div class="right pay-mod-trans">
				<a href="#" class="recurring-btn">' . $data[7] . '</a>
				<div>';
        $recurring_str = $recurring_str1 = '';
        if (($data[12] != 'NA' && $data[12]!='N / A'))
            {
            $recurring_str = explode('_', $data[12]);
            $recurring_str1 = "($recurring_str[0]) Paypal";
            }
        $html.=$recurring_str1 . '</div>
			</div>
		</div>';
        }
    if ($finalResult[$show_key] > 5)
        {
        $html.='<div class="show-more"><span>'.SHOWMORE.'</span><div>';
        }
    }
else
    {
    $html = '<div class="noresult">'.NORESULTFOUND.'</div>';
    $finalResult['failed'] = 0;
    $orderData['completed'] = 0;
    $orderData['total'] = 0;
    }

$selectbox = '<option value="">'.ALL.'</option>	
			<option  value="1"  data-right="' . $finalResult['total'] . '">'.ALL.'</option>
			<option  value="2" data-right="' . $finalResult['completed'] . '"class="sucess">'.SUCCESSFUL.'</option>
			<option  value="3"  data-right="' . $finalResult['failed'] . '"class="failed">'.FAILED.'</option>';
$finalResult['html'] = $html;
$finalResult['selectbox'] = $selectbox;
echo json_encode($finalResult);
?>

