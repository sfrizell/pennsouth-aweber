<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * EmailNotifyParameters
 */
class EmailNotifyParameters
{
    /**
     * @var string
     */
    private $reportOrProcessName;

    /**
     * @var string
     */
    private $recipientEmailAddress;

    /**
     * @var string
     */
    private $recipientName;

    /**
     * @var string
     */
    private $sendOnlyExceptions;

    /**
     * @var \DateTime
     */
    private $lastChangedDate;

    /**
     * @var integer
     */
    private $emailNotifyParametersId;


    /**
     * Set reportOrProcessName
     *
     * @param string $reportOrProcessName
     *
     * @return EmailNotifyParameters
     */
    public function setReportOrProcessName($reportOrProcessName)
    {
        $this->reportOrProcessName = $reportOrProcessName;

        return $this;
    }

    /**
     * Get reportOrProcessName
     *
     * @return string
     */
    public function getReportOrProcessName()
    {
        return $this->reportOrProcessName;
    }

    /**
     * Set recipientEmailAddress
     *
     * @param string $recipientEmailAddress
     *
     * @return EmailNotifyParameters
     */
    public function setRecipientEmailAddress($recipientEmailAddress)
    {
        $this->recipientEmailAddress = $recipientEmailAddress;

        return $this;
    }

    /**
     * Get recipientEmailAddress
     *
     * @return string
     */
    public function getRecipientEmailAddress()
    {
        return $this->recipientEmailAddress;
    }

    /**
     * Set recipientName
     *
     * @param string $recipientName
     *
     * @return EmailNotifyParameters
     */
    public function setRecipientName($recipientName)
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    /**
     * Get recipientName
     *
     * @return string
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * Set sendOnlyExceptions
     *
     * @param string $sendOnlyExceptions
     *
     * @return EmailNotifyParameters
     */
    public function setSendOnlyExceptions($sendOnlyExceptions)
    {
        $this->sendOnlyExceptions = $sendOnlyExceptions;

        return $this;
    }

    /**
     * Get sendOnlyExceptions
     *
     * @return string
     */
    public function getSendOnlyExceptions()
    {
        return $this->sendOnlyExceptions;
    }

    /**
     * Set lastChangedDate
     *
     * @param \DateTime $lastChangedDate
     *
     * @return EmailNotifyParameters
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
     * Get emailNotifyParametersId
     *
     * @return integer
     */
    public function getEmailNotifyParametersId()
    {
        return $this->emailNotifyParametersId;
    }
}

