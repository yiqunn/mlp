<?php

namespace UserBundle\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Doctrine\ODM\MongoDB\DocumentManager;
use Monolog\Logger;

use UserBundle\Document\Owner;

class UserManager {

    private $dm;          // document manager
    private $container;   // service container (needed only to get container parameters)
    private $kernelRootDir;  // kernel root directory
    private $logger;  // monolog logging service

    public function __construct(Logger $logger, $kernelRootDir) {	
	$this->logger = $logger;
	$this->kernelRootDir = $kernelRootDir;	
    }

    public function setDocumentManager($dm) {	
	$this->dm = $dm;	
    }

    public function createOwner($name, $phoneNumber, $email, $permission="read") {
	// YN: 072218, find if member with name, phone number and email has been create before
	$owner = $this->dm->getRepository("UserBundle:Owner")
	    ->createQueryBuilder()
	    ->field('name')->equals($name)
	    ->field('phoneNumber')->equals($phoneNumber)
	    ->field('email')->equals($email)
	    ->getQuery()
	    ->getSingleResult();
	
	if (!$owner) {
	    if (!$permission) {
		$permission = "read";
	    }
	    $owner = new Owner($name, $phoneNumber, $email, $permission);
	    $this->dm->persist($owner);
	    $this->dm->flush();
	} else {
	    $this->logger->warning("User already exist with {$name}, {$phoneNumber}, {$email}");
	}
	return $owner;
    } // end of createOwner
    
}
