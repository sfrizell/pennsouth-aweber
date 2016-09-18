<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AptAvailabilityStatus
 *
 * @ORM\Table(name="Apt_Availability_Status")
 * @ORM\Entity
 */
class AptAvailabilityStatus
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="availability_code", type="string", length=10)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $availabilityCode;



    /**
     * Set description
     *
     * @param string $description
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
