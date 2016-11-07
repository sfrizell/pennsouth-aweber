<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * PennsouthShareholder
 */
class PennsouthShareholder
{
    /**
     * @var string
     */
    private $shareholderBldg;

    /**
     * @var string
     */
    private $shareholderApt;

    /**
     * @var \DateTime
     */
    private $moveInDate;

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
    private $isPrimaryApplicant;

    /**
     * @var string
     */
    private $homePhone;

    /**
     * @var string
     */
    private $businessPhone;

    /**
     * @var string
     */
    private $mobilePhone;

    /**
     * @var string
     */
    private $buildinglinkShareableId;

    /**
     * @var integer
     */
    private $yearOfBirth;

    /**
     * @var string
     */
    private $sex;

    /**
     * @var string
     */
    private $transferReasonCode;

    /**
     * @var integer
     */
    private $shareholderId;

    /**
     * @var \Pennsouth\MdsBundle\Entity\PennsouthApt
     */
    private $apartment;


    /**
     * Set shareholderBldg
     *
     * @param string $shareholderBldg
     *
     * @return PennsouthShareholder
     */
    public function setShareholderBldg($shareholderBldg)
    {
        $this->shareholderBldg = $shareholderBldg;

        return $this;
    }

    /**
     * Get shareholderBldg
     *
     * @return string
     */
    public function getShareholderBldg()
    {
        return $this->shareholderBldg;
    }

    /**
     * Set shareholderApt
     *
     * @param string $shareholderApt
     *
     * @return PennsouthShareholder
     */
    public function setShareholderApt($shareholderApt)
    {
        $this->shareholderApt = $shareholderApt;

        return $this;
    }

    /**
     * Get shareholderApt
     *
     * @return string
     */
    public function getShareholderApt()
    {
        return $this->shareholderApt;
    }

    /**
     * Set moveInDate
     *
     * @param \DateTime $moveInDate
     *
     * @return PennsouthShareholder
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return PennsouthShareholder
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
     * @return PennsouthShareholder
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
     * @return PennsouthShareholder
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
     * Set isPrimaryApplicant
     *
     * @param string $isPrimaryApplicant
     *
     * @return PennsouthShareholder
     */
    public function setIsPrimaryApplicant($isPrimaryApplicant)
    {
        $this->isPrimaryApplicant = $isPrimaryApplicant;

        return $this;
    }

    /**
     * Get isPrimaryApplicant
     *
     * @return string
     */
    public function getIsPrimaryApplicant()
    {
        return $this->isPrimaryApplicant;
    }

    /**
     * Set homePhone
     *
     * @param string $homePhone
     *
     * @return PennsouthShareholder
     */
    public function setHomePhone($homePhone)
    {
        $this->homePhone = $homePhone;

        return $this;
    }

    /**
     * Get homePhone
     *
     * @return string
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * Set businessPhone
     *
     * @param string $businessPhone
     *
     * @return PennsouthShareholder
     */
    public function setBusinessPhone($businessPhone)
    {
        $this->businessPhone = $businessPhone;

        return $this;
    }

    /**
     * Get businessPhone
     *
     * @return string
     */
    public function getBusinessPhone()
    {
        return $this->businessPhone;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     *
     * @return PennsouthShareholder
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set buildinglinkShareableId
     *
     * @param string $buildinglinkShareableId
     *
     * @return PennsouthShareholder
     */
    public function setBuildinglinkShareableId($buildinglinkShareableId)
    {
        $this->buildinglinkShareableId = $buildinglinkShareableId;

        return $this;
    }

    /**
     * Get buildinglinkShareableId
     *
     * @return string
     */
    public function getBuildinglinkShareableId()
    {
        return $this->buildinglinkShareableId;
    }

    /**
     * Set yearOfBirth
     *
     * @param integer $yearOfBirth
     *
     * @return PennsouthShareholder
     */
    public function setYearOfBirth($yearOfBirth)
    {
        $this->yearOfBirth = $yearOfBirth;

        return $this;
    }

    /**
     * Get yearOfBirth
     *
     * @return integer
     */
    public function getYearOfBirth()
    {
        return $this->yearOfBirth;
    }

    /**
     * Set sex
     *
     * @param string $sex
     *
     * @return PennsouthShareholder
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set transferReasonCode
     *
     * @param string $transferReasonCode
     *
     * @return PennsouthShareholder
     */
    public function setTransferReasonCode($transferReasonCode)
    {
        $this->transferReasonCode = $transferReasonCode;

        return $this;
    }

    /**
     * Get transferReasonCode
     *
     * @return string
     */
    public function getTransferReasonCode()
    {
        return $this->transferReasonCode;
    }

    /**
     * Get shareholderId
     *
     * @return integer
     */
    public function getShareholderId()
    {
        return $this->shareholderId;
    }

    /**
     * Set apartment
     *
     * @param \Pennsouth\MdsBundle\Entity\PennsouthApt $apartment
     *
     * @return PennsouthShareholder
     */
    public function setApartment(\Pennsouth\MdsBundle\Entity\PennsouthApt $apartment = null)
    {
        $this->apartment = $apartment;

        return $this;
    }

    /**
     * Get apartment
     *
     * @return \Pennsouth\MdsBundle\Entity\PennsouthApt
     */
    public function getApartment()
    {
        return $this->apartment;
    }
}
