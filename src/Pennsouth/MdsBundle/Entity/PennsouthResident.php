<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * PennsouthResident
 */
class PennsouthResident
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
    private $lastName;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $mdsResidentCategory;

    /**
     * @var string
     */
    private $daytimePhone;

    /**
     * @var string
     */
    private $eveningPhone;

    /**
     * @var string
     */
    private $cellPhone;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var string
     */
    private $officePhone;

    /**
     * @var string
     */
    private $personId;

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
     * @var string
     */
    private $gardenMember;

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
    private $utilityCloset;

    /**
     * @var string
     */
    private $lockerStorage;

    /**
     * @var \DateTime
     */
    private $lastChangedDate;

    /**
     * @var integer
     */
    private $pennsouthResidentId;

    /**
     * @var \Pennsouth\MdsBundle\Entity\PennsouthApt
     */
    private $pennsouthAptApartment;


    /**
     * Set building
     *
     * @param string $building
     *
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return PennsouthResident
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return PennsouthResident
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return PennsouthResident
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set mdsResidentCategory
     *
     * @param string $mdsResidentCategory
     *
     * @return PennsouthResident
     */
    public function setMdsResidentCategory($mdsResidentCategory)
    {
        $this->mdsResidentCategory = $mdsResidentCategory;

        return $this;
    }

    /**
     * Get mdsResidentCategory
     *
     * @return string
     */
    public function getMdsResidentCategory()
    {
        return $this->mdsResidentCategory;
    }

    /**
     * Set daytimePhone
     *
     * @param string $daytimePhone
     *
     * @return PennsouthResident
     */
    public function setDaytimePhone($daytimePhone)
    {
        $this->daytimePhone = $daytimePhone;

        return $this;
    }

    /**
     * Get daytimePhone
     *
     * @return string
     */
    public function getDaytimePhone()
    {
        return $this->daytimePhone;
    }

    /**
     * Set eveningPhone
     *
     * @param string $eveningPhone
     *
     * @return PennsouthResident
     */
    public function setEveningPhone($eveningPhone)
    {
        $this->eveningPhone = $eveningPhone;

        return $this;
    }

    /**
     * Get eveningPhone
     *
     * @return string
     */
    public function getEveningPhone()
    {
        return $this->eveningPhone;
    }

    /**
     * Set cellPhone
     *
     * @param string $cellPhone
     *
     * @return PennsouthResident
     */
    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    /**
     * Get cellPhone
     *
     * @return string
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return PennsouthResident
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set officePhone
     *
     * @param string $officePhone
     *
     * @return PennsouthResident
     */
    public function setOfficePhone($officePhone)
    {
        $this->officePhone = $officePhone;

        return $this;
    }

    /**
     * Get officePhone
     *
     * @return string
     */
    public function getOfficePhone()
    {
        return $this->officePhone;
    }

    /**
     * Set personId
     *
     * @param string $personId
     *
     * @return PennsouthResident
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;

        return $this;
    }

    /**
     * Get personId
     *
     * @return string
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * Set windowGuardInstalled
     *
     * @param string $windowGuardInstalled
     *
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * Set toddlerRoomMember
     *
     * @param string $toddlerRoomMember
     *
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * Set gardenMember
     *
     * @param string $gardenMember
     *
     * @return PennsouthResident
     */
    public function setGardenMember($gardenMember)
    {
        $this->gardenMember = $gardenMember;

        return $this;
    }

    /**
     * Get gardenMember
     *
     * @return string
     */
    public function getGardenMember()
    {
        return $this->gardenMember;
    }

    /**
     * Set smallCloset
     *
     * @param string $smallCloset
     *
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * Set utilityCloset
     *
     * @param string $utilityCloset
     *
     * @return PennsouthResident
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
     * Set lockerStorage
     *
     * @param string $lockerStorage
     *
     * @return PennsouthResident
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
     * Set lastChangedDate
     *
     * @param \DateTime $lastChangedDate
     *
     * @return PennsouthResident
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
     * Get pennsouthResidentId
     *
     * @return integer
     */
    public function getPennsouthResidentId()
    {
        return $this->pennsouthResidentId;
    }

    /**
     * Set pennsouthAptApartment
     *
     * @param \Pennsouth\MdsBundle\Entity\PennsouthApt $pennsouthAptApartment
     *
     * @return PennsouthResident
     */
    public function setPennsouthAptApartment(\Pennsouth\MdsBundle\Entity\PennsouthApt $pennsouthAptApartment = null)
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
