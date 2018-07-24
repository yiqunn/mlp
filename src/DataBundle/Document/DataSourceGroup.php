<?php
namespace DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="dataSourceGroups",
 * )
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"name"="asc"}),
 *   @MongoDB\Index(keys={"current_version"="asc"}),
 *  })
 */
class DataSourceGroups
{
    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**                                                                                                                                                                                                    
     * @MongoDB\ReferenceOne(targetDocument="DataBundle\Document\DataSource",
     *                       simple=true)                                                                                                                                                                  
     */
    protected $current_version;

    /**                              
     * @MongoDB\Field(type="string")                                                                                                                                                                    
     */
    protected $name;
        
}
