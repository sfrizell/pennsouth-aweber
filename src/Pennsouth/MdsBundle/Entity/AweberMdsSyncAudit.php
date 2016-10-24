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
    private $aweberSubscriberListName;

    /**
     * @var string
     */
    private $subscriberEmailAddress;

    /**
     * @var string
     */
    private $updateAction;

    /**
     * @var string
     */
    private $mdsBuilding;

    /**
     * @var integer
     */
    private $mdsFloorNumber;

    /**
     * @var string
     */
    private $mdsAptLine;

    /**
     * @var string
     */
    private $mdsResidentFirstName;

    /**
     * @var string
     */
    private $mdsResidentLastName;

    /**
     * @var string
     */
    private $aweberBuilding;

    /**
     * @var integer
     */
    private $aweberFloorNumber;

    /**
     * @var string
     */
    private $aweberAptLine;

    /**
     * @var string
     */
    private $aweberSubscriberName;

    /**
     * @var string
     */
    private $actionReason;

    /**
     * @var string
     */
    private $aweberSubscriberStatus;

    /**
     * @var \DateTime
     */
    private $aweberSubscribedAt;

    /**
     * @var \DateTime
     */
    private $aweberUnsubscribedAt;

    /**
     * @var string
     */
    private $aweberSubscriptionMethod;

    /**
     * @var \DateTime
     */
    private $lastChangedDate;

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

