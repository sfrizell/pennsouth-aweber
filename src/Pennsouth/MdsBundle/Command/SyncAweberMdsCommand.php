<?php
/**
 * SyncAweberMdsCommand.php
 * User: sfrizell
 * Date: 9/20/16
 *  Function: Command class to enable running the MDS to Aweber synchronization process from the command line.
 */

namespace Pennsouth\MdsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pennsouth\MdsBundle\Command\AweberSubscriberListReader;
use Pennsouth\MdsBundle\Command\AweberSubscriberListsUpdater;
use Pennsouth\MdsBundle\AweberEntity\AweberFieldsConstants;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\InputOption;

use Pennsouth\MdsBundle\Command\PennsouthResidentListReader;

use Symfony\Component\Debug\DebugClassLoader;

//DebugClassLoader::enable();

/**
 * Class SyncAweberMdsCommand
 * @package Pennsouth\MdsBundle\Command
 * run this from the command line by issuing this command:
 *      php app/console app:sync-mds-aweber
 */


class SyncAweberMdsCommand extends ContainerAwareCommand {


    const DEFAULT_ADMINS                    = "steve.frizell@gmail.com";
    const UPDATE_AWEBER_FROM_MDS            = 'update-aweber-from-mds';
    const REPORT_ON_AWEBER_EMAILS_NOT_IN_MDS = 'report-on-aweber-email-not-in-mds';
    const LIST_MANAGEMENT_REPORTS           = 'list-management-reports';

    private $adminEmailRecipients;
    private $runReportOnAweberEmailsNotInMds;
    private $runUpdateAweberFromMds;
    private $runListManagementReports;

    protected function configure() {
        $this
                // the name of the command (the part after "bin/console") <-- (sfrizell) this is syntax for symfony 3.0; version 2.8 should use: php app/console ...
                ->setName('app:sync-mds-aweber')

                // the short description shown while running "php bin/console list"
                ->setDescription('Updates Pennsouth AWeber subscriber email lists from the MDS_Export table.')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp("This command runs the process that updates the Pennsouth Aweber.com subscriber email lists using as input the MDS_Export table..." . "\n"
                            . " The command has required arguments.")

                ->setDefinition(
                    new InputDefinition(array(
                        new InputOption(self::UPDATE_AWEBER_FROM_MDS, 'u', InputOption::VALUE_REQUIRED),
                        new InputOption(self::REPORT_ON_AWEBER_EMAILS_NOT_IN_MDS, 'r', InputOption::VALUE_REQUIRED),
                        new InputOption(self::LIST_MANAGEMENT_REPORTS, 'l', InputOption::VALUE_REQUIRED),
                    ))
                )
            ;


    }

