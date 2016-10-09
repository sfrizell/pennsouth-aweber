<?php

namespace Pennsouth\MdsBundle\Command; // uncommenting this introduces errors - why?

require('./../../../../vendor/aweber/aweber/aweber_api/aweber_api.php');
//use AWeberAPI;


class PennsouthMdsApp{

    function __construct() {
        # replace XXX with your real keys and secrets
        $this->consumerKey = 'Akz4bgpT5FO6EJZm3M0hkYSu';
        $this->consumerSecret = 'WyKB0vnarrzLlzNxpilQfyTzTUzhhOQDLnfhJ3rF';
        $this->accessToken = 'AgulWM43dmHiQn6DiU2wZcdW';
        $this->accessSecret = '34ZYztLI0wgHCTgh3YsCL765hXNVjS7BjAFBcDM2';

        $this->application = new AWeberAPI($this->consumerKey, $this->consumerSecret);

        // employeeListIdNames is a list of subscriber list-id/Name pairs
        // These are to be excluded from synchronizing with MDS. The synchronization should only be performed
        // between shareholders defined in MDS and subscriber lists defined in AWeber that target shareholders as recipients
        $this->employeeListIdNames = array( 3836498 => "Maintenance Employees",
                                            3842258 => "Employee Emails",  );
    }


       /**
        *
        * modified version of sample found here function getSubscriber email: https://labs.aweber.com/getting_started/private
        **/
       function connectToAWeberAccount() {
            $account = $this->application->getAccount($this->accessToken, $this->accessSecret);

            return $account;

           // print_r($account);
           // print $account->id;

           // account = 936765

           // $foundSubscribers = $account->findSubscribers(array('email' => $email));
           // print_r($foundSubscribers);

           // return $foundSubscribers[0];
        }

        function getEmailNotificationLists($account) {

          try {
              $emailNotificationlists = $account->lists;
              //print_r($emailNotificationlists);
              return $emailNotificationlists;
          } catch (\AWeberAPIException $exc) {
              print "AWeberAPIException\n";
              print "Type: " . $exc->type . "\n";
              print "Msg: " . $exc->message . "\n" ;
              print "Docs: " . $exc->documentation_url . "\n";
          }
      }

      function getSubscribersToEmailNotificationLists( $account, $emailNotificationLists ) {

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
                    }
                    else {
                        print ("\n" . "Not Resident list...");
                    }


                    break; // just for now, for testing looping through the data, so it is not too verbose...
              }


              // comment out the recursive printing of all subscriber data for now...
              // print ( "\n" . "*******  sfrizell - print_r - subscribers...");
              // print_r($subscribers);

             $j = 0;

              // the following foreach iterates through an
 /*             foreach ( $emailNotificationList as $entry) {
                  $j++;
                  print ("\n" . "j: " . $j . "\n");
                //  print_r($entry);
                  if (is_array($entry)) {
                      foreach ($entry as $key => $value ) {
                          echo "\n" . "key/value pair: " . "{$key} => {$value}";
                      }
                  }
                  else {
                      print "\n" . "Not array..." . "\n";
                      print_r($entry);
                  }
              }*/


          }


      }


}

$app = new PennsouthMdsApp();

$account = $app->connectToAWeberAccount();

$emailNotificationLists = $app->getEmailNotificationLists($account);

$app->getSubscribersToEmailNotificationLists( $account, $emailNotificationLists);



?>