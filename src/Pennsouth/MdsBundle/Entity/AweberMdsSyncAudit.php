<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AweberMdsSyncAudit
 *
 * @ORM\Table(name="Aweber_Mds_Sync_Audit")
 * @ORM\Entity
 */
class AweberMdsSyncAudit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Aweber_Subscriber_List_Id", type="integer", nullable=true)
     */
    private $aweberSubscriberListId;

    /**
     * @var string
     *
     * @ORM\Column(name="Subscriber_Email_Address", type="string", length=100, nullable=true)
     */
    private $subscriberEmailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="Update_Action", type="string", length=45, nullable=true)
     */
    private $updateAction;

    /**
     * @var string
     *
     * @ORM\Column(name="Mds_Building", type="string", length=2, nullable=true)
     */
    private $mdsBuilding;

    /**
     * @var integer
     *
     * @ORM\Column(name="Mds_Floor_Number", type="integer", nullable=true)
     */
    private $mdsFloorNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Mds_Apt_Line", type="string", length=1, nullable=true)
     */
    private $mdsAptLine;

    /**
     * @var string
     *
     * @ORM\Column(name="Aweber_Building", type="string", length=2, nullable=true)
     */
    private $aweberBuilding;

    /**
     * @var integer
     *
     * @ORM\Column(name="Aweber_Floor_Number", type="integer", nullable=true)
     */
    private $aweberFloorNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Aweber_Apt_Line", type="string", length=1, nullable=true)
     */
    private $aweberAptLine;

    /**
     * @var string
     *
     * @ORM\Column(name="Action_Reason", type="string", length=45, nullable=true)
     */
    private $actionReason;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Action_Date", type="datetime", nullable=true)
     */
    private $actionDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="Sync_Audit_Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $syncAuditId;



    /**
     * Set aweberSubscriberListId
     *
     * @param integer $aweberSubscriberListId
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
