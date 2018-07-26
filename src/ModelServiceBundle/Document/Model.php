<?php
namespace ModelServiceBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
// we still need hyperparamters and initiation parameters

/**
 * @MongoDB\Document(
 *   collection="models",
 * )
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"subName"="asc"}),
 *   @MongoDB\Index(keys={"accuracy"="asc"}),
 *   @MongoDB\Index(keys={"feature_names"="asc"}), 
 *   @MongoDB\Index(keys={"train_start_time"="asc", "train_stop_time"="asc"}),
 *   @MongoDB\Index(keys={"train_stop_time"="asc"}),
 *   @MongoDB\Index(keys={"dataset.training"="asc"}),
 *   @MongoDB\Index(keys={"dataset.test"="asc"}),
 *   @MongoDB\Index(keys={"model_group"="asc"}),
 *   @MongoDB\Index(keys={"active"="asc"}),
 *   @MongoDB\Index(keys={"createdAt"="asc"}),
 *   @MongoDB\Index(keys={"train_methods"="asc"}),
 *   @MongoDB\Index(keys={"optimization_methods"="asc"}),
 *  })
 * @MongoDB\HasLifecycleCallbacks()
 */
class Model
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    

    /**
     * @MongoDB\Field(type="float")
     */
    protected $accuracy;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $subName;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $feature_names;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="date")                                                                                                                                                                   
     */
    protected $train_start_time;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="date")                                                                                                                                                                   
     */
    protected $train_end_time;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="date")                                                                                                                                                                   
     */
    protected $createdAt;



    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="boolean")                                                                                                                                                                   
     */
    protected $active;

    /**                                                                                                                                                                                                    
     * @MongoDB\ReferenceOne(targetDocument="ModelServiceBundle\Document\ModelGroup",
     *                       simple=true)                                                                                                                                                                  
     */
    protected $model_group;


    /**                                                                                                                                                                                                         * @MongoDB\Field(type="collection")                                                                                                                                                                   
     */
    protected $train_methods;
    
    /**                                                                                                                                                                                                   
     * @MongoDB\Field(type="collection")                                                                                                                                                                   
     */
    protected $optimization_methods;
    

    /**                                                                                                                                                                                                  
     * @MongoDB\Field(type="hash")                                                                                                                                                                   
     */
    protected $machine_powers;

    /**                                                                                                                                                                                                  
     * @MongoDB\Field(type="hash")                                                                                                                                                                   
     */
    protected $dataset;

    /**                                                                                                                                                                                                  
     * @MongoDB\Field(type="hash")                                                                                                                                                                   
     */
    protected $hyperparameters;



    /**
     * @MongoDB\PrePersist
     */

    public function setPrePersistCreatedAt() {
	$this->createdAt = new \DateTime("now");
    }



    public function __construct($subName, $modelGroup, $accuracy=null, $feature_names=null,
				$hyperparameters=null, $train_start_time=null, $train_stop_time=null)
    {
	$this->subName = $subName;
	$this->model_group = $modelGroup;
	$this->accuracy = $accuracy;
	$this->feature_names = $feature_names;
	$this->hyperparameters = $hyperparameters;
	$this->train_start_time = $train_start_time;
	$this->train_stop_time = $train_stop_time;
        return $this;
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set accuracy
     *
     * @param float $accuracy
     * @return $this
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
        return $this;
    }

    /**
     * Get accuracy
     *
     * @return float $accuracy
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * Set featureNames
     *
     * @param collection $featureNames
     * @return $this
     */
    public function setFeatureNames($featureNames)
    {
        $this->feature_names = $featureNames;
        return $this;
    }

    /**
     * Get featureNames
     *
     * @return collection $featureNames
     */
    public function getFeatureNames()
    {
        return $this->feature_names;
    }

    /**
     * Set trainStartTime
     *
     * @param date $trainStartTime
     * @return $this
     */
    public function setTrainStartTime($trainStartTime)
    {
        $this->train_start_time = $trainStartTime;
        return $this;
    }

    /**
     * Get trainStartTime
     *
     * @return date $trainStartTime
     */
    public function getTrainStartTime()
    {
        return $this->train_start_time;
    }

    /**
     * Set trainEndTime
     *
     * @param date $trainEndTime
     * @return $this
     */
    public function setTrainEndTime($trainEndTime)
    {
        $this->train_end_time = $trainEndTime;
        return $this;
    }

    /**
     * Get trainEndTime
     *
     * @return date $trainEndTime
     */
    public function getTrainEndTime()
    {
        return $this->train_end_time;
    }

    /**
     * Set modelGroup
     *
     * @param ModelServiceBundle\Document\ModelGroup $modelGroup
     * @return $this
     */
    public function setModelGroup(\ModelServiceBundle\Document\ModelGroup $modelGroup)
    {
        $this->model_group = $modelGroup;
        return $this;
    }

    /**
     * Get modelGroup
     *
     * @return ModelServiceBundle\Document\ModelGroup $modelGroup
     */
    public function getModelGroup()
    {
        return $this->model_group;
    }

    /**
     * Set trainMethods
     *
     * @param collection $trainMethods
     * @return $this
     */
    public function setTrainMethods($trainMethods)
    {
        $this->train_methods = $trainMethods;
        return $this;
    }

    /**
     * Get trainMethods
     *
     * @return collection $trainMethods
     */
    public function getTrainMethods()
    {
        return $this->train_methods;
    }

    /**
     * Set optimizationMethods
     *
     * @param collection $optimizationMethods
     * @return $this
     */
    public function setOptimizationMethods($optimizationMethods)
    {
        $this->optimization_methods = $optimizationMethods;
        return $this;
    }

    /**
     * Get optimizationMethods
     *
     * @return collection $optimizationMethods
     */
    public function getOptimizationMethods()
    {
        return $this->optimization_methods;
    }

    /**
     * Set machinePowers
     *
     * @param hash $machinePowers
     * @return $this
     */
    public function setMachinePowers($machinePowers)
    {
        $this->machine_powers = $machinePowers;
        return $this;
    }

    /**
     * Get machinePowers
     *
     * @return hash $machinePowers
     */
    public function getMachinePowers()
    {
        return $this->machine_powers;
    }

    /**
     * Set dataset
     *
     * @param hash $dataset
     * @return $this
     */
    public function setDataset($dataset)
    {
        $this->dataset = $dataset;
        return $this;
    }

    /**
     * Get dataset
     *
     * @return hash $dataset
     */
    public function getDataset()
    {
        return $this->dataset;
    }

    /**
     * Set hyperparameters
     *
     * @param hash $hyperparameters
     * @return $this
     */
    public function setHyperparameters($hyperparameters)
    {
        $this->hyperparameters = $hyperparameters;
        return $this;
    }

    /**
     * Get hyperparameters
     *
     * @return hash $hyperparameters
     */
    public function getHyperparameters()
    {
        return $this->hyperparameters;
    }

    /**
     * Set subName
     *
     * @param string $subName
     * @return $this
     */
    public function setSubName($subName)
    {
        $this->subName = $subName;
        return $this;
    }

    /**
     * Get subName
     *
     * @return string $subName
     */
    public function getSubName()
    {
        return $this->subName;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
