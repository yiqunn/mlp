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
 *   @MongoDB\Index(keys={"owner"="asc"}), 
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
     * @MongoDB\ReferenceOne(targetDocument="UserBundle\Document\Owner",
     *                       simple=true)                                                                                                                                                              
     */
    protected $owner;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="string")                                                                                                                                                                   
     */
    protected $algorithm;

    /**                                                                                                                                                                                                    
     * @MongoDB\ReferenceOne(targetDocument="ModelServiceBundle\Document\Model",
     *                       simple=true)                                                                                                                                                                  
     */
    protected $current_version;

    



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
     * Set owner
     *
     * @param string $owner
     * @return $this
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get owner
     *
     * @return string $owner
     */
    public function getOwner()
    {
        return $this->owner;
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
}
