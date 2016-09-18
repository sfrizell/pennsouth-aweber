<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AvailabilityStatus
 *
 * @ORM\Table(name="Availability_Status")
 * @ORM\Entity
 */
class AvailabilityStatus
{
    /**
     * @var string
     *
     * @ORM\Column(name="status_description", type="string", length=45, nullable=true)
     */
    private $statusDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="availability_status_code", type="string", length=25)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $availabilityStatusCode;



    /**
     * Set statusDescription
     *
     * @param string $statusDescription
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
