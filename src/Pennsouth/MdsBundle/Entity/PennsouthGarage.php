<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PennsouthGarage
 *
 * @ORM\Table(name="Pennsouth_Garage", indexes={@ORM\Index(name="fk_Penn_South_Garage_Availability_Status1_idx", columns={"Availability_status_code"})})
 * @ORM\Entity
 */
class PennsouthGarage
{
    /**
     * @var string
     *
     * @ORM\Column(name="garage_name", type="string", length=45, nullable=true)
     */
    private $garageName;

    /**
     * @var integer
     *
     * @ORM\Column(name="garage_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $garageId;

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
     * Set garageName
     *
     * @param string $garageName
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
