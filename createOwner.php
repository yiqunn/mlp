<?php

function simpleCurlWithCh($ch, $postData, &$response,
			  $timeout=0) {
    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.73 [en] (X11; U; Linux 2.2.15 i686)');
    
    curl_setopt($ch, CURLOPT_HTTPHEADER,
    		     array('Content-Type: multipart/form-data',
		     			        'Accept: text/xml'));
    curl_setopt($ch, CURLOPT_HEADER, false);  // exclude header in output
    if ($timeout > 0) {
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    }
    curl_setopt($ch, CURLOPT_POST, true);
    $postJson = json_encode((object) $postData); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postJson);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  // return output as a string
    $response = curl_exec($ch);
    return curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

function createOwner($ownerName, $phoneNumber, $email) {
    $serverName = "137.135.120.162";
    $url = "https://" . $serverName . "/mlp/createOwner";
    $ch = curl_init($url);
    $tryTimes = 1;
    $postData = array("ownerName" => $ownerName, "phoneNumber" => $phoneNumber,
		      "email" => $email);
    $httpStatusCode = simpleCurlWithCh($ch, $postData, $response, 10);
    if (isResponseStatusOk($httpStatusCode)) {  // api call failed somehow
	echo "create new owner!!" . PHP_EOL;
	return;
    } else {
	print_r($response);
	echo PHP_EOL;
    }
}


function isResponseStatusOk($responseStatus) {
    $rS = (int) $responseStatus;
    if ($rS >= 100 && $rS < 300) {
    return true;
    } else {
    return false;
    }
    
}

$ownerName = $argv[1];
$phoneNumber = $argv[2];
$email = $argv[3];
createOwner($ownerName, $phoneNumber, $email);

?>
