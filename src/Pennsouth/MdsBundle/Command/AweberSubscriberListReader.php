<?php

namespace Pennsouth\MdsBundle\Command;

//require('./../../../../vendor/aweber/aweber/aweber_api/aweber_api.php');

//require ('/Users/sfrizell/projects/pennsouth_aweber/vendor/aweber/aweber/aweber_api/aweber_api.php');

use AWeberAPI;
use AWeberAPIException;
use AppKernel;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Symfony\Component\DependencyInjection\ContainerAwareInterface;

//require $this->get('kernel')->getRootDir() .  '/vendor/aweber/aweber/aweber_api/aweber_api.php';

//require $this->container->getParameter('kernel.root_dir') . '/vendor/aweber/aweber/aweber_api/aweber_api.php';


use Pennsouth\MdsBundle\AweberEntity\AweberSubscriber;
use Pennsouth\MdsBundle\AweberEntity\AweberFieldsConstants;

/**
 * AweberSubscriberListReader.php
 * User: sfrizell
 * Date: 10/1/16
 *  Function:
 */

// extends ContainerAwareCommand
class AweberSubscriberListReader
{

    public function __construct($fullPathToAweber) {

        // changed variable passed to this method from $rootDir to $fullPathToAweber
          // require ('/Users/sfrizell/projects/pennsouth_aweber/vendor/aweber/aweber/aweber_api/aweber_api.php');
        // The following is a kludge! Cannot get autoloader to work for Aweber API. Need to resolve so the following require won't be necessary...
         require_once $fullPathToAweber;
        // require_once $rootDir . '/vendor/aweber/aweber/aweber_api/aweber_api.php';
           # replace XXX with your real keys and secrets
           $this->consumerKey = 'Akz4bgpT5FO6EJZm3M0hkYSu';
           $this->consumerSecret = 'WyKB0vnarrzLlzNxpilQfyTzTUzhhOQDLnfhJ3rF';
           $this->accessToken = 'AgulWM43dmHiQn6DiU2wZcdW';
           $this->accessSecret = '34ZYztLI0wgHCTgh3YsCL765hXNVjS7BjAFBcDM2';


           $this->aWeberApi = new AWeberAPI($this->consumerKey, $this->consumerSecret);


           // employeeListIdNames is a list of subscriber list-id/Name pairs
           // These are to be excluded from synchronizing with MDS. The synchronization should only be performed
           // between shareholders defined in MDS and subscriber lists defined in AWeber that target shareholders as recipients
//           $this->employeeListIdNames = array( 3836498 => "Maintenance Employees",
//                                               3842258 => "Employee Emails",  );


       }

    /**
           *
           * modified version of sample found here function getSubscriber email: https://labs.aweber.com/getting_started/private
           **/

    public function getAweberApiInstance() {
        return $this->aWeberApi;
    }

    public function connectToAWeberAccount() {


        try {

           // $account = $this->application->getAccount($this->accessToken, $this->accessSecret);
           // $account = $this->getApplication()->getAccount($this->accessToken, $this->accessSecret);

            $account = $this->aWeberApi->getAccount($this->accessToken, $this->accessSecret);

            //print("\n" . "In connectToAweberAccount.");

            return $account;
        }
        catch (AWeberAPIException $exc) {
                         print "AWeberAPIException in AweberSubscriberListReader on attempt to connect to AWeber Account\n";
                         print "Type: " . $exc->type . "\n";
                         print "Msg: " . $exc->message . "\n" ;
                         print "Docs: " . $exc->documentation_url . "\n";
                         throw new \Exception($exc->type);
        }


              // print_r($account);
              // print $account->id;

              // account = 936765

              // $foundSubscribers = $account->findSubscribers(array('email' => $email));
              // print_r($foundSubscribers);

              // return $foundSubscribers[0];
    }


     public function getEmailNotificationLists($account) {


         $selectedEmailNotificationLists = array();

             try {
                 $emailNotificationlists = $account->lists;
                 foreach ($emailNotificationlists as $emailNotificationlist) {
                     if ($emailNotificationlist->data['name'] == AweberFieldsConstants::AWEBER_PENNSOUTH_NEWSLETTER_LIST or
                         $emailNotificationlist->data['name'] == AweberFieldsConstants::EMERGENCY_NOTICES_FOR_RESIDENTS) {
                         $selectedEmailNotificationLists[$emailNotificationlist->data['name']] = $emailNotificationlist;
                       //  print ("\n" . "emailNotificationList Name: " . $emailNotificationlist->data['name']);
                       //  print ("\n" . "emailNotificationList Id: " . $emailNotificationlist->data['id']);
                     }
                    // print ("\n" . "emailNotificationList Name: " . $emailNotificationlist->data['name'] . "\n");
                    // print ("\n" . "emailNotificationList Id: " . $emailNotificationlist->data['id'] . "\n" );
                 }

                 return $selectedEmailNotificationLists;
             } catch (AWeberAPIException $exc) {
                 print ".\n" . "AWeberAPIException in AweberSubscriberListReader.getEmailNotificationLists \n";
                 print "Type: " . $exc->type . "\n";
                 print "Msg: " . $exc->message . "\n" ;
                 print "Docs: " . $exc->documentation_url . "\n";
                 throw new \Exception($exc->type);
                // throw new AWeberAPIException();
             }
         }

