<?php
session_start();
include '../../functions/autoload.php';
include "../../languages/".$_POST['language'].".php";
$_SESSION['language']=$_POST['language'];
$mainObj=new Main();
$mainObj->sendMailTo($_POST,3);
?>