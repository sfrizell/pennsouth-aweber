<?php
/**
 * Emailer.php
 * User: sfrizell
 * Date: 10/17/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Command;


class Emailer
{

    var $mailer;
   // private $transport;
    private $transportRealTime;
    private $emailSubjectLine;
    private $emailBody;
    private $emailRecipients;


    public function __construct(\Swift_Mailer $mailer, $transportRealTime,
                     $emailSubjectLine, $emailBody, $emailRecipients)
    {
        $this->mailer              =  $mailer;
        $this->transportRealTime   = $transportRealTime;
        $this->emailSubjectLine     = $emailSubjectLine;
        $this->emailBody           = $emailBody;
        $this->emailRecipients      = $emailRecipients;
    }

    public function sendEmailMessage() {



               $message = \Swift_Message::newInstance()
                          ->setSubject($this->emailSubjectLine)
                          ->setFrom('DoNotReply@sfnyc.net')
                          ->setBody($this->emailBody);

                foreach ($this->emailRecipients as $emailRecipient) {
                    foreach ($emailRecipient as $emailAddress => $emailRecipientName) {
                        $message->addTo($emailAddress, $emailRecipientName);
                    }
                }

                $result = $this->mailer->send($message); // success returns 1

                //print("\n" . "result of mailer->send message: " . $result);
                //$output->writeln($result);


                $transport = $this->mailer->getTransport();

               if (!$transport instanceof \Swift_Transport_SpoolTransport) {
                   throw new \Exception("Exception in Emailer->setEmailMessage. \$transport not an instance of Swift_Transport_SpoolTransport !");
               }

               $spool = $transport->getSpool();
               if (!$spool instanceof \Swift_MemorySpool) {
                   throw new \Exception("Exception in Emailer->setEmailMessage. \$spool not an instance of Swift_MemorySpool !");
               }

                $spool->flushQueue($this->transportRealTime);


    }

}