    /**
     * the getSubscribersToAdminsMdsToAweberList reads the Aweber subscriber list 'admin_mds_to_aweber'
     * This list was created to provide Penn South Administrators an ability to manage the list of email
     * recipients to the automated email messages that are generated from this application. The emails
     * notify about success or failure of the running of this program.
     * The url of the subscriber list name 'admins_mds_to_aweber_update' is: awlist4459191
     */
     public function getSubscribersToAdminsMdsToAweberList($account) {


      //   print ".\n" . "getSubscribersToAdminsMdsToAweberList - 0 \n";

         $listId = AweberFieldsConstants::ADMINS_MDS_TO_AWEBER_LIST_ID;
         $accountId = AweberFieldsConstants::PENN_SOUTH_AWEBER_ACCOUNT;
         $listURL = "/accounts/{$accountId}/lists/{$listId}"; //
         $list = $account->loadFromUrl($listURL);

         $subscribers = $list->subscribers;

         $emailAddresses = array();
         foreach ($subscribers as $subscriberData) {
             $subscriberDataEntries = $subscriberData->data;
             $emailAddresses[] = $subscriberDataEntries["email"];
         }

         return $emailAddresses;
     }

    /**
     * @param $account
     * @param $emailNotificationList
     * This function should only be processing 2 email notification lists:
     *  1) Penn South Newsletter
     *  2) Emergency Notifications
     */
     public function getSubscribersToEmailNotificationList ($account, $emailNotificationList) {


         try {
             sleep(65); // sleep 65 seconds to avoid Aweber Rate Limit Exception - status code 403
             $listURL = $emailNotificationList->url;

             print ("\n" . "List url: " . $listURL . "\n");


             $list = $account->loadFromUrl($listURL);

             $subscribers = $list->subscribers;


             $listId = $emailNotificationList->data["id"]; // this is list-id - can use this as key for list maintained in

             $totalSubscribedSubscribers = $emailNotificationList->data["total_subscribed_subscribers"];
             $totalUnsubscribedSubscribers = $emailNotificationList->data["total_unsubscribed_subscribers"];
             print ("\n" . "Subscriber list id: " . $listId);
             print ("\n" . "Total Subscribed Subscribers: " . $totalSubscribedSubscribers . "\n");
             print ("\n" . "Total Unsubscribed Subscribers: " . $totalUnsubscribedSubscribers . "\n");


             $aweberSubscribersWithListNameKey = array(); // associative array: key = list-name, value = array of AweberSubscriber objects
             $listName = $emailNotificationList->data["name"];
             print ("\n" . "Subscriber list name: " . $listName);
             $aweberSubscribers = array();
             $i = 0;
             foreach ($subscribers as $subscriberData) {
                 $i++;
                 // here we're extracting one subscriber in a subscriber list...
                 $subscriberDataEntries = $subscriberData->data;
                 // $k = 1;
                 //  print (" --------- subscriberDataEntries..." . "\n");
                 // print_r($subscriberDataEntries);

                 $customFields = $subscriberDataEntries["custom_fields"];

                 // we check whether this subscriber is a member of a Pennsouth Resident list by examining whether one of the subscriber's
                 //  custom_fields fields is "Penn_South_Building"
                 /*               $isResidentList = false;
                                foreach ($customFields as $key => $value) {
                                     if ($key == "Penn_South_Building") {
                                         $isResidentList = true;
                                     }
                                }*/

                 // Create and populate an AweberSubscriber...
                 $aweberSubscriber = new AweberSubscriber();

                 $aweberSubscriber->setId($subscriberDataEntries["id"]);
                 $aweberSubscriber->setEmail($subscriberDataEntries["email"]);
                 $aweberSubscriber->setName($subscriberDataEntries["name"]);
                 $aweberSubscriber->setStatus($subscriberDataEntries["status"]);
                 $subscribedAt = $subscriberDataEntries["subscribed_at"];
                 if (!empty($subscribedAt)) {
                     $subscribedAt = substr($subscribedAt, 0, strpos($subscribedAt, "T"));
                     $aweberSubscriber->setSubscribedAt($subscribedAt);
                 }
                // print("\n" . " !!!!!!!!!!  AweberSubscriberListReader->getSubscribersToEmailNotificationList subscribedAt: " . $subscribedAt . "!!!!!!!! ");
                // throw new \Exception("Just a test!");
                 $unsubscribedAt = $subscriberDataEntries["unsubscribed_at"];
                 if (!empty($unsubscribedAt)) {
                     $unsubscribedAt = substr($unsubscribedAt, 0, strpos($unsubscribedAt, "T"));
                     $aweberSubscriber->setUnsubscribedAt($unsubscribedAt);
                 }
                 $aweberSubscriber->setSubscriptionMethod($subscriberDataEntries["subscription_method"]);

                 $aweberSubscriber->setPennSouthBuilding($customFields[AweberFieldsConstants::BUILDING]);
                 $aweberSubscriber->setFloorNumber($customFields[AweberFieldsConstants::FLOOR_NUMBER]);
                 $aweberSubscriber->setApartment($customFields[AweberFieldsConstants::APARTMENT]);
                 $aweberSubscriber->setCeramicsMember($customFields[AweberFieldsConstants::CERAMICS_MEMBER]);
                 $aweberSubscriber->setGardenMember($customFields[AweberFieldsConstants::GARDEN_MEMBER]);
                 $aweberSubscriber->setGymMember($customFields[AweberFieldsConstants::GYM_MEMBER]);
                 $aweberSubscriber->setHomeownerInsExpDateLeft($customFields[AweberFieldsConstants::HOMEOWNER_INS_EXP_DAYS_LEFT]);
                 $aweberSubscriber->setVehicleRegExpDaysLeft($customFields[AweberFieldsConstants::VEHICLE_REG_EXP_DAYS_LEFT]);
                 $aweberSubscriber->setIsDogInApt($customFields[AweberFieldsConstants::IS_DOG_IN_APT]);
                 $aweberSubscriber->setStorageLockerClosetBldg($customFields[AweberFieldsConstants::STORAGE_LOCKER_CLOSET_BLDG_NUM]);
                 $aweberSubscriber->setStorageLockerNum($customFields[AweberFieldsConstants::STORAGE_LOCKER_NUM]);
                 $aweberSubscriber->setStorageClosetFloorNum($customFields[AweberFieldsConstants::STORAGE_CLOSET_FLOOR_NUM]);
                 $aweberSubscriber->setBikeRackBldg($customFields[AweberFieldsConstants::BIKE_RACK_BLDG]);
                 $aweberSubscriber->setBikeRackRoom($customFields[AweberFieldsConstants::BIKE_RACK_ROOM]);
                 $aweberSubscriber->setParkingLotLocation($customFields[AweberFieldsConstants::PARKING_LOT_LOCATION]);
                 $aweberSubscriber->setToddlerRoomMember($customFields[AweberFieldsConstants::TODDLER_ROOM_MEMBER]);
                 $aweberSubscriber->setYouthRoomMember($customFields[AweberFieldsConstants::YOUTH_ROOM_MEMBER]);
                 $aweberSubscriber->setWoodworkingMember($customFields[AweberFieldsConstants::WOODWORKING_MEMBER]);
                 $aweberSubscriber->setResidentCategory($customFields[AweberFieldsConstants::RESIDENT_CATEGORY]);

                 // Add the AweberSubscriber to the $aweberSubscribers array...
                 $aweberSubscribers[] = $aweberSubscriber;

                 /*                  foreach ($customFields as $key => $value) {
                                       print ("\n" . "key: " . $key . " value: " . $value); // returns key: Penn_South_Building value: 1 , etcetera
                                                                                                               //  for each of custom fields...
                                   }*/

//                    print ("\n" . "Subscriber name: " . $aweberSubscriber->getName() . "\n");
//                    print ("\n" . "Subscriber email: " . $subscriberDataEntries["email"] . "\n");
//                    print ("\n" . "Status: " . $subscriberDataEntries["status"] . "\n");
//                    print ("\n" . "Unsubscribed date/time: " . $subscriberDataEntries["unsubscribed_at"] . "\n");
//                    print ("\n" . "Subscription Method: " . $subscriberDataEntries["subscription_method"] . "\n");
//                    print ("\n" . "Unsubscribe method: " . $subscriberDataEntries["unsubscribe_method"] . "\n");
//                    if (!empty($subscribedAt)) {
//                        $subscribedAt = substr($subscribedAt, 0, strpos($subscribedAt, "T"));
//                    }
//                    print ("\n" . "Subscribed at: " . $subscriberDataEntries["subscribed_at"] . "\n");
//                    print ("\n" . "Subscribed at parsed: " . $subscribedAt . "\n");


             } // end of iteration through the $subscribers

             $aweberSubscribersWithListNameKey[$listName] = $aweberSubscribers;

             return $aweberSubscribersWithListNameKey;
         }
         catch (AWeberAPIException $exc) {
                  print "\n" . "AWeberAPIException in AweberSubscriberListReader.getSubscribersToEmailNotificationList \n";
                  print "Type: " . $exc->type . "\n";
                  print "Msg: " . $exc->message . "\n" ;
                  print "Docs: " . $exc->documentation_url . "\n";
                  throw new \Exception($exc->type);
         }
     }

