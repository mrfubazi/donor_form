<?php 
 $curXmlData=(array)simplexml_load_file("includes/dropdownXml/currency.xml");
 for($i=0;$i<count($curXmlData['value']);$i++){
     if($_POST['curValue']==$curXmlData['value'][$i]){
         echo $curXmlData['sign'][$i];
         exit;
     }
 }