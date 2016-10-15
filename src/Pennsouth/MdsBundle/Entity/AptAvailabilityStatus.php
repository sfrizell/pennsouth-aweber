<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * AptAvailabilityStatus
 */
class AptAvailabilityStatus
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $availabilityCode;


    /**
     * Set description
     *
     * @param string $description
     *
     * @return AptAvailabilityStatus
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get availabilityCode
     *
     * @return string
     */
    public function getAvailabilityCode()
    {
        return $this->availabilityCode;
    }
}