      public function getSubscribersToEmailNotificationLists( $account, $emailNotificationLists ) {


              //  print ( "\n !!!!!!!!!!!!!  root directory: " . $this->getContainer()->getParameter('kernel.root_dir') . "\n");
               // print ( "\n !!!!!!!!!!!!!  root directory: " . $this->container->getParameter('kernel.root_dir') . "\n" );
              $i = 0;
             // the following foreach iterates through AWeberEntry objects
             foreach ($emailNotificationLists as $emailNotificationList ) {

                 $i++;
                 print ("\n" . "i: " . $i . "\n");
              //   print_r($emailNotificationList);

                 //$listURL = $emailNotificationList["url"]; // Fatal error: Cannot use object of type AWeberEntry as array
                 $listURL = $emailNotificationList->url;

                 print ( "\n" . "List url: " . $listURL . "\n");


                 $list = $account->loadFromUrl($listURL);

                 $subscribers = $list->subscribers;



                 $listId = $emailNotificationList->data["id"]; // this is list-id - can use this as key for list maintained in
                 $listName = $emailNotificationList->data["name"];
                 $totalSubscribedSubscribers = $emailNotificationList->data["total_subscribed_subscribers"];
                 $totalUnsubscribedSubscribers = $emailNotificationList->data["total_unsubscribed_subscribers"];
                 print ( "\n" . "Subscriber list id: " . $listId);
                 print ( "\n" . "Subscriber list name: " . $listName);
                 print ( "\n" . "Total Subscribed Subscribers: " . $totalSubscribedSubscribers . "\n");
                 print ( "\n" . "Total Unsubscribed Subscribers: " . $totalUnsubscribedSubscribers . "\n");

                 print ("\n" . "Following is list of subscribers for the above list id / name: " . "\n");

                   foreach ($subscribers as $subscriberData) {

                       // here we're extracting one subscriber in a subscriber list...
                     $subscriberDataEntries = $subscriberData->data;
                      // $k = 1;
                       print (" --------- subscriberDataEntries..." . "\n");
                      // print_r($subscriberDataEntries);

                       $customFields = $subscriberDataEntries["custom_fields"];

                       // we check whether this subscriber is a member of a Pennsouth Resident list by examining whether one of the subscriber's
                       //  custom_fields fields is "Penn_South_Building"
                       $isResidentList = false;
                       foreach ($customFields as $key => $value) {
                            if ($key == "Penn_South_Building") {
                                $isResidentList = true;
                            }
                       }

                       if ($isResidentList) {

                           $subscriberCustomFields = array();
                           foreach ($customFields as $key => $value) {
                               print ("\n" . "key: " . $key . " value: " . $value); // returns key: Penn_South_Building value: 1 , etcetera
                                                                                                       //  for each of custom fields...
         /*                      foreach ($this->customFieldNames as $customFieldName ) {
                                   if ($key == $customFieldName) {
                                       $subscriberCustomFields[$key] = $value;
                                       break;
                                   }
                               }*/
                           }

                           print ("\n" . "Subscriber name: " . $subscriberDataEntries["name"] . "\n");
                           print ("\n" . "Subscriber email: " . $subscriberDataEntries["email"] . "\n");
                           print ("\n" . "Status: " . $subscriberDataEntries["status"] . "\n");
                           print ("\n" . "Unsubscribed date/time: " . $subscriberDataEntries["unsubscribed_at"] . "\n");
                           print ("\n" . "Subscription Method: " . $subscriberDataEntries["subscription_method"] . "\n");
                           print ("\n" . "Unsubscribe method: " . $subscriberDataEntries["unsubscribe_method"] . "\n");
                           $subscribedAt = $subscriberDataEntries["subscribed_at"];
                           if (!empty($subscribedAt)) {
                               $subscribedAt = substr($subscribedAt, 0, strpos($subscribedAt, "T"));
                           }
                           print ("\n" . "Subscribed at: " . $subscriberDataEntries["subscribed_at"] . "\n");
                           print ("\n" . "Subscribed at parsed: " . $subscribedAt . "\n");

                           $aweberSubscriber = new AweberSubscriber();

                           $aweberSubscriber->setEmail($subscriberDataEntries["email"]);
                           $aweberSubscriber->setName($subscriberDataEntries["name"]);
                           $aweberSubscriber->setStatus($subscriberDataEntries["status"]);


                       }
                       else {
                           print ("\n" . "Not Resident list...");
                       }


                       break; // just for now, for testing looping through the data, so it is not too verbose...
                 }



             }


         } // end of function: getSubscribersToEmailNotificationLists



}