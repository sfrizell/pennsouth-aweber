<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * PennsouthApt
 */
class PennsouthApt
{
    /**
     * @var integer
     */
    private $floorNumber;

    /**
     * @var string
     */
    private $aptLine;

    /**
     * @var string
     */
    private $apartmentName;

    /**
     * @var string
     */
    private $roomCount;

    /**
     * @var string
     */
    private $hasDiningArea;

    /**
     * @var string
     */
    private $hasDressingRoom;

    /**
     * @var string
     */
    private $balconyTerraceCode;

    /**
     * @var string
     */
    private $hasAlcove;

    /**
     * @var string
     */
    private $has2ndBathroom;

    /**
     * @var string
     */
    private $exposuresSummary;

    /**
     * @var string
     */
    private $hasSouthExposure;

    /**
     * @var string
     */
    private $hasWestExposure;

    /**
     * @var string
     */
    private $hasEastExposure;

    /**
     * @var string
     */
    private $hasNorthExposure;

    /**
     * @var \DateTime
     */
    private $availabilityStatusDate;

    /**
     * @var \DateTime
     */
    private $lastChangedDate;

    /**
     * @var integer
     */
    private $apartmentId;

    /**
     * @var \Pennsouth\MdsBundle\Entity\PennsouthBldg
     */
    private $building;

    /**
     * @var \Pennsouth\MdsBundle\Entity\AptSize
     */
    private $bedroomCount;

    /**
     * @var \Pennsouth\MdsBundle\Entity\AptAvailabilityStatus
     */
    private $aptAvailabilityCode;


    /**
     * Set floorNumber
     *
     * @param integer $floorNumber
     *
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
     *
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
     *
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
     *
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
     * Set hasDiningArea
     *
     * @param string $hasDiningArea
     *
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
     *
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
     *
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
     *
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
     *
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
     * Set exposuresSummary
     *
     * @param string $exposuresSummary
     *
     * @return PennsouthApt
     */
    public function setExposuresSummary($exposuresSummary)
    {
        $this->exposuresSummary = $exposuresSummary;

        return $this;
    }

    /**
     * Get exposuresSummary
     *
     * @return string
     */
    public function getExposuresSummary()
    {
        return $this->exposuresSummary;
    }

    /**
     * Set hasSouthExposure
     *
     * @param string $hasSouthExposure
     *
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
     *
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
     *
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
     *
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
     *
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
     * Set lastChangedDate
     *
     * @param \DateTime $lastChangedDate
     *
     * @return PennsouthApt
     */
    public function setLastChangedDate($lastChangedDate)
    {
        $this->lastChangedDate = $lastChangedDate;

        return $this;
    }

    /**
     * Get lastChangedDate
     *
     * @return \DateTime
     */
    public function getLastChangedDate()
    {
        return $this->lastChangedDate;
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
     * Set building
     *
     * @param \Pennsouth\MdsBundle\Entity\PennsouthBldg $building
     *
     * @return PennsouthApt
     */
    public function setBuilding(\Pennsouth\MdsBundle\Entity\PennsouthBldg $building = null)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return \Pennsouth\MdsBundle\Entity\PennsouthBldg
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set bedroomCount
     *
     * @param \Pennsouth\MdsBundle\Entity\AptSize $bedroomCount
     *
     * @return PennsouthApt
     */
    public function setBedroomCount(\Pennsouth\MdsBundle\Entity\AptSize $bedroomCount = null)
    {
        $this->bedroomCount = $bedroomCount;

        return $this;
    }

    /**
     * Get bedroomCount
     *
     * @return \Pennsouth\MdsBundle\Entity\AptSize
     */
    public function getBedroomCount()
    {
        return $this->bedroomCount;
    }

    /**
     * Set aptAvailabilityCode
     *
     * @param \Pennsouth\MdsBundle\Entity\AptAvailabilityStatus $aptAvailabilityCode
     *
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
}
