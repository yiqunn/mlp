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

function createModel($modelGroupName, $modelName, $ownerName, $accuracy,
		     $train_start_time, $train_end_time) {
    $serverName = "137.135.120.162";
    $url = "https://" . $serverName . "/mlp/createModel";
    $ch = curl_init($url);
    $tryTimes = 1;
    $postData = array("name" => $modelGroupName, "subName"=> $modelName,
		      "accuracy" => $accuracy, "ownerName" => $ownerName,
		      "featureNames" => array('age'), "hyperparameters" => array("p1" => 1.1),
		      "train_start_time" => $train_start_time, "train_stop_time" => $train_end_time);
    $httpStatusCode = simpleCurlWithCh($ch, $postData, $response, 10);
    if (isResponseStatusOk($httpStatusCode)) {  // api call failed somehow
	echo "create new model!!" . PHP_EOL;
	return;
    } else {
	print_r($response);
	echo PHP_EOL;
    }
}

function removeModel() {
    $serverName = "137.135.120.162";
    $url = "https://" . $serverName . "/mlp/removeModel";
    $ch = curl_init($url);
    $tryTimes = 1;
    $postData = array("name" => "model1", "subName"=> 'modelSub1',
		      "ownerName" => "yiqun");
    $httpStatusCode = simpleCurlWithCh($ch, $postData, $response, 10);
    if (isResponseStatusOk($httpStatusCode)) {  // api call failed somehow
	echo "remove model!!" . PHP_EOL;
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
$modelGroupName = $argv[1];
$modelName = $argv[2];
$ownerName = $argv[3];
$accuracy = $argv[4];
$train_start_time = $argv[5];
$train_stop_time = $argv[6];
createModel($modelGroupName, $modelName, $ownerName, $accuracy,
	    $train_start_time, $train_stop_time);
?>
