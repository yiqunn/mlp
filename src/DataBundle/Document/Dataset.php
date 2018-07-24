<?php
namespace DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="datasets",
 * )
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"locations.origin"="asc"}),
 *   @MongoDB\Index(keys={"locations.copy"="asc"}),
 *   @MongoDB\Index(keys={"columns"="asc"}), 
 *   @MongoDB\Index(keys={"size"="asc"}),
 *   @MongoDB\Index(keys={"dataSource"="asc"}),
 *  })
 */
class Dataset
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
     * @MongoDB\ReferenceOne(targetDocument="DataBundle\Document\DataSource",
     *                       simple=true)                                                                                                                                                                  
     */
    protected $dataSource;

    /**                              
     * @MongoDB\Field(type="string")                                                                                                                                                                    
     */
    protected $parseFunc;
        

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
     * Set dataSource
     *
     * @param DataBundle\Document\DataSource $dataSource
     * @return $this
     */
    public function setDataSource(\DataBundle\Document\DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
        return $this;
    }

    /**
     * Get dataSource
     *
     * @return DataBundle\Document\DataSource $dataSource
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * Set parseFunc
     *
     * @param string $parseFunc
     * @return $this
     */
    public function setParseFunc($parseFunc)
    {
        $this->parseFunc = $parseFunc;
        return $this;
    }

    /**
     * Get parseFunc
     *
     * @return string $parseFunc
     */
    public function getParseFunc()
    {
        return $this->parseFunc;
    }
}