    public function getEntityManager() {
        return $this->getContainer()->get('doctrine')->getManager();
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        // outputs multiple lines to the console (adding "\n" at the end of each line)
            $output->writeln([
                'Invoking the process to read the MDS_Export table and use it to update the Pennsouth subscriber email lists defined in Aweber.com',
                '============',
                '',
            ]);


        $rootDir = $this->getContainer()->getParameter('kernel.root_dir');

        $rootDir = rtrim($rootDir, "/app");

        $fullPathToAweber = $rootDir . AweberFieldsConstants::PATH_TO_AWEBER_UNDER_VENDOR;


        // sample run of the program from the command line shown below:
        // php app/console app:sync-mds-aweber --update-aweber-from-mds true --report-on-aweber-email-not-in-mds false --list-management-reports true

        $this->runReportOnAweberEmailsNotInMds = $input->getOption(self::REPORT_ON_AWEBER_EMAILS_NOT_IN_MDS);

        $this->runUpdateAweberFromMds           = $input->getOption(self::UPDATE_AWEBER_FROM_MDS);

        $this->runListManagementReports         = $input->getOption(self::LIST_MANAGEMENT_REPORTS);


        print("\n" . "\$this->runReportOnAweberEmailsNotInMds: " . $this->runReportOnAweberEmailsNotInMds . "\n");
        print("\n" . "\$this->runUpdateAweberFromMds : " . $this->runUpdateAweberFromMds . "\n");

        print("\n" . "\$this->runListManagementReports: " . $this->runListManagementReports . "\n");
       // print_r($input->getOptions());

        exit(0);

   //     print ("\n @@@@@@@@@  rootDir trimmed: " .  $rootDir . "\n");

        // sfrizell - 10/7/2016 -- following block of code not working get a ContextErrorException running it...
//        $input = new ArgvInput();
//        $env = $input->getParameterOption(array('--env', '-e'), getenv('SYMFONY_ENV') ?: 'dev');
//        $debug = getenv('SYMFONY_DEBUG') !== '0' && !$input->hasParameterOption(array('--no-debug', '')) && $env !== 'prod';
//
//        if ($debug) {
//            Debug::enable();
//        }
//        $pennsouthResidentListReader = new PennsouthResidentListReaderCommand();
//
//        $pennsouthResidentListReader->run($input, $output);


        // sfrizell - comment out block just for now (10/18/2016):

        $entityManager = $this->getEntityManager();

        $pennsouthResidentListReader = new PennsouthResidentListReader($entityManager);


        $residentsWithEmailAddressesArray = $pennsouthResidentListReader->getPennsouthResidentsHavingEmailAddressAssociativeArray();

        // sfrizell - comment out block above just for now (10/18/2016)

  /*      $i = 0;
        foreach ($residentsWithEmailAddressesArray as $emailAddress => $resident) {
            $i++;
            if ($i < 10) {
                print ( "\n" . "emailAddress: " . $emailAddress . " name: " . $resident->getFirstName() . " " . $resident->getLastName());
            }
        }*/

       // exit;

        /** In block below, invoke Aweber API to obtain the following:
         *   a) list of Penn South Admin email recipients, to notify about the status of the running of the MDS to Aweber update process: $adminEmailRecipients
         *   b) the two Penn South Resident subscriber lists (Penn South Newsletter and Emergency Notifications): $emailNotificationLists
        **/
        $aweberSubscriberListReader = new AweberSubscriberListReader($fullPathToAweber);

        $aweberApiInstance = $aweberSubscriberListReader->getAweberApiInstance();

        $success = FALSE;
        $j = 0;
        $emailNotificationLists = array();
        // todo: check if the declaration of $account here below breaks functionality?
        $account = null; // added this declaration 11/4/2016 when code was working without it - but then
                         // how could call to$aweberSubscriberListReader->getSubscribersToEmailNotificationList($account, $emailNotificationList) work without this declaration?
                         // question is does the variable declaration here break anything???
        while (!$success) {
            try {
                $account = $aweberSubscriberListReader->connectToAWeberAccount();

                $emailRecipientsList = $aweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList($account);
                foreach ($emailRecipientsList as $emailRecipient) {
                    $this->adminEmailRecipients .= $emailRecipient . ",";
                }
                $this->adminEmailRecipients = rtrim($this->adminEmailRecipients,",");

                $emailNotificationLists = $aweberSubscriberListReader->getEmailNotificationLists($account);
                $success = TRUE;
            }
            catch (\Exception $exception) {
                if ($exception->getMessage() == "ServiceUnavailableError") {
                    $j++;
                    $maxJ= 6;
                    if ($j < $maxJ) {
                        print("\n" . "AweberAPI Service temporarily unavailable while trying to call AweberSubscriberListReader->getEmailNotificationLists. ");
                        print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                        sleep(120);
                    }
                    else {
                        $subjectLine = "Fatal exception encountered in MDS -> AWeber Update Program";
                        $messageBody =  "\n" . "Aweber API ServiceUnavailableError Exception occurred! Exception->getMessage() : " . $exception->getMessage() . "\n";
                        $messageBody .= "Failed even after trying and trying again after going to sleep {$maxJ} - 1 times.";
                        $this->sendEmailtoAdmins($subjectLine, $messageBody);
                        throw $exception;
                    }
                }
                else {
                    print("\n" . "Exception occurred! Exception->getMessage() : " . $exception->getMessage());
                    print("\n" . "Exiting from program.");
                    $subjectLine = "Fatal exception encountered in MDS -> AWeber Update Program";
                    $messageBody =  "\n" . "Exception occurred! Exception->getMessage() : " . $exception->getMessage() . "\n";
                    $this->sendEmailtoAdmins($subjectLine, $messageBody);
                    throw $exception;
                }
            }
        }

       // $aweberSubscriberListReader->getSubscribersToEmailNotificationLists($account, $emailNotificationLists);
       // print("\n" . "0");

        /**
         *   In block below, obtain the list of Penn South Subscribers to each of the Penn South Resident subscriber lists obtained from the block above
         */

        $aweberSubscribersByListNames = array();
        $success = FALSE;
        $j = 0;
        while (!$success) {
            try {
                foreach ($emailNotificationLists as $emailNotificationList) {

                   // print("\n" . "1");
                    $listName = $emailNotificationList->data["name"];

                    // returns associative array : key = name of aWeberSubscriberList ; value = array of AweberSubscriber objects
                    $aweberSubscribersByListNames[] = $aweberSubscriberListReader->getSubscribersToEmailNotificationList($account, $emailNotificationList);
                    $success = TRUE;

                    print("\n" . " List Name: " . $listName . "\n");
                    /*       if ($listName == "frizell_test") {
                               print("\n" . "2");
                               $aweberSubscriberWriter = new AweberSubscriberWriter($rootDir);

                               print("\n" . "3");
                               $subscriber = $aweberSubscriberWriter->createAweberSubscriberTest($account, $emailNotificationList);
                               print ("\n" . "!!!!!!!!!!!   subscriber: " . "\n");
                               print_r($subscriber);
                           }*/

                }
            }
            catch (\Exception $exception){
                    if ($exception->getMessage() == "ServiceUnavailableError") {
                        $j++;
                        if ($j < 6) { // 6 is arbitrary number of tries...
                            print("\n" . "AweberAPI Service temporarily unavailable when trying to call AweberSubscriberListReader->getSubscribersToEmailNotificationList. ");
                            print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                            sleep(120);
                        }
                    }
                    else {
                        print("\n" . "Exception occurred! Exception->getMessage() : " . $exception->getMessage());
                        print("\n" . "Exiting from program.");
                        $subjectLine = "Fatal exception encountered in MDS -> AWeber Update Program";
                        $messageBody =  "\n" . "Exception occurred! Exception->getMessage() : " . $exception->getMessage();
                        $this->sendEmailtoAdmins($subjectLine, $messageBody);
                        throw $exception;
                    }
            }
        }

        $checkForAweberSubscribersNotInMDS = false;
        if ($success) {
            $mdsToAweberComparator = new MdsToAweberComparator($this->getEntityManager(), $residentsWithEmailAddressesArray, $aweberSubscribersByListNames);
            // todo: a) invoke the compareAweberToMds function - done
            // todo: (b) write new method to perform the Aweber inserts/updates to subscriber lists - done
            // todo: (c) write new method to insert into AweberMdsSyncAudit what has been inserted/updated
            // todo: (d) generate summary statistics in email to admins
            // todo:  (e) write requested list management spreadsheets from the application.
            if ($this->runReportOnAweberEmailsNotInMds) { // following method invoked just to allow Penn South Management Office to sync up Aweber with MDS; once done,
                                                      // we should not need to run the following any longer...
                $mdsToAweberComparator->reportOnAweberSubscribersWithNoMatchInMds();
                print("\n" . "Report on Aweber Subscribers with No Match in MDS. Processing completed successfully.");
                $subjectLine = "Report on Aweber Subscribers with No Match in MDS: Processing Successfully Completed.";
                $messageBody =  "Results of comparison of Aweber subscriber lists with MDS are stored in the pennsouth_db database.";
                $this->sendEmailtoAdmins($subjectLine, $messageBody);
            }
            if ($this->runUpdateAweberFromMds) { // once in production, this should always be true...
                $aweberSubscriberUpdateInsertLists = $mdsToAweberComparator->compareAweberWithMds();
                if (!$aweberSubscriberUpdateInsertLists->isUpdateListAndInsertListEmpty()) { // MDS has data that is not yet reflected in Aweber; need to insert/update Aweber from MDS...
                    // - invoke method to insert/update Aweber subscriber lists from MDS
                    // - invoke method to create an audit trail of the inserts/updates to Aweber
                    // - send summary statistics to Penn South Admins
                    $aweberSubscriberListsUpdater = new AweberSubscriberListsUpdater($fullPathToAweber, $aweberApiInstance);
                    $aweberSubscriberListsUpdater->updateAweberSubscriberLists($account, $aweberSubscriberUpdateInsertLists);
                    $aweberUpdateSummary = $mdsToAweberComparator->storeAuditTrailofUpdatesToAweberSubscribers($aweberSubscriberUpdateInsertLists);
                }
                print("\n" . "Processing completed successfully.");
                $subjectLine = "MDS -> AWeber Update Program: Processing Successfully Completed.";
                $messageBody =  "Processing completed successfully in MDS to AWeber Update program.";
                $this->sendEmailtoAdmins($subjectLine, $messageBody);
            }
        }
        else { // not $success
            print("\n" . "An error occurred in the Sync Aweber from MDS program. Processing did not complete successfully!");
            $subjectLine = "MDS -> AWeber Update Program did NOT complete successfully. ";
            $messageBody =  "\n" . "Processing failed in MDS to AWeber Update program." . "\n" . "\$success flag was not set to true. An undetermined error occurred.";
            $this->sendEmailtoAdmins($subjectLine, $messageBody);

            throw new \Exception("End of program. \$success flag not set to true. An error occurred in the Sync Aweber from MDS program. Processing did not complete successfully!");
        }

    //    $account = $app->connectToAWeberAccount();

    //    $emailNotificationLists = $app->getEmailNotificationLists($account);

    //    $app->getSubscribersToEmailNotificationLists( $account, $emailNotificationLists);


            // outputs a message followed by a "\n"
           // $output->writeln('Whoa!');

            // outputs a message without adding a "\n" at the end of the line
          //  $output->write('You are about to ');
           // $output->write('create a user.');

    }

    private function sendEmailtoAdmins( $subjectLine, $messageBody) {
          $mailer = $this->getContainer()->get('mailer');
          $emailSubjectLine = $subjectLine;
          $emailRecipients = null;
          if (!is_null($this->adminEmailRecipients)) {
              $emailRecipients = $this->adminEmailRecipients;
              print("\n" . "Sending to recipients obtained from Aweber subscriber list admin_mds_to_aweber ");
          }
          else {
              $emailRecipients = self::DEFAULT_ADMINS;
          }
          $emailBody = $messageBody;

          $emailer = new Emailer($mailer, $this->getContainer()->get('swiftmailer.transport.real'), $emailSubjectLine, $emailBody, $emailRecipients);


          $emailer->sendEmailMessage();

    }

}