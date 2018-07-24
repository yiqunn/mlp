<?php
namespace ModelServiceBundle\Document;
use ModelServiceBundle\Document\Parameter;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="parameters",
 * )
 */
class InitiationParameter extend Parameter
{
    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="string")                                                                                                                                                                   
     */
    protected $strategy;

    public function getParamType() {
	return EnumParamType::initiation;
    }

}
