<?php
/**
 * Emailer.php
 * User: sfrizell
 * Date: 10/17/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Command;

use Swift_Mailer;
use Swift_Message;
use Swift_Mime_Message;
use Swift_Transport_SpoolTransport;
use Swift_MemorySpool;
use Swift_Attachment;
use Swift_Mime_SimpleMessage;

class Emailer
{

    const PENNSOUTHDATA_SENDER_EMAIL = 'pennsouthdata@gmail.com';
    const PENNSOUTHDATA_SENDER_NAME = 'Penn South';
    var $mailer;
   // private $transport;
    private $transportRealTime;
    private $emailSubjectLine;
    private $emailBody;
    private $emailRecipients;
    private $attachmentFilePath;


    public function __construct(Swift_Mailer $mailer, $transportRealTime,
                     $emailSubjectLine, $emailBody, $emailRecipients, $attachmentFilePath = null)
    {
        $this->mailer              =  $mailer;
        $this->transportRealTime   = $transportRealTime;
        $this->emailSubjectLine     = $emailSubjectLine;
        $this->emailBody           = $emailBody;
        $this->emailRecipients      = $emailRecipients;
        $this->attachmentFilePath   = $attachmentFilePath;
    }

    public function sendEmailMessage() {


        // to add attachment, add this after the ->setBody reference:
        // ->attach(Swift_Attachment::fromPath('/path/to/a/file.zip'))


        if (is_null($this->attachmentFilePath)) {
            $message = Swift_Message::newInstance()
                ->setSubject($this->emailSubjectLine)
                ->setFrom(self::PENNSOUTHDATA_SENDER_EMAIL, self::PENNSOUTHDATA_SENDER_NAME)
                ->setBody($this->emailBody);
        }
        else {
            $message = Swift_Message::newInstance()
                ->setSubject($this->emailSubjectLine)
                ->setFrom(self::PENNSOUTHDATA_SENDER_EMAIL, self::PENNSOUTHDATA_SENDER_NAME)
                ->setBody($this->emailBody)
                ->attach(Swift_Attachment::fromPath($this->attachmentFilePath));
        }

              foreach ($this->emailRecipients as $emailRecipient) {
                    foreach ($emailRecipient as $emailAddress => $emailRecipientName) {
                        $message->addTo($emailAddress, $emailRecipientName);
                    }
              }

/*                    foreach ($this->emailRecipients as $emailAddress => $emailRecipientName) {
                        $message->addTo($emailAddress, $emailRecipientName);
                    }*/

                $result = $this->mailer->send($message); // success returns 1

                //print("\n" . "result of mailer->send message: " . $result);
                //$output->writeln($result);


                $transport = $this->mailer->getTransport();

               if (!$transport instanceof Swift_Transport_SpoolTransport) {
                   throw new \Exception("Exception in Emailer->setEmailMessage. \$transport not an instance of Swift_Transport_SpoolTransport !");
               }

               $spool = $transport->getSpool();
               if (!$spool instanceof Swift_MemorySpool) {
                   throw new \Exception("Exception in Emailer->setEmailMessage. \$spool not an instance of Swift_MemorySpool !");
               }

                $spool->flushQueue($this->transportRealTime);


    }

}