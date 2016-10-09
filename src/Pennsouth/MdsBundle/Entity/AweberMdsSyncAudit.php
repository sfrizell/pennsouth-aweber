<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * AweberMdsSyncAudit
 */
class AweberMdsSyncAudit
{
    /**
     * @var integer
     */
    private $aweberSubscriberListId;

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
    private $actionReason;

    /**
     * @var \DateTime
     */
    private $actionDate;

    /**
     * @var integer
     */
    private $syncAuditId;


    /**
     * Set aweberSubscriberListId
     *
     * @param integer $aweberSubscriberListId
     *
     * @return AweberMdsSyncAudit
     */
    public function setAweberSubscriberListId($aweberSubscriberListId)
    {
        $this->aweberSubscriberListId = $aweberSubscriberListId;

        return $this;
    }

    /**
     * Get aweberSubscriberListId
     *
     * @return integer
     */
    public function getAweberSubscriberListId()
    {
        return $this->aweberSubscriberListId;
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
     * Set actionDate
     *
     * @param \DateTime $actionDate
     *
     * @return AweberMdsSyncAudit
     */
    public function setActionDate($actionDate)
    {
        $this->actionDate = $actionDate;

        return $this;
    }

    /**
     * Get actionDate
     *
     * @return \DateTime
     */
    public function getActionDate()
    {
        return $this->actionDate;
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

