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
class DataSourceGroup
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
     * Set currentVersion
     *
     * @param DataBundle\Document\DataSource $currentVersion
     * @return $this
     */
    public function setCurrentVersion(\DataBundle\Document\DataSource $currentVersion)
    {
        $this->current_version = $currentVersion;
        return $this;
    }

    /**
     * Get currentVersion
     *
     * @return DataBundle\Document\DataSource $currentVersion
     */
    public function getCurrentVersion()
    {
        return $this->current_version;
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
}
