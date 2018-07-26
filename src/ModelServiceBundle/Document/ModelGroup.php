<?php
namespace ModelServiceBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="modelGroups",
 * )
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"name"="asc"}),
 *   @MongoDB\Index(keys={"accuracy"="asc"}),
 *   @MongoDB\Index(keys={"owners"="asc"}),
 *   @MongoDB\Index(keys={"active"="asc"}), 
 *   @MongoDB\Index(keys={"current_version"="asc"}),
 *   @MongoDB\Index(keys={"algorithm"="asc"}),
 *  })
 */
class ModelGroup
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;
    
    /**
     * @MongoDB\Field(type="float")
     */
    protected $accuracy;


    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="boolean")                                                                                                                                                                   
     */
    protected $active;

    /**                                                                                                                                                                                                    
     * @MongoDB\ReferenceMany(targetDocument="UserBundle\Document\Owner",
     *				simple=true)                                                                                                                                                              
     */
    protected $owners;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="string")                                                                                                                                                                   
     */
    protected $algorithm;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="integer")                                                                                                                                                                   
     */
    protected $activeModels;

    /**                                                                                                                                                                                                    
     * @MongoDB\ReferenceOne(targetDocument="ModelServiceBundle\Document\Model",
     *                       simple=true)                                                                                                                                                                  
     */
    protected $current_version;

    



    public function __construct($name, $owners)
    {
	$this->name = $name;
	$this->owners = $owners;
	$this->active = true;
	$this->activeModels = 0;
        return $this;
    }

    public function addOneActiveModel() {
	$this->active = true;
	$this->activeModels += 1;
    }

    public function decreaseActiveModels() {
	$this->activeModels -= 1;
	if ($this->activeModels <= 0) {
	    $this->activeModels = 0;
	    $this->active = false;
	}
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
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
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
     * Set algorithm
     *
     * @param string $algorithm
     * @return $this
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
        return $this;
    }

    /**
     * Get algorithm
     *
     * @return string $algorithm
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Set currentVersion
     *
     * @param ModelServiceBundle\Document\Model $currentVersion
     * @return $this
     */
    public function setCurrentVersion(\ModelServiceBundle\Document\Model $currentVersion)
    {
        $this->current_version = $currentVersion;
        return $this;
    }

    /**
     * Get currentVersion
     *
     * @return ModelServiceBundle\Document\Model $currentVersion
     */
    public function getCurrentVersion()
    {
        return $this->current_version;
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
     * Set activeModels
     *
     * @param integer $activeModels
     * @return $this
     */
    public function setActiveModels($activeModels)
    {
        $this->activeModels = $activeModels;
        return $this;
    }

    /**
     * Get activeModels
     *
     * @return integer $activeModels
     */
    public function getActiveModels()
    {
        return $this->activeModels;
    }

    /**
     * Add owner
     *
     * @param UserBundle\Document\Owner $owner
     */
    public function addOwner(\UserBundle\Document\Owner $owner)
    {
        $this->owners[] = $owner;
    }

    /**
     * Remove owner
     *
     * @param UserBundle\Document\Owner $owner
     */
    public function removeOwner(\UserBundle\Document\Owner $owner)
    {
        $this->owners->removeElement($owner);
    }

    /**
     * Get owners
     *
     * @return \Doctrine\Common\Collections\Collection $owners
     */
    public function getOwners()
    {
        return $this->owners;
    }
}
