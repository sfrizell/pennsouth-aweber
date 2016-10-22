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

class MdsToAweberUpdater
{
    private $entityManager;
    private $pennsouthResidents; // array of PennsouthResident entities having email addresses
    private $aweberSubscribersWithListNameKeys; // associative array : key = Aweber Subscriber List Name ; value = array of AWeberSubscriber objects

    public function __construct(EntityManager $entityManager, $pennsouthResidents, $aweberSubscribersWithListNameKey)
    {
        $this->entityManager                    = $entityManager;
        $this->pennsouthResidents               = $pennsouthResidents;
        $this->aweberSubscribersWithListNameKeys = $aweberSubscribersWithListNameKey;
        date_default_timezone_set('America/New_York');
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     *
     */
    public function compareAndUpdateAweberFromMds() {
        // todo: write this function!! Loop through pennsouthResidents : if match found in either aweber subscriber list, update the custom fields - what if currently unsuscribed??
        // todo:     if no match found, insert subscriber to pennsouth newsletter list  */

    }

    /**
     *  find all subscribers with email addresses in Aweber where there is no match on email address in MDS Export.
     *  For each such instance write a row to the Aweber_Mds_Sync_Audit table
     *
     */
    public function reportOnAweberSubscribersWithNoMatchInMds() {
        $currDate = new \DateTime("now");
        $j = 0;
        foreach ($this->aweberSubscribersWithListNameKeys as $listName => $aweberSubscribers) {
            $j++;
            print("\n" . "MdsToAweberUpdater - listname: " . $listName);
            foreach ($aweberSubscribers as $aweberSubscriberList) { // after the 'as' each is a list of subscribers?
                $batchSize = 20; // call entityManager->flush after this # of inserts...
                $insertBatchCtr = 0;
                foreach ($aweberSubscriberList as $aweberSubscriber) {
                    //print("\n" . "!!!!!!!!!!!   aweberSubscriber in MdsToAweberUpdate... !!!!!!!!!!" . "\n");
                    //print_r($aweberSubscriber);
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
                      /*  if ($insertBatchCtr > $batchSize) {
                            $insertBatchCtr = 0;
                        }*/
                    }
                }
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            } // foreach aweberSubscribers
        } // foreach aweberSubscribersWithListNameKeys...

    }

    private function createAweberMdsSyncAuditNoMdsSubscriber(AweberSubscriber $aweberSubscriber, $listName, $currDate, $flush) {

        // todo: add subscriber name to AweberMdsSyncAudit... 10/18/2016
        $aweberMdsSyncAudit = new AweberMdsSyncAudit();
        // set attributes of $aweberMdsSyncAudit...
        $aweberMdsSyncAudit->setAweberSubscriberListName($listName);
        $aweberMdsSyncAudit->setSubscriberEmailAddress($aweberSubscriber->getEmail());
        $aweberMdsSyncAudit->setAweberBuilding($aweberSubscriber->getPennSouthBuilding());
        $aweberMdsSyncAudit->setAweberFloorNumber($aweberSubscriber->getFloorNumber());
        $aweberMdsSyncAudit->setAweberAptLine($aweberSubscriber->getApartment());
        $aweberMdsSyncAudit->setAweberSubscriberStatus($aweberSubscriber->getStatus());
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

