<?php
/**
 * MdsToAweberUpdater.php
 * User: sfrizell
 * Date: 10/10/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Service;

use Doctrine\ORM\EntityManager;
use Pennsouth\MdsBundle\AweberEntity\AweberFieldsConstants;
use Pennsouth\MdsBundle\AweberEntity\AweberSubscriber;
use Pennsouth\MdsBundle\AweberEntity\AweberUpdateSummary;
use Pennsouth\MdsBundle\Entity\PennsouthResident;
use Pennsouth\MdsBundle\Entity\AweberMdsSyncAudit;
use Pennsouth\MdsBundle\AweberEntity\AweberSubscriberUpdateInsertDeleteLists;
use Symfony\Component\Config\Definition\Exception\Exception;

class MdsToAweberComparator
{
    const UPDATE = 'update';
    const INSERT = 'insert';
    const DELETE = 'delete';
    const ACTION_REASON_NO_MATCHING_EMAIL_IN_MDS = "No matching email found in MDS";
    const UPDATE_APT                                = 'apt';
    const UPDATE_CERAMICS_CLUB                       = 'ceramics';
    const UPDATE_YOUTH_MEMBER                       = 'youth_rm';
    const UPDATE_WOODWORKING_MEMBER                 = 'woodworking';
    const UPDATE_GYM_MEMBER                         = 'gym';
    const UPDATE_GARDEN_MEMBER                      = 'garden';
    const UPDATE_TODDLER_ROOM                       = 'toddler_rm';
    const UPDATE_STORAGE_LOCKER_CLOSET_BLDG         = 'storage_lkr_closet_bldg';
    const UPDATE_STORAGE_LOCKER_NUM                 = 'storage_locker_num';
    const UPDATE_STORAGE_CLOSET_FLOOR_NUM           = 'storage_closet_fl_num';
    const UPDATE_BIKE_RACK_BLDG                     = 'bike_rack_bldg';
    const UPDATE_BIKE_RACK_ROOM                     = 'bike_rack_rm';
    const UPDATE_BIKE_RACK_LOCATION                 = 'bike_rack_location';
    const UPDATE_HOMEOWNERS_INS_INTERVAL_REMAINING  = 'home_ins_interval_remaining';
    const UPDATE_VEHICLE_REG_INTERVAL_REMAINING     = 'vehicle_reg_interval_remaining';
    const UPDATE_IS_DOG_PRESENT                     = 'dog';
    const UPDATE_PARKING_LOT_LOCATION               = 'parking_lot';
    const UPDATE_RESIDENT_CATEGORY                  = 'resident_category';
    const UPDATE_INCOME_AFFIDAVIT_RECEIVED          = 'income_affidavit_received';
    const UPDATE_ACTION_REPORTING                   = 'reporting';
    const ACTION_REASON_APT_SURRENDERED             = 'apt surrendered';




    private $entityManager;
    private $pennsouthResidents; // array of PennsouthResident entities having email addresses
    private $aweberSubscribersByListNames; // associative array : key = Aweber Subscriber List Name ; value = array of AWeberSubscriber objects
    public function __construct(EntityManager $entityManager, $pennsouthResidents, $aweberSubscribersByListNames = null)
    {
        $this->entityManager                    = $entityManager;
        $this->pennsouthResidents               = $pennsouthResidents;
        $this->aweberSubscribersByListNames = $aweberSubscribersByListNames;
        date_default_timezone_set('America/New_York');
    }

    public function getEntityManager() {
        return $this->entityManager;
    }


    /**
     * Loop through pennsouthResidents : if match found in either aweber subscriber list and status of indicates the subscriber has not unsubsribed, then we want to check
     *     for differences between MDS data and Aweber subscriber data and update the Aweber subscriber if differences are found.
     *    if no match found, then we want to insert a new subscriber into the aweber 'Primary Resident List' subscriber list from the MDS resident data.
     *  No updates to Aweber are performed in this method. An instance of AweberSubscriberUpdateInsertLists is returned by the method, which is used subsequently
     *    to perform the inserts/update into the Aweber subscriber lists.
     * @return AweberSubscriberUpdateInsertDeleteLists - list of Aweber subscribers to insert or update.
     */
    public function compareAweberWithMds() {

        $aweberSubscribersUpdateList = array();
        $aweberSubscribersInsertList = array();
        $aweberSubscribersDeleteList = array();
       // $aweberSubscriberToSave = new AweberSubscriber();
        foreach ($this->pennsouthResidents as $pennsouthResident) {
            $foundEmailAddressInAweber = false;
            if ( !is_null($this->aweberSubscribersByListNames) )
            foreach ($this->aweberSubscribersByListNames as $aweberSubscribers) {
                foreach ($aweberSubscribers as $listName => $aweberSubscriberList) {
                   // if ($listName == AweberSubscriberListReader::PRIMARY_RESIDENT_LIST) {
                        foreach ($aweberSubscriberList as $aweberSubscriber) {
                            if ( ($aweberSubscriber instanceof AweberSubscriber) and ( $pennsouthResident instanceof PennsouthResident)) { // these should both always be the case; here for IDE parsing purposes...
                                if (strtolower($aweberSubscriber->getEmail()) == strtolower($pennsouthResident->getEmailAddress())) {
                                    $foundEmailAddressInAweber = true;
                                    // $aweberSubscriber should always be instanceof AweberSubscriber
                                    if ( $aweberSubscriber->getStatus() == 'subscribed') {
                                        if ( (strpos($pennsouthResident->getAptSurrendered(), 'External Move') == true)  ) { // if apt surrendered, then delete the email address from aweber
                                            $aweberSubscriberToDelete = $this->createAweberSubscriberToDeleteFromMdsInput( $pennsouthResident, $aweberSubscriber);
                                            $aweberSubscriberbyListName = [$listName => $aweberSubscriberToDelete];
                                            $aweberSubscribersDeleteList[] = $aweberSubscriberbyListName;
                                        }
                                        else {
                                            // if no differences detected between current Aweber and MDS input, the function returns null
                                            $aweberSubscriberToSave = $this->createAweberSubscriberFromMdsInput(self::UPDATE, $pennsouthResident, $aweberSubscriber);
                                            if (!is_null($aweberSubscriberToSave)) {
                                                $aweberSubscriberbyListName = [$listName => $aweberSubscriberToSave];
                                                $aweberSubscribersUpdateList[] = $aweberSubscriberbyListName;
                                            }
                                        }
                                    }
                                    break;
                                }
                            }
                        }
                   // }
                }
            } // end foreach of loop through $aweberSubscribersByListName
            if (!$foundEmailAddressInAweber and (!strpos($pennsouthResident->getAptSurrendered(), 'External Move') == true)) {
                $aweberSubscriberToSave = $this->createAweberSubscriberFromMdsInput(self::INSERT, $pennsouthResident);
                // inserts are only to Primary Residents subscriber list...
                $aweberSubscriberbyListName = [AweberFieldsConstants::PRIMARY_RESIDENT_LIST => $aweberSubscriberToSave];
                $aweberSubscribersInsertList[] = $aweberSubscriberbyListName;
            }
        }


        $aweberSubscriberUpdateInsertDeleteLists = new AweberSubscriberUpdateInsertDeleteLists();

        $aweberSubscriberUpdateInsertDeleteLists->setAweberSubscriberInsertList($aweberSubscribersInsertList);
        $aweberSubscriberUpdateInsertDeleteLists->setAweberSubscriberUpdateList($aweberSubscribersUpdateList);
        $aweberSubscriberUpdateInsertDeleteLists->setAweberSubscriberDeleteList($aweberSubscribersDeleteList);

        return $aweberSubscriberUpdateInsertDeleteLists;

    }

    // todo - change the signature of the following method back to private after testing...
    /**
     *  Compare $pennsouthResident (MDS Export file data) with $aweberSubscriber (AWeber subscriber data)
     *           If values are different, return an instance of $aweberSubscriber updated to reflect the values
     *            from MDS. Otherwise return null.
     * @param $updateOrInsert
     * @param $pennsouthResident
     * @param $aweberSubscriber
     * @return $aweberSubscriber
     */
    public function createAweberSubscriberFromMdsInput($updateOrInsert, PennsouthResident $pennsouthResident, AweberSubscriber $aweberSubscriber = null) {

        $aweberUpdateRequired = false;
        if ($updateOrInsert == self::UPDATE) {
            $aweberSubscriberUpdated = $this->updateAweberSubscriberActionReasonAndPrevCustomFields($pennsouthResident, $aweberSubscriber);
            if ( !is_null($aweberSubscriberUpdated) and ($aweberSubscriberUpdated instanceof AweberSubscriber) ) {
                $aweberUpdateRequired = TRUE;
                $aweberSubscriber = $aweberSubscriberUpdated;
            }
        }

        if ($updateOrInsert == self::INSERT or $aweberUpdateRequired) {
            if ($updateOrInsert == self::INSERT) {
                $aweberSubscriber = new AweberSubscriber();
            }
            $aweberSubscriber->setPennSouthBuilding($pennsouthResident->getBuilding());
            $aweberSubscriber->setFloorNumber($pennsouthResident->getFloorNumber());
            $aweberSubscriber->setApartment($pennsouthResident->getAptLine());
            $aweberSubscriber->setEmail($pennsouthResident->getEmailAddress());
            $aweberSubscriber->setResidentCategory( is_null( $pennsouthResident->getMdsResidentCategory()) ? "" : $pennsouthResident->getMdsResidentCategory());
            $aweberSubscriber->setParkingLotLocation( is_null( $pennsouthResident->getParkingLotLocation()) ? "" : $pennsouthResident->getParkingLotLocation());
            $aweberSubscriber->setIsDogInApt( is_null ( $pennsouthResident->getIsDogInApt()) ? "" : $pennsouthResident->getIsDogInApt());
            $aweberSubscriber->setStorageLockerClosetBldg( is_null( $pennsouthResident->getStorageLockerClosetBldgNum()) ? "" : $pennsouthResident->getStorageLockerClosetBldgNum() );
            $aweberSubscriber->setStorageLockerNum( is_null ( $pennsouthResident->getStorageLockerNum()) ? "" : $pennsouthResident->getStorageLockerNum());
            $aweberSubscriber->setStorageClosetFloorNum( is_null($pennsouthResident->getStorageClosetFloorNum()) ? "" : $pennsouthResident->getStorageClosetFloorNum());
            $aweberSubscriber->setBikeRackBldg( is_null( $pennsouthResident->getBikeRackBldg()) ? "" : $pennsouthResident->getBikeRackBldg());
            $aweberSubscriber->setBikeRackRoom( is_null( $pennsouthResident->getBikeRackRoom()) ? "" : $pennsouthResident->getBikeRackRoom() );
            $aweberSubscriber->setBikeRackLocation( is_null( $pennsouthResident->getBikeRackLocation()) ? "" : $pennsouthResident->getBikeRackLocation() );
            $aweberSubscriber->setWoodworkingMember( is_null( $pennsouthResident->getWoodworkingMember()) ? "" : $pennsouthResident->getWoodworkingMember());
            $aweberSubscriber->setHomeownerInsIntervalRemaining( is_null($pennsouthResident->getHomeownerInsIntervalRemaining()) ? "" : $pennsouthResident->getHomeownerInsIntervalRemaining());
            $aweberSubscriber->setYouthRoomMember(is_null($pennsouthResident->getYouthRoomMember()) ? "" : $pennsouthResident->getYouthRoomMember());
            $aweberSubscriber->setResidentCategory(is_null($pennsouthResident->getMdsResidentCategory()) ? "" : $pennsouthResident->getMdsResidentCategory());
            $aweberSubscriber->setCeramicsMember(is_null($pennsouthResident->getCeramicsMember()) ? "" : $pennsouthResident->getCeramicsMember());
            $aweberSubscriber->setGardenMember(is_null($pennsouthResident->getGardenMember()) ? "" : $pennsouthResident->getGardenMember());
            $aweberSubscriber->setGymMember(is_null($pennsouthResident->getGymMember()) ? "" : $pennsouthResident->getGymMember());
            $aweberSubscriber->setVehicleRegIntervalRemaining(is_null($pennsouthResident->getVehicleRegIntervalRemaining()) ? "" : $pennsouthResident->getVehicleRegIntervalRemaining());
            $aweberSubscriber->setToddlerRoomMember(is_null($pennsouthResident->getToddlerRoomMember()) ? "" : $pennsouthResident->getToddlerRoomMember());
            $aweberSubscriber->setIncAffidavitReceived(is_null($pennsouthResident->getIncAffidavitReceived()) ? "" : $pennsouthResident->getIncAffidavitReceived());
            $aweberSubscriber->setName(is_null($pennsouthResident->getFirstName() . " " . $pennsouthResident->getLastName()) ? "" : $pennsouthResident->getFirstName() . " " . $pennsouthResident->getLastName());
            $aweberSubscriber->setFirstName(is_null($pennsouthResident->getFirstName()) ? "" : $pennsouthResident->getFirstName());
            $aweberSubscriber->setLastName(is_null($pennsouthResident->getLastName()) ? "" : $pennsouthResident->getLastName());
            $aweberSubscriber->setAptSurrendered(is_null($pennsouthResident->getAptSurrendered()) ? "" : $pennsouthResident->getAptSurrendered());
            $customFields = array ( AweberFieldsConstants::BUILDING                         => $aweberSubscriber->getPennSouthBuilding(),
                                    AweberFieldsConstants::FLOOR_NUMBER                     => $aweberSubscriber->getFloorNumber(),
                                    AweberFieldsConstants::APARTMENT                        => $aweberSubscriber->getApartment(),
                                    AweberFieldsConstants::RESIDENT_CATEGORY                => $aweberSubscriber->getResidentCategory(),
                                    AweberFieldsConstants::PARKING_LOT_LOCATION             => $aweberSubscriber->getParkingLotLocation(),
                                    AweberFieldsConstants::IS_DOG_IN_APT                    => $aweberSubscriber->getIsDogInApt(),
                                    AweberFieldsConstants::STORAGE_LOCKER_CLOSET_BLDG_NUM   => $aweberSubscriber->getStorageLockerClosetBldg(),
                                    AweberFieldsConstants::STORAGE_LOCKER_NUM               => $aweberSubscriber->getStorageLockerNum(),
                                    AweberFieldsConstants::STORAGE_CLOSET_FLOOR_NUM         => $aweberSubscriber->getStorageClosetFloorNum(),
                                    AweberFieldsConstants::BIKE_RACK_BLDG                   => $aweberSubscriber->getBikeRackBldg(),
                                    AweberFieldsConstants::BIKE_RACK_ROOM                   => $aweberSubscriber->getBikeRackRoom(),
                                    AweberFieldsConstants::BIKE_RACK_LOCATION               => $aweberSubscriber->getBikeRackLocation(),
                                    AweberFieldsConstants::WOODWORKING_MEMBER               => $aweberSubscriber->getWoodworkingMember(),
                                    AweberFieldsConstants::HOMEOWNER_INS_INTERVAL_REMAINING => $aweberSubscriber->getHomeownerInsIntervalRemaining(),
                                    AweberFieldsConstants::YOUTH_ROOM_MEMBER                => $aweberSubscriber->getYouthRoomMember(),
                                    AweberFieldsConstants::CERAMICS_MEMBER                  => $aweberSubscriber->getCeramicsMember(),
                                    AweberFieldsConstants::GARDEN_MEMBER                    => $aweberSubscriber->getGardenMember(),
                                    AweberFieldsConstants::GYM_MEMBER                       => $aweberSubscriber->getGymMember(),
                                    AweberFieldsConstants::VEHICLE_REG_INTERVAL_REMAINING   => $aweberSubscriber->getVehicleRegIntervalRemaining(),
                                    AweberFieldsConstants::TODDLER_ROOM_MEMBER              => $aweberSubscriber->getToddlerRoomMember(),
                                    AweberFieldsConstants::INCOME_AFFIDAVIT_RECEIVED        => $aweberSubscriber->getIncAffidavitReceived()
            );
            $aweberSubscriber->setCustomFields($customFields);
            return $aweberSubscriber;
        }

        return null;

    }

    /**
     *  When the Pennsouth Resident is identified as having surrendered their apartment, either for an external or internal move, the email addresses of the resident should
     *   be deleted from Aweber subscriber lists.
     * @param PennsouthResident $pennsouthResident
     * @param AweberSubscriber|null $aweberSubscriber
     * @return AweberSubscriber
     */
    private function createAweberSubscriberToDeleteFromMdsInput(PennsouthResident $pennsouthResident, AweberSubscriber $aweberSubscriber) {


        $aweberSubscriber->setAptSurrendered(is_null($pennsouthResident->getAptSurrendered()) ? "" : $pennsouthResident->getAptSurrendered());

        $aweberSubscriber->setActionReason(self::ACTION_REASON_APT_SURRENDERED);


        return $aweberSubscriber;

    }

    /**
     * - Compare Aweber subscriber data ($aweberSubscriber) with MDS Export File data ($pennsouthResident) for subscriber with same email address.
     * @param $pennsouthResident
     * @param $aweberSubscriber
     * @return $aweberSubscriber
     *  return: $aweberSubscriber with $actionReason property updated if there are any data differences in name or custom fields between Aweber and MDS Export file data; otherwise return null.
     *
     */
    private function updateAweberSubscriberActionReasonAndPrevCustomFields(PennsouthResident $pennsouthResident, AweberSubscriber $aweberSubscriber) {

        $actionReason = '';
        $separator = ',';
        $singleQuotes = "'";

        if (trim($aweberSubscriber->getApartment(), $singleQuotes )            !== trim($pennsouthResident->getAptLine()) or
            trim($aweberSubscriber->getPennSouthBuilding(),$singleQuotes)     !== trim($pennsouthResident->getBuilding()) or
            trim($aweberSubscriber->getFloorNumber(),$singleQuotes)           !== trim($pennsouthResident->getFloorNumber()) ) {
            $actionReason .= self::UPDATE_APT . $separator;
        }
        if ( trim( $aweberSubscriber->getCeramicsMember(),$singleQuotes )         !== trim($pennsouthResident->getCeramicsMember()) ) {
            $actionReason .= self::UPDATE_CERAMICS_CLUB . $separator;
        }
        if ( trim($aweberSubscriber->getGardenMember(),$singleQuotes )           !== trim($pennsouthResident->getGardenMember())  ) {
            $actionReason .= self::UPDATE_GARDEN_MEMBER . $separator;
        }
        if ( trim($aweberSubscriber->getGymMember(),$singleQuotes)              !== trim($pennsouthResident->getGymMember())  ) {
            $actionReason .= self::UPDATE_GYM_MEMBER . $separator;
        }
        if ( trim($aweberSubscriber->getYouthRoomMember(),$singleQuotes)              !== trim($pennsouthResident->getYouthRoomMember())  ) {
            $actionReason .= self::UPDATE_YOUTH_MEMBER . $separator;
        }
        if ( trim($aweberSubscriber->getWoodworkingMember(),$singleQuotes)              !== trim($pennsouthResident->getWoodworkingMember())  ) {
            $actionReason .= self::UPDATE_WOODWORKING_MEMBER . $separator;
        }
        if ( trim($aweberSubscriber->getToddlerRoomMember(),$singleQuotes)       !== trim($pennsouthResident->getToddlerRoomMember()) ) {
            $actionReason .= self::UPDATE_TODDLER_ROOM . $separator;
        }
        if ( trim($aweberSubscriber->getIncAffidavitReceived(),$singleQuotes)       !== trim($pennsouthResident->getIncAffidavitReceived()) ) {
            $actionReason .= self::UPDATE_INCOME_AFFIDAVIT_RECEIVED . $separator;
        }

        if ( trim($aweberSubscriber->getHomeownerInsIntervalRemaining(),$singleQuotes) !== trim($pennsouthResident->getHomeownerInsIntervalRemaining()) ) {
            $actionReason .= self::UPDATE_HOMEOWNERS_INS_INTERVAL_REMAINING . $separator;
        }

        if ( trim($aweberSubscriber->getVehicleRegIntervalRemaining(),$singleQuotes) !== trim($pennsouthResident->getVehicleRegIntervalRemaining()) ) {
            $actionReason .= self::UPDATE_VEHICLE_REG_INTERVAL_REMAINING . $separator;
        }
        if ( trim($aweberSubscriber->getIsDogInApt(),$singleQuotes )             !== trim($pennsouthResident->getIsDogInApt()) ) {
            $actionReason .= self::UPDATE_IS_DOG_PRESENT . $separator;
        }
        if ( trim($aweberSubscriber->getStorageLockerClosetBldg(),$singleQuotes )  !== trim($pennsouthResident->getStorageLockerClosetBldgNum()) ) {
            $actionReason .= self::UPDATE_STORAGE_LOCKER_CLOSET_BLDG . $separator;
        }
        if ( trim($aweberSubscriber->getStorageLockerNum() ,$singleQuotes )       !== trim($pennsouthResident->getStorageLockerNum()) ) {
            $actionReason .= self::UPDATE_STORAGE_LOCKER_NUM . $separator;
        }
        if ( trim($aweberSubscriber->getStorageClosetFloorNum() ,$singleQuotes )   !== trim($pennsouthResident->getStorageClosetFloorNum()) ) {
            $actionReason .= self::UPDATE_STORAGE_CLOSET_FLOOR_NUM . $separator;
        }
        if ( trim($aweberSubscriber->getBikeRackBldg() ,$singleQuotes )            !== trim($pennsouthResident->getBikeRackBldg()) ) {
            $actionReason .= self::UPDATE_BIKE_RACK_BLDG . $separator;
        }
        if ( trim($aweberSubscriber->getBikeRackRoom() ,$singleQuotes  )          !== trim($pennsouthResident->getBikeRackRoom()) ) {
            $actionReason .= self::UPDATE_BIKE_RACK_ROOM . $separator;
        }
        if ( trim($aweberSubscriber->getBikeRackLocation() ,$singleQuotes  )          !== trim($pennsouthResident->getBikeRackLocation()) ) {
            $actionReason .= self::UPDATE_BIKE_RACK_LOCATION . $separator;
        }
        if ( trim($aweberSubscriber->getParkingLotLocation() ,$singleQuotes )      !== trim($pennsouthResident->getParkingLotLocation()) ) {
            $actionReason .= self::UPDATE_PARKING_LOT_LOCATION . $separator;
        }
        if ( trim($aweberSubscriber->getResidentCategory() ,$singleQuotes )       !== trim($pennsouthResident->getMdsResidentCategory()) ) {
            $actionReason .= self::UPDATE_RESIDENT_CATEGORY . $separator;
        }


        $aweberSubscriber->setPrevApartment( trim( $aweberSubscriber->getApartment(), $singleQuotes) );
        $aweberSubscriber->setPrevPennSouthBuilding(trim($aweberSubscriber->getPennSouthBuilding(),$singleQuotes));
        $aweberSubscriber->setPrevFloorNumber(trim($aweberSubscriber->getFloorNumber(), $singleQuotes) );
        $aweberSubscriber->setPrevCeramicsMember( trim( $aweberSubscriber->getCeramicsMember(), $singleQuotes ));
        $aweberSubscriber->setPrevGardenMember( trim( $aweberSubscriber->getGardenMember() , $singleQuotes ) );
        $aweberSubscriber->setPrevGymMember( trim( $aweberSubscriber->getGymMember() , $singleQuotes ) );
        $aweberSubscriber->setPrevYouthRoomMember( trim( $aweberSubscriber->getYouthRoomMember() , $singleQuotes ) );
        $aweberSubscriber->setPrevWoodworkingMember( trim( $aweberSubscriber->getWoodworkingMember() , $singleQuotes ) );
        $aweberSubscriber->setPrevToddlerRoomMember( trim( $aweberSubscriber->getToddlerRoomMember() , $singleQuotes ) );
        $aweberSubscriber->setPrevHomeownerInsIntervalRemaining( trim( $aweberSubscriber->getHomeownerInsIntervalRemaining() , $singleQuotes ) );
        $aweberSubscriber->setPrevVehicleRegIntervalRemaining( trim( $aweberSubscriber->getVehicleRegIntervalRemaining() , $singleQuotes ) );
        $aweberSubscriber->setIsDogInApt( trim( $aweberSubscriber->getIsDogInApt() , $singleQuotes ) );
        $aweberSubscriber->setPrevStorageLockerClosetBldg( trim( $aweberSubscriber->getStorageLockerClosetBldg() , $singleQuotes ) );
        $aweberSubscriber->setPrevStorageLockerNum( trim( $aweberSubscriber->getStorageLockerNum() , $singleQuotes ) );
        $aweberSubscriber->setPrevStorageClosetFloorNum( trim( $aweberSubscriber->getStorageClosetFloorNum() , $singleQuotes ) );
        $aweberSubscriber->setPrevBikeRackBldg( trim( $aweberSubscriber->getBikeRackBldg() , $singleQuotes ) );
        $aweberSubscriber->setPrevBikeRackRoom( trim( $aweberSubscriber->getBikeRackRoom() , $singleQuotes ) );
        $aweberSubscriber->setPrevParkingLotLocation( trim( $aweberSubscriber->getParkingLotLocation() , $singleQuotes ) );
        $aweberSubscriber->setPrevResidentCategory( trim( $aweberSubscriber->getResidentCategory() , $singleQuotes ) );
        $aweberSubscriber->setPrevIncAffidavitReceived( trim( $aweberSubscriber->getIncAffidavitReceived() , $singleQuotes ) );

        $actionReason = trim($actionReason, $separator);
        if (strlen($actionReason) > 0) {
            $aweberSubscriber->setActionReason($actionReason);
            return $aweberSubscriber;
        }
        else {
            return null;
        }


    }


    public function storeAuditTrailofUpdatesToAweberSubscribers(AweberSubscriberUpdateInsertDeleteLists $aweberSubscriberUpdateInsertDeleteLists) {

        $aweberUpdateSummary = new AweberUpdateSummary();


        $currDate = new \DateTime("now");
        // $isAweberMdsSyncAuditDeleted = false;
        if (!$aweberSubscriberUpdateInsertDeleteLists->isAweberSubscriberInsertListEmpty()) {
                    $insertCtr = 0;
                    $batchSize = 40;
                    $updateAction = self::INSERT;
                    $this->deleteAweberMdsSyncAuditByUpdateAction($updateAction);
                   // $isAweberMdsSyncAuditDeleted = true;
                    $saveListName = null;
                    foreach ($aweberSubscriberUpdateInsertDeleteLists->getAweberSubscriberInsertList() as $aweberSubscriberByListName) {
                        foreach ($aweberSubscriberByListName as $listName => $aweberSubscriber) {
                            // $saveListName = $listName;
                            if (!array_key_exists($listName, $aweberUpdateSummary->getListInsertArrayCtr())) {
                                $aweberUpdateSummary->initializeListInsertArrayCtr($listName);
                                $aweberUpdateSummary->incrementListInsertArrayCtr($listName);
                            } else {
                                $aweberUpdateSummary->incrementListInsertArrayCtr($listName);
                            }
                            $insertCtr++;
                            if (($insertCtr % $batchSize) === 0) {
                                $flush = true;
                            } else {
                                $flush = false;
                            }
                            if ($aweberSubscriber instanceof AweberSubscriber) { // should always be true
                                $aweberSubscriber->setActionReason(self::INSERT);
                            }
                            $this->insertAweberMdsSyncAudit($aweberSubscriber, AweberFieldsConstants::PRIMARY_RESIDENT_LIST, $currDate, $flush, $updateAction);
                        }
                    }
                    $this->getEntityManager()->flush();
                    $this->getEntityManager()->clear();
        }

        if (!$aweberSubscriberUpdateInsertDeleteLists->isAweberSubscriberUpdateListEmpty()) {
         /*   if (!$isAweberMdsSyncAuditDeleted) {
                $this->truncateAweberMdsSyncAudit();
            }*/
            $updateAction = self::UPDATE;
            $this->deleteAweberMdsSyncAuditByUpdateAction($updateAction);
            $updateCtr = 0;
            $batchSize = 40;
            foreach ($aweberSubscriberUpdateInsertDeleteLists->getAweberSubscriberUpdateList() as $aweberSubscriberByListName) {
                foreach($aweberSubscriberByListName as $listName => $aweberSubscriber) {
                    if (!array_key_exists($listName, $aweberUpdateSummary->getListUpdateArrayCtr())) {
                        $aweberUpdateSummary->initializeListUpdateArrayCtr($listName);
                        $aweberUpdateSummary->incrementListUpdateArrayCtr($listName);
                    } else {
                        $aweberUpdateSummary->incrementListUpdateArrayCtr($listName);
                    }
                    $updateCtr++;
                    if (($updateCtr % $batchSize) === 0) {
                        $flush = true;
                    } else {
                        $flush = false;
                    }
                    $this->insertAweberMdsSyncAudit($aweberSubscriber, $listName, $currDate, $flush, $updateAction);
                }
            }
            $this->flushAndClearEntityManager();
        }

        if (!$aweberSubscriberUpdateInsertDeleteLists->isAweberSubscriberDeleteListEmpty()) {
               /*   if (!$isAweberMdsSyncAuditDeleted) {
                      $this->truncateAweberMdsSyncAudit();
                  }*/
                  $updateAction = self::DELETE;
                  $this->deleteAweberMdsSyncAuditByUpdateAction($updateAction);
                  $updateCtr = 0;
                  $batchSize = 40;
                  foreach ($aweberSubscriberUpdateInsertDeleteLists->getAweberSubscriberDeleteList() as $aweberSubscriberByListName) {
                      foreach($aweberSubscriberByListName as $listName => $aweberSubscriber) {
                          if (!array_key_exists($listName, $aweberUpdateSummary->getListDeleteArrayCtr())) {
                              $aweberUpdateSummary->initializeListDeleteArrayCtr($listName);
                              $aweberUpdateSummary->incrementListDeleteArrayCtr($listName);
                          } else {
                              $aweberUpdateSummary->incrementListDeleteArrayCtr($listName);
                          }
                          $updateCtr++;
                          if (($updateCtr % $batchSize) === 0) {
                              $flush = true;
                          } else {
                              $flush = false;
                          }
                          $this->insertAweberMdsSyncAudit($aweberSubscriber, $listName, $currDate, $flush, $updateAction);
                      }
                  }
                  $this->flushAndClearEntityManager();
              }


        return $aweberUpdateSummary;

    }


    /**
      *  Find all subscribers with email addresses in Aweber where there is no match on email address in MDS Export.
      *  For each such instance write a row to the Aweber_Mds_Sync_Audit table
      *
      */
     public function reportOnAweberSubscribersWithNoMatchInMds() {

         $this->deleteAweberMdsSyncAuditByUpdateAction(self::ACTION_REASON_NO_MATCHING_EMAIL_IN_MDS); // first delete any entries in the Audit table from a previous run for this actionReason...
         $currDate = new \DateTime("now");
         $j = 0;
         foreach ($this->aweberSubscribersByListNames as $aweberSubscribers) {
             $j++;

             foreach ($aweberSubscribers as $listName => $aweberSubscriberList) { // after the 'as' each is a list of subscribers?
                 print("\n" . "MdsToAweberUpdater - listname: " . $listName);
                 $batchSize = 20; // call entityManager->flush after this # of inserts...
                 $insertBatchCtr = 0;
                 foreach ($aweberSubscriberList as $aweberSubscriber) {
                    // print("\n" . "!!!!!!!!!!!   aweberSubscriber in MdsToAweberComparator... !!!!!!!!!!" . "\n");
                    // print_r($aweberSubscriber);
                     if ($aweberSubscriber instanceof AweberSubscriber and $aweberSubscriber->getStatus() == 'subscribed') {
                         $is_subscriber_in_mds = FALSE;
                         foreach ($this->pennsouthResidents as $pennsouthResident) {
                             // print("\n" . "!!!!!!!!!!!   aweberSubscriber in MdsToAweberUpdate... !!!!!!!!!!" . "\n");
                             // print_r($aweberSubscriber);
                             // print("\n" . "!!!!!!!!!!!   aweberSubscriber getEmail... !!!!!!!!!!" . "\n");
                             // print($aweberSubscriber->getEmail());
                             if (($pennsouthResident instanceof PennsouthResident) and ($aweberSubscriber instanceof AweberSubscriber)) { // should always be true; here for parsing purposes
                                 if (strtolower($aweberSubscriber->getEmail()) == strtolower($pennsouthResident->getEmailAddress())) {
                                     $is_subscriber_in_mds = TRUE;
                                     break;
                                 }
                             }

                         }
                         if (!$is_subscriber_in_mds) {
                             $insertBatchCtr++;
                             if (($insertBatchCtr % $batchSize) === 0) {
                                 $flush = TRUE;
                             } else {
                                 $flush = FALSE;
                             }
                             $this->createAweberMdsSyncAuditNoMdsSubscriber($aweberSubscriber, $listName, $currDate, $flush);
                         }
                     }
                 }

              } // foreach aweberSubscribers
         } // foreach aweberSubscribersWithListNameKeys...
         $this->flushAndClearEntityManager();

     }

        /**
         * Insert into AweberMdsSyncAudit table to maintain audit trail of updates to Aweber Subscriber lists.
         * @param AweberSubscriber $aweberSubscriber
         * @param $listName
         * @param $currDate
         * @param $flush - true/false - for better performance, limit number of flushes (commits) to batch of inserts.
         * @param  $updateAction - insert/update
         * @throws $exception
         */
        private function insertAweberMdsSyncAudit(AweberSubscriber $aweberSubscriber, $listName, $currDate, $flush, $updateAction) {

            $aweberMdsSyncAudit = new AweberMdsSyncAudit();
            // set attributes of $aweberMdsSyncAudit...

            $aweberMdsSyncAudit->setAweberSubscriberListName($listName);
            $aweberMdsSyncAudit->setSubscriberEmailAddress($aweberSubscriber->getEmail());
            $aweberMdsSyncAudit->setAweberBuilding( $aweberSubscriber->getPrevPennSouthBuilding());
            $aweberMdsSyncAudit->setAweberFloorNumber($aweberSubscriber->getPrevFloorNumber());
            $aweberMdsSyncAudit->setAweberAptLine($aweberSubscriber->getPrevApartment());
            $aweberMdsSyncAudit->setAweberBikeRackBldg( $aweberSubscriber->getPrevBikeRackBldg() );
            $aweberMdsSyncAudit->setAweberBikeRackRoom( $aweberSubscriber->getPrevBikeRackRoom() );
            $aweberMdsSyncAudit->setAweberBikeRackLocation( $aweberSubscriber->getPrevBikeRackLocation() );
            $aweberMdsSyncAudit->setAweberCeramicsMember( $aweberSubscriber->getPrevCeramicsMember());
            $aweberMdsSyncAudit->setAweberGardenMember( $aweberSubscriber->getPrevGardenMember() );
            $aweberMdsSyncAudit->setAweberGymMember( $aweberSubscriber->getPrevGymMember() );
            $aweberMdsSyncAudit->setAweberIncAffidavitReceived( $aweberSubscriber->getPrevIncAffidavitReceived() );


            $prevHomeownerInsExpDaysLeft = $aweberSubscriber->getPrevHomeownerInsIntervalRemaining();
            $aweberMdsSyncAudit->setAweberHomeownerInsIntervalRemaining( (isset($prevHomeownerInsExpDaysLeft) and !empty($prevHomeownerInsExpDaysLeft)) ? $prevHomeownerInsExpDaysLeft : NULL );
            $aweberMdsSyncAudit->setAweberIsDogInApt( $aweberSubscriber->getPrevIsDogInApt() );
            $aweberMdsSyncAudit->setAweberParkingLotLocation( $aweberSubscriber->getPrevParkingLotLocation() );
            $aweberMdsSyncAudit->setAweberResidentCategory( $aweberSubscriber->getPrevResidentCategory() );
            $aweberMdsSyncAudit->setAweberStorageClFloorNum($aweberSubscriber->getPrevStorageClosetFloorNum() );
            $aweberMdsSyncAudit->setAweberStorageLkrClBldg( $aweberSubscriber->getPrevStorageLockerClosetBldg() );
            $aweberMdsSyncAudit->setAweberStorageLkrNum( $aweberSubscriber->getPrevStorageLockerNum() );
            $aweberMdsSyncAudit->setAweberToddlerRmMember( $aweberSubscriber->getPrevToddlerRoomMember() );
            $aweberMdsSyncAudit->setAweberYouthRmMember( $aweberSubscriber->getPrevYouthRoomMember() );
            $aweberMdsSyncAudit->setAweberWoodworkingMember( $aweberSubscriber->getPrevWoodworkingMember() );
            $prevVehicleRegExpDaysLeft = $aweberSubscriber->getPrevVehicleRegIntervalRemaining();
            $aweberMdsSyncAudit->setAweberHomeownerInsIntervalRemaining( (isset($prevVehicleRegExpDaysLeft) and !empty($prevVehicleRegExpDaysLeft)) ? $prevVehicleRegExpDaysLeft : NULL );
            $aweberMdsSyncAudit->setAweberSubscriberStatus($aweberSubscriber->getStatus());
            $aweberMdsSyncAudit->setAweberSubscriberName($aweberSubscriber->getName());
            $aweberMdsSyncAudit->setUpdateAction($updateAction);
            if (!is_null($aweberSubscriber->getSubscribedAt()) ) {
                $subscribedAtDate = \DateTime::createFromFormat('Y-m-d', $aweberSubscriber->getSubscribedAt()); // need the backward slash to address namespace issue.
                $aweberMdsSyncAudit->setAweberSubscribedAt($subscribedAtDate);
            }
            if ( !is_null($aweberSubscriber->getUnsubscribedAt()) ) {
                $unSubscribedAtDate = \DateTime::createFromFormat('Y-m-d', $aweberSubscriber->getUnsubscribedAt()); // need the backward slash to address namespace issue.
                $aweberMdsSyncAudit->setAweberUnsubscribedAt($unSubscribedAtDate);
            }
            $aweberMdsSyncAudit->setAweberSubscriptionMethod($aweberSubscriber->getSubscriptionMethod());


            $aweberMdsSyncAudit->setActionReason($aweberSubscriber->getActionReason());
            $aweberMdsSyncAudit->setLastChangedDate($currDate);

            $aweberMdsSyncAudit->setMdsAptLine($aweberSubscriber->getApartment());
            $aweberMdsSyncAudit->setMdsBuilding($aweberSubscriber->getPennSouthBuilding());
            $aweberMdsSyncAudit->setMdsFloorNumber($aweberSubscriber->getFloorNumber());
            $aweberMdsSyncAudit->setMdsResidentFirstName($aweberSubscriber->getFirstName());
            $aweberMdsSyncAudit->setMdsResidentLastName($aweberSubscriber->getLastName());
            $aweberMdsSyncAudit->setMdsBikeRackBldg( $aweberSubscriber->getBikeRackBldg() );
            $aweberMdsSyncAudit->setMdsBikeRackLocation( $aweberSubscriber->getBikeRackLocation() );
            $aweberMdsSyncAudit->setMdsBikeRackRoom( $aweberSubscriber->getBikeRackRoom() );
            $aweberMdsSyncAudit->setMdsCeramicsMember( $aweberSubscriber->getCeramicsMember() );
            $aweberMdsSyncAudit->setMdsGardenMember( $aweberSubscriber->getGardenMember() );
            $aweberMdsSyncAudit->setMdsGymMember( $aweberSubscriber->getGymMember() );
            $aweberMdsSyncAudit->setMdsIncAffidavitReceived( $aweberSubscriber->getIncAffidavitReceived() );
            $homeownerInsExpDaysLeft = $aweberSubscriber->getHomeownerInsIntervalRemaining();
            $aweberMdsSyncAudit->setMdsHomeownerInsIntervalRemaining( (isset($homeownerInsExpDaysLeft) and !empty($homeownerInsExpDaysLeft)) ? $homeownerInsExpDaysLeft : NULL );

            $aweberMdsSyncAudit->setMdsIsDogInApt( $aweberSubscriber->getIsDogInApt() );
            $aweberMdsSyncAudit->setMdsParkingLotLocation( $aweberSubscriber->getParkingLotLocation() );
            $aweberMdsSyncAudit->setMdsResidentCategory( $aweberSubscriber->getResidentCategory() );
            $aweberMdsSyncAudit->setMdsStorageClFloorNum( $aweberSubscriber->getStorageClosetFloorNum());
            $aweberMdsSyncAudit->setMdsStorageLkrClBldg( $aweberSubscriber->getStorageLockerClosetBldg() );
            $aweberMdsSyncAudit->setMdsStorageLkrNum( $aweberSubscriber->getStorageLockerNum() );
            $aweberMdsSyncAudit->setMdsToddlerRmMember( $aweberSubscriber->getToddlerRoomMember() );
            $aweberMdsSyncAudit->setMdsYouthRmMember( $aweberSubscriber->getYouthRoomMember() );
            $aweberMdsSyncAudit->setMdsWoodworkingMember( $aweberSubscriber->getWoodworkingMember() );
            $vehicleRegExpDaysLeft = $aweberSubscriber->getVehicleRegIntervalRemaining();
            $aweberMdsSyncAudit->setMdsVehicleRegIntervalRemaining( (isset($vehicleRegExpDaysLeft) and !empty($vehicleRegExpDaysLeft)) ? $vehicleRegExpDaysLeft : NULL );

            try {

                $this->getEntityManager()->persist($aweberMdsSyncAudit);

                if ($flush) {
                    $this->getEntityManager()->flush();
                    $this->getEntityManager()->clear();
                }
            }
            catch (\Exception $exception) {
                // todo : should add logging here
                print("\n Exception encountered in MdsToAweberComparator->insertAweberMdsSyncAudit. Exception->getMessage: " . $exception->getMessage() . "\n");
                throw $exception;
            }

        }

    /**
     *  Truncate the AweberMdsSyncAudit table.
     *  Every run of this program should initialize by truncating all rows in the AweberSyncAudit table; no
     *    need to keep an audit trail of earlier runs of the program.
     *  This code follows recommendation for truncate table using Doctrine found here: http://stackoverflow.com/questions/9686888/how-to-truncate-a-table-using-doctrine-2
     */
        private function truncateAweberMdsSyncAudit() {

            try {
                $aweberMdsSyncAuditClassName = 'AweberMdsSyncAudit'; // className
                $cmd = $this->getEntityManager()->getClassMetadata($aweberMdsSyncAuditClassName);
                $connection = $this->getEntityManager()->getConnection();
                $dbPlatform = $connection->getDatabasePlatform();
                $connection->query('SET FOREIGN_KEY_CHECKS=0'); // no foreign key references in this instance, but put in place
                //  in the event of any change in the future
                $q = $dbPlatform->getTruncateTableSQL($cmd->getTableName());
                $connection->executeUpdate($q);
                $connection->query('SET FOREIGN_KEY_CHECKS=1'); // no foreign key references in this instance, but no harm in
                //  having this in place
                $connection->close();
            }
            catch (Exception $exception) {
                // todo: should add logging here...
                print("\n Exception encountered in MdsToAweberComparator->truncateAweberMdsSyncAudit. Exception->getMessage: " . $exception->getMessage() . "\n");
                throw $exception;
            }

        }

    /**
     * deletes rows from the AweberMdsSyncAudit table that have a value in the update_action column
     *   matching that of the input parameter.
     *  If the $updateAction parameter has a null value, the entire table is truncated.
     * @param $updateAction
     */
        private function deleteAweberMdsSyncAuditByUpdateAction($updateAction) {

            if ( is_null($updateAction)) {
                $this->truncateAweberMdsSyncAudit();
            }
            else {
                if ($updateAction == self::ACTION_REASON_NO_MATCHING_EMAIL_IN_MDS) {
                    $updateAction = self::UPDATE_ACTION_REPORTING;
                }
               // $aweberMdsSyncAuditEntityName = 'AweberMdsSyncAudit'; // className
               // $cmd = $this->getEntityManager()->getClassMetadata($aweberMdsSyncAuditClassName);
               // $connection = $cmd->getCon
                $connection = $this->getEntityManager()->getConnection();
                //$dbPlatform = $connection->getDatabasePlatform();
                try {
                    $connection->beginTransaction();
                    $queryBuilder = $connection->createQueryBuilder();
                    $queryBuilder
                        ->delete(AweberFieldsConstants::AWEBER_MDS_SYNC_AUDIT_TABLE_NAME)
                        ->where('Update_Action = ?')
                        ->setParameter(0, $updateAction);
                    $queryBuilder->execute();
                    $connection->commit();
                    $connection->close();

                } catch (Exception $exception) {
                    // todo : should add logging here...
                    print("\n Exception encountered in MdsToAweberComparator->deleteAweberMdsSyncAuditByUpdateAction. Exception->getMessage: " . $exception->getMessage() . "\n");
                    $connection->rollBack();
                    throw $exception;
                }

            }

        }

    /**
     * This function is only invoked in initial stages of project to compare Aweber with MDS. It should not be needed
     *   once MDS is brought into sync with Aweber and once all inputting of email addresses is accomplished in MDS.
     * @param AweberSubscriber $aweberSubscriber
     * @param $listName
     * @param $currDate
     * @param $flush - true/false - for better performance, limit number of flushes (commits) to batch of inserts.
     */
    private function createAweberMdsSyncAuditNoMdsSubscriber(AweberSubscriber $aweberSubscriber, $listName, $currDate, $flush) {


        $aweberMdsSyncAudit = new AweberMdsSyncAudit();
        // set attributes of $aweberMdsSyncAudit...
        $aweberMdsSyncAudit->setAweberSubscriberListName($listName);
        $aweberMdsSyncAudit->setSubscriberEmailAddress($aweberSubscriber->getEmail());
        $aweberMdsSyncAudit->setAweberBuilding($aweberSubscriber->getPennSouthBuilding());
        $aweberMdsSyncAudit->setAweberFloorNumber($aweberSubscriber->getFloorNumber());
        $aweberMdsSyncAudit->setAweberAptLine($aweberSubscriber->getApartment());
        $aweberMdsSyncAudit->setAweberSubscriberStatus($aweberSubscriber->getStatus());
        $aweberMdsSyncAudit->setAweberSubscriberName($aweberSubscriber->getName());
        if ($aweberSubscriber->getSubscribedAt() != null) {
            $subscribedAtDate = \DateTime::createFromFormat('Y-m-d', $aweberSubscriber->getSubscribedAt()); // need the backward slash to address namespace issue.
            $aweberMdsSyncAudit->setAweberSubscribedAt($subscribedAtDate);
        }
        if ($aweberSubscriber->getUnsubscribedAt() != null) {
            $unSubscribedAtDate = \DateTime::createFromFormat('Y-m-d', $aweberSubscriber->getUnsubscribedAt()); // need the backward slash to address namespace issue.
            $aweberMdsSyncAudit->setAweberUnsubscribedAt($unSubscribedAtDate);
        }
        $aweberMdsSyncAudit->setAweberSubscriptionMethod($aweberSubscriber->getSubscriptionMethod());
        $aweberMdsSyncAudit->setUpdateAction(self::UPDATE_ACTION_REPORTING);
        $aweberMdsSyncAudit->setActionReason(self::ACTION_REASON_NO_MATCHING_EMAIL_IN_MDS);
        $aweberMdsSyncAudit->setLastChangedDate($currDate);

        try {

            $this->getEntityManager()->persist($aweberMdsSyncAudit);

            if ($flush) {
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        }
        catch (Exception $exception) {
            // todo : should add logging here
            print("\n Exception encountered in MdsToAweberComparator->createAweberMdsSyncAuditNoMdsSubscriber. Exception->getMessage: " . $exception->getMessage() . "\n");
            throw $exception;
        }
    }

    private function flushAndClearEntityManager() {

        try {
            $this->getEntityManager()->flush();
            $this->getEntityManager()->clear();
           // $this->getEntityManager()->commit();
           // $this->getEntityManager()->close();
        }
        catch (Exception $exception) {
            // todo : should add logging here
            print("\n Exception encountered in MdsToAweberComparator->flushAndClearEntityManager. Exception->getMessage: " . $exception->getMessage() . "\n");
            throw $exception;
        }

    }

}

