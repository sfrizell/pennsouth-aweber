<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PennsouthApt
 *
 * @ORM\Table(name="Pennsouth_Apt", indexes={@ORM\Index(name="fk_Pennsouth_Apt_Apt_Availability_Status1_idx", columns={"Apt_Availability_code"}), @ORM\Index(name="fk_Pennsouth_Apt_Apt_Size1_idx", columns={"Apt_Size_apt_size_code"}), @ORM\Index(name="fk_Pennsouth_Apt_Pennsouth_Bldg1", columns={"Buiilding_Id"})})
 * @ORM\Entity
 */
class PennsouthApt
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Floor_Number", type="integer", nullable=false)
     */
    private $floorNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Apt_Line", type="string", length=1, nullable=false)
     */
    private $aptLine;

    /**
     * @var string
     *
     * @ORM\Column(name="apartment_name", type="string", length=4, nullable=false)
     */
    private $apartmentName;

    /**
     * @var string
     *
     * @ORM\Column(name="Room_count", type="decimal", precision=2, scale=0, nullable=false)
     */
    private $roomCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="Bedroom_Count", type="integer", nullable=false)
     */
    private $bedroomCount;

    /**
     * @var string
     *
     * @ORM\Column(name="Has_Dining_Area", type="string", length=1, nullable=true)
     */
    private $hasDiningArea;

    /**
     * @var string
     *
     * @ORM\Column(name="Has_Dressing_Room", type="string", length=1, nullable=true)
     */
    private $hasDressingRoom;

    /**
     * @var string
     *
     * @ORM\Column(name="Balcony_Terrace_Code", type="string", length=1, nullable=true)
     */
    private $balconyTerraceCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Has_Alcove", type="string", length=1, nullable=true)
     */
    private $hasAlcove;

    /**
     * @var string
     *
     * @ORM\Column(name="Has_2nd_Bathroom", type="string", length=1, nullable=true)
     */
    private $has2ndBathroom;

    /**
     * @var string
     *
     * @ORM\Column(name="Has_South_Exposure", type="string", length=1, nullable=true)
     */
    private $hasSouthExposure;

    /**
     * @var string
     *
     * @ORM\Column(name="Has_West_Exposure", type="string", length=1, nullable=true)
     */
    private $hasWestExposure;

    /**
     * @var string
     *
     * @ORM\Column(name="Has_East_Exposure", type="string", length=1, nullable=true)
     */
    private $hasEastExposure;

    /**
     * @var string
     *
     * @ORM\Column(name="Has_North_Exposure", type="string", length=1, nullable=true)
     */
    private $hasNorthExposure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="availability_status_date", type="datetime", nullable=true)
     */
    private $availabilityStatusDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="apartment_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $apartmentId;

    /**
     * @var \Pennsouth\MdsBundle\Entity\AptSize
     *
     * @ORM\ManyToOne(targetEntity="Pennsouth\MdsBundle\Entity\AptSize")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Apt_Size_apt_size_code", referencedColumnName="apt_size_code")
     * })
     */
    private $aptSizeAptSizeCode;

    /**
     * @var \Pennsouth\MdsBundle\Entity\AptAvailabilityStatus
     *
     * @ORM\ManyToOne(targetEntity="Pennsouth\MdsBundle\Entity\AptAvailabilityStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Apt_Availability_code", referencedColumnName="availability_code")
     * })
     */
    private $aptAvailabilityCode;

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
     * Set floorNumber
     *
     * @param integer $floorNumber
     * @return PennsouthApt
     */
    public function setFloorNumber($floorNumber)
    {
        $this->floorNumber = $floorNumber;

        return $this;
    }

    /**
     * Get floorNumber
     *
     * @return integer 
     */
    public function getFloorNumber()
    {
        return $this->floorNumber;
    }

    /**
     * Set aptLine
     *
     * @param string $aptLine
     * @return PennsouthApt
     */
    public function setAptLine($aptLine)
    {
        $this->aptLine = $aptLine;

        return $this;
    }

    /**
     * Get aptLine
     *
     * @return string 
     */
    public function getAptLine()
    {
        return $this->aptLine;
    }

    /**
     * Set apartmentName
     *
     * @param string $apartmentName
     * @return PennsouthApt
     */
    public function setApartmentName($apartmentName)
    {
        $this->apartmentName = $apartmentName;

        return $this;
    }

    /**
     * Get apartmentName
     *
     * @return string 
     */
    public function getApartmentName()
    {
        return $this->apartmentName;
    }

    /**
     * Set roomCount
     *
     * @param string $roomCount
     * @return PennsouthApt
     */
    public function setRoomCount($roomCount)
    {
        $this->roomCount = $roomCount;

        return $this;
    }

    /**
     * Get roomCount
     *
     * @return string 
     */
    public function getRoomCount()
    {
        return $this->roomCount;
    }

    /**
     * Set bedroomCount
     *
     * @param integer $bedroomCount
     * @return PennsouthApt
     */
    public function setBedroomCount($bedroomCount)
    {
        $this->bedroomCount = $bedroomCount;

        return $this;
    }

    /**
     * Get bedroomCount
     *
     * @return integer 
     */
    public function getBedroomCount()
    {
        return $this->bedroomCount;
    }

    /**
     * Set hasDiningArea
     *
     * @param string $hasDiningArea
     * @return PennsouthApt
     */
    public function setHasDiningArea($hasDiningArea)
    {
        $this->hasDiningArea = $hasDiningArea;

        return $this;
    }

    /**
     * Get hasDiningArea
     *
     * @return string 
     */
    public function getHasDiningArea()
    {
        return $this->hasDiningArea;
    }

    /**
     * Set hasDressingRoom
     *
     * @param string $hasDressingRoom
     * @return PennsouthApt
     */
    public function setHasDressingRoom($hasDressingRoom)
    {
        $this->hasDressingRoom = $hasDressingRoom;

        return $this;
    }

    /**
     * Get hasDressingRoom
     *
     * @return string 
     */
    public function getHasDressingRoom()
    {
        return $this->hasDressingRoom;
    }

    /**
     * Set balconyTerraceCode
     *
     * @param string $balconyTerraceCode
     * @return PennsouthApt
     */
    public function setBalconyTerraceCode($balconyTerraceCode)
    {
        $this->balconyTerraceCode = $balconyTerraceCode;

        return $this;
    }

    /**
     * Get balconyTerraceCode
     *
     * @return string 
     */
    public function getBalconyTerraceCode()
    {
        return $this->balconyTerraceCode;
    }

    /**
     * Set hasAlcove
     *
     * @param string $hasAlcove
     * @return PennsouthApt
     */
    public function setHasAlcove($hasAlcove)
    {
        $this->hasAlcove = $hasAlcove;

        return $this;
    }

    /**
     * Get hasAlcove
     *
     * @return string 
     */
    public function getHasAlcove()
    {
        return $this->hasAlcove;
    }

    /**
     * Set has2ndBathroom
     *
     * @param string $has2ndBathroom
     * @return PennsouthApt
     */
    public function setHas2ndBathroom($has2ndBathroom)
    {
        $this->has2ndBathroom = $has2ndBathroom;

        return $this;
    }

    /**
     * Get has2ndBathroom
     *
     * @return string 
     */
    public function getHas2ndBathroom()
    {
        return $this->has2ndBathroom;
    }

    /**
     * Set hasSouthExposure
     *
     * @param string $hasSouthExposure
     * @return PennsouthApt
     */
    public function setHasSouthExposure($hasSouthExposure)
    {
        $this->hasSouthExposure = $hasSouthExposure;

        return $this;
    }

    /**
     * Get hasSouthExposure
     *
     * @return string 
     */
    public function getHasSouthExposure()
    {
        return $this->hasSouthExposure;
    }

    /**
     * Set hasWestExposure
     *
     * @param string $hasWestExposure
     * @return PennsouthApt
     */
    public function setHasWestExposure($hasWestExposure)
    {
        $this->hasWestExposure = $hasWestExposure;

        return $this;
    }

    /**
     * Get hasWestExposure
     *
     * @return string 
     */
    public function getHasWestExposure()
    {
        return $this->hasWestExposure;
    }

    /**
     * Set hasEastExposure
     *
     * @param string $hasEastExposure
     * @return PennsouthApt
     */
    public function setHasEastExposure($hasEastExposure)
    {
        $this->hasEastExposure = $hasEastExposure;

        return $this;
    }

    /**
     * Get hasEastExposure
     *
     * @return string 
     */
    public function getHasEastExposure()
    {
        return $this->hasEastExposure;
    }

    /**
     * Set hasNorthExposure
     *
     * @param string $hasNorthExposure
     * @return PennsouthApt
     */
    public function setHasNorthExposure($hasNorthExposure)
    {
        $this->hasNorthExposure = $hasNorthExposure;

        return $this;
    }

    /**
     * Get hasNorthExposure
     *
     * @return string 
     */
    public function getHasNorthExposure()
    {
        return $this->hasNorthExposure;
    }

    /**
     * Set availabilityStatusDate
     *
     * @param \DateTime $availabilityStatusDate
     * @return PennsouthApt
     */
    public function setAvailabilityStatusDate($availabilityStatusDate)
    {
        $this->availabilityStatusDate = $availabilityStatusDate;

        return $this;
    }

    /**
     * Get availabilityStatusDate
     *
     * @return \DateTime 
     */
    public function getAvailabilityStatusDate()
    {
        return $this->availabilityStatusDate;
    }

    /**
     * Get apartmentId
     *
     * @return integer 
     */
    public function getApartmentId()
    {
        return $this->apartmentId;
    }

    /**
     * Set aptSizeAptSizeCode
     *
     * @param \Pennsouth\MdsBundle\Entity\AptSize $aptSizeAptSizeCode
     * @return PennsouthApt
     */
    public function setAptSizeAptSizeCode(\Pennsouth\MdsBundle\Entity\AptSize $aptSizeAptSizeCode = null)
    {
        $this->aptSizeAptSizeCode = $aptSizeAptSizeCode;

        return $this;
    }

    /**
     * Get aptSizeAptSizeCode
     *
     * @return \Pennsouth\MdsBundle\Entity\AptSize 
     */
    public function getAptSizeAptSizeCode()
    {
        return $this->aptSizeAptSizeCode;
    }

    /**
     * Set aptAvailabilityCode
     *
     * @param \Pennsouth\MdsBundle\Entity\AptAvailabilityStatus $aptAvailabilityCode
     * @return PennsouthApt
     */
    public function setAptAvailabilityCode(\Pennsouth\MdsBundle\Entity\AptAvailabilityStatus $aptAvailabilityCode = null)
    {
        $this->aptAvailabilityCode = $aptAvailabilityCode;

        return $this;
    }

    /**
     * Get aptAvailabilityCode
     *
     * @return \Pennsouth\MdsBundle\Entity\AptAvailabilityStatus 
     */
    public function getAptAvailabilityCode()
    {
        return $this->aptAvailabilityCode;
    }

    /**
     * Set buiilding
     *
     * @param \Pennsouth\MdsBundle\Entity\PennsouthBldg $buiilding
     * @return PennsouthApt
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
