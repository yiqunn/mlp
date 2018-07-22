<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="products",
 * )
 */
class Product
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
  protected $price;
}