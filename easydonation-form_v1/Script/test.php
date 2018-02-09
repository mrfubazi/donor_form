<h1>Credit card Payment Gateway(Paypal)</h1>
<?php
$sandbox = TRUE;

// Set PayPal API version and credentials.
$api_version = '85.0';
$api_endpoint ='https://api-3t.sandbox.paypal.com/nvp';    //live:https://api-3t.paypal.com/nvp
$api_username = 'chandra.shekhar1111_api1.sparxtechnologies.com'; //'chandra.shekhar1111_api1.sparxtechnologies.com';
$api_password = '1401375810';
$api_signature = 'AQU0e5vuZCvSg-XJploSa.sGUDlpAG53Kr0CYpbVbFMhahPdznmsDhIk';

// Store request params in an array
$request_params = array
					(
					'METHOD' => 'DoDirectPayment', 
					'USER' => $api_username, 
					'PWD' => $api_password, 
					'SIGNATURE' => $api_signature, 
					'VERSION' => $api_version, 
					'PAYMENTACTION' => 'Sale', 					
					'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
					'CREDITCARDTYPE' => 'Visa', 
					'ACCT' => '4032035686303777', 						
					'EXPDATE' => '022024', 			
					'CVV2' => '456', 
					'FIRSTNAME' => 'Tester', 
					'LASTNAME' => 'Testerson', 
					'STREET' => '707 W. Bay Drive', 
					'CITY' => 'Largo', 
					'STATE' => 'FL', 					
					'COUNTRYCODE' => 'US', 
					'ZIP' => '33770', 
					'AMT' => '100.00', 
					'CURRENCYCODE' => 'USD', 
					'DESC' => 'Testing Payments Pro' 
					);
					
// Loop through $request_params array to generate the NVP string.
$nvp_string = '';
foreach($request_params as $var=>$val)
{
	$nvp_string .= '&'.$var.'='.urlencode($val);	
}

// Send NVP string to PayPal and store response
if($_POST['submit'])
{
$curl = curl_init();
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_URL, $api_endpoint);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

$result = curl_exec($curl);

curl_close($curl);

// Parse the API response
$result_array = NVPToArray($result);
print_r($result_array);die;
if($result_array['ACK']=="Success")
{
	 mail('ram.prakash@sparxtechnologies.com','creditcard',json_encode($result_array));
	header("location:thanks.php");
}
else{
	header("location:cancel.php");
	}
}
// Function to convert NTP string to an array
function NVPToArray($NVPString)
{
	$proArray = array();
	while(strlen($NVPString))
	{
		// name
		$keypos= strpos($NVPString,'=');
		$keyval = substr($NVPString,0,$keypos);
		// value
		$valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
		$valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
		// decoding the respose
		$proArray[$keyval] = urldecode($valval);
		$NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
	}
	return $proArray;
}

echo "<pre>";
print_r($request_params);
?>
<form action="" method="post">
	<input type="submit" name="submit" value="Pay">
</form>

