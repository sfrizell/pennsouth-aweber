<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PennsouthShareholder
 *
 * @ORM\Table(name="Pennsouth_Shareholder", indexes={@ORM\Index(name="fk_Internal_Applicant_Pennsouth_Apt1_idx", columns={"Apartment_id"})})
 * @ORM\Entity
 */
class PennsouthShareholder
{
    /**
     * @var string
     *
     * @ORM\Column(name="shareholder_bldg", type="string", length=4, nullable=true)
     */
    private $shareholderBldg;

    /**
     * @var string
     *
     * @ORM\Column(name="shareholder_apt", type="string", length=4, nullable=true)
     */
    private $shareholderApt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="move_in_date", type="datetime", nullable=true)
     */
    private $moveInDate;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=45, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=45, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=45, nullable=true)
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="is_primary_applicant", type="string", length=1, nullable=true)
     */
    private $isPrimaryApplicant;

    /**
     * @var string
     *
     * @ORM\Column(name="home_phone", type="string", length=10, nullable=true)
     */
    private $homePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="business_phone", type="string", length=10, nullable=true)
     */
    private $businessPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_phone", type="string", length=10, nullable=true)
     */
    private $mobilePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="buildinglink_shareable_id", type="string", length=20, nullable=true)
     */
    private $buildinglinkShareableId;

    /**
     * @var integer
     *
     * @ORM\Column(name="year_of_birth", type="integer", nullable=true)
     */
    private $yearOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=45, nullable=true)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="Transfer_reason_code", type="string", length=20, nullable=false)
     */
    private $transferReasonCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="Shareholder_Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $shareholderId;

    /**
     * @var \Pennsouth\MdsBundle\Entity\PennsouthApt
     *
     * @ORM\ManyToOne(targetEntity="Pennsouth\MdsBundle\Entity\PennsouthApt")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Apartment_id", referencedColumnName="apartment_id")
     * })
     */
    private $apartment;



    /**
     * Set shareholderBldg
     *
     * @param string $shareholderBldg
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
