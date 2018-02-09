<?php

include '../../../configuration.php';
if (!isset($_SESSION['language']))
    {
    $_SESSION['language'] = "en";
    }
include "../../languages/" . $_SESSION['language'] . ".php";
//echo SEARCH;
class Orderhistory {

    public function history($post) {
        
        if (isset($post['searchName']) && strtolower($post['searchName']) ==strtolower(SEARCH)) {
            
            unset($post['searchName']);
        }
        $key_gen = 1;
        $final_data = $result = array();
        $i = $completed = $failed = 0;
        if (file_exists(ORDERCSVPATH . TRANDETAILPAGENAME . ".csv") && ($handle = fopen(ORDERCSVPATH . TRANDETAILPAGENAME . ".csv", "r")) !== FALSE) {

            //echo'<table border="1">';
            $row = 1;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($data[9] == 'NA') {
                    $data[9] = $key_gen;
                    $key_gen++;
                }
                $num = count($data);
                
                $date = strtotime($data[10]);
                $date1 = $post['date_from'];
                $date2 =$post['date_to'];
                
                $name = substr($post['searchName'], 0, strlen($post['searchName']));
                $nameto = $data[0];
                $pos = stripos($data[0], $post['searchName']);
                if ($pos === false) {
                    $searchName = $post['searchName'];
                } else {
                    $searchName = $data[0];
                }
                // counting completed and failed status based on search 
                if ($row != 1) {
                    
                    if (isset($post['searchName']) && $searchName != $nameto){
                        
                        continue;
                    }
                    
                    if(isset($post['date_from']) && isset($post['date_to'])){                        
                    
                        //echo $date."**".$date1."**".$date2."<br>";
                        if($date >= $date1 && $date <= $date2){
                            
                        }else{
                            
                            continue;
                        }
                    }
                    
                    if(strtolower($data[14]) == 'completed'){
                        
                      $completed++;  
                    }else{
                        
                       $failed++; 
                    }                   
                    
                   
                }
                // end block counting completed and failed status based on search 
                for ($c = 0; $c < $num; $c++) {
                    $date = strtotime($data[10]);

                    if ($row == 1) {
                        //$final_data['head'][]=$data[$c];
                    } elseif (isset($post['searchName']) && $searchName == $nameto && $date >= $date1 && $date <= $date2) {

                        $final_data[$data[9]][] = $data[$c];
                    } elseif (isset($post['searchName']) && $searchName == $nameto && $date1 == '' && $date2 == '') {
                        $final_data[$data[9]][] = $data[$c];
                    } elseif ($date >= $date1 && $date <= $date2 && $post['searchName'] == '') {
                        $final_data[$data[9]][] = $data[$c];
                    } elseif ($post['searchName'] == '' && $date1 == '') {
                        if ($row != 1) {
                            $final_data[$data[9]][] = $data[$c];
                        }
                    }
                }

                $row++;
                $i++;
            }
//echo $completed;die;
            $result['orders'] = $final_data;
            $result['completed'] = $completed;
            $result['failed'] = $failed;
            $result['total'] = (int) ($failed + $completed);
            fclose($handle); //echo '<pre>'; print_r($result);echo '</pre>';
            return $result;
        } else {
            echo FILENOTFOUND;
        }
    }

    function getCurrencySymbol() {
        if (file_exists('../../dropdownXml/currency.xml')) {
            $xml = (array) simplexml_load_file('../../dropdownXml/currency.xml');
            $valuesInXml = count($xml['value']);
            $nameInXml = count($xml['name']);
            if ($valuesInXml != $nameInXml) {
                echo CURRENCYNOTFOUNDERROR;
                exit();
            }
            $xml = array_combine($xml['value'], $xml['sign']);
            return $xml;
        }
    }

}

?>
