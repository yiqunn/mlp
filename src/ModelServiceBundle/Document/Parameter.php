<?php
namespace ModelServiceBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="parameters",
 * )
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField("type")
 * @MongoDB\DiscriminatorMap({
 *   "hyper"="ModelServiceBundle\Document\Hyperparameter",
 *   "initiation"="ModelServiceBundle\Document\InitiationParameter",
 * })	
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"name"="asc"}),
 *   @MongoDB\Index(keys={"model"="asc"}),
 *   @MongoDB\Index(keys={"value"="asc"}),
 *   @MongoDB\Index(keys={"type"="asc"}), 
 *  })
 */
class Parameter
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
     * @MongoDB\ReferenceOne(targetDocument="ModelServiceBundle\Document\Model",
     *                       simple=true)                                                                                                                                                                  
     */
    protected $model;


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
     * Set model
     *
     * @param ModelServiceBundle\Document\Model $model
     * @return $this
     */
    public function setModel(\ModelServiceBundle\Document\Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Get model
     *
     * @return ModelServiceBundle\Document\Model $model
     */
    public function getModel()
    {
        return $this->model;
    }
}
