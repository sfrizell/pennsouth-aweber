<?php

namespace Pennsouth\MdsBundle\Service;

//require('./../../../../vendor/aweber/aweber/aweber_api/aweber_api.php');

//require ('/Users/sfrizell/projects/pennsouth_aweber/vendor/aweber/aweber/aweber_api/aweber_api.php');

use AWeberAPI;
use AWeberAPIException;
use AppKernel;
use Doctrine\ORM\EntityManager;
use Pennsouth\MdsBundle\AweberEntity\AweberCredentialsProvider;
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

class AweberSubscriberListReader
{

    private $entityManager;

    public function __construct(EntityManager $entityManager) {
     //   public function __construct($fullPathToAweber) {

        $this->entityManager = $entityManager;

        try {
            // changed variable passed to this method from $rootDir to $fullPathToAweber
            // require ('/Users/sfrizell/projects/pennsouth_aweber/vendor/aweber/aweber/aweber_api/aweber_api.php');
            // The following is a kludge! Cannot get autoloader to work for Aweber API. Need to resolve so the following require won't be necessary...
          //  require_once $fullPathToAweber;
            // require_once $rootDir . '/vendor/aweber/aweber/aweber_api/aweber_api.php';
            # replace XXX with your real keys and secrets

            $aweberCredentialsPopulator = new AweberCredentialsProvider($this->getEntityManager());
            $aweberCredentialsPopulator->populateAweberCredentials();

            $this->consumerKey      = $aweberCredentialsPopulator->getConsumerKey();
            $this->consumerSecret   = $aweberCredentialsPopulator->getConsumerSecret();
            $this->accessToken      = $aweberCredentialsPopulator->getAccessToken();
            $this->accessSecret     = $aweberCredentialsPopulator->getAccessSecret();


            // todo - sfrizell - test removal of line below on 12/11/2016 - this had been working. Now suddenly we are getting a User Warning: Another AweberAPI client library is already in scope - was there a change in notification setting (i.e. from Error to Warning?)
            $this->aWeberApi = new AWeberAPI($this->consumerKey, $this->consumerSecret);


            // employeeListIdNames is a list of subscriber list-id/Name pairs
            // These are to be excluded from synchronizing with MDS. The synchronization should only be performed
            // between shareholders defined in MDS and subscriber lists defined in AWeber that target shareholders as recipients
//           $this->employeeListIdNames = array( 3836498 => "Maintenance Employees",
//                                               3842258 => "Employee Emails",  );
        }
        catch (AWeberAPIException $exception) {
            print "AWeberAPIException in AweberSubscriberListReader->__construct() on attempt to instantiate an AWeberAPI\n";
            print "Type: " . $exception->type . "\n";
            print "Msg: " . $exception->message . "\n" ;
            print "Docs: " . $exception->documentation_url . "\n";
            throw $exception;
        }
        catch (\Exception $exception) {
                    print "\n Unidentified exception caught in AweberSubscriberListReader->__construct() on attempt to instantiate an AWeberAPI\n";
                    print "Msg: " . $exception->getMessage() . "\n" ;
                    throw $exception;
        }


       }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
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
                         throw $exc;
        }


              // print_r($account);
              // print $account->id;

              // account = 936765

              // $foundSubscribers = $account->findSubscribers(array('email' => $email));
              // print_r($foundSubscribers);

              // return $foundSubscribers[0];
    }

    /**
     * todo : remove FRIZELL_TEST_LIST after testing...
     * @param $account
     * @return array
     * @throws \Exception
     */
     public function getEmailNotificationLists($account) {


         $selectedEmailNotificationLists = array();

             try {
                 $emailNotificationlists = $account->lists;
                 foreach ($emailNotificationlists as $emailNotificationlist) {
                     if ($emailNotificationlist->data['name'] == AweberFieldsConstants::PRIMARY_RESIDENT_LIST or
                         $emailNotificationlist->data['name'] == AweberFieldsConstants::EMERGENCY_NOTICES_FOR_RESIDENTS or
                         $emailNotificationlist->data['name'] == AweberFieldsConstants::FRIZELL_TEST_LIST) {
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

         $j = 0;
         $success = false;
         while (!$success) { // allow for retry if we get rate limit or temporarily unavailable exception...
             try {

                 $listId = AweberFieldsConstants::ADMINS_MDS_TO_AWEBER_LIST_ID;
                 $accountId = AweberFieldsConstants::PENN_SOUTH_AWEBER_ACCOUNT;
                 $listURL = "/accounts/{$accountId}/lists/{$listId}"; //
                 if ($account instanceof \AWeberEntry) { // should always be true...
                     $list = $account->loadFromUrl($listURL);

                     $subscribers = $list->subscribers;

                     $emailAddresses = array();
                     foreach ($subscribers as $subscriberData) {
                         $subscriberDataEntries = $subscriberData->data;
                         $emailAddresses[] = array($subscriberDataEntries['email'] => $subscriberDataEntries['name']);
                     }

                    return $emailAddresses;
                 }
                 else {
                     print ("\n Fatal error encountered in AweberSubscriberListReader->getSubscriberstoAdminsMdsToAweberList! \$account is not instanceof AweberEntry. Exiting from program. \n");
                     throw new \Exception("\n Fatal error encountered in AweberSubscriberListReader->getSubscriberstoAdminsMdsToAweberList! \$account is not instanceof AweberEntry. Exiting from program. \n");
                 }

             } catch (AWeberAPIException $exception) {
                 if ($exception->status == "403") { // ServiceUnavailableError
                     $j++;
                     if ($j < 6) { // 6 is arbitrary number of tries...
                         print("\n" . "AweberAPIException (status = 403 - forbidden / rate limite exceeded) occurred in AweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList. ");
                         print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                         sleep(120);
                     } else {
                         print("\n" . "AweberAPIException (status 403) occurred in AweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList! Exception->getMessage() : " . $exception->getMessage());
                         print "Type: " . $exception->type . "\n";
                         print("\n" . "Exiting from program.");
                         throw $exception;
                     }
                 } else if ($exception->status == "503") {
                     $j++;
                     if ($j < 6) { // 6 is arbitrary number of tries...
                         print("\n" . "AweberAPIException (status = 503 - service temporarily unavailable) occurred in AweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList. ");
                         print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                         sleep(120);
                     } else {
                         print("\n" . "AweberAPIException (status = 503 - service temporarily unavailable) occurred in AweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList! Exception->getMessage() : " . $exception->getMessage());
                         print "Type: " . $exception->type . "\n";
                         print("\n" . "Exiting from program.");
                         throw $exception;
                     }
                 } else {
                     print("\n" . "AweberAPIException occurred in AweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList! Exception->getMessage() : " . $exception->getMessage());
                     print("\n" . "Exiting from program.");
                     throw $exception;
                 }
             }
         }
     }

    /**
     * @param $account
     * @param $emailNotificationList
     * This function should only be processing 2 Aweber subscriber lists (emailNotificationList):
     *  1) Primary Resident List
     *  2) Penn South Emergency Info Only
     */
     public function getSubscribersToEmailNotificationList ($account, $emailNotificationList) {

         $j = 0;
         $success = false;
         while (!$success) { // allow for retry if we get rate limit or temporarily unavailable exception...
             try {
                 sleep(65); // sleep 65 seconds to avoid Aweber Rate Limit Exception - status code 403
                 if ($emailNotificationList instanceof \AWeberEntry) {
                     $listURL = $emailNotificationList->url; // aweber api call

                     print ("\n" . "List url: " . $listURL . "\n");

                     if ($account instanceof \AWeberEntry) {

                         $list = $account->loadFromUrl($listURL); // aweber API call

                         $subscribers = $list->subscribers; // aweber API call


                         $listId = $emailNotificationList->data["id"]; // this is list-id - can use this as key for list maintained in

                         $totalSubscribedSubscribers = $emailNotificationList->data["total_subscribed_subscribers"];
                         $totalUnsubscribedSubscribers = $emailNotificationList->data["total_unsubscribed_subscribers"];
                         $listName = $emailNotificationList->data["name"];
                         print ("\n" . "Subscriber list name: " . $listName);
                         print ("\n" . "Subscriber list id: " . $listId);
                         print ("\n" . "Total Subscribed Subscribers: " . $totalSubscribedSubscribers . "\n");
                         print ("\n" . "Total Unsubscribed Subscribers: " . $totalUnsubscribedSubscribers . "\n");


                         $aweberSubscribersWithListNameKey = array(); // associative array: key = list-name, value = array of AweberSubscriber objects
                         $aweberSubscribers = array();
                         $i = 0;
                         foreach ($subscribers as $subscriberData) {
                             $i++;
                             // here we're extracting one subscriber in a subscriber list...
                             $subscriberDataEntries = $subscriberData->data;
                             // $k = 1;
                             //  print (" --------- subscriberDataEntries..." . "\n");

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

                             $aweberSubscriber->setCustomFields($customFields);
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
                             $aweberSubscriber->setHomeownerInsIntervalRemaining($customFields[AweberFieldsConstants::HOMEOWNER_INS_INTERVAL_REMAINING]);
                             $aweberSubscriber->setVehicleRegIntervalRemaining($customFields[AweberFieldsConstants::VEHICLE_REG_INTERVAL_REMAINING]);
                             $aweberSubscriber->setIsDogInApt($customFields[AweberFieldsConstants::IS_DOG_IN_APT]);
                             $aweberSubscriber->setStorageLockerClosetBldg($customFields[AweberFieldsConstants::STORAGE_LOCKER_CLOSET_BLDG_NUM]);
                             $aweberSubscriber->setStorageLockerNum($customFields[AweberFieldsConstants::STORAGE_LOCKER_NUM]);
                             $aweberSubscriber->setStorageClosetFloorNum($customFields[AweberFieldsConstants::STORAGE_CLOSET_FLOOR_NUM]);
                             $aweberSubscriber->setBikeRackBldg($customFields[AweberFieldsConstants::BIKE_RACK_BLDG]);
                             $aweberSubscriber->setBikeRackRoom($customFields[AweberFieldsConstants::BIKE_RACK_ROOM]);
                             $aweberSubscriber->setBikeRackLocation($customFields[AweberFieldsConstants::BIKE_RACK_LOCATION]);
                             $aweberSubscriber->setParkingLotLocation($customFields[AweberFieldsConstants::PARKING_LOT_LOCATION]);
                             $aweberSubscriber->setToddlerRoomMember($customFields[AweberFieldsConstants::TODDLER_ROOM_MEMBER]);
                             $aweberSubscriber->setYouthRoomMember($customFields[AweberFieldsConstants::YOUTH_ROOM_MEMBER]);
                             $aweberSubscriber->setWoodworkingMember($customFields[AweberFieldsConstants::WOODWORKING_MEMBER]);
                             $aweberSubscriber->setResidentCategory($customFields[AweberFieldsConstants::RESIDENT_CATEGORY]);
                             $aweberSubscriber->setIncAffidavitReceived($customFields[AweberFieldsConstants::INCOME_AFFIDAVIT_RECEIVED]);

                             // Add the AweberSubscriber to the $aweberSubscribers array...
                             $aweberSubscribers[] = $aweberSubscriber;

                         } // end of iteration through the $subscribers

                         $aweberSubscribersWithListNameKey[$listName] = $aweberSubscribers;


                         return $aweberSubscribersWithListNameKey;
                     }
                     else {
                         print ("\n Fatal error encountered in AweberSubscriberListReader->getSubscribersToEmailNotificationList! \$account is not instanceof AweberEntry. Exiting from program. \n");
                         throw new \Exception("\n Fatal error encountered in AweberSubscriberListReader->getSubscribersToEmailNotificationList! \$account is not instanceof AweberEntry. Exiting from program. \n");
                     }
                 }

             } catch (AWeberAPIException $exception) {
                 if ($exception->status == "403") { // ServiceUnavailableError
                     $j++;
                     if ($j < 6) { // 6 is arbitrary number of tries...
                         print("\n" . "AweberAPIException (status = 403 - forbidden / rate limite exceeded) occurred in AweberSubscriberListReader->getSubscribersToEmailNotificationList. ");
                         print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                         sleep(120);
                     } else {
                         print("\n" . "AweberAPIException (status 403) occurred in AweberSubscriberListReader->getSubscribersToEmailNotificationList! Exception->getMessage() : " . $exception->getMessage());
                         print "Type: " . $exception->type . "\n";
                         print("\n" . "Exiting from program.");
                         throw $exception;
                     }
                 } else if ($exception->status == "503") {
                     $j++;
                     if ($j < 6) { // 6 is arbitrary number of tries...
                         print("\n" . "AweberAPIException (status = 503 - service temporarily unavailable) occurred in AweberSubscriberListReader->getSubscribersToEmailNotificationList. ");
                         print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                         sleep(120);
                     } else {
                         print("\n" . "AweberAPIException (status = 503 - service temporarily unavailable) occurred in AweberSubscriberListReader->getSubscribersToEmailNotificationList! Exception->getMessage() : " . $exception->getMessage());
                         print "Type: " . $exception->type . "\n";
                         print("\n" . "Exiting from program.");
                         throw $exception;
                     }
                 } else {
                     print("\n" . "AweberAPIException occurred when trying to call AweberSubscriberListReader->getSubscribersToEmailNotificationList! Exception->getMessage() : " . $exception->getMessage());
                     print("\n" . "Exiting from program.");
                     throw $exception;
                 }
             } // end catch AweberAPIException
         } // end while !$success

         return FALSE;
     }

      public function getSubscribersToEmailNotificationLists( $account, array $emailNotificationLists ) {


              $i = 0;
             // the following foreach iterates through AWeberEntry objects
             foreach ($emailNotificationLists as $emailNotificationList ) {

                 $i++;
                 print ("\n" . "i: " . $i . "\n");
              //   print_r($emailNotificationList);

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

                           $aweberSubscriber->setId($subscriberDataEntries["id"]);
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