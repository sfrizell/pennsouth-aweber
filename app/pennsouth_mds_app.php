<?php
require('../vendor/AWeber-API-PHP-Library-master/aweber_api/aweber_api.php');

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

    function connectToAWeberAccount_orig() {
        list($requestToken, $tokenSecret) = $this->application->getRequestToken('oob');

        echo "Go to this url in your browser: {$this->application->getAuthorizeUrl()}\n";
        echo 'Type code here: ';
        $code = trim(fgets(STDIN));
        $this->application->adapter->debug = true;


        $this->application->user->requestToken = $requestToken;
        $this->application->user->tokenSecret = $tokenSecret;
        $this->application->user->verifier = $code;

        list($accessToken, $accessSecret) = $this->application->getAccessToken();

        print "\n\n$accessToken \n $accessSecret\n";
    }

    // test - modified version of sample found here function getSubscriber email: https://labs.aweber.com/getting_started/private
    function connectToAWeberAccount2() {
         $account = $this->application->getAccount($this->accessToken, $this->accessSecret);
         print_r($account);
         print $account->id;

        // account = 936765

        // $foundSubscribers = $account->findSubscribers(array('email' => $email));
        // print_r($foundSubscribers);

        // return $foundSubscribers[0];
     }

        // test - modified version of sample found here function getSubscriber email: https://labs.aweber.com/getting_started/private
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
          } catch (AWeberAPIException $exc) {
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
              print_r($emailNotificationList);

              //$listURL = $emailNotificationList["url"]; // Fatal error: Cannot use object of type AWeberEntry as array
              $listURL = $emailNotificationList->url;
              print ( "\n" . "List url: " . $listURL);
              $list = $account->loadFromUrl($listURL);

              $subscribers = $list->subscribers;
              print_r($subscribers);


              $listId = $emailNotificationList->data["id"]; // this is list-id - can use this as key for list maintained in
              $listName = $emailNotificationList->data["name"];
              print ( "\n" . "Subscriber list id: " . $listId);
              print ( "\n" . "Subscriber list name: " . $listName);
             $j = 0;

              // the following foreach iterates through an
              foreach ( $emailNotificationList as $entry) {
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
                 // print_r($entry[1]); // Fatal error: Cannot use object of type OAuthApplication as array
              }


          }


      }


}

$app = new PennsouthMdsApp();
//$app->connectToAWeberAccount();
//$app->connectToAWeberAccount2();

$account = $app->connectToAWeberAccount();

$emailNotificationLists = $app->getEmailNotificationLists($account);

$app->getSubscribersToEmailNotificationLists( $account, $emailNotificationLists);



?>