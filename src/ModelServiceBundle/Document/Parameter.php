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

}
