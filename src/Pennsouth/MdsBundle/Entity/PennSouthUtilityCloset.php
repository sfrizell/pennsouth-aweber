<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PennSouthUtilityCloset
 *
 * @ORM\Table(name="Penn_South_Utility_Closet", indexes={@ORM\Index(name="fk_Penn_South_Utility_Closet_Pennsouth_Bldg1_idx", columns={"Buiilding_Id"}), @ORM\Index(name="fk_Penn_South_Utility_Closet_Availability_Status1_idx", columns={"Availability_status_code"})})
 * @ORM\Entity
 */
class PennSouthUtilityCloset
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
     * @ORM\Column(name="utility_closet_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $utilityClosetId;

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
     * Set availabilityStatusCode
     *
     * @param \Pennsouth\MdsBundle\Entity\AvailabilityStatus $availabilityStatusCode
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

    /**
     * Set buiilding
     *
     * @param \Pennsouth\MdsBundle\Entity\PennsouthBldg $buiilding
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
}
