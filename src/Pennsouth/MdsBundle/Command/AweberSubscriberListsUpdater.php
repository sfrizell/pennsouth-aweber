<?php
/**
 * AweberSubscriberListsUpdater.php
 * User: sfrizell
 * Date: 11/4/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Command;

use AWeberAPI;
use AWeberAPIException;
use Pennsouth\MdsBundle\AweberEntity\AweberFieldsConstants;
use Pennsouth\MdsBundle\AweberEntity\AweberSubscriber;
use Pennsouth\MdsBundle\AweberEntity\AweberSubscriberUpdateInsertLists;

class AweberSubscriberListsUpdater
{

    private $aweberSubscriberUpdateInsertLists;
    private $account;
    public $aweberApiInstance;
   // private $pathToAweber = '/vendor/aweber/aweber/aweber_api/aweber_api.php';
    private $fullPathToAweber;
    private $emailNotificationLists;

    public function __construct($fullPathToAweber, $aweberApiInstance) {

        $this->aweberApiInstance    = $aweberApiInstance;
        $this->fullPathToAweber     = $fullPathToAweber;

        // is the following require_once needed? maybe just needs to be passed to invoked methods since there are no calls to Aweber API in this class...
       //  require_once $fullPathToAweber;
           // $this->pathToAweber = $rootDir . $this->pathToAweber;

         //   require_once $this->pathToAweber;
           //require_once $rootDir . '/vendor/aweber/aweber/aweber_api/aweber_api.php';
       }

    /**
     * Using results of comparison of MDS Resident information to Aweber Subscriber list (stored in AweberSubscriberUpdateInsertLists array)
     *  update Aweber Subscriber Lists (Insert new subscribers / Update existing subscribers)
     * @param $account - aWeberAccount
     * @param AweberSubscriberUpdateInsertLists $aweberSubscriberUpdateInsertLists - container for results of comparison of MDS to Aweber
     */
    public function updateAweberSubscriberLists($account, AweberSubscriberUpdateInsertLists $aweberSubscriberUpdateInsertLists) {

        $this->account = $account;
        $this->aweberSubscriberUpdateInsertLists = $aweberSubscriberUpdateInsertLists;
        $errorMessages = array();

        // Are there resident email addresses in MDS with no match in Aweber? If so insert the subscriber into Aweber
        if (!$this->aweberSubscriberUpdateInsertLists->isAweberSubscriberInsertListEmpty()) {
            $aweberSubscriberWriter = new AweberSubscriberWriter($this->aweberApiInstance);
           // $aweberSubscriberWriter = new AweberSubscriberWriter($this->fullPathToAweber, $this->aweberApiInstance);
            $insertCtr = 0;
           // $batchSize = 30;
            foreach ($this->aweberSubscriberUpdateInsertLists->getAweberSubscriberInsertList() as $aweberSubscriberByListName) {
                foreach ($aweberSubscriberByListName as $listName => $aweberSubscriber) {
                    $insertCtr++;
                    // should not need the sleep block below since we are slowing down the pace in the SubscriberWriter itself...
/*                    if (($insertCtr % $batchSize) === 0) { // evaluates to zero $batchSize iterations through the cycle...
                        sleep(65);
                    }*/
                        try {

/*                            if ($aweberSubscriber->getEmail() == 'sfnyc.net@gmail.com') {
                                print("\n" . "-------   AweberSubscriberListsUpdater - found sfnyc.net@gmail.com email address for insert   ----------");
                                print("\n" . "listName: " . $listName);
                                //print_r($aweberSubscriber);
                                // insert the AweberSubscriber in the subscriber list...
                                $aweberSubscriberWriter->createAweberSubscriber($listName, $aweberSubscriber);
                            }*/
                            // todo : uncomment the following after testing...
                            $errorMessage = $aweberSubscriberWriter->createAweberSubscriber( $listName, $aweberSubscriber);
                            if (!is_null($errorMessage)) {
                                $errorMessages[] = $errorMessage;
                            }

                        } // end catch exception block
                        catch (\Exception $exception) {
                            print ("\n" . "Exception caught in AweberSubscriberListsUpdater->updateAweberSubscriberLists insert subscribers section. \n");
                            print ("\n" . "Exception->getMessage(): " . $exception->getMessage() . "\n");
                            print ("\n" . "Exception->getCode: " . $exception->getCode());
                            throw $exception;
                        }
                } // inner foreach
            } // outer foreach
        }

        // Check for resident email addrresses in MDS where Aweber custom fields don't match the values in MDS for the given resident?
        // If so, update Aweber subscriber
        if (!$this->aweberSubscriberUpdateInsertLists->isAweberSubscriberUpdateListEmpty()) {
            $aweberSubscriberWriter = new AweberSubscriberWriter( $this->aweberApiInstance);
           // $aweberSubscriberWriter = new AweberSubscriberWriter($this->fullPathToAweber, $this->aweberApiInstance);
            $updateCtr = 0;
            //$batchSize = 30;
            foreach ($this->aweberSubscriberUpdateInsertLists->getAweberSubscriberUpdateList() as $aweberSubscriberByListName ) {
                foreach ( $aweberSubscriberByListName as $listName => $aweberSubscriber) {
                    $updateCtr++;
                    // the block below to sleep should not be necessary as it is in the updateAweberSubscriber method...
   /*                 if (($updateCtr % $batchSize) === 0) {
                        sleep(60);
                    }*/
                    try {
                        // todo : remove the following after testing...
                       // if ($aweberSubscriber->getEmail() == 'steve.frizell@gmail.com') {
                      //  if ($aweberSubscriber->getCeramicsMember() == 'Y') {
                          // print("\n" . "-------   AweberSubscriberListsUpdater - found steve.frizell email address for update   ----------");
                         //   print("\n" . "-------   AweberSubscriberListsUpdater - \$aweberSubscriber->getCeramicsMember() == 'Y'   ----------");
                         //  print("\n" . "listName: " . $listName);
                           //print_r($aweberSubscriber);
                           // update the AweberSubscriber in the subscriber list...
                           // $aweberSubscriberWriter->updateAweberSubscriber($listName, $aweberSubscriber);
                      // }
                        // update the AweberSubscriber...
                        $aweberSubscriberWriter->updateAweberSubscriber( $listName, $aweberSubscriber);
                    }
                    catch (\Exception $exception) {
                         {
                            print("\n" . "Exception caught in AweberSubscriberListsUpdater->updateAweberSubscriberLists update subscribers section.\n");
                             print ("Exception->getMessage() : \n" . $exception->getMessage());
                            print("\n" . "Exiting from AweberSubscriberListsUpdater->updateAweberSubscriberLists method and throwing same exception.");
                            throw $exception;
                        }
                    }
                }
            }
        }

        return $errorMessages; // array that is either empty or that contains error message strings...
    }
}