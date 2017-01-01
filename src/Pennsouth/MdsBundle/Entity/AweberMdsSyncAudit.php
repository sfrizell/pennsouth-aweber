<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * AweberMdsSyncAudit
 */
class AweberMdsSyncAudit
{
    /**
     * @var string
     */
    public $aweberSubscriberListName;

    /**
     * @var string
     */
    public $subscriberEmailAddress;

    /**
     * @var string
     */
    public $updateAction;

    /**
     * @var string
     */
    public $mdsBuilding;

    /**
     * @var integer
     */
    public $mdsFloorNumber;

    /**
     * @var string
     */
    public $mdsAptLine;

    /**
     * @var string
     */
    public $mdsResidentFirstName;

    /**
     * @var string
     */
    public $mdsResidentLastName;

    /**
     * @var string
     */
    public $aweberBuilding;

    /**
     * @var integer
     */
    public $aweberFloorNumber;

    /**
     * @var string
     */
    public $aweberAptLine;

    /**
     * @var string
     */
    public $aweberSubscriberName;

    /**
     * @var string
     */
    public $actionReason;

    /**
     * @var string
     */
    public $aweberSubscriberStatus;

    /**
     * @var \DateTime
     */
    public $aweberSubscribedAt;

    /**
     * @var \DateTime
     */
    public $aweberUnsubscribedAt;

    /**
     * @var string
     */
    public $aweberSubscriptionMethod;

    /**
     * @var string
     */
    public $mdsToddlerRmMember;

    /**
     * @var string
     */
    public $mdsYouthRmMember;

    /**
     * @var string
     */
    public $mdsCeramicsMember;

    /**
     * @var string
     */
    public $mdsWoodworkingMember;

    /**
     * @var string
     */
    public $mdsGymMember;

    /**
     * @var string
     */
    public $mdsGardenMember;

    /**
     * @var string
     */
    public $mdsParkingLotLocation;

    /**
     * @var integer
     */
    public $mdsVehicleRegIntervalRemaining;

    /**
     * @var integer
     */
    public $mdsHomeownerInsIntervalRemaining;

    /**
     * @var string
     */
    public $mdsStorageLkrClBldg;

    /**
     * @var string
     */
    public $mdsStorageLkrNum;

    /**
     * @var string
     */
    public $mdsStorageClFloorNum;

    /**
     * @var string
     */
    public $mdsIsDogInApt;

    /**
     * @var string
     */
    public $mdsBikeRackBldg;

    /**
     * @var string
     */
    public $mdsBikeRackRoom;

    /**
     * @var string
     */
    public $mdsBikeRackLocation;

    /**
     * @var string
     */
    public $mdsResidentCategory;

    /**
     * @var string
     */
    public $aweberToddlerRmMember;

    /**
     * @var string
     */
    public $aweberYouthRmMember;

    /**
     * @var string
     */
    public $aweberCeramicsMember;

    /**
     * @var string
     */
    public $aweberWoodworkingMember;

    /**
     * @var string
     */
    public $aweberGymMember;

    /**
     * @var string
     */
    public $aweberGardenMember;

    /**
     * @var string
     */
    public $aweberParkingLotLocation;

    /**
     * @var integer
     */
    public $aweberVehicleRegIntervalRemaining;

    /**
     * @var integer
     */
    public $aweberHomeownerInsIntervalRemaining;

    /**
     * @var string
     */
    public $aweberStorageLkrClBldg;

    /**
     * @var string
     */
    public $aweberStorageLkrNum;

    /**
     * @var string
     */
    public $aweberStorageClFloorNum;

    /**
     * @var string
     */
    public $aweberIsDogInApt;

    /**
     * @var string
     */
    public $aweberBikeRackBldg;

    /**
     * @var string
     */
    public $aweberBikeRackRoom;

    /**
     * @var string
     */
    public $aweberBikeRackLocation;

    /**
     * @var string
     */
    public $aweberResidentCategory;

    /**
     * @var \DateTime
     */
    public $lastChangedDate;

    /**
     * @var integer
     */
    private $syncAuditId;


    /**
     * Set aweberSubscriberListName
     *
     * @param string $aweberSubscriberListName
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberSubscriberListName($aweberSubscriberListName)
    {
        $this->aweberSubscriberListName = $aweberSubscriberListName;

        return $this;
    }

    /**
     * Get aweberSubscriberListName
     *
     * @return string
     */
    public function getAweberSubscriberListName()
    {
        return $this->aweberSubscriberListName;
    }

