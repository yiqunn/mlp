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
 *   @MongoDB\Index(keys={"accuracy.training"="asc"}),
 *   @MongoDB\Index(keys={"accuracy.test"="asc"}),
 *   @MongoDB\Index(keys={"feature_names"="asc"}), 
 *   @MongoDB\Index(keys={"train_start_time"="asc", "train_stop_time"="asc"}),
 *   @MongoDB\Index(keys={"train_stop_time"="asc"}),
 *   @MongoDB\Index(keys={"dataset.training"="asc"}),
 *   @MongoDB\Index(keys={"dataset.test"="asc"}),
 *   @MongoDB\Index(keys={"model_group"="asc"}),
 *   @MongoDB\Index(keys={"training_methods"="asc"}),
 *   @MongoDB\Index(keys={"optimization_methods"="asc"}),
 *  })
 */
class Model
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $subName;
    

    /**
     * @MongoDB\Field(type="hash")
     */
    protected $accuracy;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $feature_names;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="date")                                                                                                                                                                   
     */
    protected $training_start_time;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="date")                                                                                                                                                                   
     */
    protected $training_end_time;

    /**                                                                                                                                                                                                    
     * @MongoDB\ReferenceOne(targetDocument="ModelServiceBundle\Document\ModelGroup",
     *                       simple=true)                                                                                                                                                                  
     */
    protected $model_group;


    /**                                                                                                                                                                                                         * @MongoDB\Field(type="collection")                                                                                                                                                                   
     */
    protected $training_methods;
    
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
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
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
     * Set trainingStartTime
     *
     * @param date $trainingStartTime
     * @return $this
     */
    public function setTrainingStartTime($trainingStartTime)
    {
        $this->training_start_time = $trainingStartTime;
        return $this;
    }

    /**
     * Get trainingStartTime
     *
     * @return date $trainingStartTime
     */
    public function getTrainingStartTime()
    {
        return $this->training_start_time;
    }

    /**
     * Set trainingEndTime
     *
     * @param date $trainingEndTime
     * @return $this
     */
    public function setTrainingEndTime($trainingEndTime)
    {
        $this->training_end_time = $trainingEndTime;
        return $this;
    }

    /**
     * Get trainingEndTime
     *
     * @return date $trainingEndTime
     */
    public function getTrainingEndTime()
    {
        return $this->training_end_time;
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
     * Set trainingMethods
     *
     * @param collection $trainingMethods
     * @return $this
     */
    public function setTrainingMethods($trainingMethods)
    {
        $this->training_methods = $trainingMethods;
        return $this;
    }

    /**
     * Get trainingMethods
     *
     * @return collection $trainingMethods
     */
    public function getTrainingMethods()
    {
        return $this->training_methods;
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
}
