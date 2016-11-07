<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * AvailabilityStatus
 */
class AvailabilityStatus
{
    /**
     * @var string
     */
    private $statusDescription;

    /**
     * @var string
     */
    private $availabilityStatusCode;


    /**
     * Set statusDescription
     *
     * @param string $statusDescription
     *
     * @return AvailabilityStatus
     */
    public function setStatusDescription($statusDescription)
    {
        $this->statusDescription = $statusDescription;

        return $this;
    }

    /**
     * Get statusDescription
     *
     * @return string
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     * Get availabilityStatusCode
     *
     * @return string
     */
    public function getAvailabilityStatusCode()
    {
        return $this->availabilityStatusCode;
    }
}