    /**
     * Set subscriberEmailAddress
     *
     * @param string $subscriberEmailAddress
     *
     * @return AweberMdsSyncAudit
     */
    public function setSubscriberEmailAddress($subscriberEmailAddress)
    {
        $this->subscriberEmailAddress = $subscriberEmailAddress;

        return $this;
    }

    /**
     * Get subscriberEmailAddress
     *
     * @return string
     */
    public function getSubscriberEmailAddress()
    {
        return $this->subscriberEmailAddress;
    }

    /**
     * Set updateAction
     *
     * @param string $updateAction
     *
     * @return AweberMdsSyncAudit
     */
    public function setUpdateAction($updateAction)
    {
        $this->updateAction = $updateAction;

        return $this;
    }

    /**
     * Get updateAction
     *
     * @return string
     */
    public function getUpdateAction()
    {
        return $this->updateAction;
    }

    /**
     * Set mdsBuilding
     *
     * @param string $mdsBuilding
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsBuilding($mdsBuilding)
    {
        $this->mdsBuilding = $mdsBuilding;

        return $this;
    }

    /**
     * Get mdsBuilding
     *
     * @return string
     */
    public function getMdsBuilding()
    {
        return $this->mdsBuilding;
    }

    /**
     * Set mdsFloorNumber
     *
     * @param integer $mdsFloorNumber
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsFloorNumber($mdsFloorNumber)
    {
        $this->mdsFloorNumber = $mdsFloorNumber;

        return $this;
    }

    /**
     * Get mdsFloorNumber
     *
     * @return integer
     */
    public function getMdsFloorNumber()
    {
        return $this->mdsFloorNumber;
    }

    /**
     * Set mdsAptLine
     *
     * @param string $mdsAptLine
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsAptLine($mdsAptLine)
    {
        $this->mdsAptLine = $mdsAptLine;

        return $this;
    }

    /**
     * Get mdsAptLine
     *
     * @return string
     */
    public function getMdsAptLine()
    {
        return $this->mdsAptLine;
    }

    /**
     * Set mdsResidentFirstName
     *
     * @param string $mdsResidentFirstName
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsResidentFirstName($mdsResidentFirstName)
    {
        $this->mdsResidentFirstName = $mdsResidentFirstName;

        return $this;
    }

    /**
     * Get mdsResidentFirstName
     *
     * @return string
     */
    public function getMdsResidentFirstName()
    {
        return $this->mdsResidentFirstName;
    }

    /**
     * Set mdsResidentLastName
     *
     * @param string $mdsResidentLastName
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsResidentLastName($mdsResidentLastName)
    {
        $this->mdsResidentLastName = $mdsResidentLastName;

        return $this;
    }

    /**
     * Get mdsResidentLastName
     *
     * @return string
     */
    public function getMdsResidentLastName()
    {
        return $this->mdsResidentLastName;
    }

    /**
     * Set aweberBuilding
     *
     * @param string $aweberBuilding
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberBuilding($aweberBuilding)
    {
        $this->aweberBuilding = $aweberBuilding;

        return $this;
    }

    /**
     * Get aweberBuilding
     *
     * @return string
     */
    public function getAweberBuilding()
    {
        return $this->aweberBuilding;
    }

    /**
     * Set aweberFloorNumber
     *
     * @param integer $aweberFloorNumber
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberFloorNumber($aweberFloorNumber)
    {
        $this->aweberFloorNumber = $aweberFloorNumber;

        return $this;
    }

    /**
     * Get aweberFloorNumber
     *
     * @return integer
     */
    public function getAweberFloorNumber()
    {
        return $this->aweberFloorNumber;
    }

    /**
     * Set aweberAptLine
     *
     * @param string $aweberAptLine
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberAptLine($aweberAptLine)
    {
        $this->aweberAptLine = $aweberAptLine;

        return $this;
    }

    /**
     * Get aweberAptLine
     *
     * @return string
     */
    public function getAweberAptLine()
    {
        return $this->aweberAptLine;
    }

    /**
     * Set aweberSubscriberName
     *
     * @param string $aweberSubscriberName
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberSubscriberName($aweberSubscriberName)
    {
        $this->aweberSubscriberName = $aweberSubscriberName;

        return $this;
    }

    /**
     * Get aweberSubscriberName
     *
     * @return string
     */
    public function getAweberSubscriberName()
    {
        return $this->aweberSubscriberName;
    }

