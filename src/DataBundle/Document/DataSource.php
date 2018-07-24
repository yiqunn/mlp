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
     * Set locations
     *
     * @param hash $locations
     * @return $this
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;
        return $this;
    }

    /**
     * Get locations
     *
     * @return hash $locations
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Set columns
     *
     * @param collection $columns
     * @return $this
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Get columns
     *
     * @return collection $columns
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set size
     *
     * @param float $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Get size
     *
     * @return float $size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set dataSourceGroup
     *
     * @param DataBundle\Document\DataSourceGroup $dataSourceGroup
     * @return $this
     */
    public function setDataSourceGroup(\DataBundle\Document\DataSourceGroup $dataSourceGroup)
    {
        $this->dataSourceGroup = $dataSourceGroup;
        return $this;
    }

    /**
     * Get dataSourceGroup
     *
     * @return DataBundle\Document\DataSourceGroup $dataSourceGroup
     */
    public function getDataSourceGroup()
    {
        return $this->dataSourceGroup;
    }
}
