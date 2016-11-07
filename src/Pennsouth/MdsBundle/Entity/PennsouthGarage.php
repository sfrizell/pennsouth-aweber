<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * PennsouthGarage
 */
class PennsouthGarage
{
    /**
     * @var string
     */
    private $garageName;

    /**
     * @var integer
     */
    private $garageId;

    /**
     * @var \Pennsouth\MdsBundle\Entity\AvailabilityStatus
     */
    private $availabilityStatusCode;


    /**
     * Set garageName
     *
     * @param string $garageName
     *
     * @return PennsouthGarage
     */
    public function setGarageName($garageName)
    {
        $this->garageName = $garageName;

        return $this;
    }

    /**
     * Get garageName
     *
     * @return string
     */
    public function getGarageName()
    {
        return $this->garageName;
    }

    /**
     * Get garageId
     *
     * @return integer
     */
    public function getGarageId()
    {
        return $this->garageId;
    }

    /**
     * Set availabilityStatusCode
     *
     * @param \Pennsouth\MdsBundle\Entity\AvailabilityStatus $availabilityStatusCode
     *
     * @return PennsouthGarage
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