    /**
     * Set actionReason
     *
     * @param string $actionReason
     *
     * @return AweberMdsSyncAudit
     */
    public function setActionReason($actionReason)
    {
        $this->actionReason = $actionReason;

        return $this;
    }

    /**
     * Get actionReason
     *
     * @return string
     */
    public function getActionReason()
    {
        return $this->actionReason;
    }

    /**
     * Set aweberSubscriberStatus
     *
     * @param string $aweberSubscriberStatus
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberSubscriberStatus($aweberSubscriberStatus)
    {
        $this->aweberSubscriberStatus = $aweberSubscriberStatus;

        return $this;
    }

    /**
     * Get aweberSubscriberStatus
     *
     * @return string
     */
    public function getAweberSubscriberStatus()
    {
        return $this->aweberSubscriberStatus;
    }

    /**
     * Set aweberSubscribedAt
     *
     * @param \DateTime $aweberSubscribedAt
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberSubscribedAt($aweberSubscribedAt)
    {
        $this->aweberSubscribedAt = $aweberSubscribedAt;

        return $this;
    }

    /**
     * Get aweberSubscribedAt
     *
     * @return \DateTime
     */
    public function getAweberSubscribedAt()
    {
        return $this->aweberSubscribedAt;
    }

    /**
     * Set aweberUnsubscribedAt
     *
     * @param \DateTime $aweberUnsubscribedAt
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberUnsubscribedAt($aweberUnsubscribedAt)
    {
        $this->aweberUnsubscribedAt = $aweberUnsubscribedAt;

        return $this;
    }

    /**
     * Get aweberUnsubscribedAt
     *
     * @return \DateTime
     */
    public function getAweberUnsubscribedAt()
    {
        return $this->aweberUnsubscribedAt;
    }

    /**
     * Set aweberSubscriptionMethod
     *
     * @param string $aweberSubscriptionMethod
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberSubscriptionMethod($aweberSubscriptionMethod)
    {
        $this->aweberSubscriptionMethod = $aweberSubscriptionMethod;

        return $this;
    }

    /**
     * Get aweberSubscriptionMethod
     *
     * @return string
     */
    public function getAweberSubscriptionMethod()
    {
        return $this->aweberSubscriptionMethod;
    }

    /**
     * Set mdsToddlerRmMember
     *
     * @param string $mdsToddlerRmMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsToddlerRmMember($mdsToddlerRmMember)
    {
        $this->mdsToddlerRmMember = $mdsToddlerRmMember;

        return $this;
    }

    /**
     * Get mdsToddlerRmMember
     *
     * @return string
     */
    public function getMdsToddlerRmMember()
    {
        return $this->mdsToddlerRmMember;
    }

    /**
     * Set mdsYouthRmMember
     *
     * @param string $mdsYouthRmMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsYouthRmMember($mdsYouthRmMember)
    {
        $this->mdsYouthRmMember = $mdsYouthRmMember;

        return $this;
    }

    /**
     * Get mdsYouthRmMember
     *
     * @return string
     */
    public function getMdsYouthRmMember()
    {
        return $this->mdsYouthRmMember;
    }

    /**
     * Set mdsCeramicsMember
     *
     * @param string $mdsCeramicsMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsCeramicsMember($mdsCeramicsMember)
    {
        $this->mdsCeramicsMember = $mdsCeramicsMember;

        return $this;
    }

    /**
     * Get mdsCeramicsMember
     *
     * @return string
     */
    public function getMdsCeramicsMember()
    {
        return $this->mdsCeramicsMember;
    }

    /**
     * Set mdsWoodworkingMember
     *
     * @param string $mdsWoodworkingMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsWoodworkingMember($mdsWoodworkingMember)
    {
        $this->mdsWoodworkingMember = $mdsWoodworkingMember;

        return $this;
    }

    /**
     * Get mdsWoodworkingMember
     *
     * @return string
     */
    public function getMdsWoodworkingMember()
    {
        return $this->mdsWoodworkingMember;
    }

    /**
     * Set mdsGymMember
     *
     * @param string $mdsGymMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsGymMember($mdsGymMember)
    {
        $this->mdsGymMember = $mdsGymMember;

        return $this;
    }

    /**
     * Get mdsGymMember
     *
     * @return string
     */
    public function getMdsGymMember()
    {
        return $this->mdsGymMember;
    }

