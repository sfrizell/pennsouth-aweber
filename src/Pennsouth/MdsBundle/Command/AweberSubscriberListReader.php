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

/**
 * AweberSubscriberListReader.php
 * User: sfrizell
 * Date: 10/1/16
 *  Function:
 */

// extends ContainerAwareCommand
class AweberSubscriberListReader
{
    const AWEBER_PENNSOUTH_NEWSLETTER_LIST = 'Penn South Newsletter'; // Unique List ID: awlist3774632
    const EMERGENCY_NOTICES_FOR_RESIDENTS = 'Emergency Notices for Residents'; // Unique List ID: awlist3926140

    const CUSTOM_FIELDS = array('BUILDING' => 'Penn_South_Building',
                                'FLOOR_NUMBER' => 'Floor_Number',
                                'APARTMENT' => 'Apartment');

    const BUILDING      = 'Penn_South_Building';
    const FLOOR_NUMBER  = 'Floor_Number';
    const APARTMENT     = 'Apartment';

    public function __construct($rootDir) {

          // require ('/Users/sfrizell/projects/pennsouth_aweber/vendor/aweber/aweber/aweber_api/aweber_api.php');
        // The following is a kludge! Cannot get auoloader to work for Aweber API. Need to resolve so the following require won't be necessary...
         require_once $rootDir . '/vendor/aweber/aweber/aweber_api/aweber_api.php';
           # replace XXX with your real keys and secrets
           $this->consumerKey = 'Akz4bgpT5FO6EJZm3M0hkYSu';
           $this->consumerSecret = 'WyKB0vnarrzLlzNxpilQfyTzTUzhhOQDLnfhJ3rF';
           $this->accessToken = 'AgulWM43dmHiQn6DiU2wZcdW';
           $this->accessSecret = '34ZYztLI0wgHCTgh3YsCL765hXNVjS7BjAFBcDM2';

         //  $this->application = new AWeberAPI($this->consumerKey, $this->consumerSecret);
           $this->aWeberApi = new AWeberAPI($this->consumerKey, $this->consumerSecret);
        //    $this->setApplication( new AWeberAPI($this->consumerKey, $this->consumerSecret));


           // employeeListIdNames is a list of subscriber list-id/Name pairs
           // These are to be excluded from synchronizing with MDS. The synchronization should only be performed
           // between shareholders defined in MDS and subscriber lists defined in AWeber that target shareholders as recipients
           $this->employeeListIdNames = array( 3836498 => "Maintenance Employees",
                                               3842258 => "Employee Emails",  );
      //  $this.$customFieldNames = array('Penn_South_Building', 'Floor_Number', 'Apartment', 'Window_Guard_Installed', 'Dog_Allowed');



       }

    /**
           *
           * modified version of sample found here function getSubscriber email: https://labs.aweber.com/getting_started/private
           **/
    public function connectToAWeberAccount() {


        try {

           // $account = $this->application->getAccount($this->accessToken, $this->accessSecret);
           // $account = $this->getApplication()->getAccount($this->accessToken, $this->accessSecret);

            $account = $this->aWeberApi->getAccount($this->accessToken, $this->accessSecret);

            return $account;
        }
        catch (AWeberAPIException $exc) {
                         print "AWeberAPIException on attempt to connect to AWeber Account\n";
                         print "Type: " . $exc->type . "\n";
                         print "Msg: " . $exc->message . "\n" ;
                         print "Docs: " . $exc->documentation_url . "\n";
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
                     if ($emailNotificationlist->data['name'] == self::AWEBER_PENNSOUTH_NEWSLETTER_LIST or
                         $emailNotificationlist->data['name'] == self::EMERGENCY_NOTICES_FOR_RESIDENTS) {
                         $selectedEmailNotificationLists[] = $emailNotificationlist;
                        // print ("\n" . "emailNotificationList Name: " . $emailNotificationlist->data['name']);
                     }
                 }

                 return $selectedEmailNotificationLists;
             } catch (AWeberAPIException $exc) {
                 print "AWeberAPIException\n";
                 print "Type: " . $exc->type . "\n";
                 print "Msg: " . $exc->message . "\n" ;
                 print "Docs: " . $exc->documentation_url . "\n";
             }
         }

    /**
     * @param $account
     * @param $emailNotificationList
     * This function should only be processing 2 email notification lists:
     *  1) Penn South Newsletter
     *  2) Emergency Notifications
     */
     public function getSubscribersToEmailNotificationList ($account, $emailNotificationList) {


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

            $i = 0;
            foreach ($subscribers as $subscriberData) {
                $i++;
                // here we're extracting one subscriber in a subscriber list...
              $subscriberDataEntries = $subscriberData->data;
               // $k = 1;
                print (" --------- subscriberDataEntries..." . "\n");
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

                    $aweberSubscriber = new AweberSubscriber();

                    $aweberSubscriber->setEmail($subscriberDataEntries["email"]);
                    $aweberSubscriber->setName($subscriberDataEntries["name"]);
                    $aweberSubscriber->setStatus($subscriberDataEntries["status"]);
                   // $subscriberCustomFields = array();
                    $aweberSubscriber->setPennSouthBuilding($customFields[self::BUILDING]);
                    $aweberSubscriber->setFloorNumber($customFields[self::FLOOR_NUMBER]);
                    $aweberSubscriber->setApartment($customFields[self::APARTMENT]);
                    foreach ($customFields as $key => $value) {
                        print ("\n" . "key: " . $key . " value: " . $value); // returns key: Penn_South_Building value: 1 , etcetera
                                                                                                //  for each of custom fields...

                     /*   foreach ($this->customFieldNames as $customFieldName ) {
                             if ($key == $customFieldName) {
                                 $subscriberCustomFields[$key] = $value;
                                 break;
                             }
                        }*/
                    }

                    print ("\n" . "Subscriber name: " . $aweberSubscriber->getName() . "\n");
                //print ("\n" . "Subscriber name: " . $subscriberDataEntries["name"] . "\n");
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



                if ($i > 4) {

                    break; // just for now, for testing looping through the data, so it is not too verbose...
                }
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