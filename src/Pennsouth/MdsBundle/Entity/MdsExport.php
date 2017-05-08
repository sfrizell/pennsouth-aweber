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
    private $categoryInterpreted;


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
     * @var \DateTime
     */
    private $dateOfBirth;

    /**
     * @var string
     */
    private $decalNum;

    /**
     * @var \DateTime
     */
    private $vehicleRegExpDate;

    /**
     * @var \DateTime
     */
    private $homeownerInsuranceExpDate;

    /**
     * @var string
     */
    private $storageLockerClosetBldgNum;

    /**
     * @var string
     */
    private $storageLockerNum;

    /**
     * @var integer
     */
    private $storageClosetFloorNum;

    /**
     * @var string
     */
    private $dogTagNum;

    /**
     * @var string
     */
    private $bikeRackLocation;

    /**
     * @var string
     */
    private $bikeRackBldg;

    /**
     * @var string
     */
    private $bikeRackRoom;


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
     * @var string
     */
    private $toddlerRoomMember;

    /**
     * @var string
     */
    private $shareholderFlag;

    /**
      * @var \DateTime
      */
     private $incAffidavitReceiptDate;

    /**
     * @var string
     */
    private $incAffidavitReceived;

    /**
     * @var string
     */
    private $incAffidavitDateDiscrepancy;

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
     * @var string
     */
    private $aptSurrendered;

    /**
     * @var \DateTime
     */
    private $lastChangedDate;

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
     * @return string
     */
    public function getCategoryInterpreted()
    {
        return $this->categoryInterpreted;
    }

    /**
     * @param string $categoryInterpreted
     */
    public function setCategoryInterpreted($categoryInterpreted)
    {
        $this->categoryInterpreted = $categoryInterpreted;
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
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return MdsExport
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set decalNum
     *
     * @param string $decalNum
     *
     * @return MdsExport
     */
    public function setDecalNum($decalNum)
    {
        $this->decalNum = $decalNum;

        return $this;
    }

    /**
     * Get decalNum
     *
     * @return string
     */
    public function getDecalNum()
    {
        return $this->decalNum;
    }

    /**
     * Set vehicleRegExpDate
     *
     * @param \DateTime $vehicleRegExpDate
     *
     * @return MdsExport
     */
    public function setVehicleRegExpDate($vehicleRegExpDate)
    {
        $this->vehicleRegExpDate = $vehicleRegExpDate;

        return $this;
    }

    /**
     * Get vehicleRegExpDate
     *
     * @return \DateTime
     */
    public function getVehicleRegExpDate()
    {
        return $this->vehicleRegExpDate;
    }

    /**
     * Set homeownerInsuranceExpDate
     *
     * @param \DateTime $homeownerInsuranceExpDate
     *
     * @return MdsExport
     */
    public function setHomeownerInsuranceExpDate($homeownerInsuranceExpDate)
    {
        $this->homeownerInsuranceExpDate = $homeownerInsuranceExpDate;

        return $this;
    }

    /**
     * Get homeownerInsuranceExpDate
     *
     * @return \DateTime
     */
    public function getHomeownerInsuranceExpDate()
    {
        return $this->homeownerInsuranceExpDate;
    }

    /**
     * Set storageLockerClosetBldgNum
     *
     * @param string $storageLockerClosetBldgNum
     *
     * @return MdsExport
     */
    public function setStorageLockerClosetBldgNum($storageLockerClosetBldgNum)
    {
        $this->storageLockerClosetBldgNum = $storageLockerClosetBldgNum;

        return $this;
    }

    /**
     * Get storageLockerClosetBldgNum
     *
     * @return string
     */
    public function getStorageLockerClosetBldgNum()
    {
        return $this->storageLockerClosetBldgNum;
    }

    /**
     * Set storageLockerNum
     *
     * @param string $storageLockerNum
     *
     * @return MdsExport
     */
    public function setStorageLockerNum($storageLockerNum)
    {
        $this->storageLockerNum = $storageLockerNum;

        return $this;
    }

    /**
     * Get storageLockerNum
     *
     * @return string
     */
    public function getStorageLockerNum()
    {
        return $this->storageLockerNum;
    }

    /**
     * Set storageClosetFloorNum
     *
     * @param integer $storageClosetFloorNum
     *
     * @return MdsExport
     */
    public function setStorageClosetFloorNum($storageClosetFloorNum)
    {
        $this->storageClosetFloorNum = $storageClosetFloorNum;

        return $this;
    }

    /**
     * Get storageClosetFloorNum
     *
     * @return integer
     */
    public function getStorageClosetFloorNum()
    {
        return $this->storageClosetFloorNum;
    }

    /**
     * Set dogTagNum
     *
     * @param string $dogTagNum
     *
     * @return MdsExport
     */
    public function setDogTagNum($dogTagNum)
    {
        $this->dogTagNum = $dogTagNum;

        return $this;
    }

    /**
     * Get dogTagNum
     *
     * @return string
     */
    public function getDogTagNum()
    {
        return $this->dogTagNum;
    }

    /**
     * Set bikeRackLocation
     *
     * @param string $bikeRackLocation
     *
     * @return MdsExport
     */
    public function setBikeRackLocation($bikeRackLocation)
    {
        $this->bikeRackLocation = $bikeRackLocation;

        return $this;
    }

    /**
     * Get bikeRackLocation
     *
     * @return string
     */
    public function getBikeRackLocation()
    {
        return $this->bikeRackLocation;
    }

    /**
     * Set bikeRackBldg
     *
     * @param string $bikeRackBldg
     *
     * @return MdsExport
     */
    public function setBikeRackBldg($bikeRackBldg)
    {
        $this->bikeRackBldg = $bikeRackBldg;

        return $this;
    }

    /**
     * Get bikeRackBldg
     *
     * @return string
     */
    public function getBikeRackBldg()
    {
        return $this->bikeRackBldg;
    }

    /**
     * Set bikeRackRoom
     *
     * @param string $bikeRackRoom
     *
     * @return MdsExport
     */
    public function setBikeRackRoom($bikeRackRoom)
    {
        $this->bikeRackRoom = $bikeRackRoom;

        return $this;
    }

    /**
     * Get bikeRackRoom
     *
     * @return string
     */
    public function getBikeRackRoom()
    {
        return $this->bikeRackRoom;
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
     * @return string
     */
    public function getShareholderFlag()
    {
        return $this->shareholderFlag;
    }

    /**
     * @param string $shareholderFlag
     */
    public function setShareholderFlag($shareholderFlag)
    {
        $this->shareholderFlag = $shareholderFlag;
    }

    /**
     * @return \DateTime
     */
    public function getIncAffidavitReceiptDate()
    {
        return $this->incAffidavitReceiptDate;
    }

    /**
     * @param \DateTime $incAffidavitReceiptDate
     */
    public function setIncAffidavitReceiptDate($incAffidavitReceiptDate)
    {
        $this->incAffidavitReceiptDate = $incAffidavitReceiptDate;
    }

    /**
     * @return string
     */
    public function getIncAffidavitReceived()
    {
        return $this->incAffidavitReceived;
    }

    /**
     * @param string $incAffidavitReceived
     */
    public function setIncAffidavitReceived($incAffidavitReceived)
    {
        $this->incAffidavitReceived = $incAffidavitReceived;
    }

    /**
     * @return string
     */
    public function getIncAffidavitDateDiscrepancy()
    {
        return $this->incAffidavitDateDiscrepancy;
    }

    /**
     * @param string $incAffidavitDateDiscrepancy
     */
    public function setIncAffidavitDateDiscrepancy($incAffidavitDateDiscrepancy)
    {
        $this->incAffidavitDateDiscrepancy = $incAffidavitDateDiscrepancy;
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
     * @return string
     */
    public function getAptSurrendered()
    {
        return $this->aptSurrendered;
    }

    /**
     * @param string $aptSurrendered
     */
    public function setAptSurrendered($aptSurrendered)
    {
        $this->aptSurrendered = $aptSurrendered;
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
     * Get mdsExportId
     *
     * @return integer
     */
    public function getMdsExportId()
    {
        return $this->mdsExportId;
    }
}