    /**
     * Set mdsGardenMember
     *
     * @param string $mdsGardenMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsGardenMember($mdsGardenMember)
    {
        $this->mdsGardenMember = $mdsGardenMember;

        return $this;
    }

    /**
     * Get mdsGardenMember
     *
     * @return string
     */
    public function getMdsGardenMember()
    {
        return $this->mdsGardenMember;
    }

    /**
     * Set mdsParkingLotLocation
     *
     * @param string $mdsParkingLotLocation
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsParkingLotLocation($mdsParkingLotLocation)
    {
        $this->mdsParkingLotLocation = $mdsParkingLotLocation;

        return $this;
    }

    /**
     * Get mdsParkingLotLocation
     *
     * @return string
     */
    public function getMdsParkingLotLocation()
    {
        return $this->mdsParkingLotLocation;
    }

    /**
     * Set mdsVehicleRegIntervalRemaining
     *
     * @param integer $mdsVehicleRegIntervalRemaining
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsVehicleRegIntervalRemaining($mdsVehicleRegIntervalRemaining)
    {
        $this->mdsVehicleRegIntervalRemaining = $mdsVehicleRegIntervalRemaining;

        return $this;
    }

    /**
     * Get mdsVehicleRegIntervalRemaining
     *
     * @return integer
     */
    public function getMdsVehicleRegIntervalRemaining()
    {
        return $this->mdsVehicleRegIntervalRemaining;
    }

    /**
     * Set mdsHomeownerInsIntervalRemaining
     *
     * @param integer $mdsHomeownerInsIntervalRemaining
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsHomeownerInsIntervalRemaining($mdsHomeownerInsIntervalRemaining)
    {
        $this->mdsHomeownerInsIntervalRemaining = $mdsHomeownerInsIntervalRemaining;

        return $this;
    }

    /**
     * Get mdsHomeownerInsIntervalRemaining
     *
     * @return integer
     */
    public function getMdsHomeownerInsIntervalRemaining()
    {
        return $this->mdsHomeownerInsIntervalRemaining;
    }

    /**
     * Set mdsStorageLkrClBldg
     *
     * @param string $mdsStorageLkrClBldg
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsStorageLkrClBldg($mdsStorageLkrClBldg)
    {
        $this->mdsStorageLkrClBldg = $mdsStorageLkrClBldg;

        return $this;
    }

    /**
     * Get mdsStorageLkrClBldg
     *
     * @return string
     */
    public function getMdsStorageLkrClBldg()
    {
        return $this->mdsStorageLkrClBldg;
    }

    /**
     * Set mdsStorageLkrNum
     *
     * @param string $mdsStorageLkrNum
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsStorageLkrNum($mdsStorageLkrNum)
    {
        $this->mdsStorageLkrNum = $mdsStorageLkrNum;

        return $this;
    }

    /**
     * Get mdsStorageLkrNum
     *
     * @return string
     */
    public function getMdsStorageLkrNum()
    {
        return $this->mdsStorageLkrNum;
    }

    /**
     * Set mdsStorageClFloorNum
     *
     * @param string $mdsStorageClFloorNum
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsStorageClFloorNum($mdsStorageClFloorNum)
    {
        $this->mdsStorageClFloorNum = $mdsStorageClFloorNum;

        return $this;
    }

    /**
     * Get mdsStorageClFloorNum
     *
     * @return string
     */
    public function getMdsStorageClFloorNum()
    {
        return $this->mdsStorageClFloorNum;
    }

    /**
     * Set mdsIsDogInApt
     *
     * @param string $mdsIsDogInApt
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsIsDogInApt($mdsIsDogInApt)
    {
        $this->mdsIsDogInApt = $mdsIsDogInApt;

        return $this;
    }

    /**
     * Get mdsIsDogInApt
     *
     * @return string
     */
    public function getMdsIsDogInApt()
    {
        return $this->mdsIsDogInApt;
    }

    /**
     * Set mdsBikeRackBldg
     *
     * @param string $mdsBikeRackBldg
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsBikeRackBldg($mdsBikeRackBldg)
    {
        $this->mdsBikeRackBldg = $mdsBikeRackBldg;

        return $this;
    }

    /**
     * Get mdsBikeRackBldg
     *
     * @return string
     */
    public function getMdsBikeRackBldg()
    {
        return $this->mdsBikeRackBldg;
    }

    /**
     * @return string
     */
    public function getMdsBikeRackRoom()
    {
        return $this->mdsBikeRackRoom;
    }

