<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * PennsouthStorageLocker
 */
class PennsouthStorageLocker
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var integer
     */
    private $storageLockerId;

    /**
     * @var \Pennsouth\MdsBundle\Entity\PennsouthBldg
     */
    private $building;

    /**
     * @var \Pennsouth\MdsBundle\Entity\AvailabilityStatus
     */
    private $availabilityStatusCode;


    /**
     * Set location
     *
     * @param string $location
     *
     * @return PennsouthStorageLocker
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get storageLockerId
     *
     * @return integer
     */
    public function getStorageLockerId()
    {
        return $this->storageLockerId;
    }

    /**
     * Set building
     *
     * @param \Pennsouth\MdsBundle\Entity\PennsouthBldg $building
     *
     * @return PennsouthStorageLocker
     */
    public function setBuilding(\Pennsouth\MdsBundle\Entity\PennsouthBldg $building = null)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return \Pennsouth\MdsBundle\Entity\PennsouthBldg
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set availabilityStatusCode
     *
     * @param \Pennsouth\MdsBundle\Entity\AvailabilityStatus $availabilityStatusCode
     *
     * @return PennsouthStorageLocker
     */
    public function setAvailabilityStatusCode(\Pennsouth\MdsBundle\Entity\AvailabilityStatus $availabilityStatusCode = null)
    {
        $this->availabilityStatusCode = $availabilityStatusCode;

        return $this;
    }

    /**
     * Get availabilityStatusCode
     *
     * @return \Pennsouth\MdsBundle\Entity\AvailabilityStatus
     */
    public function getAvailabilityStatusCode()
    {
        return $this->availabilityStatusCode;
    }
}
