<?php
/**
 * MdsToAweberUpdater.php
 * User: sfrizell
 * Date: 10/10/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Command;

use Doctrine\ORM\EntityManager;
use Pennsouth\MdsBundle\AweberEntity\AweberSubscriber;
use Pennsouth\MdsBundle\Entity\PennsouthResident;
use Pennsouth\MdsBundle\Entity\AweberMdsSyncAudit;
use Pennsouth\MdsBundle\AweberEntity\AweberSubscriberUpdateInsertLists;

class MdsToAweberComparator
{
    const UPDATE = 'update';
    const INSERT = 'insert';
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
     *
     */
    public function compareAweberWithMds() {
        // todo: write this function!! Loop through pennsouthResidents : if match found in either aweber subscriber list, update the custom fields - what if currently unsuscribed??
        // todo:     if no match found, insert subscriber to pennsouth newsletter list  */

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
                                $foundEmailAddressInAweber = TRUE;
                                if ($aweberSubscriber->getStatus() == 'subscribed') {
                                    // if no differences detected between current Aweber and MDS input, the function returns null;d

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


    /**
      *  find all subscribers with email addresses in Aweber where there is no match on email address in MDS Export.
      *  For each such instance write a row to the Aweber_Mds_Sync_Audit table
      *
      */
     public function reportOnAweberSubscribersWithNoMatchInMds() {
         $currDate = new \DateTime("now");
         $j = 0;
         foreach ($this->aweberSubscribersByListNames as $aweberSubscribers) {
             $j++;

             foreach ($aweberSubscribers as $listName => $aweberSubscriberList) { // after the 'as' each is a list of subscribers?
                 print("\n" . "MdsToAweberUpdater - listname: " . $listName);
                 $batchSize = 20; // call entityManager->flush after this # of inserts...
                 $insertBatchCtr = 0;
                 foreach ($aweberSubscriberList as $aweberSubscriber) {
                     print("\n" . "!!!!!!!!!!!   aweberSubscriber in MdsToAweberUpdate... !!!!!!!!!!" . "\n");
                     print_r($aweberSubscriber);
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
        if ($aweberSubscriber->getSubscribedAt() != null ) {
            $subscribedAtDate = \DateTime::createFromFormat('Y-m-d', $aweberSubscriber->getSubscribedAt()); // need the backward slash to address namespace issue.
            $aweberMdsSyncAudit->setAweberSubscribedAt($subscribedAtDate);
        }
        if ($aweberSubscriber->getUnsubscribedAt() != null) {
            $unSubscribedAtDate = \DateTime::createFromFormat('Y-m-d', $aweberSubscriber->getUnsubscribedAt()); // need the backward slash to address namespace issue.
            $aweberMdsSyncAudit->setAweberUnsubscribedAt($unSubscribedAtDate);
        }
        $aweberMdsSyncAudit->setAweberSubscriptionMethod($aweberSubscriber->getSubscriptionMethod());
        $aweberMdsSyncAudit->setActionReason('No matching email found in MDS');
        $aweberMdsSyncAudit->setLastChangedDate($currDate);


        $this->getEntityManager()->persist($aweberMdsSyncAudit);

        if ($flush) {
            $this->getEntityManager()->flush();
            $this->getEntityManager()->clear();
        }

    }

}

