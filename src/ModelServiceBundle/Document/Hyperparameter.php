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
class Hyperparameter extend Parameter
{
    public function getParamType() {
	return EnumParamType::hyper;
    }
}
