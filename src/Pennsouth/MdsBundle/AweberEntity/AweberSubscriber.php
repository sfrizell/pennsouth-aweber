<?php

namespace Pennsouth\MdsBundle\AweberEntity;
/**
 * AweberSubscriber.php
 * User: sfrizell
 * Date: 9/29/16
 *  Function:
 */
class AweberSubscriber
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $pennSouthBuilding;

    /**
     * @var integer
     */
    private $floorNumber;

    /**
     * @var string
     */
    private $apartment;

    /**
     * @var string
     */
    private $name;

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
    private $subscriptionMethod;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string - Date/Time
     */
    private $unsubscribedAt;

    /**
     * @var string - Date/Time
     */
    private $subscribedAt;

    /**
     * @var array
     */
    private $customFields = array();

    /**
     * @var string
     */
    private $residentCategory;

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
    private $parkingLotLocation;

    /**
     * @var integer
     */
    private $vehicleRegExpDaysLeft;

    /**
     * @var integer
     */
    private $homeownerInsExpDateLeft;

    /**
     * @var string
     */
    private $isDogInApt;

    /**
     * @var string
     */
    private $storageLockerClosetBldg;

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
    private $bikeRackBldg;

    /**
     * @var string
     */
    private $bikeRackRoom;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPennSouthBuilding()
    {
        return $this->pennSouthBuilding;
    }

    /**
     * @param string $pennSouthBuilding
     */
    public function setPennSouthBuilding($pennSouthBuilding)
    {
        $this->pennSouthBuilding = $pennSouthBuilding;
    }

    /**
     * @return int
     */
    public function getFloorNumber()
    {
        return $this->floorNumber;
    }

    /**
     * @param int $floorNumber
     */
    public function setFloorNumber($floorNumber)
    {
        $this->floorNumber = $floorNumber;
    }

    /**
     * @return string
     */
    public function getApartment()
    {
        return $this->apartment;
    }

    /**
     * @param string $apartment
     */
    public function setApartment($apartment)
    {
        $this->apartment = $apartment;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getSubscriptionMethod()
    {
        return $this->subscriptionMethod;
    }

    /**
     * @param string $subscriptionMethod
     */
    public function setSubscriptionMethod($subscriptionMethod)
    {
        $this->subscriptionMethod = $subscriptionMethod;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getUnsubscribedAt()
    {
        return $this->unsubscribedAt;
    }

    /**
     * @param string $unsubscribedAt
     */
    public function setUnsubscribedAt($unsubscribedAt)
    {
        $this->unsubscribedAt = $unsubscribedAt;
    }

    /**
     * @return string
     */
    public function getSubscribedAt()
    {
        return $this->subscribedAt;
    }

    /**
     * @param string $subscribedAt
     */
    public function setSubscribedAt($subscribedAt)
    {
        $this->subscribedAt = $subscribedAt;
    }

    /**
     * @return array
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @param array $customFields
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
    }

    /**
     * @return string
     */
    public function getResidentCategory()
    {
        return $this->residentCategory;
    }

    /**
     * @param string $residentCategory
     */
    public function setResidentCategory($residentCategory)
    {
        $this->residentCategory = $residentCategory;
    }

    /**
     * @return string
     */
    public function getToddlerRoomMember()
    {
        return $this->toddlerRoomMember;
    }

    /**
     * @param string $toddlerRoomMember
     */
    public function setToddlerRoomMember($toddlerRoomMember)
    {
        $this->toddlerRoomMember = $toddlerRoomMember;
    }

    /**
     * @return string
     */
    public function getYouthRoomMember()
    {
        return $this->youthRoomMember;
    }

    /**
     * @param string $youthRoomMember
     */
    public function setYouthRoomMember($youthRoomMember)
    {
        $this->youthRoomMember = $youthRoomMember;
    }

    /**
     * @return string
     */
    public function getCeramicsMember()
    {
        return $this->ceramicsMember;
    }

    /**
     * @param string $ceramicsMember
     */
    public function setCeramicsMember($ceramicsMember)
    {
        $this->ceramicsMember = $ceramicsMember;
    }

    /**
     * @return string
     */
    public function getWoodworkingMember()
    {
        return $this->woodworkingMember;
    }

    /**
     * @param string $woodworkingMember
     */
    public function setWoodworkingMember($woodworkingMember)
    {
        $this->woodworkingMember = $woodworkingMember;
    }

    /**
     * @return string
     */
    public function getGymMember()
    {
        return $this->gymMember;
    }

    /**
     * @param string $gymMember
     */
    public function setGymMember($gymMember)
    {
        $this->gymMember = $gymMember;
    }

    /**
     * @return string
     */
    public function getGardenMember()
    {
        return $this->gardenMember;
    }

    /**
     * @param string $gardenMember
     */
    public function setGardenMember($gardenMember)
    {
        $this->gardenMember = $gardenMember;
    }

    /**
     * @return string
     */
    public function getParkingLotLocation()
    {
        return $this->parkingLotLocation;
    }

    /**
     * @param string $parkingLotLocation
     */
    public function setParkingLotLocation($parkingLotLocation)
    {
        $this->parkingLotLocation = $parkingLotLocation;
    }

    /**
     * @return int
     */
    public function getVehicleRegExpDaysLeft()
    {
        return $this->vehicleRegExpDaysLeft;
    }

    /**
     * @param int $vehicleRegExpDaysLeft
     */
    public function setVehicleRegExpDaysLeft($vehicleRegExpDaysLeft)
    {
        $this->vehicleRegExpDaysLeft = $vehicleRegExpDaysLeft;
    }

    /**
     * @return int
     */
    public function getHomeownerInsExpDateLeft()
    {
        return $this->homeownerInsExpDateLeft;
    }

    /**
     * @param int $homeownerInsExpDateLeft
     */
    public function setHomeownerInsExpDateLeft($homeownerInsExpDateLeft)
    {
        $this->homeownerInsExpDateLeft = $homeownerInsExpDateLeft;
    }

    /**
     * @return string
     */
    public function getIsDogInApt()
    {
        return $this->isDogInApt;
    }

    /**
     * @param string $isDogInApt
     */
    public function setIsDogInApt($isDogInApt)
    {
        $this->isDogInApt = $isDogInApt;
    }

    /**
     * @return mixed
     */
    public function getStorageLockerClosetBldg()
    {
        return $this->storageLockerClosetBldg;
    }

    /**
     * @param mixed $storageLockerClosetBldg
     */
    public function setStorageLockerClosetBldg($storageLockerClosetBldg)
    {
        $this->storageLockerClosetBldg = $storageLockerClosetBldg;
    }

    /**
     * @return mixed
     */
    public function getStorageLockerNum()
    {
        return $this->storageLockerNum;
    }

    /**
     * @param mixed $storageLockerNum
     */
    public function setStorageLockerNum($storageLockerNum)
    {
        $this->storageLockerNum = $storageLockerNum;
    }

    /**
     * @return mixed
     */
    public function getStorageClosetFloorNum()
    {
        return $this->storageClosetFloorNum;
    }

    /**
     * @param mixed $storageClosetFloorNum
     */
    public function setStorageClosetFloorNum($storageClosetFloorNum)
    {
        $this->storageClosetFloorNum = $storageClosetFloorNum;
    }

    /**
     * @return mixed
     */
    public function getBikeRackBldg()
    {
        return $this->bikeRackBldg;
    }

    /**
     * @param mixed $bikeRackBldg
     */
    public function setBikeRackBldg($bikeRackBldg)
    {
        $this->bikeRackBldg = $bikeRackBldg;
    }

    /**
     * @return mixed
     */
    public function getBikeRackRoom()
    {
        return $this->bikeRackRoom;
    }

    /**
     * @param mixed $bikeRackRoom
     */
    public function setBikeRackRoom($bikeRackRoom)
    {
        $this->bikeRackRoom = $bikeRackRoom;
    }




}