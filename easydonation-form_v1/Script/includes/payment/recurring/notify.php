<?php
session_start();
include '../../functions/autoload.php';
$custom=$_REQUEST['custom'];
$customArr=  explode("---", $custom);
$_SESSION['language']=$customArr[8];
include "../../languages/".$_SESSION['language'].".php";
$mainObj=new Main();
$data=  $_REQUEST;
$mainObj->sendMailTo($data,1);
?>
