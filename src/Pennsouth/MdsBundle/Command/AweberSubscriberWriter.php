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

class AweberSubscriberWriter
{

    public function __construct($rootDir) {
        require_once $rootDir . '/vendor/aweber/aweber/aweber_api/aweber_api.php';
    }

    public function createAweberSubscriber($account, $emailNotificationList) {

        try {
            $aweberSubscriber = new AweberSubscriber();

            $aweberSubscriber->setEmail('steve.frizell@gmail.com');
            $aweberSubscriber->setName('Stephen Frizell');

            $subscriberCustomFields = array();
          //  $subscriberCustomFields["Pennsouth_Building"] = "1"; // misstyped!
            $subscriberCustomFields["Penn_South_Building"] = "1"; // misstyped!
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
            print "AWeberAPIException in AweberSubscriberWriter->createAweberSubscriber \n";
              print "Type: " . $exc->type . "\n";
              print "Msg: " . $exc->message . "\n" ;
              print "Docs: " . $exc->documentation_url . "\n";
        }



    }

}