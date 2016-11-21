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
    private $aweberApiInstance;
    public function __construct($pathToAweber, $aweberApiInstance) {
        require_once $pathToAweber;

        $this->aweberApiInstance = $aweberApiInstance;
       // require_once $rootDir . '/vendor/aweber/aweber/aweber_api/aweber_api.php';
    }

    public function createAweberSubscriberTest($account, $emailNotificationList) {

        try {
            $aweberSubscriber = new AweberSubscriber();

            $aweberSubscriber->setEmail('steve.frizell@gmail.com');
            $aweberSubscriber->setName('Stephen Frizell');
            $aweberSubscriber->setFirstName('Stephen');
            $aweberSubscriber->setLastName('Frizell');

            $subscriberCustomFields = array();
          //  $subscriberCustomFields["Pennsouth_Building"] = "1"; // misstyped!
            $subscriberCustomFields["Penn_South_Building"] = "1";
            $subscriberCustomFields["Floor_Number"] = "1";
            $subscriberCustomFields["Apartment"] = "A";

            $params = array();
            $params['name'] = $aweberSubscriber->getName();
            $params['email'] = $aweberSubscriber->getEmail();
            $params['custom_fields'] = $subscriberCustomFields;

            $newSubscriber = $emailNotificationList->subscribers->create($params);
            return $newSubscriber;

        }
        catch (AWeberAPIException $exc) {
            print "AWeberAPIException in AweberSubscriberWriter->createAweberSubscriberTest \n";
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
     */
    public function createAweberSubscriber( $listName, AweberSubscriber $aweberSubscriber) {

        try {
            $this->aweberSubscriber = $aweberSubscriber;

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
            if ($listName == AweberFieldsConstants::AWEBER_PENNSOUTH_NEWSLETTER_LIST) {
                $URL = AweberFieldsConstants::PENNSOUTH_NEWSLETTER_LIST_URL . '/subscribers';
            }
            else {
                if ($listName == AweberFieldsConstants::EMERGENCY_NOTICES_FOR_RESIDENTS) {
                    $URL = AweberFieldsConstants::PENNSOUTH_EMERGENCY_NOTICES_LIST_URL . '/subscribers';
                } else {
                    throw new \Exception('Exception in AweberSubscriberWriter->createAweberSubscriber function. Could not interpret \$listName!');
                }
            }

            $RETURN_FORMAT = array(
                'return' => 'headers'
            );

            $resp = $this->aweberApiInstance->adapter->request($HTTP_METHOD, $URL, $params, $RETURN_FORMAT);

            if ($resp['Status-Code'] == 201) { // success
                // we will be using $subscriber_id in example 3
               $subscriber_id = array_pop(explode('/', $resp['Location']));
                return $subscriber_id;
              //  print "New subscriber added, subscriber_id: {$subscriber_id}\n";
            } else {
                throw new \Exception('Exception in AweberSubscriberWriter->createAweberSubscriber for subscriber with email address'  . $aweberSubscriber->getEmail() . " Aweber API Status-Code: " . $resp['Status-Code']);
                //print "Failure: " . print_r($resp,1) . "\n";
            }

            //$newSubscriber = $emailNotificationList->subscribers->create($params);
            //return $newSubscriber;

        }
        catch (AWeberAPIException $exc) {
              print "AWeberAPIException in AweberSubscriberWriter->createAweberSubscriber \n";
              print "Type: " . $exc->type . "\n";
              print "Msg: " . $exc->message . "\n" ;
              print "Docs: " . $exc->documentation_url . "\n";
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


              //  $listURLPennsouthNewsletter = "/accounts/" . AweberFieldsConstants::PENN_SOUTH_AWEBER_ACCOUNT . "/lists/" . AweberFieldsConstants::PENNSOUTH_NEWSLETTER_LIST_ID;


             // $subscriberUrl = AweberFieldsConstants::

              //  if ($aweberSubscriber->getEmail() == )

           $HTTP_METHOD = 'PATCH';

            $RETURN_FORMAT = array(
                'return' => 'status'
            );

           $subscriberUrl = null;
           if ($listName == AweberFieldsConstants::AWEBER_PENNSOUTH_NEWSLETTER_LIST) {
               $subscriberUrl = AweberFieldsConstants::PENNSOUTH_NEWSLETTER_LIST_URL . "/subscribers/" . $aweberSubscriber->getId();
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
                    print "AWeberAPIException in AweberSubscriberWriter->createAweberSubscriber \n";
                    print "Type: " . $exc->type . "\n";
                    print "Msg: " . $exc->message . "\n";
                    print "Docs: " . $exc->documentation_url . "\n";
                }

                return true;

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