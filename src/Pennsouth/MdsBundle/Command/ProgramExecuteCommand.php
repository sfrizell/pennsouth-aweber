<?php
/**
 * SyncAweberMdsCommand.php
 * User: sfrizell
 * Date: 9/20/16
 *  Function: Command class to enable running the MDS to Aweber synchronization process from the command line.
 */

namespace Pennsouth\MdsBundle\Command;

use Pennsouth\MdsBundle\AweberEntity\AweberUpdateSummary;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Symfony\Component\Console\Command\Command;
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


    const DEFAULT_ADMINS                    =  array ( array("steve.frizell@gmail.com" => "Stephen Frizell"));
    const UPDATE_AWEBER_FROM_MDS            = 'update-aweber-from-mds';
    const REPORT_ON_AWEBER_EMAILS_NOT_IN_MDS = 'report-on-aweber-email-not-in-mds';
    const REPORT_ON_AWEBER_UPDATES_FROM_MDS = 'report-on-aweber-updates-from-mds';
    const REPORT_ON_APTS_WITH_NO_EMAIL      = 'report-on-apts-where-no-resident-has-email-address';
    const PARKING_LOT_REPORT                = 'parking-lot-report';
    const HOMEOWNERS_INSURANCE_REPORT       = 'homeowners-insurance-report';
    const APP_OUTPUT_DIRECTORY_DEV          = "/app_output";
    const APP_OUTPUT_DIRECTORY_PROD         = "/home/pennsouthdata/home/mgmtoffice/public_ftp";
    const ENVIRONMENT_DEV                   = 'dev';
    const ENVIRONMENT_PROD                  = 'prod';

    private $adminEmailRecipients = array();
    private $runReportOnAweberEmailsNotInMds;
    private $runReportOnAptsWithNoEmail;
    private $runUpdateAweberFromMds;
    private $runReportOnAweberUpdatesFromMds;
    private $runParkingLotReport;
    private $runHomeownersInsuranceReport;
    private $emailNotifyReportOrProcess;

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
                        new InputOption(self::UPDATE_AWEBER_FROM_MDS, 'u', InputOption::VALUE_REQUIRED, 'Option to update Aweber from MDS input: y/n', 'y'),
                        new InputOption(self::REPORT_ON_AWEBER_EMAILS_NOT_IN_MDS, 'a', InputOption::VALUE_REQUIRED, 'Option to report on subscriber email addresses in Aweber and not in MDS: y/n', 'n'),
                        new InputOption(self::PARKING_LOT_REPORT, 'p', InputOption::VALUE_REQUIRED, 'Option to create Parking Lot Report: y/n', 'n'),
                        new InputOption(self::HOMEOWNERS_INSURANCE_REPORT, 'i', InputOption::VALUE_REQUIRED, 'Option to create Homeowners Insurance Report: y/n', 'n'),
                        new InputOption(self::REPORT_ON_AWEBER_UPDATES_FROM_MDS, 'r', InputOption::VALUE_REQUIRED, 'Option to create spreadsheet listing details of updates of Aweber from MDS.: y/n', 'n'),
                        new InputOption(self::REPORT_ON_APTS_WITH_NO_EMAIL, 'b', InputOption::VALUE_REQUIRED, 'Option to create spreadsheet listing apts where no resident has email address.: y/n', 'n'),
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

        // just a little test
