<?php 
include '../../../configuration.php';
include '../../functions/autoload.php';
$searchName=$_GET['searchName'];

$date_from=strtotime($_GET['date_from']);
$date_to =strtotime(trim($_GET['date_to']));
$cond='';
if(isset($_GET['date_from']) && !empty($_GET['date_from']) && isset($_GET['date_to']) && !empty($_GET['date_to'])){
	$cond="&date_from=$date_from&date_to=$date_to";
	}
if(!empty($searchName)){
//$url=  SITEPATH.'transdetail?searchName='.$searchName.$cond;
$url=  SITEPATH.'includes/order_history/ordersdetail/displayOrderHistory.php?searchName='.$searchName.$cond;
}
else{
	//$url=  SITEPATH.'transdetail';
	$url=  SITEPATH.'includes/order_history/ordersdetail/displayOrderHistory.php';
	}
	redirect($url);
?>

