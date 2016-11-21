<?php
/**
 * MdsToAweberUpdater.php
 * User: sfrizell
 * Date: 10/10/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Command;

use Doctrine\ORM\EntityManager;
use Pennsouth\MdsBundle\AweberEntity\AweberFieldsConstants;
use Pennsouth\MdsBundle\AweberEntity\AweberSubscriber;
use Pennsouth\MdsBundle\AweberEntity\AweberUpdateSummary;
use Pennsouth\MdsBundle\Entity\PennsouthResident;
use Pennsouth\MdsBundle\Entity\AweberMdsSyncAudit;
use Pennsouth\MdsBundle\AweberEntity\AweberSubscriberUpdateInsertLists;
use Symfony\Component\Config\Definition\Exception\Exception;

class MdsToAweberComparator
{
    const UPDATE = 'update';
    const INSERT = 'insert';
    const ACTION_REASON_NO_MATCHING_EMAIL_IN_MDS = "No matching email found in MDS.";
    private $entityManager;
    private $pennsouthResidents; // array of PennsouthResident entities having email addresses
    private $aweberSubscribersByListNames; // associative array : key = Aweber Subscriber List Name ; value = array of AWeberSubscriber objects
    public function __construct(EntityManager $entityManager, $pennsouthResidents, $aweberSubscribersByListNames)
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
     *    if no match found, then we want to insert a new subscriber into the aweber Penn South Newsletter subscriber list from the MDS resident data.
     *  No updates to Aweber are performed in this method. An instance of AweberSubscriberUpdateInsertLists is returned by the method, which is used subsequently
     *    to perform the inserts/update into the Aweber subscriber lists.
     * @return AweberSubscriberUpdateInsertLists - list of Aweber subscribers to insert or update.
     */
    public function compareAweberWithMds() {

        $aweberSubscribersUpdateList = array();
        $aweberSubscribersInsertList = array();
       // $aweberSubscriberToSave = new AweberSubscriber();
        foreach ($this->pennsouthResidents as $pennsouthResident) {
            $foundEmailAddressInAweber = false;
            foreach ($this->aweberSubscribersByListNames as $aweberSubscribers) {
                foreach ($aweberSubscribers as $listName => $aweberSubscriberList) {
                   // if ($listName == AweberSubscriberListReader::AWEBER_PENNSOUTH_NEWSLETTER_LIST) {
                        foreach ($aweberSubscriberList as $aweberSubscriber) {
                            if (strtolower($aweberSubscriber->getEmail()) == strtolower($pennsouthResident->getEmailAddress())) {
                                $foundEmailAddressInAweber = true;
                                if ($aweberSubscriber->getStatus() == 'subscribed') {
                                    // if no differences detected between current Aweber and MDS input, the function returns null

                                    $aweberSubscriberToSave = $this->createAweberSubscriberFromMdsInput(self::UPDATE, $pennsouthResident, $aweberSubscriber);
                                    if (!is_null($aweberSubscriberToSave)) {
                                       $aweberSubscriberbyListName = [ $listName => $aweberSubscriberToSave];
                                       $aweberSubscribersUpdateList[] = $aweberSubscriberbyListName;
                                    }
                                }
                                break;
                            }
                        }
                   // }
                }
            } // end foreach of loop through $aweberSubscribersByListName
            if (!$foundEmailAddressInAweber) {
                $aweberSubscriberToSave = $this->createAweberSubscriberFromMdsInput(self::INSERT, $pennsouthResident, $aweberSubscriber);
                // inserts are only to Penn South Newsletter subscriber list...
                $aweberSubscriberbyListName = [AweberSubscriberListReader::AWEBER_PENNSOUTH_NEWSLETTER_LIST => $aweberSubscriberToSave];
                $aweberSubscribersInsertList[] = $aweberSubscriberbyListName;
            }
        }


        $aweberSubscriberUpdateInsertLists = new AweberSubscriberUpdateInsertLists();

        $aweberSubscriberUpdateInsertLists->setAweberSubscriberInsertList($aweberSubscribersInsertList);
        $aweberSubscriberUpdateInsertLists->setAweberSubscriberUpdateList($aweberSubscribersUpdateList);

        return $aweberSubscriberUpdateInsertLists;

    }

    /**
     *  Compare $pennsouthResident (MDS Export file data) with $aweberSubscriber (AWeber subscriber data)
     *           If values are different, return an instance of $aweberSubscriber updated to reflect the values
     *            from MDS. Otherwise return null.
     * @param $pennsouthResident
     * @param $aweberSubscriber
     */
    private function createAweberSubscriberFromMdsInput($updateOrInsert, PennsouthResident $pennsouthResident, AweberSubscriber $aweberSubscriber) {

        $aweberUpdateRequired = false;
        if ($updateOrInsert == self::UPDATE) {
            $aweberUpdateRequired = $this->doesAweberRequireUpdate($pennsouthResident, $aweberSubscriber);
        }

        if ($updateOrInsert == self::INSERT or $aweberUpdateRequired) {
            $aweberSubscriber = new AweberSubscriber();
            $aweberSubscriber->setResidentCategory($pennsouthResident->getMdsResidentCategory());
            $aweberSubscriber->setParkingLotLocation($pennsouthResident->getParkingLotLocation());
            $aweberSubscriber->setIsDogInApt($pennsouthResident->getIsDogInApt());
            $aweberSubscriber->setStorageLockerClosetBldg($pennsouthResident->getStorageLockerClosetBldgNum());
            $aweberSubscriber->setStorageLockerNum($pennsouthResident->getStorageLockerNum());
            $aweberSubscriber->setStorageClosetFloorNum($pennsouthResident->getStorageClosetFloorNum());
            $aweberSubscriber->setBikeRackBldg($pennsouthResident->getBikeRackBldg());
            $aweberSubscriber->setBikeRackRoom($pennsouthResident->getBikeRackRoom());
            $aweberSubscriber->setWoodworkingMember($pennsouthResident->getWoodworkingMember());
            $aweberSubscriber->setHomeownerInsExpDateLeft($pennsouthResident->getHomeownerInsExpCountdown());
            $aweberSubscriber->setYouthRoomMember($pennsouthResident->getYouthRoomMember());
            $aweberSubscriber->setApartment($pennsouthResident->getAptLine());
            $aweberSubscriber->setPennSouthBuilding($pennsouthResident->getBuilding());
            $aweberSubscriber->setFloorNumber($pennsouthResident->getFloorNumber());
            $aweberSubscriber->setResidentCategory($pennsouthResident->getMdsResidentCategory());
            $aweberSubscriber->setCeramicsMember($pennsouthResident->getCeramicsMember());
            $aweberSubscriber->setGardenMember($pennsouthResident->getGardenMember());
            $aweberSubscriber->setGymMember($pennsouthResident->getGymMember());
            $aweberSubscriber->setHomeownerInsExpDateLeft($pennsouthResident->getHomeownerInsExpCountdown());
            $aweberSubscriber->setVehicleRegExpDaysLeft($pennsouthResident->getVehicleRegExpCountdown());
            $aweberSubscriber->setToddlerRoomMember($pennsouthResident->getToddlerRoomMember());
            $aweberSubscriber->setName($pennsouthResident->getFirstName() . " " . $pennsouthResident->getLastName());
            $aweberSubscriber->setFirstName($pennsouthResident->getFirstName());
            $aweberSubscriber->setLastName($pennsouthResident->getLastName());
            return $aweberSubscriber;
        }

        return null;

    }

    /**
     * - Compare Aweber subscriber data ($aweberSubscriber) with MDS Export File data ($pennsouthResident) for subscriber with same email address.
     * @param $pennsouthResident
     * @param $aweberSubscriber
     *  return: true if there are any data differences in name or custom fields between Aweber and MDS Export file data; otherwise return false.
     */
    private function doesAweberRequireUpdate(PennsouthResident $pennsouthResident, AweberSubscriber $aweberSubscriber) {

        $doesAweberRequireUpdate = false;
        if ($aweberSubscriber->getApartment()               !== $pennsouthResident->getAptLine()                        or
            $aweberSubscriber->getPennSouthBuilding()       !== $pennsouthResident->getBuilding()                       or
            $aweberSubscriber->getFloorNumber()             !== $pennsouthResident->getFloorNumber()                    or
            $aweberSubscriber->getCeramicsMember()          !== $pennsouthResident->getCeramicsMember()                 or
            $aweberSubscriber->getGardenMember()            !== $pennsouthResident->getGardenMember()                   or
            $aweberSubscriber->getGymMember()               !== $pennsouthResident->getGymMember()                      or
            $aweberSubscriber->getToddlerRoomMember()       !== $pennsouthResident->getToddlerRoomMember()              or
            $aweberSubscriber->getHomeownerInsExpDateLeft() !== $pennsouthResident->getHomeownerInsExpCountdown()       or
            $aweberSubscriber->getIsDogInApt()              !== $pennsouthResident->getIsDogInApt()                     or
            $aweberSubscriber->getStorageLockerClosetBldg() !== $pennsouthResident->getStorageLockerClosetBldgNum()     or
            $aweberSubscriber->getStorageLockerNum()        !== $pennsouthResident->getStorageLockerNum()               or
            $aweberSubscriber->getStorageClosetFloorNum()   !== $pennsouthResident->getStorageClosetFloorNum()          or
            $aweberSubscriber->getBikeRackBldg()            !== $pennsouthResident->getBikeRackBldg()                   or
            $aweberSubscriber->getBikeRackRoom()            !== $pennsouthResident->getBikeRackRoom()                   or
            $aweberSubscriber->getParkingLotLocation()      !== $pennsouthResident->getParkingLotLocation()             or
            $aweberSubscriber->getResidentCategory()        !== $pennsouthResident->getMdsResidentCategory()            or
            $aweberSubscriber->getVehicleRegExpDaysLeft()   !== $pennsouthResident->getVehicleRegExpCountdown()         or
            $aweberSubscriber->getWoodworkingMember()       !== $pennsouthResident->getWoodworkingMember()              or
            $aweberSubscriber->getYouthRoomMember()         !== $pennsouthResident->getYouthRoomMember()                or
            $aweberSubscriber->getName()                    !== ($pennsouthResident->getFirstName() . " " . $pennsouthResident->getLastName())
        ) {
            $doesAweberRequireUpdate = true;
        }

        return $doesAweberRequireUpdate;

    }


    public function storeAuditTrailofUpdatesToAweberSubscribers(AweberSubscriberUpdateInsertLists $aweberSubscriberUpdateInsertLists) {

        $aweberUpdateSummary = new AweberUpdateSummary();


        $currDate = new \DateTime("now");
        // $isAweberMdsSyncAuditDeleted = false;
        if (!$aweberSubscriberUpdateInsertLists->isAweberSubscriberInsertListEmpty()) {
                    $insertCtr = 0;
                    $batchSize = 40;
                    $actionReason = self::INSERT;
                    $this->deleteAweberMdsSyncAuditByActionReason($actionReason);
                   // $isAweberMdsSyncAuditDeleted = true;
                    $saveListName = null;
                    foreach ($aweberSubscriberUpdateInsertLists->getAweberSubscriberInsertList() as $listName => $aweberSubscriber) {
                       // $saveListName = $listName;
                        if (!array_key_exists($listName, $aweberUpdateSummary->getListInsertArrayCtr())) {
                            $aweberUpdateSummary->initializeListInsertArrayCtr($listName);
                        }
                        else {
                            $aweberUpdateSummary->incrementListInsertArrayCtr($listName);
                        }
                        $insertCtr++;
                        if (($insertCtr % $batchSize) === 0) {
                            $flush = true;
                        }
                        else {
                            $flush = false;
                        }
                        $this->insertAweberMdsSyncAudit( $aweberSubscriber, AweberFieldsConstants::AWEBER_PENNSOUTH_NEWSLETTER_LIST, $currDate, $flush, $actionReason );
                    }

        }

        if (!$aweberSubscriberUpdateInsertLists->isAweberSubscriberUpdateListEmpty()) {
         /*   if (!$isAweberMdsSyncAuditDeleted) {
                $this->truncateAweberMdsSyncAudit();
            }*/
            $actionReason = self::UPDATE;
            $this->deleteAweberMdsSyncAuditByActionReason($actionReason);
            $insertCtr = 0;
            $batchSize = 40;
            foreach ($aweberSubscriberUpdateInsertLists->getAweberSubscriberUpdateList() as $listName => $aweberSubscriber) {
                if (!array_key_exists($listName, $aweberUpdateSummary->getListUpdateArrayCtr())) {
                    $aweberUpdateSummary->initializeListUpdateArrayCtr($listName);
                }
                else {
                    $aweberUpdateSummary->incrementListUpdateArrayCtr($listName);
                }
                $insertCtr++;
                if (($insertCtr % $batchSize) === 0) {
                    $flush = true;
                }
                else {
                    $flush = false;
                }
                $this->insertAweberMdsSyncAudit( $aweberSubscriber, $listName,  $currDate, $flush, $actionReason );
            }
        }

        return $aweberUpdateSummary;

    }


    /**
      *  Find all subscribers with email addresses in Aweber where there is no match on email address in MDS Export.
      *  For each such instance write a row to the Aweber_Mds_Sync_Audit table
      *
      */
     public function reportOnAweberSubscribersWithNoMatchInMds() {

         $this->deleteAweberMdsSyncAuditByActionReason(self::ACTION_REASON_NO_MATCHING_EMAIL_IN_MDS); // first delete any entries in the Audit table from a previous run for this actionReason...
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
                     $is_subscriber_in_mds = FALSE;
                     foreach ($this->pennsouthResidents as $pennsouthResident) {
                        // print("\n" . "!!!!!!!!!!!   aweberSubscriber in MdsToAweberUpdate... !!!!!!!!!!" . "\n");
                        // print_r($aweberSubscriber);
                        // print("\n" . "!!!!!!!!!!!   aweberSubscriber getEmail... !!!!!!!!!!" . "\n");
                        // print($aweberSubscriber->getEmail());
                         if (strtolower($aweberSubscriber->getEmail()) == strtolower($pennsouthResident->getEmailAddress())) {
                             $is_subscriber_in_mds = TRUE;
                             break;
                         }

                     }
                     if (!$is_subscriber_in_mds) {
                         $insertBatchCtr++;
                         if (($insertBatchCtr % $batchSize) === 0) {
                             $flush = TRUE;
                         }
                         else {
                             $flush = FALSE;
                         }
                         $this->createAweberMdsSyncAuditNoMdsSubscriber($aweberSubscriber, $listName, $currDate, $flush);
                     }
                 }
                 $this->getEntityManager()->flush();
                 $this->getEntityManager()->clear();
              } // foreach aweberSubscribers
         } // foreach aweberSubscribersWithListNameKeys...

     }

        /**
         * Insert into AweberMdsSyncAudit table to maintain audit trail of updates to Aweber Subscriber lists.
         * @param AweberSubscriber $aweberSubscriber
         * @param $listName
         * @param $currDate
         * @param $flush - true/false - for better performance, limit number of flushes (commits) to batch of inserts.
         * @param  $actionReason - insert/update
         */
        private function insertAweberMdsSyncAudit(AweberSubscriber $aweberSubscriber, $listName, $currDate, $flush, $actionReason) {

            $aweberMdsSyncAudit = new AweberMdsSyncAudit();
            // set attributes of $aweberMdsSyncAudit...

            $aweberMdsSyncAudit->setAweberSubscriberListName($listName);
            $aweberMdsSyncAudit->setSubscriberEmailAddress($aweberSubscriber->getEmail());
            $aweberMdsSyncAudit->setAweberBuilding($aweberSubscriber->getPennSouthBuilding());
            $aweberMdsSyncAudit->setAweberFloorNumber($aweberSubscriber->getFloorNumber());
            $aweberMdsSyncAudit->setAweberAptLine($aweberSubscriber->getApartment());
            $aweberMdsSyncAudit->setAweberSubscriberStatus($aweberSubscriber->getStatus());
            $aweberMdsSyncAudit->setAweberSubscriberName($aweberSubscriber->getName());
            if ($aweberSubscriber->getSubscribedAt() != null ) {
                $subscribedAtDate = \DateTime::createFromFormat('Y-m-d', $aweberSubscriber->getSubscribedAt()); // need the backward slash to address namespace issue.
                $aweberMdsSyncAudit->setAweberSubscribedAt($subscribedAtDate);
            }
            if ($aweberSubscriber->getUnsubscribedAt() != null) {
                $unSubscribedAtDate = \DateTime::createFromFormat('Y-m-d', $aweberSubscriber->getUnsubscribedAt()); // need the backward slash to address namespace issue.
                $aweberMdsSyncAudit->setAweberUnsubscribedAt($unSubscribedAtDate);
            }
            $aweberMdsSyncAudit->setAweberSubscriptionMethod($aweberSubscriber->getSubscriptionMethod());

            $aweberMdsSyncAudit->setActionReason($actionReason);
            $aweberMdsSyncAudit->setLastChangedDate($currDate);

            $aweberMdsSyncAudit->setMdsAptLine($aweberSubscriber->getApartment());
            $aweberMdsSyncAudit->setMdsBuilding($aweberSubscriber->getPennSouthBuilding());
            $aweberMdsSyncAudit->setMdsFloorNumber($aweberSubscriber->getFloorNumber());
            $aweberMdsSyncAudit->setMdsResidentFirstName($aweberSubscriber->getFirstName());
            $aweberMdsSyncAudit->setMdsResidentLastName($aweberSubscriber->getLastName());

            try {

                $this->getEntityManager()->persist($aweberMdsSyncAudit);

                if ($flush) {
                    $this->getEntityManager()->flush();
                    $this->getEntityManager()->clear();
                }
            }
            catch (Exception $e) {
                // todo : should add logging here
                throw $e;
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
            catch (Exception $e) {
                // todo: should add logging here...
                throw $e;
            }

        }

    /**
     * deletes rows from the AweberMdsSyncAudit table that have a value in the action_reason column
     *   matching that of the input parameter.
     *  If the $actionReason parameter has a null value, the entire table is truncated.
     * @param $actionReason
     */
        private function deleteAweberMdsSyncAuditByActionReason( $actionReason) {

            if ( is_null($actionReason)) {
                $this->truncateAweberMdsSyncAudit();
            }
            else {
                $aweberMdsSyncAuditClassName = 'AweberMdsSyncAudit'; // className
                $cmd = $this->getEntityManager()->getClassMetadata($aweberMdsSyncAuditClassName);
               // $connection = $cmd->getCon
                $connection = $this->getEntityManager()->getConnection();
                //$dbPlatform = $connection->getDatabasePlatform();
                try {
                    $connection->beginTransaction();
                    $queryBuilder = $connection->createQueryBuilder();
                    $queryBuilder
                        ->delete($aweberMdsSyncAuditClassName)
                        ->where('actionReason = ?')
                        ->setParameter(0, $actionReason);
                    $queryBuilder->execute();
                    $connection->commit();
                    $connection->close();

                } catch (Exception $e) {
                    // todo : should add logging here...
                    $connection->rollBack();
                    throw $e;
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
        $aweberMdsSyncAudit->setActionReason(self::ACTION_REASON_NO_MATCHING_EMAIL_IN_MDS);
        $aweberMdsSyncAudit->setLastChangedDate($currDate);

        try {

            $this->getEntityManager()->persist($aweberMdsSyncAudit);

            if ($flush) {
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        }
        catch (Exception $e) {
            // todo : should add logging here
            throw $e;
        }
    }

}