/*        $updateCtr = 0;
        $batchSize = 30;
        while ($updateCtr < 35)
        {
        	$updateCtr++;

        	$modulo = $updateCtr % $batchSize;
        	print("\n" . "\$updateCtr: " . $updateCtr . " \$modulo: " . $modulo );
        }

        exit(0);*/

        $runStartDate = new \DateTime("now");
        print("\n" . "Program run start date/time: " . $runStartDate->format('Y-m-d H:i:s') . "\n");

        print ("\n getenv('SYMFONY_ENV'): " . getenv('SYMFONY_ENV') . "\n");



        $rootDir = $this->getContainer()->getParameter('kernel.root_dir');

        $rootDir = rtrim($rootDir, "/app");

        // get environment -- 'prod' or 'dev' -- on production server, this environment variable ( 'SYMFONY_ENV') is set in root's .bash_profile
        //  when it is not explicitly set, it will get set to the default value of 'dev'
        // print ( "\n \$this->getContainer()->get('kernel')->getEnvironment(): " . $this->getContainer()->get('kernel')->getEnvironment() . "\n" );

        $env = $this->getContainer()->get('kernel')->getEnvironment();

        print("\n   environment: " . $env . "\n");

        if ($env == self::ENVIRONMENT_PROD) {
            $appOutputDir = self::APP_OUTPUT_DIRECTORY_PROD;
        }
        else {
            $appOutputDir = $rootDir . self::APP_OUTPUT_DIRECTORY_DEV;
        }

        print("\n \$rootDir: " . $rootDir . "\n");

        print("\n \$appOutputDir: " . $appOutputDir . "\n");

        print ("\n current_user: " . get_current_user() . "\n");


        $fullPathToAweber = $rootDir . AweberFieldsConstants::PATH_TO_AWEBER_UNDER_VENDOR;


        // sample run of the program from the command line shown below:
        // php app/console app:sync-mds-aweber --update-aweber-from-mds true --report-on-aweber-email-not-in-mds false --list-management-reports true


        // default is FALSE, so anything other than parameter of 'y' is interpreted as FALSE...
        $this->runReportOnAweberEmailsNotInMds = ( is_null($input->getOption(self::REPORT_ON_AWEBER_EMAILS_NOT_IN_MDS)) ? FALSE
                                : ( strtolower($input->getOption(self::REPORT_ON_AWEBER_EMAILS_NOT_IN_MDS)) == 'y' ? TRUE : FALSE ) );

        // default is TRUE, so anything other than parameter of 'n' is interpreted as TRUE...
        $this->runUpdateAweberFromMds = ( is_null( $input->getOption(self::UPDATE_AWEBER_FROM_MDS)) ? TRUE
                                        : ( strtolower($input->getOption(self::UPDATE_AWEBER_FROM_MDS)) == 'n' ? FALSE : TRUE ) );

        // default is FALSE, so anything other than parameter of 'y' is interpreted as FALSE...
        $this->runParkingLotReport = ( is_null( $input->getOption(self::PARKING_LOT_REPORT)) ? FALSE
                                        : ( strtolower($input->getOption(self::PARKING_LOT_REPORT)) == 'y' ? TRUE : FALSE ) );

        // default is FALSE, so anything other than parameter of 'y' is interpreted as FALSE...
        $this->runHomeownersInsuranceReport = ( is_null( $input->getOption(self::HOMEOWNERS_INSURANCE_REPORT)) ? FALSE
                                        : ( strtolower($input->getOption(self::HOMEOWNERS_INSURANCE_REPORT)) == 'y' ? TRUE : FALSE ) );

        // default is FALSE, so anything other than parameter of 'y' is interpreted as FALSE...
        $this->runReportOnAweberUpdatesFromMds = ( is_null( $input->getOption(self::REPORT_ON_AWEBER_UPDATES_FROM_MDS)) ? FALSE
                                        : ( strtolower($input->getOption(self::REPORT_ON_AWEBER_UPDATES_FROM_MDS)) == 'y' ? TRUE : FALSE ) );

        // default is FALSE, so anything other than parameter of 'y' is interpreted as FALSE...
        $this->runReportOnAptsWithNoEmail = ( is_null( $input->getOption(self::REPORT_ON_APTS_WITH_NO_EMAIL)) ? FALSE
                                        : ( strtolower($input->getOption(self::REPORT_ON_APTS_WITH_NO_EMAIL)) == 'y' ? TRUE : FALSE ) );


        $processCtr = 0;
        if ($this->runUpdateAweberFromMds) {
            print ("\n" . "run update from MDS set to true. \n");
            $emailNotifyReportOrProcess = self::UPDATE_AWEBER_FROM_MDS;
            $processCtr++;
        }
        else {
            print ("\n" . "run update from MDS set to false. \n");
        }

        if ($this->runReportOnAweberEmailsNotInMds) {
            print ("\n" . "run report on Aweber Emails not in MDS set to true. \n");
            $emailNotifyReportOrProcess = self::REPORT_ON_AWEBER_EMAILS_NOT_IN_MDS;
            $processCtr++;
        }
        else {
            print ("\n" . "run report on Aweber Emails not in MDS set to false. \n");
        }

        if ($this->runParkingLotReport) {
            print ("\n" . "run Parking Lot Report set to true. \n");
            $emailNotifyReportOrProcess = self::PARKING_LOT_REPORT;
            $processCtr++;
        }
        else {
            print ("\n" . "run Parking Lot Report set to false. \n");
        }


        if ($this->runHomeownersInsuranceReport) {
            print ("\n" . "run Homeowners Insurance Report set to true. \n");
            $emailNotifyReportOrProcess = self::HOMEOWNERS_INSURANCE_REPORT;
            $processCtr++;
        }
        else {
            print ("\n" . "run Homeowners Insurance Report set to false. \n");
        }

        if ($this->runReportOnAptsWithNoEmail) {
            print ("\n" . "Run Report on Apartments with No Email Address set to true. \n");
            $emailNotifyReportOrProcess = self::REPORT_ON_APTS_WITH_NO_EMAIL;
            $processCtr++;
        }
        else {
            print ("\n" . "Run Report on Apartments with No Email Address set to false. \n");
        }

        if ($this->runReportOnAweberUpdatesFromMds) {
            print ("\n" . "run report (generate spreadsheet) on Aweber updates from MDS set to true. \n");
            print ("\n" . "Because of memory limitations it is not possible to also run the Aweber updates from MDS. It is being set to FALSE. \n");
            $this->runUpdateAweberFromMds = FALSE;
            $emailNotifyReportOrProcess = self::REPORT_ON_AWEBER_UPDATES_FROM_MDS;
            $processCtr++;
        }
        else {
            print ("\n" . "run report (generate spreadsheet) on Aweber updates from MDS set to false. \n");
        }

        if ($processCtr > 1) {
            print("\n Command line parameters have been set to run more than one process / report in this run of the program. Please limit the run parameters to one process or report. \n");
            print("\n Program is exiting. Adjust parameters and resubmit.");
            exit(1);
        }

        // Seems to need 128M (32M default setting on Rose Hosting server is too little - Doctrine query runs out of memory in select from pennsouth_resident...
        $memory_limit = ini_get('memory_limit');
        print("\n memory_limit: " . $memory_limit);



   //     print ("\n @@@@@@@@@  rootDir trimmed: " .  $rootDir . "\n");


        /** In block below, invoke Aweber API to obtain the following:
         *   a) list of Penn South Admin email recipients, to notify about the status of the running of the MDS to Aweber update process: $adminEmailRecipients
         *   b) the two Penn South Resident subscriber lists ('Primary Resident List' and 'Penn South Emergency Info Only'): $emailNotificationLists
        **/

        // test below


  /*     $entityManager = $this->getEntityManager();

        $pennsouthResidentListReader = new PennsouthResidentListReader($entityManager);


        $residentsWithEmailAddressesArray = $pennsouthResidentListReader->getPennsouthResidentsHavingEmailAddressAssociativeArray();

         $aweberSubscriberListReader = new AweberSubscriberListReader($fullPathToAweber);

          $account = $aweberSubscriberListReader->connectToAWeberAccount();
          print("\n" . "Connected to AweberAccount...");
          $aweberApiInstance = $aweberSubscriberListReader->getAweberApiInstance();


         $aweberSubscriberWriter = new AweberSubscriberWriter($fullPathToAweber, $aweberApiInstance);

        $mdsToAweberComparator = new MdsToAweberComparator($this->getEntityManager(), $residentsWithEmailAddressesArray);

        $pennsouthResident = null;
        foreach ( $residentsWithEmailAddressesArray as $residentWithEmailAddress ) {
            if ($residentWithEmailAddress->getEmailAddress() == 'sfnyc.net@gmail.com') {
                $pennsouthResident = $residentWithEmailAddress;
            }
        }

        $aweberSubscriberTest = $mdsToAweberComparator->createAweberSubscriberFromMdsInput(MdsToAweberComparator::INSERT, $pennsouthResident);
          $emailNotificationLists = array();

                $account = null; // added this declaration 11/4/2016 when code was working without it - but then
                                 // how could call to$aweberSubscriberListReader->getSubscribersToEmailNotificationList($account, $emailNotificationList) work without this declaration?
                                 // question is does the variable declaration here break anything???

                try {
                    $account = $aweberSubscriberListReader->connectToAWeberAccount();


                    $emailNotificationLists = $aweberSubscriberListReader->getEmailNotificationLists($account);

                }
                catch (\Exception $exception) {

                        print("\n" . "Exception occurred when invoking AweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList and ->getEmailNotificationsLists! \n");
                        print ("Exception->getMessage() : " . $exception->getMessage() . "\n");
                        print("\n" . "Exiting from program.");
                        $subjectLine = "Fatal exception encountered in MDS -> AWeber Update Program";
                        $messageBody =  "\n" . "Exception occurred! Exception->getMessage() : " . $exception->getMessage() . "\n";
                        $messageBody .= "\n" . "Exception stack trace: " . $exception->getTraceAsString();
                        $this->sendEmailtoAdmins($subjectLine, $messageBody);
                        throw $exception;
                    }

        $emailNotificationList = $emailNotificationLists[AweberFieldsConstants::FRIZELL_TEST_LIST];
        print("\n -- SyncAweberMdsCommand - 1");
              //  print_r($emailNotificationList);

                print("\n -- SyncAweberMdsCommand - 2");

        $aweberEntry = $aweberSubscriberWriter->createAweberSubscriberTest($account, $emailNotificationList, $aweberSubscriberTest);

        print("\n" . "Subscriber inserted: Aweber entry: \n");
        print_r($aweberEntry);
        print("\n" . "End of test... \n");

        exit(0);*/
        // test above


        $this->adminEmailRecipients = null;
        //$emailNotificationLists = array();
        $account = null; // added this declaration 11/4/2016 when code was working without it - but then
                         // how could call to$aweberSubscriberListReader->getSubscribersToEmailNotificationList($account, $emailNotificationList) work without this declaration?
                         // question is does the variable declaration here break anything???

        try {
            $aweberSubscriberListReader = new AweberSubscriberListReader($this->getEntityManager());
           // $aweberSubscriberListReader = new AweberSubscriberListReader($fullPathToAweber);
            $account = $aweberSubscriberListReader->connectToAWeberAccount();

            $aweberApiInstance = $aweberSubscriberListReader->getAweberApiInstance();

            $this->adminEmailRecipients = $aweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList($account);


            $emailNotificationLists = $aweberSubscriberListReader->getEmailNotificationLists($account);

        }
        catch (\Exception $exception) {

                print("\n" . "Exception occurred when invoking AweberSubscriberListReader->getSubscribersToAdminsMdsToAweberList and ->getEmailNotificationsLists! \n");
                print ("Exception->getMessage() : " . $exception->getMessage() . "\n");
                print("\n" . "Exiting from program.");
                $subjectLine = "Fatal exception encountered in MDS -> AWeber Update Program";
                $messageBody =  "\n" . "Exception occurred! Exception->getMessage() : " . $exception->getMessage() . "\n";
                $messageBody .= "\n" . "Exception stack trace: " . $exception->getTraceAsString();
                $this->sendEmailtoAdmins($subjectLine, $messageBody);
                exit(1);
        }

       // print("\n ------- 1 -----------\n");

        if ($this->runParkingLotReport) {
             try {
                 $phpExcel = $this->getContainer()->get('phpexcel');
                 $homeownersInsuranceReportCreator = new ManagementReportsCreator($this->getEntityManager(), $phpExcel, $appOutputDir, $env);
                 $homeownersInsuranceReportCreator->generateParkingLotList();
                 $subjectLine = "Pennsouth Parking Lot List Created.";
                 $messageBody = "\n The Pennsouth Parking Lot List spreadsheet has been created and is attached to this email. It is also available on the Pennsouth Ftp Server. \n";
                 $attachmentFilePath = $appOutputDir . "/" . ManagementReportsCreator::PARKING_LOT_LIST_FILE_NAME;
                 $this->sendEmailtoAdmins($subjectLine, $messageBody, $attachmentFilePath);
             }
             catch (\Exception $exception) {
                 print("\n Exception encountered when running the Parking Lot Report.");
                 print("\n Exception->getMessage(): " . $exception->getMessage());
                 print("\n stacktrace: " . $exception->getTraceAsString());
                 print("\n Exiting from program.");
                 $subjectLine = "Fatal exception encountered in MDS -> AWeber Update Program in section where Parking Lot Report is created.";
                 $messageBody =  "\n Exception->getMessage() : " . $exception->getMessage() . "\n";
                 $messageBody .= "\n" . "Exception stack trace: " . $exception->getTraceAsString();
                 $this->sendEmailtoAdmins($subjectLine, $messageBody);
                 exit(1);
             }
        }

        if ($this->runHomeownersInsuranceReport) {
             try {
                 $homeownersInsuranceReportCreator = new ManagementReportsCreator($this->getEntityManager(), null, $appOutputDir, $env);
                 $homeownersInsuranceReportCreator->createHomeownersInsuranceReport();
                 $subjectLine = "Pennsouth Homeowners Insurance Report Created.";
                 $messageBody = "\n The Pennsouth Homeowners Insurance Report has been created and is attached to this email. It is also available on the Pennsouth Ftp Server. \n";
                 $attachmentFilePath = $appOutputDir . "/" . ManagementReportsCreator::HOMEOWNERS_INSURANCE_REPORT_FILE_NAME;
                 $this->sendEmailtoAdmins($subjectLine, $messageBody, $attachmentFilePath);
             }
             catch (\Exception $exception) {
                 print("\n Exception encountered when running the Homeowners Insurance Report.");
                 print("\n Exception->getMessage(): " . $exception->getMessage());
                 print("\n stacktrace: " . $exception->getTraceAsString());
                 print("\n Exiting from program.");
                 $subjectLine = "Fatal exception encountered in MDS -> AWeber Update Program in section where the Homeowners Insurance Report is created.";
                 $messageBody =  "\n Exception->getMessage() : " . $exception->getMessage() . "\n";
                 $messageBody .= "\n" . "Exception stack trace: " . $exception->getTraceAsString();
                 $this->sendEmailtoAdmins($subjectLine, $messageBody);
                 exit(1);
             }
        }


        if ($this->runReportOnAptsWithNoEmail) {
            try {
                $phpExcel = $this->getContainer()->get('phpexcel');
                $aptsWithNoResidentHavingEmailAddressListCreator = new AptsWithNoResidentHavingEmailAddressListCreator($this->getEntityManager(), $phpExcel, $appOutputDir, $env);
                $aptsWithNoResidentHavingEmailAddressListCreator->createSpreadsheetAptsWithNoEmailAddresses();
                $subjectLine = "List of Apartments With No Email Address Created.";
                $messageBody = "\n A document containing a list of apartments with no resident having an email address has been created. \n ";
                $messageBody .= " \n The spreadsheet is attached to this email. It is also available on the Pennsouth Ftp Server. \n";
                $attachmentFilePath = $appOutputDir . "/" . AptsWithNoResidentHavingEmailAddressListCreator::LIST_APTS_WITH_NO_EMAIL_ADDRESS_FILE_NAME;
                $this->sendEmailtoAdmins($subjectLine, $messageBody, $attachmentFilePath);
                exit(0);
            } catch (\Exception $exception) {
                print("\n Exception encountered when running the function to create a list of apartments where no resident has email.");
                print("\n Exception->getMessage(): " . $exception->getMessage());
                print("\n stacktrace: " . $exception->getTraceAsString());
                print("\n Exiting from program.");
                $subjectLine = "Fatal exception encountered in MDS -> AWeber Update Program in section where list of apartments with no email address is generated.";
                $messageBody = "\n Exception->getMessage() : " . $exception->getMessage() . "\n";
                $messageBody .= "\n" . "Exception stack trace: " . $exception->getTraceAsString();
                $this->sendEmailtoAdmins($subjectLine, $messageBody);
                exit(1);
            }
        }


        // block to generate spreadsheet of MDS -> Aweber updates.
        // **** NOTE: Because of memory limitations, this step must be run by itself without other application functionality options being invoked.
        try {
            if ($this->runReportOnAweberUpdatesFromMds) {
                $phpExcel = $this->getContainer()->get('phpexcel');
                $aweberMdsAuditListCreator = new AweberMdsSyncAuditListCreator($this->getEntityManager(), $phpExcel, $appOutputDir);
                $aweberMdsAuditListCreator->createSpreadsheetAweberUpdatesList();
                $subjectLine = "Report Generated on Aweber.com updates from MDS";
                $messageBody = "\n Spreadsheet report generated listing details of updates of Pennsouth resident subscriber lists in Aweber from MDS. \n" ;
                $messageBody .= "\n The spreadsheet is available on the Pennsouth ftp server. \n";
                $this->sendEmailtoAdmins($subjectLine, $messageBody);
                $runEndDate = new \DateTime("now");
                print("\n" . "Program run end date/time: " . $runEndDate->format('Y-m-d H:i:s') . "\n");
                exit(0);
            }

        }
        catch (\Exception $exception) {

            print("\n" . "Exception occurred in section of SyncAweberMdsCommand where spreadsheet is generated reportin on MDS to Aweber updates! Exception->getMessage() : " . $exception->getMessage());
            print("\n" . "Exiting from program.");
            $subjectLine = "Fatal exception encountered when attempting to generate spreadsheet reporting on MDS to Aweber updates!";
            $messageBody = "\n" . "Exception occurred in section of SyncAweberMdsCommand where spreadsheet is generated to report on MDS to Aweber updates! Exception->getMessage() : " . $exception->getMessage();
            $messageBody .= "\n" . "Exception stack trace: " . $exception->getTraceAsString();
            $this->sendEmailtoAdmins($subjectLine, $messageBody);
            throw $exception;
        }



        // check whether there is anything left to do...
       if (!$this->runUpdateAweberFromMds and !$this->runReportOnAweberEmailsNotInMds) {
           print("\n Neither the flag to run the Update Aweber from MDS nor the flag to run Reports on Aweber Emails Not in MDS is set to true. \n");
           print("\n So nothing left to do. Exiting the program. \n");
           exit(0);
       }


        /**
         *   In block below, obtain the list of Penn South Subscribers to each of the Penn South Resident subscriber lists obtained from the block above
         */
        $aweberSubscribersByListNames = array();
        try {

            $entityManager = $this->getEntityManager();

            $pennsouthResidentListReader = new PennsouthResidentListReader($entityManager);


            // The following commented-out code turns on SQL logging for Doctrine - prints out the SQL that gets created from the DQL calls.
/*            $this
                ->getEntityManager()
                ->getConnection()
                ->getConfiguration()
                ->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());*/

            $residentsWithEmailAddressesArray = $pennsouthResidentListReader->getPennsouthResidentsHavingEmailAddressAssociativeArray();


            foreach ($emailNotificationLists as $emailNotificationList) {

                $listName = $emailNotificationList->data["name"];

                print("\n" . " List Name: " . $listName . "\n");

                // returns associative array : key = name of aWeberSubscriberList ; value = array of AweberSubscriber objects
                $aweberSubscribersByListNames[] = $aweberSubscriberListReader->getSubscribersToEmailNotificationList($account, $emailNotificationList);


            }
        }

        catch (\Exception $exception) {
            print("\n" . "Exception occurred when trying to call AweberSubscriberListReader->getSubscribersToEmailNotificationList! Exception->getMessage() : " . $exception->getMessage());
            print("\n" . "Exiting from program.");
            $subjectLine  = "Fatal exception encountered in MDS -> AWeber Update Program";
            $messageBody  =  "\n" . "Exception occurred! Exception->getMessage() : " . $exception->getMessage();
            $messageBody .=  "\n" . "Exception occurred! Exception->getCode() : " . $exception->getCode();
            $messageBody .= "\n" . "Exception stack trace: " . $exception->getTraceAsString();
            $this->sendEmailtoAdmins($subjectLine, $messageBody);
            throw $exception;
        }


        try {
            $mdsToAweberComparator = new MdsToAweberComparator($this->getEntityManager(), $residentsWithEmailAddressesArray, $aweberSubscribersByListNames);
            if ($this->runReportOnAweberEmailsNotInMds) { // following method invoked just to allow Penn South Management Office to sync up Aweber with MDS; once done,
                // we should not need to run the following any longer...
                $mdsToAweberComparator->reportOnAweberSubscribersWithNoMatchInMds();
                print("\n" . "Report on Aweber Subscribers with No Match in MDS. Processing completed successfully.");
                $subjectLine = "Report on Aweber Subscribers with No Match in MDS: Processing Successfully Completed.";
                $messageBody = "Results of comparison of Aweber subscriber lists with MDS are stored in the pennsouth_db database.";
                $this->sendEmailtoAdmins($subjectLine, $messageBody);
               // $subjectLine = "Pennsouth List of Residents with Aweber.com Email Addresses not in MDS Successfully Created.";
               // $messageBody = "\n The report on Pennsouth residents with Aweber Email addresses not found in MDS is available on the Pennsouth Ftp Server. \n";
               // $this->sendEmailtoAdmins($subjectLine, $messageBody);
            }
            if ($this->runUpdateAweberFromMds) { // once in production, this should always be true...
                $aweberSubscriberUpdateInsertLists = $mdsToAweberComparator->compareAweberWithMds();
                $aweberUpdateSummary = null;
                $messageBody = null;
                if (!$aweberSubscriberUpdateInsertLists->isUpdateListAndInsertListEmpty()) { // MDS has data that is not yet reflected in Aweber; need to insert/update Aweber from MDS...
                    // - invoke method to insert/update Aweber subscriber lists from MDS
                    // - invoke method to create an audit trail of the inserts/updates to Aweber
                    // - send summary statistics to Penn South Admins
                    $aweberSubscriberListsUpdater = new AweberSubscriberListsUpdater($fullPathToAweber, $aweberApiInstance, $emailNotificationLists);
                    $errorMessages = $aweberSubscriberListsUpdater->updateAweberSubscriberLists($account, $aweberSubscriberUpdateInsertLists);
                    $aweberUpdateSummary = $mdsToAweberComparator->storeAuditTrailofUpdatesToAweberSubscribers($aweberSubscriberUpdateInsertLists);
                    // todo : evaluate whether it will be okay to create the spreadsheet reporting on the updates in the same run as the update...
                    // $phpExcel = $this->getContainer()->get('phpexcel');
                   /* $aweberMdsAuditListCreator = new AweberMdsSyncAuditListCreator($this->getEntityManager(), $phpExcel, $appOutputDir);
                    $aweberMdsAuditListCreator->createSpreadsheetAweberUpdatesList(); */
                    $subjectLine = "MDS -> AWeber Update Program: Processing Successfully Completed.";
                    $messageBody = "RunUpdateAweberFromMds: Processing completed successfully in MDS to AWeber Update program." . "\n\n";
                    $messageBody = $this->buildMessageBodyForEmailToAdmins($messageBody, $aweberUpdateSummary, $errorMessages);
                    $this->sendEmailtoAdmins($subjectLine, $messageBody);
                } else {
                    $subjectLine = "MDS -> AWeber Update Program: Processing Successfully Completed.";
                    $messageBody = "RunUpdateAweberFromMds: Processing completed successfully in MDS to AWeber Update program. However, no updates or inserts were performed.";
                    $this->sendEmailtoAdmins($subjectLine, $messageBody);
                }

                print("\n" . "RunUpdateAweberFromMds: Processing completed successfully.");
            }
        } catch (\Exception $exception) {

            print("\n" . "Exception occurred in section of SyncAweberMdsCommand where mdstoAweberComparator is invoked! Exception->getMessage() : " . $exception->getMessage());
            print("\n" . "Exiting from program.");
            $subjectLine = "Fatal exception encountered in MDS -> AWeber Update Program";
            $messageBody = "\n" . "Exception occurred in section of SyncAweberMdsCommand where mdstoAweberComparator is invoked! Exception->getMessage() : " . $exception->getMessage();
            $messageBody .= "\n" . "Exception stack trace: " . $exception->getTraceAsString();
            $this->sendEmailtoAdmins($subjectLine, $messageBody);
            throw $exception;
        }



        // block to generate spreadsheet of MDS -> Aweber updates.
        // **** NOTE: Because of memory limitations, this step must be run by itself without other application functionality options being invoked.
       try {
           if ($this->runReportOnAweberEmailsNotInMds) {
               $phpExcel = $this->getContainer()->get('phpexcel');
               $aweberMdsAuditListCreator = new AweberMdsSyncAuditListCreator($this->getEntityManager(), $phpExcel, $appOutputDir);
               $aweberMdsAuditListCreator->createSpreadsheetAweberEmailAddressesNotInMds();
               $subjectLine = "Report Created of Email Addresses found in Aweber.com but not in MDS";
               $messageBody = "\n Spreadsheet report created listing email addresses of Pennsouth residents found in Aweber but not in MDS. \n" ;
               $messageBody .= "\n The spreadsheet is attached to this email. It is also available on the Pennsouth ftp server. \n";
               $attachmentFilePath = $appOutputDir . "/" . AweberMdsSyncAuditListCreator::LIST_AWEBER_EMAILS_NOT_IN_MDS_FILE_NAME;
               $this->sendEmailtoAdmins($subjectLine, $messageBody, $attachmentFilePath);
               $runEndDate = new \DateTime("now");
               print("\n" . "Program run end date/time: " . $runEndDate->format('Y-m-d H:i:s') . "\n");
               exit(0);
           }

       }
       catch (\Exception $exception) {

           print("\n" . "Exception occurred in section of SyncAweberMdsCommand where spreadsheet is generated reporting on email addresses found in Aweber.com but not MDS! Exception->getMessage() : " . $exception->getMessage());
           print("\n" . "Exiting from program.");
           $subjectLine = "Fatal exception encountered when attempting to generate spreadsheet reporting on email addresses found in aweber.com but not in MDS!";
           $messageBody = "\n" . "Exception occurred in section of SyncAweberMdsCommand where spreadsheet is generated reporting on email addresses found in Aweber.com but not MDS! Exception->getMessage() : " . $exception->getMessage();
           $messageBody .= "\n" . "Exception stack trace: " . $exception->getTraceAsString();
           $this->sendEmailtoAdmins($subjectLine, $messageBody);
           throw $exception;
       }

        $runEndDate = new \DateTime("now");
        print("\n" . "Program run end date/time: " . $runEndDate->format('Y-m-d H:i:s') . "\n");
        exit(0);


    }

    private function buildMessageBodyForEmailToAdmins($messageBody,  AweberUpdateSummary $aweberUpdateSummary, $errorMessages = null)
    {
        if (!is_null($aweberUpdateSummary->getListInsertArrayCtr() and count($aweberUpdateSummary->getListInsertArrayCtr()) > 0)) {
            $messageBody .=  "\n" . "List inserts: " . "\n";
            foreach ($aweberUpdateSummary->getListInsertArrayCtr() as $listName => $value) {
                $messageBody .= "   " . $listName . " count: " . $value . "\n\n";
            }
        } else {
            $messageBody .= "\n" . "There were no inserts in Aweber subscriber lists in this run of the program." . "\n";
        }

        if (!is_null($aweberUpdateSummary->getListUpdateArrayCtr() and count($aweberUpdateSummary->getListUpdateArrayCtr()) > 0)) {
            $messageBody .=  "\n" . "List updates: " . "\n";
            foreach ($aweberUpdateSummary->getListUpdateArrayCtr() as $listName => $value) {
                $messageBody .= "   " . $listName . " count: " . $value . "\n\n";
            }
        } else {
            $messageBody .= "\n" . "There were no updates made to Aweber subscriber lists in this run of the program." . "\n";
        }

        // if there are errorMessages, add them to the end of the message body.
        if (!is_null($errorMessages) and !empty($errorMessages)) {
            $messageBody .= "\n" . implode( "\n", $errorMessages);
        }

        return $messageBody;
    }

    private function sendEmailtoAdmins( $subjectLine, $messageBody, $attachmentFilePath = null) {
          $mailer = $this->getContainer()->get('mailer');
          $emailSubjectLine = $subjectLine;
          if (!is_null($this->adminEmailRecipients) and !empty($this->adminEmailRecipients)) {
              $emailRecipients = $this->adminEmailRecipients;
              print("\n" . "Sending to recipients obtained from Aweber subscriber list admin_mds_to_aweber ");
          }
          else {
              $emailRecipients = self::DEFAULT_ADMINS;
          }

          $emailBody = $messageBody;

          $emailer = new Emailer($mailer, $this->getContainer()->get('swiftmailer.transport.real'), $emailSubjectLine, $emailBody, $emailRecipients, $attachmentFilePath);


          $emailer->sendEmailMessage();

    }

}