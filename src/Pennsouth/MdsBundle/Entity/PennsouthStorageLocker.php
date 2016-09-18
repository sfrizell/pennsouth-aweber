<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PennsouthStorageLocker
 *
 * @ORM\Table(name="Pennsouth_Storage_Locker", indexes={@ORM\Index(name="fk_Penn_South_Storage_Locker_Pennsouth_Bldg1_idx", columns={"Buiilding_Id"}), @ORM\Index(name="fk_Penn_South_Storage_Locker_Availability_Status1_idx", columns={"Availability_status_code"})})
 * @ORM\Entity
 */
class PennsouthStorageLocker
{
    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=45, nullable=true)
     */
    private $location;

    /**
     * @var integer
     *
     * @ORM\Column(name="storage_locker_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $storageLockerId;

    /**
     * @var \Pennsouth\MdsBundle\Entity\AvailabilityStatus
     *
     * @ORM\ManyToOne(targetEntity="Pennsouth\MdsBundle\Entity\AvailabilityStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Availability_status_code", referencedColumnName="availability_status_code")
     * })
     */
    private $availabilityStatusCode;

    /**
     * @var \Pennsouth\MdsBundle\Entity\PennsouthBldg
     *
     * @ORM\ManyToOne(targetEntity="Pennsouth\MdsBundle\Entity\PennsouthBldg")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Buiilding_Id", referencedColumnName="Building_Id")
     * })
     */
    private $buiilding;



    /**
     * Set location
     *
     * @param string $location
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
     * Set availabilityStatusCode
     *
     * @param \Pennsouth\MdsBundle\Entity\AvailabilityStatus $availabilityStatusCode
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

    /**
     * Set buiilding
     *
     * @param \Pennsouth\MdsBundle\Entity\PennsouthBldg $buiilding
     * @return PennsouthStorageLocker
     */
    public function setBuiilding(\Pennsouth\MdsBundle\Entity\PennsouthBldg $buiilding = null)
    {
        $this->buiilding = $buiilding;

        return $this;
    }

    /**
     * Get buiilding
     *
     * @return \Pennsouth\MdsBundle\Entity\PennsouthBldg 
     */
    public function getBuiilding()
    {
        return $this->buiilding;
    }
}
