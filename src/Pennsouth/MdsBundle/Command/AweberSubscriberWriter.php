<?php
/**
 * AweberSubscriberWriter.php
 * User: sfrizell
 * Date: 10/3/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Command;

use AWeberAPI;
use AWeberAPIException;
use Pennsouth\MdsBundle\AweberEntity\AweberSubscriber;
use Pennsouth\MdsBundle\AweberEntity\AweberFieldsConstants;

class AweberSubscriberWriter
{

    private $aweberSubscriber;
    public function __construct($pathToAweber, $aweberApiInstance) {
        require_once $pathToAweber;

        $this->aweberApiInstance = $aweberApiInstance;
       // require_once $rootDir . '/vendor/aweber/aweber/aweber_api/aweber_api.php';

/*        $this->consumerKey = 'Akz4bgpT5FO6EJZm3M0hkYSu';
        $this->consumerSecret = 'WyKB0vnarrzLlzNxpilQfyTzTUzhhOQDLnfhJ3rF';
        $this->accessToken = 'AgulWM43dmHiQn6DiU2wZcdW';
        $this->accessSecret = '34ZYztLI0wgHCTgh3YsCL765hXNVjS7BjAFBcDM2';


        $this->aWeberApi = new AWeberAPI($this->consumerKey, $this->consumerSecret);

        $account = $this->aWeberApi->getAccount($this->accessToken, $this->accessSecret);*/

    }

    public function createAweberSubscriberTest($account, $emailNotificationList, AweberSubscriber $aweberSubscriber) {

        try {



          //  $aweberSubscriber = new AweberSubscriber();

            print("\n -- createAweberSubscriberTest - 1");
//            $aweberSubscriber->setEmail('steve.frizell@gmail.com');
//            $aweberSubscriber->setName('Stephen Frizell');
//            $aweberSubscriber->setFirstName('Stephen');
//            $aweberSubscriber->setLastName('Frizell');

//            $subscriberCustomFields = array();
//            $subscriberCustomFields["Penn_South_Building"] = "1";
//            $subscriberCustomFields["Floor_Number"] = "1";
//            $subscriberCustomFields["Apartment"] = "A";

            $subscriberCustomFields = $this->setCustomFields($aweberSubscriber);

            $params = array();
            $params['name'] = $aweberSubscriber->getName();
            $params['email'] = $aweberSubscriber->getEmail();
            $params['custom_fields'] = $subscriberCustomFields;

            print("\n -- createAweberSubscriberTest - 2");
            $listURL = $emailNotificationList->url;

            print("\n \$listURL: \n" );
            print_r($listURL);

            print("\n ---- issuing command: \$list = \$account->loadFromUrl(\$listURL) \n");

            $list = $account->loadFromUrl($listURL); // aweber API call
            print("\n  -------- \$list: \n" );
            print_r($list );

            print("\n ----------  \$params: \n" );
            print_r( $params);

            print( "\n ********   Issuing command: \$newSubscriber = \$list->subscribers->create(\$params)");

            $newSubscriber = $list->subscribers->create($params);
           // $newSubscriber = $emailNotificationList->subscribers->create($params);
            print("\n -- createAweberSubscriberTest - 3");
            return $newSubscriber;

        }
        catch (AWeberAPIException $exc) {
            print "\n AWeberAPIException in AweberSubscriberWriter->createAweberSubscriberTest \n";
              print "Type: " . $exc->type . "\n";
              print "Msg: " . $exc->message . "\n" ;
              print "Docs: " . $exc->documentation_url . "\n";
        }



    }

    /**
     * For create Subscriber API reference, see: http://engineering.aweber.com/awebers-api-how-to-do-all-the-things/
     * @param $listName
     * @param AweberSubscriber $aweberSubscriber
     * @return mixed
     * @throws \Exception
     * todo : Remove test code for 'frizell' in this method...
     */
    public function createAweberSubscriber( $listName, AweberSubscriber $aweberSubscriber) {



        $j = 0;
        $maxRetries = 1;
        $success = false;
        while (!$success) { // allow for retry if we get rate limit or temporarily unavailable exception...
            try {
                sleep(5); // sleep 5 seconds to avoid Aweber Rate Limit Exception - status code 403
               // $this->aweberSubscriber = $aweberSubscriber;

                // $aweberSubscriber->setEmail('steve.frizell@gmail.com');
                // $aweberSubscriber->setName('Stephen Frizell');

                $subscriberCustomFields = $this->setCustomFields($aweberSubscriber);


                $params = array();
                $params['name'] = $aweberSubscriber->getName();
                $params['ws.op'] = 'create';
                $params['email'] = $aweberSubscriber->getEmail();
                $params['custom_fields'] = $subscriberCustomFields;

                $HTTP_METHOD = 'POST';
                $URL = null;
                if ($listName == AweberFieldsConstants::PRIMARY_RESIDENT_LIST) {
                    if (strtolower($aweberSubscriber->getEmail()) == 'steve.frizell@gmail.com') {
                        $URL = AweberFieldsConstants::FRIZELL_SUBSCRIBER_LIST_TEST_URL . '/subscribers';
                    } else {
                        $URL = AweberFieldsConstants::PRIMARY_RESIDENT_LIST_URL . '/subscribers';
                    }
                } else {
                    if ($listName == AweberFieldsConstants::EMERGENCY_NOTICES_FOR_RESIDENTS) {
                        $URL = AweberFieldsConstants::PENNSOUTH_EMERGENCY_NOTICES_LIST_URL . '/subscribers';
                    } else {
                        throw new \Exception('Exception in AweberSubscriberWriter->createAweberSubscriber function. Could not interpret \$listName! \$listName Value: ' . $listName);
                    }
                }

                print ("\n --------- \$HTTP_METHOD: \n" . $HTTP_METHOD);
                print ("\n ------- \$URL: " . $URL);
                print ("\n ------- \$params: \n");
                print_r($params);

                $RETURN_FORMAT = array(
                    'return' => 'headers'
                );

                print ("\n ------- \$RETURN_FORMAT: \n");
                print_r($RETURN_FORMAT);

                print ("\n --------- \$this->aweberApiInstance \n");

                print_r($this->aweberApiInstance);

                print ("\n ********  Issuing command: \$resp = \$this->aweberApiInstance->adapter->request(\$HTTP_METHOD, \$URL, \$params, \$RETURN_FORMAT) ");

                $resp = $this->aweberApiInstance->adapter->request($HTTP_METHOD, $URL, $params, $RETURN_FORMAT);

                if ($resp['Status-Code'] == 201) { // success
                    // we will be using $subscriber_id in example 3
                    $subscriber_id = array_pop(explode('/', $resp['Location']));
                    return $subscriber_id;
                    //  print "New subscriber added, subscriber_id: {$subscriber_id}\n";
                } else {
                    print ("\n" . "Exception in AweberSubscriberWriter->createAweberSubscriber for subscriber with email address" . $aweberSubscriber->getEmail() . " Aweber API Status-Code: " . $resp['Status-Code']);
                    // throw new \Exception("\n" . "Exception in AweberSubscriberWriter->createAweberSubscriber for subscriber with email address" . $aweberSubscriber->getEmail() . " Aweber API Status-Code: " . $resp['Status-Code']);
                    //print "Failure: " . print_r($resp,1) . "\n";
                }
            }

            catch (AWeberAPIException $exception) {
                 if ($exception->status == "403") { // ServiceUnavailableError
                     $j++;
                     if ($j < $maxRetries) { // 6 is arbitrary number of tries...
                         print("\n" . "AweberAPIException (status = 403 - forbidden / rate limite exceeded) occurred in AweberSubscriberWriter->createAweberSubscriber. ");
                         print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                         sleep(120);
                     } else {
                         print("\n" . "AweberAPIException (status 403) occurred in AweberSubscriberWriter->createAweberSubscriber! Exception->getMessage() : " . $exception->getMessage());
                         print "Type: " . $exception->type . "\n";
                         print("\n" . "Exiting from program.");
                         throw $exception;
                     }
                 } else if ($exception->status == "503") {
                     $j++;
                     if ($j < $maxRetries) { // 6 is arbitrary number of tries...
                         print("\n" . "AweberAPIException (status = 503 - service temporarily unavailable) occurred in AweberSubscriberWriter->createAweberSubscriber. ");
                         print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                         sleep(120);
                     } else {
                         print("\n" . "AweberAPIException (status = 503 - service temporarily unavailable) occurred in AweberSubscriberWriter->createAweberSubscriber! Exception->getMessage() : " . $exception->getMessage());
                         print "Type: " . $exception->type . "\n";
                         print("\n" . "Exiting from program.");
                         throw $exception;
                     }
                 } else {
                     print("\n" . "AweberAPIException occurred in AweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList! Exception->getMessage() : " . $exception->getMessage());
                     print "Type: " . $exception->type . "\n";
                     print "Status: " . $exception->status . "\n";
                     print("\n" . "Exiting from program.");
                     throw $exception;
                 }
             }
        }



    }

    /**
     * To obtain subscriber need to invoke $account->loadFromUrl( $loadUrl)
     *  Format of URL: https://api.aweber.com/1.0/accounts/<id>/lists/<id>/subscribers/<id>
     * Example for obtaining a list:
     *         $listId = AweberFieldsConstants::ADMINS_MDS_TO_AWEBER_LIST_ID;
     *         $accountId = AweberFieldsConstants::PENN_SOUTH_AWEBER_ACCOUNT;
     *         $listURL = "/accounts/{$accountId}/lists/{$listId}"; //
     *         $list = $account->loadFromUrl($listURL)
     * For update API (patch) reference, see: http://engineering.aweber.com/awebers-api-how-to-do-all-the-things/
     * @param $account
     * @param $emailNotificationLists
     * @param $aweberSubscriberUpdateList
     * @return mixed
     */

    public function updateAweberSubscriber( $listName, AweberSubscriber $aweberSubscriber) {


              //  $listURLPennsouthNewsletter = "/accounts/" . AweberFieldsConstants::PENN_SOUTH_AWEBER_ACCOUNT . "/lists/" . AweberFieldsConstants::PRIMARY_RESIDENT_LIST_ID;


             // $subscriberUrl = AweberFieldsConstants::

              //  if ($aweberSubscriber->getEmail() == )

           $HTTP_METHOD = 'PATCH';

            $RETURN_FORMAT = array(
                'return' => 'status'
            );

           $subscriberUrl = null;
           if ($listName == AweberFieldsConstants::PRIMARY_RESIDENT_LIST) {
               $subscriberUrl = AweberFieldsConstants::PRIMARY_RESIDENT_LIST_URL . "/subscribers/" . $aweberSubscriber->getId();
           }
           else {
               if ($listName == AweberFieldsConstants::EMERGENCY_NOTICES_FOR_RESIDENTS) {
                   $subscriberUrl = AweberFieldsConstants::PENNSOUTH_EMERGENCY_NOTICES_LIST_URL . "/subscribers/" . $aweberSubscriber->getId();
               } else {
                   throw new \Exception("Exception in AweberSubscriberWriter->updateAweberSubscriber function. Could not interpret \$listName!");
               }
           }


                try {

                   // $subscriber = $account->loadFromUrl($subscriberUrl);

                    // $aweberSubscriber->setEmail('steve.frizell@gmail.com');
                    // $aweberSubscriber->setName('Stephen Frizell');

                    $subscriberCustomFields = $this->setCustomFields($aweberSubscriber);

                    $params = array();
                    $params['name'] = $aweberSubscriber->getName();
                    $params['email'] = $aweberSubscriber->getEmail();
                    $params['custom_fields'] = $subscriberCustomFields;

                    $resp = $this->aweberApiInstance->adapter->request($HTTP_METHOD, $subscriberUrl, $params, $RETURN_FORMAT);

                    if (!$resp == 209) { // status of 209 means success..
                        throw new \Exception('Failure Aweber API return code in AweberSubscriberWriter->updateAweberSubscriber function. Return code: ' . $resp);
                    }

                    return true;
                    // To update the subscriber entry, make a PATCH request: see: https://labs.aweber.com/docs/reference/1.0#subscriber_entry
                    // update name and custom fields

                    // how do I obtain/create the ->subscribers variable below?
                  //  $newSubscriber = $emailNotificationList->subscribers->create($params);
                  //  return $newSubscriber;

                } catch (AWeberAPIException $exc) {
                    print "AWeberAPIException in AweberSubscriberWriter->updateAweberSubscriber \n";
                    print "Type: " . $exc->type . "\n";
                    print "Msg: " . $exc->message . "\n";
                    print "Docs: " . $exc->documentation_url . "\n";
                    throw $exc;
                }



       }

    /**
     * @param AweberSubscriber $aweberSubscriber
     * @return array of Aweber custom fields built from an instance of AweberSubscriber (which was created/updated from MDS data.
     */
       private function setCustomFields(AweberSubscriber $aweberSubscriber) {

           $subscriberCustomFields = array();
           $subscriberCustomFields[AweberFieldsConstants::BUILDING]                      = $aweberSubscriber->getPennSouthBuilding();
           $subscriberCustomFields[AweberFieldsConstants::FLOOR_NUMBER]                  = $aweberSubscriber->getFloorNumber();
           $subscriberCustomFields[AweberFieldsConstants::APARTMENT]                     = $aweberSubscriber->getApartment();
           $subscriberCustomFields[AweberFieldsConstants::CERAMICS_MEMBER]               = $aweberSubscriber->getCeramicsMember();
           $subscriberCustomFields[AweberFieldsConstants::GARDEN_MEMBER]                 = $aweberSubscriber->getGardenMember();
           $subscriberCustomFields[AweberFieldsConstants::GYM_MEMBER]                    = $aweberSubscriber->getGymMember();
           $subscriberCustomFields[AweberFieldsConstants::TODDLER_ROOM_MEMBER]           = $aweberSubscriber->getToddlerRoomMember();
           $subscriberCustomFields[AweberFieldsConstants::WOODWORKING_MEMBER]            = $aweberSubscriber->getWoodworkingMember();
           $subscriberCustomFields[AweberFieldsConstants::YOUTH_ROOM_MEMBER]             = $aweberSubscriber->getYouthRoomMember();
           $subscriberCustomFields[AweberFieldsConstants::IS_DOG_IN_APT]                 = $aweberSubscriber->getIsDogInApt();
           $subscriberCustomFields[AweberFieldsConstants::STORAGE_LOCKER_CLOSET_BLDG_NUM] = $aweberSubscriber->getStorageLockerClosetBldg();
           $subscriberCustomFields[AweberFieldsConstants::STORAGE_LOCKER_NUM]            = $aweberSubscriber->getStorageLockerNum();
           $subscriberCustomFields[AweberFieldsConstants::STORAGE_CLOSET_FLOOR_NUM]      = $aweberSubscriber->getStorageClosetFloorNum();
           $subscriberCustomFields[AweberFieldsConstants::BIKE_RACK_BLDG]                = $aweberSubscriber->getBikeRackBldg();
           $subscriberCustomFields[AweberFieldsConstants::BIKE_RACK_ROOM]                = $aweberSubscriber->getBikeRackRoom();
           $subscriberCustomFields[AweberFieldsConstants::HOMEOWNER_INS_EXP_DAYS_LEFT]   = $aweberSubscriber->getHomeownerInsExpDateLeft();
           $subscriberCustomFields[AweberFieldsConstants::VEHICLE_REG_EXP_DAYS_LEFT]     = $aweberSubscriber->getVehicleRegExpDaysLeft();
           $subscriberCustomFields[AweberFieldsConstants::PARKING_LOT_LOCATION]          = $aweberSubscriber->getParkingLotLocation();
           $subscriberCustomFields[AweberFieldsConstants::RESIDENT_CATEGORY]             = $aweberSubscriber->getResidentCategory();

           return $subscriberCustomFields;

       }


}