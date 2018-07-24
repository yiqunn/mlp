<?php
namespace ModelServiceBundle\Document;
use ModelServiceBundle\Document\Parameter;
use ModelServiceBundle\Document\EnumParamType;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="parameters",
 * )
 */
class Hyperparameter extends Parameter
{
    public function getParamType() {
	return EnumParamType::hyper;
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
