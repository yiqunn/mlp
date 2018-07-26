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

	return new Response('<?xml version="1.0" encoding="UTF-8"?><Response></Response>',
			    200,  // ok
			    array('content-type' => 'text/xml'));

    }
}