    /**
     * @param string $mdsBikeRackRoom
     */
    public function setMdsBikeRackRoom($mdsBikeRackRoom)
    {
        $this->mdsBikeRackRoom = $mdsBikeRackRoom;
    }



    /**
     * Set mdsBikeRackLocation
     *
     * @param string $mdsBikeRackLocation
     *
     * @return AweberMdsSyncAudit
     */
    public function setMdsBikeRackLocation($mdsBikeRackLocation)
    {
        $this->mdsBikeRackLocation = $mdsBikeRackLocation;

        return $this;
    }

    /**
     * Get mdsBikeRackLocation
     *
     * @return string
     */
    public function getMdsBikeRackLocation()
    {
        return $this->mdsBikeRackLocation;
    }

    /**
     * Set mdsResidentCategory
     *
     * @param string $mdsResidentCategory
     *
     * @return AweberMdsSyncAudit
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
     * Set aweberToddlerRmMember
     *
     * @param string $aweberToddlerRmMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberToddlerRmMember($aweberToddlerRmMember)
    {
        $this->aweberToddlerRmMember = $aweberToddlerRmMember;

        return $this;
    }

    /**
     * Get aweberToddlerRmMember
     *
     * @return string
     */
    public function getAweberToddlerRmMember()
    {
        return $this->aweberToddlerRmMember;
    }

    /**
     * Set aweberYouthRmMember
     *
     * @param string $aweberYouthRmMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberYouthRmMember($aweberYouthRmMember)
    {
        $this->aweberYouthRmMember = $aweberYouthRmMember;

        return $this;
    }

    /**
     * Get aweberYouthRmMember
     *
     * @return string
     */
    public function getAweberYouthRmMember()
    {
        return $this->aweberYouthRmMember;
    }

    /**
     * Set aweberCeramicsMember
     *
     * @param string $aweberCeramicsMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberCeramicsMember($aweberCeramicsMember)
    {
        $this->aweberCeramicsMember = $aweberCeramicsMember;

        return $this;
    }

    /**
     * Get aweberCeramicsMember
     *
     * @return string
     */
    public function getAweberCeramicsMember()
    {
        return $this->aweberCeramicsMember;
    }

    /**
     * Set aweberWoodworkingMember
     *
     * @param string $aweberWoodworkingMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberWoodworkingMember($aweberWoodworkingMember)
    {
        $this->aweberWoodworkingMember = $aweberWoodworkingMember;

        return $this;
    }

    /**
     * Get aweberWoodworkingMember
     *
     * @return string
     */
    public function getAweberWoodworkingMember()
    {
        return $this->aweberWoodworkingMember;
    }

    /**
     * Set aweberGymMember
     *
     * @param string $aweberGymMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberGymMember($aweberGymMember)
    {
        $this->aweberGymMember = $aweberGymMember;

        return $this;
    }

    /**
     * Get aweberGymMember
     *
     * @return string
     */
    public function getAweberGymMember()
    {
        return $this->aweberGymMember;
    }

    /**
     * Set aweberGardenMember
     *
     * @param string $aweberGardenMember
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberGardenMember($aweberGardenMember)
    {
        $this->aweberGardenMember = $aweberGardenMember;

        return $this;
    }

    /**
     * Get aweberGardenMember
     *
     * @return string
     */
    public function getAweberGardenMember()
    {
        return $this->aweberGardenMember;
    }

    /**
     * Set aweberParkingLotLocation
     *
     * @param string $aweberParkingLotLocation
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberParkingLotLocation($aweberParkingLotLocation)
    {
        $this->aweberParkingLotLocation = $aweberParkingLotLocation;

        return $this;
    }

    /**
     * Get aweberParkingLotLocation
     *
     * @return string
     */
    public function getAweberParkingLotLocation()
    {
        return $this->aweberParkingLotLocation;
    }

    /**
     * Set aweberVehicleRegIntervalRemaining
     *
     * @param integer $aweberVehicleRegIntervalRemaining
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberVehicleRegIntervalRemaining($aweberVehicleRegIntervalRemaining)
    {
        $this->aweberVehicleRegIntervalRemaining = $aweberVehicleRegIntervalRemaining;

        return $this;
    }

    /**
     * Get aweberVehicleRegIntervalRemaining
     *
     * @return integer
     */
    public function getAweberVehicleRegIntervalRemaining()
    {
        return $this->aweberVehicleRegIntervalRemaining;
    }

