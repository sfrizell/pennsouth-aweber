<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdsExport
 *
 * @ORM\Table(name="Mds_Export")
 * @ORM\Entity
 */
class MdsExport
{
    /**
     * @var string
     *
     * @ORM\Column(name="Building", type="string", length=2, nullable=false)
     */
    private $building;

    /**
     * @var string
     *
     * @ORM\Column(name="MDS_Apt", type="string", length=4, nullable=false)
     */
    private $mdsApt;

    /**
     * @var integer
     *
     * @ORM\Column(name="Floor_Number", type="integer", nullable=true)
     */
    private $floorNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Apt_Line", type="string", length=1, nullable=true)
     */
    private $aptLine;

    /**
     * @var string
     *
     * @ORM\Column(name="First_Name", type="string", length=45, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="Last_Name", type="string", length=45, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="Email_Address", type="string", length=70, nullable=true)
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="Category", type="string", length=45, nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="Daytime_Phone", type="string", length=20, nullable=true)
     */
    private $daytimePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="Evening_Phone", type="string", length=20, nullable=true)
     */
    private $eveningPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="Cell_Phone", type="string", length=20, nullable=true)
     */
    private $cellPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="Fax", type="string", length=20, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="Tenant_Id", type="string", length=20, nullable=true)
     */
    private $tenantId;

    /**
     * @var string
     *
     * @ORM\Column(name="Person_Id", type="string", length=20, nullable=true)
     */
    private $personId;

    /**
     * @var string
     *
     * @ORM\Column(name="Office_Phone", type="string", length=20, nullable=true)
     */
    private $officePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="Status_Codes", type="string", length=45, nullable=true)
     */
    private $statusCodes;

    /**
     * @var string
     *
     * @ORM\Column(name="Standard_Lockbox_Tenant_Id", type="string", length=45, nullable=true)
     */
    private $standardLockboxTenantId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Move_In_Date", type="datetime", nullable=true)
     */
    private $moveInDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Last_Changed_Date", type="datetime", nullable=true)
     */
    private $lastChangedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Locker_Storage", type="string", length=1, nullable=true)
     */
    private $lockerStorage;

    /**
     * @var string
     *
     * @ORM\Column(name="Utility_Closet", type="string", length=1, nullable=true)
     */
    private $utilityCloset;

    /**
     * @var string
     *
     * @ORM\Column(name="Small_Closet", type="string", length=1, nullable=true)
     */
    private $smallCloset;

    /**
     * @var string
     *
     * @ORM\Column(name="Parking", type="string", length=1, nullable=true)
     */
    private $parking;

    /**
     * @var string
     *
     * @ORM\Column(name="Window_Guard_Installed", type="string", length=1, nullable=true)
     */
    private $windowGuardInstalled;

    /**
     * @var string
     *
     * @ORM\Column(name="Dog_Allowed", type="string", length=1, nullable=true)
     */
    private $dogAllowed;

    /**
     * @var string
     *
     * @ORM\Column(name="Loan_Credit_Union", type="string", length=1, nullable=true)
     */
    private $loanCreditUnion;

    /**
     * @var string
     *
     * @ORM\Column(name="Toddler_Room_Member", type="string", length=1, nullable=true)
     */
    private $toddlerRoomMember;

    /**
     * @var string
     *
     * @ORM\Column(name="Youth_Room_Member", type="string", length=1, nullable=true)
     */
    private $youthRoomMember;

    /**
     * @var string
     *
     * @ORM\Column(name="Ceramics_Member", type="string", length=1, nullable=true)
     */
    private $ceramicsMember;

    /**
     * @var string
     *
     * @ORM\Column(name="Garden_Member", type="string", length=1, nullable=true)
     */
    private $gardenMember;

    /**
     * @var string
     *
     * @ORM\Column(name="Woodworking_Member", type="string", length=1, nullable=true)
     */
    private $woodworkingMember;

    /**
     * @var string
     *
     * @ORM\Column(name="Gym_Member", type="string", length=1, nullable=true)
     */
    private $gymMember;

    /**
     * @var integer
     *
     * @ORM\Column(name="Mds_export_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mdsExportId;



    /**
     * Set building
     *
     * @param string $building
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
     * Set daytimePhone
     *
     * @param string $daytimePhone
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
     * Set officePhone
     *
     * @param string $officePhone
     * @return MdsExport
     */
    public function setOfficePhone($officePhone)
    {
        $this->officePhone = $officePhone;

        return $this;
    }

    /**
     * Get officePhone
     *
     * @return string 
     */
    public function getOfficePhone()
    {
        return $this->officePhone;
    }

    /**
     * Set statusCodes
     *
     * @param string $statusCodes
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
     * Set lastChangedDate
     *
     * @param \DateTime $lastChangedDate
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
     * Set lockerStorage
     *
     * @param string $lockerStorage
     * @return MdsExport
     */
    public function setLockerStorage($lockerStorage)
    {
        $this->lockerStorage = $lockerStorage;

        return $this;
    }

    /**
     * Get lockerStorage
     *
     * @return string 
     */
    public function getLockerStorage()
    {
        return $this->lockerStorage;
    }

    /**
     * Set utilityCloset
     *
     * @param string $utilityCloset
     * @return MdsExport
     */
    public function setUtilityCloset($utilityCloset)
    {
        $this->utilityCloset = $utilityCloset;

        return $this;
    }

    /**
     * Get utilityCloset
     *
     * @return string 
     */
    public function getUtilityCloset()
    {
        return $this->utilityCloset;
    }

    /**
     * Set smallCloset
     *
     * @param string $smallCloset
     * @return MdsExport
     */
    public function setSmallCloset($smallCloset)
    {
        $this->smallCloset = $smallCloset;

        return $this;
    }

    /**
     * Get smallCloset
     *
     * @return string 
     */
    public function getSmallCloset()
    {
        return $this->smallCloset;
    }

    /**
     * Set parking
     *
     * @param string $parking
     * @return MdsExport
     */
    public function setParking($parking)
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * Get parking
     *
     * @return string 
     */
    public function getParking()
    {
        return $this->parking;
    }

    /**
     * Set windowGuardInstalled
     *
     * @param string $windowGuardInstalled
     * @return MdsExport
     */
    public function setWindowGuardInstalled($windowGuardInstalled)
    {
        $this->windowGuardInstalled = $windowGuardInstalled;

        return $this;
    }

    /**
     * Get windowGuardInstalled
     *
     * @return string 
     */
    public function getWindowGuardInstalled()
    {
        return $this->windowGuardInstalled;
    }

    /**
     * Set dogAllowed
     *
     * @param string $dogAllowed
     * @return MdsExport
     */
    public function setDogAllowed($dogAllowed)
    {
        $this->dogAllowed = $dogAllowed;

        return $this;
    }

    /**
     * Get dogAllowed
     *
     * @return string 
     */
    public function getDogAllowed()
    {
        return $this->dogAllowed;
    }

    /**
     * Set loanCreditUnion
     *
     * @param string $loanCreditUnion
     * @return MdsExport
     */
    public function setLoanCreditUnion($loanCreditUnion)
    {
        $this->loanCreditUnion = $loanCreditUnion;

        return $this;
    }

    /**
     * Get loanCreditUnion
     *
     * @return string 
     */
    public function getLoanCreditUnion()
    {
        return $this->loanCreditUnion;
    }

    /**
     * Set toddlerRoomMember
     *
     * @param string $toddlerRoomMember
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
     * Get mdsExportId
     *
     * @return integer 
     */
    public function getMdsExportId()
    {
        return $this->mdsExportId;
    }
}
