<?php
namespace DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="dataSources",
 * )
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"locations.origin"="asc"}),
 *   @MongoDB\Index(keys={"locations.copy"="asc"}),
 *   @MongoDB\Index(keys={"columns"="asc"}), 
 *   @MongoDB\Index(keys={"size"="asc"}),
 *   @MongoDB\Index(keys={"dataSourceGroup"="asc"}),
 *  })
 */
class DataSource
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="hash")
     */
    protected $locations;
    
    /**
     * @MongoDB\Field(type="collection")
     */
    protected $columns;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="float")                                                                                                                                                                   
     */
    protected $size;


    /**                                                                                                                                                                                                    
     * @MongoDB\ReferenceOne(targetDocument="DataBundle\Document\DataSourceGroup",
     *                       simple=true)                                                                                                                                                                  
     */
    protected $dataSourceGroup;

}
