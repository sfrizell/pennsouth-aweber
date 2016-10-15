<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * PennSouthUtilityCloset
 */
class PennSouthUtilityCloset
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var integer
     */
    private $utilityClosetId;

    /**
     * @var \Pennsouth\MdsBundle\Entity\PennsouthBldg
     */
    private $buiilding;

    /**
     * @var \Pennsouth\MdsBundle\Entity\AvailabilityStatus
     */
    private $availabilityStatusCode;


    /**
     * Set location
     *
     * @param string $location
     *
     * @return PennSouthUtilityCloset
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
     * Get utilityClosetId
     *
     * @return integer
     */
    public function getUtilityClosetId()
    {
        return $this->utilityClosetId;
    }

    /**
     * Set buiilding
     *
     * @param \Pennsouth\MdsBundle\Entity\PennsouthBldg $buiilding
     *
     * @return PennSouthUtilityCloset
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

    /**
     * Set availabilityStatusCode
     *
     * @param \Pennsouth\MdsBundle\Entity\AvailabilityStatus $availabilityStatusCode
     *
     * @return PennSouthUtilityCloset
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
