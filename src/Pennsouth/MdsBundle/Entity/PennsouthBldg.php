<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PennsouthBldg
 *
 * @ORM\Table(name="Pennsouth_Bldg")
 * @ORM\Entity
 */
class PennsouthBldg
{
    /**
     * @var string
     *
     * @ORM\Column(name="Building_Name", type="string", length=45, nullable=true)
     */
    private $buildingName;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=45, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="City", type="string", length=45, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="State", type="string", length=2, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="Zip", type="string", length=5, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="Building_Id", type="string", length=4)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $buildingId;



    /**
     * Set buildingName
     *
     * @param string $buildingName
     * @return PennsouthBldg
     */
    public function setBuildingName($buildingName)
    {
        $this->buildingName = $buildingName;

        return $this;
    }

    /**
     * Get buildingName
     *
     * @return string 
     */
    public function getBuildingName()
    {
        return $this->buildingName;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return PennsouthBldg
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return PennsouthBldg
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return PennsouthBldg
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return PennsouthBldg
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Get buildingId
     *
     * @return string 
     */
    public function getBuildingId()
    {
        return $this->buildingId;
    }
}
