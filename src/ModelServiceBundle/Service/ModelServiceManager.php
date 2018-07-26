<?php

namespace ModelServiceBundle\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Doctrine\ODM\MongoDB\DocumentManager;
use Monolog\Logger;


use ModelServiceBundle\Document\Model;
use ModelServiceBundle\Document\ModelGroup;

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
	    $modelGroup = new ModelGroup($name, array($owner));
	    $this->dm->persist($modelGroup);
	    $this->logger->debug("Created modelGroup with name {$name} for owner " .
				 $owner->getName());
	    $this->dm->flush();
	}
	
	// 2) add one more model in this model group, and change the current version to this model,
	//    set the modelgroup to be active
	
	$model = $this->dm->createQueryBuilder("ModelServiceBundle:Model")
	    ->field("subName")->equals($subName)
	    ->field("model_group")->equals($modelGroup)
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
	if (is_string($train_start_time)) {
	    $train_start_time = new \DateTime($train_start_time);
	}
	if (is_string($train_stop_time)) {
	    $train_stop_time = new \DateTime($train_stop_time);
	}

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


    // in order for us to reverse back conviniently, just set model to be inactive
    public function removeModel($modelGroupName, $ownerName,
				$modelSubName, &$res) {

	// 1) find the modelGroup
	// 2) find the model use modelGroup and modelSubName
	// 3) set the model to be inactive
	// 4) set the modelGroup to be inactive if it has no active model


	// 1) find the modelGroup
	$res = array("errs" => array());
	$owner = null;
	$modelGroup = null;
	
	if (!$this->findOwnerAndModelGroup($ownerName, $modelGroupName, $owner, $modelGroup, $res)) {
	    return false;
	}

	if (!$modelGroup) {
	    $err = "model group with owner {$ownerName} and name {$modelGroupName} does not exist, ".
		"quit removing model.";
	    $res["errs"][] = $err;
	    $this->logger->error($err);
	    return false;	    
	}


	// 2) find the model use modelGroup and modelSubName
	$model = $this->dm->createQueryBuilder("ModelServiceBundle:Model")
	    ->field("subName")->equals($modelSubName)
	    ->field("model_group")->equals($modelGroup)
	    ->getQuery()
	    ->getSingleResult();

	if (!$model) {
	    $err = "Model with subName {$modelSubName} and modelGroup " . $modelGroup->getId() .
		" does not exist before, quit removing model.";
	    $res["errs"][] = $err;
	    $this->logger->error($err);
	    return false;
	} else {
	    // 3) set the model to be inactive
	    // 4) set the modelGroup to be inactive if it has no active model	    
	    $model->setActive(false);
	    $modelGroup->decreaseActiveModels();
	    if ($model == $modelGroup->getCurrentVersion()) { // if the model is the current version of the modelGroup
		// trace back to the second last version of the modelGroup
		$curModel = $this->dm->createQueryBuilder("ModelServiceBundle:Model")
		    ->field("model_group")->equals($modelGroup)
		    ->sort("createdAt", "desc")
		    ->getQuery()
		    ->getSingleResult();
		$modelGroup->setCurrentVersion($curModel);
		
	    }
	}
	$this->dm->flush();
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
	    ->field("owners")->equals($owner)
	    ->getQuery()
	    ->getSingleResult();

	return true;
    }


    // get model by id should be relatively easy to implement

    // Get most accurate model for a given model name
    public function getMostAccurateModel($modelGroupName, &$res) {

	$res = array("errs" => array());
	// 1) find all the modelGroups
	$modelGroups = $this->dm->createQueryBuilder("ModelServiceBundle:ModelGroup")
	    ->field("name")->equals($modelGroupName)
	    ->field("active")->equals(true)
	    ->getQuery()
	    ->execute();
	
	$maxNum = 0; // mark the largest accuracy
	$maxModels = array(); // restore all models with the largest accuracy

	// 2) loop through all modelGroups
	foreach ($modelGroups as $modelGroup) {
	    $models = $this->dm->createQueryBuilder("ModelServiceBundle:Model")
		->field("model_group")->equals($modelGroup)
		->field("active")->equals(true)
		->getQuery()
		->execute();
	    // 3) loop through all models under that modelGroup
	    foreach ($models as $model) {
		$tmpNum = $model->getAccuracy();
		if ($tmpNum > $maxNum) {
		    $maxModels = array($model);
		    $maxNum = $tmpNum;
		} elseif ($tmpNum == $maxNum) { // if the accuracy is equal to the max, add it
		                                // to the array
		    $maxModels[] = $model;
		}
	    }	    
	}

	if (empty($maxModels)) {
	    $res["errs"][] = "No model found using model group name {$modelGroupName}.";
	    return false;
	}
	return $maxModels;	
    } // end of getMostAccurateModel

    // Get last model trained for a given model owner
    public function getLastTrainedModel($ownerName, &$res) {

	$owner = $this->dm->getRepository("UserBundle:Owner")
	    ->findOneByName($ownerName);
	if (!$owner) {
	    $err = "owner with name {$ownerName} does not exist, needs to be added first. ";
	    $res["errs"][] = $err;
	    $this->logger->error($err);
	    return false;
	}

	$modelGroups = $this->dm->createQueryBuilder("ModelServiceBundle:ModelGroup")
	    ->field("active")->equals(true)
	    ->field("owners")->equals($owner)
	    ->getQuery()
	    ->execute();


	$lastTrainedModels = array(); // we can have some models with the same traning end time
	$lastTrainedTime = null;
	foreach ($modelGroups as $modelGroup) {
	    $models = $this->dm->createQueryBuilder("ModelServiceBundle:Model")
		->field("model_group")->equals($modelGroup)
		->field("active")->equals(true)
		->getQuery()
		->execute();

	    foreach ($models as $model) {
		$tmpTrainedTime = $model->getTrainEndTime();
		if ((!$lastTrainedTime) || $lastTrainedTime < $tmpTrainedTime) {
		    $lastTrainedTime = $tmpTrainedTime;
		    $lastTrainedModels = array($model);
		} elseif ($lastTrainedTime == $tmpTrainedTime) {
		    $lastTrainedModels[] = $model;
		}
	    }
	}

	return $lastTrainedModels;
    }
}