    /**
     * Set aweberHomeownerInsIntervalRemaining
     *
     * @param integer $aweberHomeownerInsIntervalRemaining
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberHomeownerInsIntervalRemaining($aweberHomeownerInsIntervalRemaining)
    {
        $this->aweberHomeownerInsIntervalRemaining = $aweberHomeownerInsIntervalRemaining;

        return $this;
    }

    /**
     * Get aweberHomeownerInsIntervalRemaining
     *
     * @return integer
     */
    public function getAweberHomeownerInsIntervalRemaining()
    {
        return $this->aweberHomeownerInsIntervalRemaining;
    }

    /**
     * Set aweberStorageLkrClBldg
     *
     * @param string $aweberStorageLkrClBldg
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberStorageLkrClBldg($aweberStorageLkrClBldg)
    {
        $this->aweberStorageLkrClBldg = $aweberStorageLkrClBldg;

        return $this;
    }

    /**
     * Get aweberStorageLkrClBldg
     *
     * @return string
     */
    public function getAweberStorageLkrClBldg()
    {
        return $this->aweberStorageLkrClBldg;
    }

    /**
     * Set aweberStorageLkrNum
     *
     * @param string $aweberStorageLkrNum
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberStorageLkrNum($aweberStorageLkrNum)
    {
        $this->aweberStorageLkrNum = $aweberStorageLkrNum;

        return $this;
    }

    /**
     * Get aweberStorageLkrNum
     *
     * @return string
     */
    public function getAweberStorageLkrNum()
    {
        return $this->aweberStorageLkrNum;
    }

    /**
     * Set aweberStorageClFloorNum
     *
     * @param string $aweberStorageClFloorNum
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberStorageClFloorNum($aweberStorageClFloorNum)
    {
        $this->aweberStorageClFloorNum = $aweberStorageClFloorNum;

        return $this;
    }

    /**
     * Get aweberStorageClFloorNum
     *
     * @return string
     */
    public function getAweberStorageClFloorNum()
    {
        return $this->aweberStorageClFloorNum;
    }

    /**
     * Set aweberIsDogInApt
     *
     * @param string $aweberIsDogInApt
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberIsDogInApt($aweberIsDogInApt)
    {
        $this->aweberIsDogInApt = $aweberIsDogInApt;

        return $this;
    }

    /**
     * Get aweberIsDogInApt
     *
     * @return string
     */
    public function getAweberIsDogInApt()
    {
        return $this->aweberIsDogInApt;
    }

    /**
     * Set aweberBikeRackBldg
     *
     * @param string $aweberBikeRackBldg
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberBikeRackBldg($aweberBikeRackBldg)
    {
        $this->aweberBikeRackBldg = $aweberBikeRackBldg;

        return $this;
    }

    /**
     * Get aweberBikeRackBldg
     *
     * @return string
     */
    public function getAweberBikeRackBldg()
    {
        return $this->aweberBikeRackBldg;
    }

    /**
     * @return string
     */
    public function getAweberBikeRackRoom()
    {
        return $this->aweberBikeRackRoom;
    }

    /**
     * @param string $aweberBikeRackRoom
     */
    public function setAweberBikeRackRoom($aweberBikeRackRoom)
    {
        $this->aweberBikeRackRoom = $aweberBikeRackRoom;
    }



    /**
     * Set aweberBikeRackLocation
     *
     * @param string $aweberBikeRackLocation
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberBikeRackLocation($aweberBikeRackLocation)
    {
        $this->aweberBikeRackLocation = $aweberBikeRackLocation;

        return $this;
    }

    /**
     * Get aweberBikeRackLocation
     *
     * @return string
     */
    public function getAweberBikeRackLocation()
    {
        return $this->aweberBikeRackLocation;
    }

    /**
     * Set aweberResidentCategory
     *
     * @param string $aweberResidentCategory
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberResidentCategory($aweberResidentCategory)
    {
        $this->aweberResidentCategory = $aweberResidentCategory;

        return $this;
    }

    /**
     * Get aweberResidentCategory
     *
     * @return string
     */
    public function getAweberResidentCategory()
    {
        return $this->aweberResidentCategory;
    }


    /**
     * Set lastChangedDate
     *
     * @param \DateTime $lastChangedDate
     *
     * @return AweberMdsSyncAudit
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
     * Get syncAuditId
     *
     * @return integer
     */
    public function getSyncAuditId()
    {
        return $this->syncAuditId;
    }
}

