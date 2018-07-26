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
	} else {
	    $response->setStatusCode("200"); 
	}
	
	return $response;
    }


    /**
     * @Route("/mlp/removeModel",
     *        name="mlp_removeModel")
     *
     */

    public function mlpRemoveModelAction(Request $request) {

	$response = new JsonResponse();
	$result = array();
	$respondCode = null;
	
	$jsonStr = utf8_encode($request->getContent());
	$jsonAry = json_decode($jsonStr, TRUE);

	$modelGroupName = isset($jsonAry['name']) ? $jsonAry['name'] : "";
	$modelName = isset($jsonAry['subName']) ? $jsonAry['subName'] : "";	
	$ownerName = isset($jsonAry['ownerName']) ? $jsonAry['ownerName'] : "";

	$modelServiceMgr = $this->get("model_service_manager");
	$res = array();
	if (!$modelServiceMgr->removeModel($modelGroupName, $ownerName, $modelName, $res)) {

	    $result['errors'] = $res["errs"];
	    $response->setData($result);
	    $response->setStatusCode("400"); 
	} else {
	    $response->setStatusCode("200"); 
	}
	return $response;
    }


    /**
     * @Route("/mlp/getMostAccurateModel",
     *        name="mlp_getMostAccurateModel")
     *
     */

    public function mlpGetMostAccurateModelAction(Request $request) {

	$response = new JsonResponse();
	$result = array();
	$respondCode = null;
	
	$jsonStr = utf8_encode($request->getContent());
	$jsonAry = json_decode($jsonStr, TRUE);

	$modelGroupName = isset($jsonAry['name']) ? $jsonAry['name'] : "";
	$modelServiceMgr = $this->get("model_service_manager");
	$res = array();
	if (!$models = $modelServiceMgr->getMostAccurateModel($modelGroupName, 
							      $res)) {
	    
	    $result['errors'] = $res["errs"];
	    $response->setData($result);
	    $response->setStatusCode("400"); 
	} else {
	    $response->setStatusCode("200");
	    $data = array();
	    foreach ($models as $m) {
		$data[] = $m->toArray();
	    }
	    $result['data'] = $data;
	    $response->setData($result);
	}

	return $response;
    }

    /**
     * @Route("/mlp/getLastTrainedModel",
     *        name="mlp_getLastTrainedModel")
     *
     */

    public function mlpGetLastTrainedModelAction(Request $request) {

	$response = new JsonResponse();
	$result = array();
	$respondCode = null;
	
	$jsonStr = utf8_encode($request->getContent());
	$jsonAry = json_decode($jsonStr, TRUE);

	$ownerName = isset($jsonAry['ownerName']) ? $jsonAry['ownerName'] : "";
	$modelServiceMgr = $this->get("model_service_manager");
	$res = array();
	
	if (!$lastTrainedModels = $modelServiceMgr->createModel($ownerName, $res)) {
	    $result['errors'] = $res["errs"];
	    $response->setData($result);
	    $response->setStatusCode("400"); 
	} else {
	    $response->setStatusCode("200");
	    $data = array();
	    foreach ($lastTrainedModels as $m) {
		$data[] = $m->toArray();
	    }
	    $result['data'] = $data;
	    $response->setData($result);
	}
	return $response;
    }
    
}
