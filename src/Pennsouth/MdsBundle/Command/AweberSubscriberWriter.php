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

    public function __construct( $aweberApiInstance) {
      //  public function __construct($pathToAweber, $aweberApiInstance) {
       // require_once $pathToAweber;

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


            print("\n -- AweberSubscriberWriter->createAweberSubscriberTest - 1 \n");

            print("\n \$aweberSubscriber: \n");
            print_r($aweberSubscriber);
            print ("\n");
/*
           $aweberSubscriber = new AweberSubscriber();


            $aweberSubscriber->setEmail('sfnyc.net@gmail.com');
            $aweberSubscriber->setName('Stephen FrizellTest');
            $aweberSubscriber->setFirstName('Stephen');
            $aweberSubscriber->setLastName('Frizell');
            $aweberSubscriber->setGymMember('Y');
            $aweberSubscriber->setParkingLotLocation('UPPER');
            $aweberSubscriber->setPennSouthBuilding('1');
            $aweberSubscriber->setFloorNumber('2');
            $aweberSubscriber->setApartment('C');*/


          //  $aweberSubscriber->setVehicleRegIntervalRemaining(0);

//            $subscriberCustomFields = array();
//            $subscriberCustomFields['Penn_South_Building'] = '1';
//            $subscriberCustomFields['Floor_Number'] = '1';
//            $subscriberCustomFields['Apartment'] = 'A';

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
     * @return null (interpreted as success) or errorMessage
     * @throws \Exception
     * todo : Remove test code for 'frizell' in this method...
     */
    public function createAweberSubscriber( $listName, AweberSubscriber $aweberSubscriber) {



        $j = 0;
        $maxRetries = 5;
        $success = false;
        $errorMessage = null;
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
                    $URL = AweberFieldsConstants::PRIMARY_RESIDENT_LIST_URL . '/subscribers';
               /*     if (strtolower($aweberSubscriber->getEmail()) == 'sfnyc.net@gmail.com') {
                        $URL = AweberFieldsConstants::FRIZELL_SUBSCRIBER_LIST_TEST_URL . '/subscribers';
                    } else {
                        $URL = AweberFieldsConstants::PRIMARY_RESIDENT_LIST_URL . '/subscribers';
                    }*/
                } else {
                    if ($listName == AweberFieldsConstants::EMERGENCY_NOTICES_FOR_RESIDENTS) {
                        $URL = AweberFieldsConstants::PENNSOUTH_EMERGENCY_NOTICES_LIST_URL . '/subscribers';
                    } else {
                        throw new \Exception('Exception in AweberSubscriberWriter->createAweberSubscriber function. Could not interpret \$listName! \$listName Value: ' . $listName);
                    }
                }

/*                print ("\n --------- \$HTTP_METHOD: \n" . $HTTP_METHOD);
                print ("\n ------- \$URL: " . $URL);
                print ("\n ------- \$params: \n");
                print_r($params);*/

                $RETURN_FORMAT = array(
                    'return' => 'headers'
                );

 /*               print ("\n ------- \$RETURN_FORMAT: \n");
                print_r($RETURN_FORMAT);

                print ("\n --------- \$this->aweberApiInstance \n");

                print_r($this->aweberApiInstance);

                print ("\n ********  Issuing command: \$resp = \$this->aweberApiInstance->adapter->request(\$HTTP_METHOD, \$URL, \$params, \$RETURN_FORMAT) ");*/

                $resp = $this->aweberApiInstance->adapter->request($HTTP_METHOD, $URL, $params, $RETURN_FORMAT);

                if ($resp['Status-Code'] == 201) { // success
                    // we will be using $subscriber_id in example 3
                    // the following commented out line throws a ContextErrorException - Runtime Notice: Only variables should be passed by reference
                   // $subscriber_id = array_pop(explode('/', $resp['Location']));
                    return null; // success
                    //  print "New subscriber added, subscriber_id: {$subscriber_id}\n";
                } else {
                    print ("\n" . "Exception in AweberSubscriberWriter->createAweberSubscriber for subscriber with email address" . $aweberSubscriber->getEmail() . " Aweber API Status-Code: " . $resp['Status-Code']);
                    // throw new \Exception("\n" . "Exception in AweberSubscriberWriter->createAweberSubscriber for subscriber with email address" . $aweberSubscriber->getEmail() . " Aweber API Status-Code: " . $resp['Status-Code']);
                    throw new \Exception("\n" . "Exception in AweberSubscriberWriter->createAweberSubscriber for subscriber with email address" . $aweberSubscriber->getEmail() . " Aweber API Status-Code: " . $resp['Status-Code']);
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
                 } else if ($exception->status == "400") {

                     print("\n" . "AweberAPIException (status = 400 - Email address blocked. Please refer to https://help.aweber.com/entries/97662366 ) occurred in AweberSubscriberWriter->createAweberSubscriber. ");
                     print ("\n" . "skipping this email address: " . $aweberSubscriber->getEmail());
                     $errorMessage = "Aweber API error - status = 400 for email_address: " . $aweberSubscriber->getEmail();
                     return $errorMessage;
                    // return FALSE; // todo - add logic to handle in invoking method...

                 }
                 else if ($exception->type == "APIUnreachableError") {
                     $j++;
                     if ($j < $maxRetries) { // 6 is arbitrary number of tries...
                         print("\n" . "AweberAPIException (type = APIUnreachableError - service temporarily unavailable) occurred in AweberSubscriberWriter->createAweberSubscriber. ");
                         print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                         sleep(120);
                     }
                }
                  else {
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
                   // todo - sfrizell - remove once the application is fully tested...
                   if ($listName == AweberFieldsConstants::FRIZELL_TEST_LIST) {
                       $subscriberUrl = AweberFieldsConstants::FRIZELL_SUBSCRIBER_LIST_TEST_URL . "/subscribers/" . $aweberSubscriber->getId();
                   }
                   else {
                       throw new \Exception("Exception in AweberSubscriberWriter->updateAweberSubscriber function. Could not interpret \$listName: " . $listName . "\n");
                   }
               }
           }


        $j = 0;
        $maxRetries = 5;
        $success = false;
        while (!$success) {
            try {
                sleep(5); // sleep 5 seconds to avoid Aweber Rate Limit Exception - status code 403
                // $subscriber = $account->loadFromUrl($subscriberUrl);

                // $aweberSubscriber->setEmail('steve.frizell@gmail.com');
                // $aweberSubscriber->setName('Stephen Frizell');

                $subscriberCustomFields = $this->setCustomFields($aweberSubscriber);

                $params = array();
                $params['name'] = $aweberSubscriber->getName();
                $params['email'] = $aweberSubscriber->getEmail();
                $params['custom_fields'] = $subscriberCustomFields;

                // todo - remove after debugging...
                //print("\n custom_fields: \n");
                //print_r($subscriberCustomFields);

                //print ("\n subscriberURL: \n");
                //print_r($subscriberUrl);

                $resp = $this->aweberApiInstance->adapter->request($HTTP_METHOD, $subscriberUrl, $params, $RETURN_FORMAT);

                if (!$resp == 209) { // status of 209 means success..
                    throw new \Exception('Failure Aweber API return code in AweberSubscriberWriter->updateAweberSubscriber function. Return code: ' . $resp);
                }
                return TRUE;
                // To update the subscriber entry, make a PATCH request: see: https://labs.aweber.com/docs/reference/1.0#subscriber_entry
                // update name and custom fields

                // how do I obtain/create the ->subscribers variable below?
                //  $newSubscriber = $emailNotificationList->subscribers->create($params);
                //  return $newSubscriber;

            } catch (AWeberAPIException $exception) {
                             if ($exception->status == "403") { // ServiceUnavailableError
                                 $j++;
                                 if ($j < $maxRetries) { //  arbitrary number of tries...
                                     print("\n" . "AweberAPIException (status = 403 - forbidden / rate limite exceeded) occurred in AweberSubscriberWriter->updateAweberSubscriber. ");
                                     print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                                     sleep(120);
                                 } else {
                                     print("\n" . "AweberAPIException (status 403) occurred in AweberSubscriberWriter->updateAweberSubscriber! Exception->getMessage() : " . $exception->getMessage());
                                     print "Type: " . $exception->type . "\n";
                                     print("\n" . "Exiting from program.");
                                     throw $exception;
                                 }
                             } else if ($exception->status == "503") {
                                 $j++;
                                 if ($j < $maxRetries) { // 6 is arbitrary number of tries...
                                     print("\n" . "AweberAPIException (status = 503 - service temporarily unavailable) occurred in AweberSubscriberWriter->updateAweberSubscriber. ");
                                     print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                                     sleep(120);
                                 } else {
                                     print("\n" . "AweberAPIException (status = 503 - service temporarily unavailable) occurred in AweberSubscriberWriter->updateAweberSubscriber! Exception->getMessage() : " . $exception->getMessage());
                                     print "Type: " . $exception->type . "\n";
                                     print("\n" . "Exiting from program.");
                                     throw $exception;
                                 }
                             }
                             else if ($exception->type == "APIUnreachableError") {
                                  $j++;
                                  if ($j < $maxRetries) { // 6 is arbitrary number of tries...
                                      print("\n" . "AweberAPIException (type = APIUnreachableError - service temporarily unavailable) occurred in AweberSubscriberWriter->updateAweberSubscriber. ");
                                      print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                                      sleep(120);
                                  }
                             }
                             else {
                                 print("\n" . "AweberAPIException occurred in AweberSubscriberWriter->updateAweberSubscriber! Exception->getMessage() : " . $exception->getMessage());
                                 print "Type: " . $exception->type . "\n";
                                 print "Status: " . $exception->status . "\n";
                                 print("\n" . "Exiting from program.");
                                 throw $exception;
                             }
            }


        }

        return TRUE;

       }

    /**
     * @param AweberSubscriber $aweberSubscriber
     * @return array of Aweber custom fields built from an instance of AweberSubscriber (which was created/updated from MDS data.
     */
       private function setCustomFieldsFailed(AweberSubscriber $aweberSubscriber) {

           $subscriberCustomFields = array();
           $subscriberCustomFields[AweberFieldsConstants::BUILDING]                      = $aweberSubscriber->getPennSouthBuilding() ;
           $subscriberCustomFields[AweberFieldsConstants::FLOOR_NUMBER]                  = $aweberSubscriber->getFloorNumber();
           $subscriberCustomFields[AweberFieldsConstants::APARTMENT]                     = $aweberSubscriber->getApartment();
           if(strlen($aweberSubscriber->getCeramicsMember()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::CERAMICS_MEMBER] = $aweberSubscriber->getCeramicsMember();
           }
           if (strlen($aweberSubscriber->getGardenMember()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::GARDEN_MEMBER] = $aweberSubscriber->getGardenMember();
           }
           if (strlen($aweberSubscriber->getGymMember()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::GYM_MEMBER] = $aweberSubscriber->getGymMember();
           }
           if (strlen($aweberSubscriber->getToddlerRoomMember()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::TODDLER_ROOM_MEMBER] = $aweberSubscriber->getToddlerRoomMember();
           }
           if (strlen($aweberSubscriber->getWoodworkingMember()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::WOODWORKING_MEMBER] = $aweberSubscriber->getWoodworkingMember();
           }
           if (strlen($aweberSubscriber->getYouthRoomMember()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::YOUTH_ROOM_MEMBER] = $aweberSubscriber->getYouthRoomMember();
           }

           if (strlen($aweberSubscriber->getIsDogInApt()) > 0 ) {
               $subscriberCustomFields[AweberFieldsConstants::IS_DOG_IN_APT] = $aweberSubscriber->getIsDogInApt();
           }
           if (strlen($aweberSubscriber->getStorageLockerClosetBldg()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::STORAGE_LOCKER_CLOSET_BLDG_NUM] = $aweberSubscriber->getStorageLockerClosetBldg();
           }
           if (strlen($aweberSubscriber->getStorageLockerNum()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::STORAGE_LOCKER_NUM] = $aweberSubscriber->getStorageLockerNum();
           }
           if (strlen($aweberSubscriber->getStorageClosetFloorNum()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::STORAGE_CLOSET_FLOOR_NUM] = $aweberSubscriber->getStorageClosetFloorNum();
           }
           if (strlen($aweberSubscriber->getBikeRackBldg()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::BIKE_RACK_BLDG] = $aweberSubscriber->getBikeRackBldg();
           }
           if (strlen($aweberSubscriber->getBikeRackRoom()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::BIKE_RACK_ROOM] = $aweberSubscriber->getBikeRackRoom();
           }
           if (strlen($aweberSubscriber->getBikeRackLocation()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::BIKE_RACK_LOCATION] = $aweberSubscriber->getBikeRackLocation();
           }
           if (strlen($aweberSubscriber->getHomeownerInsIntervalRemaining()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::HOMEOWNER_INS_INTERVAL_REMAINING] = $aweberSubscriber->getHomeownerInsIntervalRemaining();
           }
           if (strlen($aweberSubscriber->getVehicleRegIntervalRemaining()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::VEHICLE_REG_INTERVAL_REMAINING] = $aweberSubscriber->getVehicleRegIntervalRemaining();
           }
           if (strlen($aweberSubscriber->getParkingLotLocation()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::PARKING_LOT_LOCATION] = $aweberSubscriber->getParkingLotLocation();
           }
           if (strlen($aweberSubscriber->getResidentCategory()) > 0) {
               $subscriberCustomFields[AweberFieldsConstants::RESIDENT_CATEGORY] = $aweberSubscriber->getResidentCategory();
           }

           return $subscriberCustomFields;

       }

    /**
     *      todo - delete this function after testing the rewritten version above.
     *      This function has been rewritten above. Keeping it in place just in case, for now.
         * @param AweberSubscriber $aweberSubscriber
         * @return array of Aweber custom fields built from an instance of AweberSubscriber (which was created/updated from MDS data.
     *
         */
           private function setCustomFields(AweberSubscriber $aweberSubscriber) {

               $singleQuote = "'";
               $subscriberCustomFields = array();
               $subscriberCustomFields[AweberFieldsConstants::BUILDING]                      = $singleQuote . $aweberSubscriber->getPennSouthBuilding() . $singleQuote;
               $subscriberCustomFields[AweberFieldsConstants::FLOOR_NUMBER]                  = $singleQuote . $aweberSubscriber->getFloorNumber() . $singleQuote;
               $subscriberCustomFields[AweberFieldsConstants::APARTMENT]                     = $singleQuote . $aweberSubscriber->getApartment() . $singleQuote;
               if(strlen($aweberSubscriber->getCeramicsMember()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::CERAMICS_MEMBER] = $singleQuote . $aweberSubscriber->getCeramicsMember() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getGardenMember()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::GARDEN_MEMBER] = $singleQuote . $aweberSubscriber->getGardenMember() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getGymMember()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::GYM_MEMBER] = $singleQuote . $aweberSubscriber->getGymMember() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getToddlerRoomMember()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::TODDLER_ROOM_MEMBER] = $singleQuote . $aweberSubscriber->getToddlerRoomMember() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getWoodworkingMember()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::WOODWORKING_MEMBER] = $singleQuote . $aweberSubscriber->getWoodworkingMember() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getYouthRoomMember()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::YOUTH_ROOM_MEMBER] = $singleQuote . $aweberSubscriber->getYouthRoomMember() . $singleQuote;
               }

               if (strlen($aweberSubscriber->getIsDogInApt()) > 0 ) {
                   $subscriberCustomFields[AweberFieldsConstants::IS_DOG_IN_APT] = $singleQuote . $aweberSubscriber->getIsDogInApt() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getStorageLockerClosetBldg()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::STORAGE_LOCKER_CLOSET_BLDG_NUM] = $singleQuote . $aweberSubscriber->getStorageLockerClosetBldg() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getStorageLockerNum()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::STORAGE_LOCKER_NUM] = $singleQuote . $aweberSubscriber->getStorageLockerNum() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getStorageClosetFloorNum()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::STORAGE_CLOSET_FLOOR_NUM] = $singleQuote . $aweberSubscriber->getStorageClosetFloorNum() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getBikeRackBldg()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::BIKE_RACK_BLDG] = $singleQuote . $aweberSubscriber->getBikeRackBldg() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getBikeRackRoom()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::BIKE_RACK_ROOM] = $singleQuote . $aweberSubscriber->getBikeRackRoom() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getBikeRackLocation()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::BIKE_RACK_LOCATION] = $singleQuote . $aweberSubscriber->getBikeRackLocation() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getHomeownerInsIntervalRemaining()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::HOMEOWNER_INS_INTERVAL_REMAINING] = $singleQuote . $aweberSubscriber->getHomeownerInsIntervalRemaining() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getVehicleRegIntervalRemaining()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::VEHICLE_REG_INTERVAL_REMAINING] = $singleQuote . $aweberSubscriber->getVehicleRegIntervalRemaining() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getParkingLotLocation()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::PARKING_LOT_LOCATION] = $singleQuote . $aweberSubscriber->getParkingLotLocation() . $singleQuote;
               }
               if (strlen($aweberSubscriber->getResidentCategory()) > 0) {
                   $subscriberCustomFields[AweberFieldsConstants::RESIDENT_CATEGORY] = $singleQuote . $aweberSubscriber->getResidentCategory() . $singleQuote;
               }

               return $subscriberCustomFields;

           }



}