<?php

namespace UserBundle\Controller;

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

class UserController extends Controller {



    /**
     * @Route("/mlp/createOwner",
     *        name="mlp_createOwner")
     *
     */

    public function mlpCreateOwnerAction(Request $request) {

	$response = new JsonResponse();
	$result = array();
	$respondCode = null;
	
	$jsonStr = utf8_encode($request->getContent());
	$jsonAry = json_decode($jsonStr, TRUE);

	$ownerName = isset($jsonAry['ownerName']) ? $jsonAry['ownerName'] : "";
	$phoneNumber = isset($jsonAry['phoneNumber']) ? $jsonAry['phoneNumber'] : "";
	$email = isset($jsonAry['email']) ? $jsonAry['email'] : "";


	$userManager = $this->get("user_manager");
	$res = array();
	if ((!$userManager->createOwner($ownerName, $phoneNumber, $email, "write", $res)) ||
	    (count(res['errs']))) {
	    $result['errors'] = $res["errs"];
	    $response->setData($result);
	    $response->setStatusCode("400"); 
	} else {
	    $response->setStatusCode("200"); 
	}
	
	return $response;
    }

}
