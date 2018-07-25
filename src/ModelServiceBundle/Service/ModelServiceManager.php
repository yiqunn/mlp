<?php

namespace ModelServiceBundle\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Doctrine\ODM\MongoDB\DocumentManager;
use Monolog\Logger;


class ModelServiceManager {

    private $dm;          // document manager
    private $container;   // service container (needed only to get container parameters)
    private $kernelRootDir;  // kernel root directory
    private $logger;  // monolog logging service
    private $userMgr;
    
    public function __construct(Logger $logger, $kernelRootDir) {	
	$this->logger = $logger;
	$this->kernelRootDir = $kernelRootDir;	
    }
    
    
 
    public function setDocumentManager($dm) {	
	$this->dm = $dm;	
    }
    public function setUserManager($userMgr) {	
	$this->userMgr = $userMgr;	
    }

}
