<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * MdsExport
 */
class MdsExport
{
    /**
     * @var string
     */
    private $building;

    /**
     * @var string
     */
    private $mdsApt;

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
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $category;

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
    private $tenantId;

    /**
     * @var string
     */
    private $personId;

    /**
     * @var string
     */
    private $officePhone;

    /**
     * @var string
     */
    private $statusCodes;

    /**
     * @var string
     */
    private $standardLockboxTenantId;

    /**
     * @var \DateTime
     */
    private $moveInDate;

    /**
     * @var \DateTime
     */
    private $lastChangedDate;

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
    private $gardenMember;

    /**
     * @var string
     */
    private $woodworkingMember;

    /**
     * @var string
     */
    private $gymMember;

    /**
     * @var integer
     */
    private $mdsExportId;


    /**
     * Set building
     *
     * @param string $building
     *
     * @return MdsExport
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
     * Set mdsApt
     *
     * @param string $mdsApt
     *
     * @return MdsExport
     */
    public function setMdsApt($mdsApt)
    {
        $this->mdsApt = $mdsApt;

        return $this;
    }

    /**
     * Get mdsApt
     *
     * @return string
     */
    public function getMdsApt()
    {
        return $this->mdsApt;
    }

    /**
     * Set floorNumber
     *
     * @param integer $floorNumber
     *
     * @return MdsExport
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
     * @return MdsExport
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return MdsExport
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return MdsExport
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
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return MdsExport
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
     * Set category
     *
     * @param string $category
     *
     * @return MdsExport
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set daytimePhone
     *
     * @param string $daytimePhone
     *
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * Set tenantId
     *
     * @param string $tenantId
     *
     * @return MdsExport
     */
    public function setTenantId($tenantId)
    {
        $this->tenantId = $tenantId;

        return $this;
    }

    /**
     * Get tenantId
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * Set personId
     *
     * @param string $personId
     *
     * @return MdsExport
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
     * Set officePhone
     *
     * @param string $officePhone
     *
     * @return MdsExport
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
     * Set statusCodes
     *
     * @param string $statusCodes
     *
     * @return MdsExport
     */
    public function setStatusCodes($statusCodes)
    {
        $this->statusCodes = $statusCodes;

        return $this;
    }

    /**
     * Get statusCodes
     *
     * @return string
     */
    public function getStatusCodes()
    {
        return $this->statusCodes;
    }

    /**
     * Set standardLockboxTenantId
     *
     * @param string $standardLockboxTenantId
     *
     * @return MdsExport
     */
    public function setStandardLockboxTenantId($standardLockboxTenantId)
    {
        $this->standardLockboxTenantId = $standardLockboxTenantId;

        return $this;
    }

    /**
     * Get standardLockboxTenantId
     *
     * @return string
     */
    public function getStandardLockboxTenantId()
    {
        return $this->standardLockboxTenantId;
    }

    /**
     * Set moveInDate
     *
     * @param \DateTime $moveInDate
     *
     * @return MdsExport
     */
    public function setMoveInDate($moveInDate)
    {
        $this->moveInDate = $moveInDate;

        return $this;
    }

    /**
     * Get moveInDate
     *
     * @return \DateTime
     */
    public function getMoveInDate()
    {
        return $this->moveInDate;
    }

    /**
     * Set lastChangedDate
     *
     * @param \DateTime $lastChangedDate
     *
     * @return MdsExport
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
     * Set lockerStorage
     *
     * @param string $lockerStorage
     *
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * @return MdsExport
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
     * Set gardenMember
     *
     * @param string $gardenMember
     *
     * @return MdsExport
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
     * Set woodworkingMember
     *
     * @param string $woodworkingMember
     *
     * @return MdsExport
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
     * @return MdsExport
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
     * Get mdsExportId
     *
     * @return integer
     */
    public function getMdsExportId()
    {
        return $this->mdsExportId;
    }
}

