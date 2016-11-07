<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * AptResidentAttributes
 */
class AptResidentAttributes
{
    /**
     * @var string
     */
    private $building;

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
    private $lockerStorage;

    /**
     * @var string
     */
    private $utilityCloset;

    /**
     * @var string
     */
    private $smallCloset;

    /**
     * @var string
     */
    private $parking;

    /**
     * @var string
     */
    private $windowGuardInstalled;

    /**
     * @var string
     */
    private $dogAllowed;

    /**
     * @var string
     */
    private $loanCreditUnion;

    /**
     * @var string
     */
    private $toddlerRoomMember;

    /**
     * @var string
     */
    private $youthRoomMember;

    /**
     * @var string
     */
    private $ceramicsMember;

    /**
     * @var string
     */
    private $woodworkingMember;

    /**
     * @var string
     */
    private $gymMember;

    /**
     * @var \DateTime
     */
    private $lastChangedDate;

    /**
     * @var \Pennsouth\MdsBundle\Entity\PennsouthApt
     */
    private $pennsouthAptApartment;


    /**
     * Set building
     *
     * @param string $building
     *
     * @return AptResidentAttributes
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set floorNumber
     *
     * @param integer $floorNumber
     *
     * @return AptResidentAttributes
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
     * @return AptResidentAttributes
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
     * Set lockerStorage
     *
     * @param string $lockerStorage
     *
     * @return AptResidentAttributes
     */
    public function setLockerStorage($lockerStorage)
    {
        $this->lockerStorage = $lockerStorage;

        return $this;
    }

    /**
     * Get lockerStorage
     *
     * @return string
     */
    public function getLockerStorage()
    {
        return $this->lockerStorage;
    }

    /**
     * Set utilityCloset
     *
     * @param string $utilityCloset
     *
     * @return AptResidentAttributes
     */
    public function setUtilityCloset($utilityCloset)
    {
        $this->utilityCloset = $utilityCloset;

        return $this;
    }

    /**
     * Get utilityCloset
     *
     * @return string
     */
    public function getUtilityCloset()
    {
        return $this->utilityCloset;
    }

    /**
     * Set smallCloset
     *
     * @param string $smallCloset
     *
     * @return AptResidentAttributes
     */
    public function setSmallCloset($smallCloset)
    {
        $this->smallCloset = $smallCloset;

        return $this;
    }

    /**
     * Get smallCloset
     *
     * @return string
     */
    public function getSmallCloset()
    {
        return $this->smallCloset;
    }

    /**
     * Set parking
     *
     * @param string $parking
     *
     * @return AptResidentAttributes
     */
    public function setParking($parking)
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * Get parking
     *
     * @return string
     */
    public function getParking()
    {
        return $this->parking;
    }

    /**
     * Set windowGuardInstalled
     *
     * @param string $windowGuardInstalled
     *
     * @return AptResidentAttributes
     */
    public function setWindowGuardInstalled($windowGuardInstalled)
    {
        $this->windowGuardInstalled = $windowGuardInstalled;

        return $this;
    }

    /**
     * Get windowGuardInstalled
     *
     * @return string
     */
    public function getWindowGuardInstalled()
    {
        return $this->windowGuardInstalled;
    }

    /**
     * Set dogAllowed
     *
     * @param string $dogAllowed
     *
     * @return AptResidentAttributes
     */
    public function setDogAllowed($dogAllowed)
    {
        $this->dogAllowed = $dogAllowed;

        return $this;
    }

    /**
     * Get dogAllowed
     *
     * @return string
     */
    public function getDogAllowed()
    {
        return $this->dogAllowed;
    }

    /**
     * Set loanCreditUnion
     *
     * @param string $loanCreditUnion
     *
     * @return AptResidentAttributes
     */
    public function setLoanCreditUnion($loanCreditUnion)
    {
        $this->loanCreditUnion = $loanCreditUnion;

        return $this;
    }

    /**
     * Get loanCreditUnion
     *
     * @return string
     */
    public function getLoanCreditUnion()
    {
        return $this->loanCreditUnion;
    }

    /**
     * Set toddlerRoomMember
     *
     * @param string $toddlerRoomMember
     *
     * @return AptResidentAttributes
     */
    public function setToddlerRoomMember($toddlerRoomMember)
    {
        $this->toddlerRoomMember = $toddlerRoomMember;

        return $this;
    }

    /**
     * Get toddlerRoomMember
     *
     * @return string
     */
    public function getToddlerRoomMember()
    {
        return $this->toddlerRoomMember;
    }

    /**
     * Set youthRoomMember
     *
     * @param string $youthRoomMember
     *
     * @return AptResidentAttributes
     */
    public function setYouthRoomMember($youthRoomMember)
    {
        $this->youthRoomMember = $youthRoomMember;

        return $this;
    }

    /**
     * Get youthRoomMember
     *
     * @return string
     */
    public function getYouthRoomMember()
    {
        return $this->youthRoomMember;
    }

    /**
     * Set ceramicsMember
     *
     * @param string $ceramicsMember
     *
     * @return AptResidentAttributes
     */
    public function setCeramicsMember($ceramicsMember)
    {
        $this->ceramicsMember = $ceramicsMember;

        return $this;
    }

    /**
     * Get ceramicsMember
     *
     * @return string
     */
    public function getCeramicsMember()
    {
        return $this->ceramicsMember;
    }

    /**
     * Set woodworkingMember
     *
     * @param string $woodworkingMember
     *
     * @return AptResidentAttributes
     */
    public function setWoodworkingMember($woodworkingMember)
    {
        $this->woodworkingMember = $woodworkingMember;

        return $this;
    }

    /**
     * Get woodworkingMember
     *
     * @return string
     */
    public function getWoodworkingMember()
    {
        return $this->woodworkingMember;
    }

    /**
     * Set gymMember
     *
     * @param string $gymMember
     *
     * @return AptResidentAttributes
     */
    public function setGymMember($gymMember)
    {
        $this->gymMember = $gymMember;

        return $this;
    }

    /**
     * Get gymMember
     *
     * @return string
     */
    public function getGymMember()
    {
        return $this->gymMember;
    }

    /**
     * Set lastChangedDate
     *
     * @param \DateTime $lastChangedDate
     *
     * @return AptResidentAttributes
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
     * Set pennsouthAptApartment
     *
     * @param \Pennsouth\MdsBundle\Entity\PennsouthApt $pennsouthAptApartment
     *
     * @return AptResidentAttributes
     */
    public function setPennsouthAptApartment(\Pennsouth\MdsBundle\Entity\PennsouthApt $pennsouthAptApartment)
    {
        $this->pennsouthAptApartment = $pennsouthAptApartment;

        return $this;
    }

    /**
     * Get pennsouthAptApartment
     *
     * @return \Pennsouth\MdsBundle\Entity\PennsouthApt
     */
    public function getPennsouthAptApartment()
    {
        return $this->pennsouthAptApartment;
    }
}
