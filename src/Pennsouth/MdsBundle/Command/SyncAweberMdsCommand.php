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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pennsouth\MdsBundle\Command\AweberSubscriberListReader;

use Pennsouth\MdsBundle\Command\PennsouthResidentListReader;

use Symfony\Component\Debug\DebugClassLoader;

//DebugClassLoader::enable();

/**
 * Class SyncAweberMdsCommand
 * @package Pennsouth\MdsBundle\Command
 * run this from the command line by issuing this command:
 *      php app/console app:sync-mds-aweber
 */

//class SyncAweberMdsCommand extends ContainerAwareCommand

// class SyncAweberMdsCommand extends Command

class SyncAweberMdsCommand extends ContainerAwareCommand {

//    protected $pennsouthResidentListReader;
//
//    public function __construct ( PennsouthResidentListReader $pennsouthResidentListReader ) {
//
//        $this->pennsouthResidentListReader = $pennsouthResidentListReader;
//
//   }

    protected function configure() {
        $this
                // the name of the command (the part after "bin/console") <-- (sfrizell) this is syntax for symfony 3.0; version 2.8 should use: php app/console ...
                ->setName('app:sync-mds-aweber')

                // the short description shown while running "php bin/console list"
                ->setDescription('Updates Pennsouth AWeber subscriber email lists from the MDS_Export table.')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp("This command runs the process that updates the Pennsouth Aweber.com subscriber email lists using as input the MDS_Export table...")
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


    //    print ( "\n !!!!!!!!!!!!!  root directory: " . $this->getContainer()->getParameter('kernel.root_dir') . "\n");

        $rootDir = $this->getContainer()->getParameter('kernel.root_dir');

        $rootDir = rtrim($rootDir, "/app");

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

        //$entityManager = $this->get('entity.manager');


       // $pennsouthResidentListReader = new PennsouthResidentListReader($entityManager);

        //$pennsouthResidentListReader->getPennsouthResidentsHavingEmailAddresses();

       // $this->pennsouthResidentListReader->getPennsouthResidentsHavingEmailAddresses();

        $entityManager = $this->getEntityManager();

        $pennsouthResidentListReader = new PennsouthResidentListReader($entityManager);


        $residentsWithEmailAddressesArray = $pennsouthResidentListReader->getPennsouthResidentsHavingEmailAddressAssociativeArray();

  /*      $i = 0;
        foreach ($residentsWithEmailAddressesArray as $emailAddress => $resident) {
            $i++;
            if ($i < 10) {
                print ( "\n" . "emailAddress: " . $emailAddress . " name: " . $resident->getFirstName() . " " . $resident->getLastName());
            }
        }*/

       // exit;

        $aweberSubscriberListReader = new AweberSubscriberListReader($rootDir);

        $success = FALSE;
        $j = 0;
        $emailNotificationLists = array();
        while (!$success) {
            try {
                $account = $aweberSubscriberListReader->connectToAWeberAccount();

                $emailNotificationLists = $aweberSubscriberListReader->getEmailNotificationLists($account);
                $success = TRUE;
            }
            catch (\Exception $exception) {
                if ($exception->getMessage() == "ServiceUnavailableError") {
                    $j++;
                    if ($j < 6) {
                        print("\n" . "AweberAPI Service temporarily unavailable while trying to call AweberSubscriberListReader->getEmailNotificationLists. ");
                        print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                        sleep(120);
                    }
                }
                else {
                    print("\n" . "Exception occurred! Exception->getMessage() : " . $exception->getMessage());
                    print("\n" . "Exiting from program.");
                    exit(1);
                }
            }
        }

       // $aweberSubscriberListReader->getSubscribersToEmailNotificationLists($account, $emailNotificationLists);
       // print("\n" . "0");

        $aweberSubscribersWithListNameKeys = array();
        $success = FALSE;
        $j = 0;
        while (!$success) {
            try {
                foreach ($emailNotificationLists as $emailNotificationList) {

                    print("\n" . "1");
                    $listName = $emailNotificationList->data["name"];

                    // returns associative array : key = name of aWeberSubscriberList ; value = array of AweberSubscriber objects
                    $aweberSubscribersWithListNameKeys[$listName] = $aweberSubscriberListReader->getSubscribersToEmailNotificationList($account, $emailNotificationList);
                    $success = TRUE;

                    print("\n" . " List Name: " . $listName . "\n");
                    /*       if ($listName == "frizell_test") {
                               print("\n" . "2");
                               $aweberSubscriberWriter = new AweberSubscriberWriter($rootDir);

                               print("\n" . "3");
                               $subscriber = $aweberSubscriberWriter->createAweberSubscriber($account, $emailNotificationList);
                               print ("\n" . "!!!!!!!!!!!   subscriber: " . "\n");
                               print_r($subscriber);
                           }*/

                }
            }
            catch (\Exception $exception){
                    if ($exception->getMessage() == "ServiceUnavailableError") {
                        $j++;
                        if ($j < 6) {
                            print("\n" . "AweberAPI Service temporarily unavailable when trying to call AweberSubscriberListReader->getSubscribersToEmailNotificationList. ");
                            print ("\n" . "Going to sleep for 2 minutes; then will try again.");
                            sleep(120);
                        }
                    }
                    else {
                        print("\n" . "Exception occurred! Exception->getMessage() : " . $exception->getMessage());
                        print("\n" . "Exiting from program.");
                        exit(1);
                    }
            }
        }

        if ($success) {
            $mdsToAweberUpdater = new MdsToAweberUpdater($this->getEntityManager(), $residentsWithEmailAddressesArray, $aweberSubscribersWithListNameKeys);
            $mdsToAweberUpdater->reportOnAweberSubscribersWithNoMatchInMds();
            print("\n" . "Processing completed successfully.");
        }
        else {
            print("\n" . "An error occurred in the Sync Aweber from MDS program. Processing did not complete successfully!");
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

}