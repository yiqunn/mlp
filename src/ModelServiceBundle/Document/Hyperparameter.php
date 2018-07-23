<?php
namespace ModelServiceBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
// we still need hyperparamters and initiation parameters

/**
 * @MongoDB\Document(
 *   collection="hyperparameters",
 * )
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"name"="asc"}), 
 *   @MongoDB\Index(keys={"models"="asc"}),
 *  })
 */
class Hyperparameter
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
    protected $value;

    /**                                                                                                                                                                                                    
     * @MongoDB\ReferenceMany(targetDocument="ModelServiceBundle\Document\Model",
     *                        simple=true)
     */
    protected $models;


    public function __construct()
    {
        $this->models = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set value
     *
     * @param float $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value
     *
     * @return float $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Add model
     *
     * @param ModelServiceBundle\Document\Model $model
     */
    public function addModel(\ModelServiceBundle\Document\Model $model)
    {
        $this->models[] = $model;
    }

    /**
     * Remove model
     *
     * @param ModelServiceBundle\Document\Model $model
     */
    public function removeModel(\ModelServiceBundle\Document\Model $model)
    {
        $this->models->removeElement($model);
    }

    /**
     * Get models
     *
     * @return \Doctrine\Common\Collections\Collection $models
     */
    public function getModels()
    {
        return $this->models;
    }
}
