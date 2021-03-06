<?php
namespace UserBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="owners",
 * )
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"name"="asc"}),
 *   @MongoDB\Index(keys={"phoneNumber"="asc"}), 
 *   @MongoDB\Index(keys={"email"="asc"}),
 *   @MongoDB\Index(keys={"active"="asc"}),
 *   @MongoDB\Index(keys={"permission"="asc"}),
 *  })
 */
class Owner
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
     * @MongoDB\Field(type="boolean")
     */
    protected $active;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $phoneNumber;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="string")                                                                                                                                                                   
     */
    protected $email;

    /**                                                                                                                                                                                                    
     * @MongoDB\Field(type="string")                                                                                                                                                                   
     */
    protected $permission;



    public function __construct($name,
				$phoneNumber,
				$email,
				$permission) {
	$this->name = $name;
	$this->phoneNumber = $phoneNumber;
	$this->email = $email;
	$this->permission = $permission;
	$this->active = true;
	return $this;
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
     * Set phoneNumber
     *
     * @param float $phoneNumber
     * @return $this
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return float $phoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set permission
     *
     * @param string $permission
     * @return $this
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
        return $this;
    }

    /**
     * Get permission
     *
     * @return string $permission
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
    }
}
