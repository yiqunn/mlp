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

    public function createModel($name, $subName, $accuracy,
				$ownerName, $feature_names,
				$hyperparameters, $train_start_time, $train_stop_time,
				&$res) {

	// 0) if the owner is not found, return false and create model fails
	// 1) if the model group has not been created before, create the model group first,
	//    model group is identified as owner + model name
	// 2) add one more model in this model group, and change the current version to this model,
	//    set the modelgroup to be active
	// 2.1) if model with subName and same modelGroup has been created before, do not allow create
	//     it again

	$res = array("errs" => array());
	$owner = null;
	$modelGroup = null;
	
	// 0) if the owner is not found, return false and create model fails	
	if (!$this->findOwnerAndModelGroup($ownerName, $name, $owner, $modelGroup, $res)) {
	    return false;
	}

	// 1) if the model group has not been created before, create the model group first,
	//    model group is identified as owner + model name
	if (!$modelGroup) {
	    $modelGroup = new ModelGroup($name, $owner);
	    $this->dm->persist($modelGroup);
	    $this->logger->debug("Created modelGroup with name {$name} for owner " .
				 $owner->getName());
	    $this->flush();
	}
	
	// 2) add one more model in this model group, and change the current version to this model,
	//    set the modelgroup to be active
	
	$model = $this->dm->createQueryBuilder("ModelServiceBundle:Model")
	    ->field("subName")->equals($subName)
	    ->field("modelGroup")->equals($modelGroup)
	    ->getQuery()
	    ->getSingleResult();

	if ($model) {
	    $err = "Model with subName {$subName} and modelGroup" . $modelGroup->getId() .
		" has been created before, quit creating model.";
	    $res["errs"][] = $err;
	    $this->logger->error($err);
	    return false;
	}

	// if model does not exist, continue creating model
	$model = new Model($subName, $modelGroup, $accuracy, $feature_names,
			   $hyperparameters, $train_start_time, $train_stop_time);
	$this->dm->persist($model);
	$this->logger->debug("Created model with modelGroup" . $modelGroup->getId());
	$modelGroup->setCurrentVersion($model);
	$modelGroup->setActive(true);
	$modelGroup->addOneActiveModel();
	$this->dm->flush(); // done creating model
	
	return true;			
    } // end of creating model


    public function deleteModel($modelGroupName, $ownerName,
				$modelSubName, &$res) {

	// 1) find the modelGroup
	// 2) find the model use modelGroup and modelSubName
	// 3) set the model to be inactive
	// 4) set the modelGroup to be inactive if it has no active model


	// 1) find the modelGroup
	$res = array("errs" => array());
	$owner = null;
	$modelGroup = null;
	
	if (!$this->findOwnerAndModelGroup($ownerName, $name, $owner, $modelGroup, $res)) {
	    return false;
	}

	if (!$modelGroup) {
	    $err = "model group with owner {$ownerName} and name {$modelGroupName} does not exist, ".
		"quit removing model. ";
	    $res["errs"][] = $err;
	    $this->logger->error($err);
	    return false;	    
	}


	// 2) find the model use modelGroup and modelSubName
	$model = $this->dm->createQueryBuilder("ModelServiceBundle:Model")
	    ->field("subName")->equals($modelSubName)
	    ->field("modelGroup")->equals($modelGroup)
	    ->getQuery()
	    ->getSingleResult();

	if (!$model) {
	    $err = "Model with subName {$modelSubName} and modelGroup" . $modelGroup->getId() .
		" does not exist before, quit removing model.";
	    $res["errs"][] = $err;
	    $this->logger->error($err);
	    return false;
	} else {
	    // 3) set the model to be inactive
	    // 4) set the modelGroup to be inactive if it has no active model	    
	    $model->setActive(false);
	    $modelGroup->decreaseActiveModels();
	}

	return true;       	
    } // end of removing models


    public function findOwnerAndModelGroup($ownerName, $modelGroupName, &$owner, &$modelGroup,
				  &$res) {
	
	$owner = $this->dm->getRepository("UserBundle:Owner")
	    ->findOneByName($ownerName);
	if (!$owner) {
	    $err = "owner with name {$ownerName} does not exist, needs to be added first. ";
	    $res["errs"][] = $err;
	    $this->logger->error($err);
	    return false;
	}

	$modelGroup = $this->dm->createQueryBuilder("ModelServiceBundle:ModelGroup")
	    ->field("name")->equals($modelGroupName)
	    ->field("owner")->equals($owner)
	    ->getQuery()
	    ->getSingleResult();

	return true;
    }
}
