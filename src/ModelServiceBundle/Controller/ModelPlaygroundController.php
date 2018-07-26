<?php

namespace ModelServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ModelPlaygroundController extends Controller {



    /**
     * @Route("/mlp/api/ok",
     *        name="mlp_api_ok")
     *
     * URL that services external sanity-check request -- returns 200
     */

    public function mlpApiOkAction() {

	$modelServiceMgr = $this->get("model_service_manager");
	return new Response('<?xml version="1.0" encoding="UTF-8"?><Response></Response>',
			    200,  // ok
			    array('content-type' => 'text/xml'));

    }


    /**
     * @Route("/mlp/createModel",
     *        name="mlp_createModel")
     *
     */

    public function mlpCreateModelAction(Request $request) {

	$response = new JsonResponse();
	$result = array();
	$respondCode = null;
	
	$jsonStr = utf8_encode($request->getContent());
	$jsonAry = json_decode($jsonStr, TRUE);

	$modelGroupName = isset($jsonAry['name']) ? $jsonAry['name'] : "";
	$modelName = isset($jsonAry['subName']) ? $jsonAry['subName'] : "";	
	$accuracy = isset($jsonAry['accuracy']) ? $jsonAry['accuracy'] : "";
	$ownerName = isset($jsonAry['ownerName']) ? $jsonAry['ownerName'] : "";
	$featureNames = isset($jsonAry['featureNames']) ? $jsonAry['featureNames'] : "";
	$hyperparameters = isset($jsonAry['hyperparameters']) ? $jsonAry['hyperparameters'] : "";
	$train_start_time = isset($jsonAry['train_start_time']) ? $jsonAry['train_start_time'] : "";
	$train_stop_time = isset($jsonAry['train_stop_time']) ? $jsonAry['train_stop_time'] : "";

	$modelServiceMgr = $this->get("model_service_manager");
	$res = array();
	if (!$modelServiceMgr->createModel($modelGroupName, $modelName, $accuracy,
					   $ownerName, $featureNames, $hyperparameters,
					   $train_start_time, $train_stop_time, $res)) {

	    $result['errors'] = $res["errs"];
	    $response->setData($result);
	    $response->setStatusCode("400"); 
	}
	return $response;
    }

    //public function createModel
}
