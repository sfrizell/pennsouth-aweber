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
    private $personId;

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
     * @var integer
     */
    private $decalNum;

    /**
     * @var string
     */
    private $parkingLotLocation;

    /**
     * @var \DateTime
     */
    private $vehicleRegExpDate;

    /**
     * @var integer
     */
    private $vehicleRegExpCountdown;

    /**
     * @var integer
     */
    private $vehicleRegIntervalRemaining;


    /**
     * @var string
     */
    private $vehicleModel;

    /**
     * @var string
     */
    private $vehicleLicensePlateNum;

    /**
     * @var \DateTime
     */
    private $homeownerInsExpDate;

    /**
     * @var integer
     */
    private $homeownerInsExpCountdown;

    /**
     * @var integer
     */
    private $homeownerInsIntervalRemaining;

    /**
     * @var \DateTime
     */
    private $birthDate;

    /**
     * @var \DateTime
     */
    private $moveInDate;

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
    private $storageLockerClosetBldgNum;

    /**
     * @var string
     */
    private $storageLockerNum;

    /**
     * @var string
     */
    private $storageClosetFloorNum;

    /**
     * @var string
     */
    private $dogTagNum;

    /**
     * @var string
     */
    private $isDogInApt;

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
    private $aptSurrendered;


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
     * Set decalNum
     *
     * @param integer $decalNum
     *
     * @return PennsouthResident
     */
    public function setDecalNum($decalNum)
    {
        $this->decalNum = $decalNum;

        return $this;
    }

    /**
     * Get decalNum
     *
     * @return integer
     */
    public function getDecalNum()
    {
        return $this->decalNum;
    }

    /**
     * Set parkingLotLocation
     *
     * @param string $parkingLotLocation
     *
     * @return PennsouthResident
     */
    public function setParkingLotLocation($parkingLotLocation)
    {
        $this->parkingLotLocation = $parkingLotLocation;

        return $this;
    }

    /**
     * Get parkingLotLocation
     *
     * @return string
     */
    public function getParkingLotLocation()
    {
        return $this->parkingLotLocation;
    }

    /**
     * Set vehicleRegExpDate
     *
     * @param \DateTime $vehicleRegExpDate
     *
     * @return PennsouthResident
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
     * @return int
     */
    public function getVehicleRegExpCountdown()
    {
        return $this->vehicleRegExpCountdown;
    }

    /**
     * @param int $vehicleRegExpCountdown
     */
    public function setVehicleRegExpCountdown($vehicleRegExpCountdown)
    {
        $this->vehicleRegExpCountdown = $vehicleRegExpCountdown;

        return $this;
    }



    /**
     * Set vehicleRegIntervalRemaining
     *
     * @param integer $vehicleRegIntervalRemaining
     *
     * @return PennsouthResident
     */
    public function setVehicleRegIntervalRemaining($vehicleRegIntervalRemaining)
    {
        $this->vehicleRegIntervalRemaining = $vehicleRegIntervalRemaining;

        return $this;
    }

    /**
     * Get vehicleRegIntervalRemaining
     *
     * @return integer
     */
    public function getVehicleRegIntervalRemaining()
    {
        return $this->vehicleRegIntervalRemaining;
    }



    /**
     * @return string
     */
    public function getVehicleModel()
    {
        return $this->vehicleModel;
    }

    /**
     * @param string $vehicleModel
     */
    public function setVehicleModel($vehicleModel)
    {
        $this->vehicleModel = $vehicleModel;

        return $this;
    }

    /**
     * @return string
     */
    public function getVehicleLicensePlateNum()
    {
        return $this->vehicleLicensePlateNum;
    }

    /**
     * @param string $vehicleLicensePlateNum
     */
    public function setVehicleLicensePlateNum($vehicleLicensePlateNum)
    {
        $this->vehicleLicensePlateNum = $vehicleLicensePlateNum;

        return $this;
    }



    /**
     * Set homeownerInsExpDate
     *
     * @param \DateTime $homeownerInsExpDate
     *
     * @return PennsouthResident
     */
    public function setHomeownerInsExpDate($homeownerInsExpDate)
    {
        $this->homeownerInsExpDate = $homeownerInsExpDate;

        return $this;
    }

    /**
     * Get homeownerInsExpDate
     *
     * @return \DateTime
     */
    public function getHomeownerInsExpDate()
    {
        return $this->homeownerInsExpDate;
    }

    /**
     * @return int
     */
    public function getHomeownerInsExpCountdown()
    {
        return $this->homeownerInsExpCountdown;
    }

    /**
     * @param int $homeownerInsExpCountdown
     */
    public function setHomeownerInsExpCountdown($homeownerInsExpCountdown)
    {
        $this->homeownerInsExpCountdown = $homeownerInsExpCountdown;

        return $this;
    }



    /**
     * Set homeownerInsIntervalRemaining
     *
     * @param integer $homeownerInsIntervalRemaining
     *
     * @return PennsouthResident
     */
    public function setHomeownerInsIntervalRemaining($homeownerInsIntervalRemaining)
    {
        $this->homeownerInsIntervalRemaining = $homeownerInsIntervalRemaining;

        return $this;
    }

    /**
     * Get homeownerInsIntervalRemaining
     *
     * @return integer
     */
    public function getHomeownerInsIntervalRemaining()
    {
        return $this->homeownerInsIntervalRemaining;
    }



    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return PennsouthResident
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set moveInDate
     *
     * @param \DateTime $moveInDate
     *
     * @return PennsouthResident
     */
    public function setMoveInDate($moveInDate)
    {
        $this->moveInDate = $moveInDate;

        return $this;
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
     * Get moveInDate
     *
     * @return \DateTime
     */
    public function getMoveInDate()
    {
        return $this->moveInDate;
    }

    /**
     * Set storageLockerClosetBldgNum
     *
     * @param string $storageLockerClosetBldgNum
     *
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * @param string $storageClosetFloorNum
     *
     * @return PennsouthResident
     */
    public function setStorageClosetFloorNum($storageClosetFloorNum)
    {
        $this->storageClosetFloorNum = $storageClosetFloorNum;

        return $this;
    }

    /**
     * Get storageClosetFloorNum
     *
     * @return string
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
     * @return PennsouthResident
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
     * Set isDogInApt
     *
     * @param string $isDogInApt
     *
     * @return PennsouthResident
     */
    public function setIsDogInApt($isDogInApt)
    {
        $this->isDogInApt = $isDogInApt;

        return $this;
    }

    /**
     * Get isDogInApt
     *
     * @return string
     */
    public function getIsDogInApt()
    {
        return $this->isDogInApt;
    }

    /**
     * Set bikeRackLocation
     *
     * @param string $bikeRackLocation
     *
     * @return PennsouthResident
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
     * @return PennsouthResident
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
     * @return PennsouthResident
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
