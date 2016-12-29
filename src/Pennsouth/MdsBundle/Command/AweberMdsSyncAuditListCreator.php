<?php
/**
 * AweberMdsSyncAuditListCreator.php
 * User: sfrizell
 * Date: 11/27/16
 *  Function: Generate spreadsheets listing the audit trail data written to the pennsouth_db.aweber_mds_sync_audit table.
 * NOTE: Todo - remove the following functions which are not used:
 *   (a) generateAweberUpdatesListFailedWithMemoryIssues()
 *   (b) getMdsSyncAuditUpdatesAndInserts() - invoked by (a) above.
 */

namespace Pennsouth\MdsBundle\Command;

use Doctrine\ORM\EntityManager;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Color;
use PHPExcel_Cell;
use Liuggio\ExcelBundle\Factory;
use PHPExcel_CachedObjectStorageFactory;
use PHPExcel_Settings;
use Doctrine\ORM\Query;

class AweberMdsSyncAuditListCreator
{

    const LIST_AWEBER_UPDATES_FILE_NAME                     = 'aweber_updates.xlsx';
    const LIST_AWEBER_EMAILS_NOT_IN_MDS                     = 'aweber_emails_not_in_mds.xlsx';
    const LIST_AWEBER_EMAILS_NOT_IN_MDS_FILE_NAME_BASE      = 'aweber_emails_not_in_mds';
    const LIST_AWEBERUPDATES_FILE_NAME_BASE                 = 'aweber_updates';
    const EXCEL_FILENAME_SUFFIX                             = '.xlsx';
    const LIST_AWEBERS_SUBS_WITH_NO_MATCH_IN_MDS_FILE_NAME  = 'aweber_no_matches_in_mds.xlsx';
    const LIST_AWEBER_UPDATES_BATCH_SIZE = 2000;

    const AWEBER_EMAILS_NOT_IN_MDS_HEADER_ARRAY = array(
            'Aweber Subscriber List',
            'Aweber Building',
            'Aweber Floor Number',
            'Aweber Apt Line',
            'Aweber Subscriber Name',
            'Subscriber Email Address',
            'Action Reason',
            'Aweber Subscriber Status',
            'Aweber Subscribed At',
            'Aweber Unsubscribed At',
            'Aweber Subscription Method',
            'Database Insert Date'
    );

    const AWEBER_EMAILS_NOT_IN_MDS_COL_NAMES = array(
                'aweberSubscriberListName',
                'aweberBuilding',
                'aweberFloorNumber',
                'aweberAptLine',
                'aweberSubscriberName',
                'subscriberEmailAddress',
                'actionReason',
                'aweberSubscriberStatus',
                'aweberSubscribedAt',
                'aweberUnsubscribedAt',
                'aweberSubscriptionMethod',
                'lastChangedDate'
        );

    const AWEBER_UPDATES_LIST_HEADER_ARRAY = array(
            'Aweber Subscriber List',
            'Update Action',
            'MDS Pennsouth Building',
            'MDS Floor Number',
            'MDS Apt Line',
            'MDS Resident First Name',
            'MDS Resident Last Name',
            'Aweber Builidng',
            'Aweber Floor Number',
            'Aweber Apt Line',
            'Aweber Subscriber Name',
            'Subscriber Email Address',
            'Action Reason',
            'Aweber Subscriber Status',
            'Aweber Subscribed At',
            'Aweber Unsubscribed At',
            'Aweber Subscription Method',
            'MDS Toddler Rm Member',
            'MDS Youth Rm Member',
            'MDS Ceramics Member',
            'MDS Woodworking Member',
            'MDS Gym Member',
            'MDS Garden Member',
            'MDS Parking Lot Location',
            'MDS Vehicle Reg Exp Days Left',
            'MDS Homeowner Ins Exp Days Left',
            'MDS Storage Lkr Cl Building',
            'MDS Storage Lkr Num',
            'MDS Storage Lkr Cl Fl Num',
            'MDS Is Dog In Apt',
            'MDS Bike Rack Bldg',
            'MDS Bike Rack Location',
            'MDS Resident Category',
            'Aweber Toddler Rm Member',
            'Aweber Youth Rm Member',
            'Aweber Ceramics Member',
            'Aweber Woodworking Member',
            'Aweber Gym Member',
            'Aweber Garden Member',
            'Aweber Parking Lot Location',
            'Aweber Vehicle Reg Exp Days Left',
            'Aweber Homeowner Ins Exp Days Left',
            'Aweber Storage Lkr Cl Building',
            'Aweber Storage Lkr Num',
            'Aweber Storage Lkr Cl Fl Num',
            'Aweber Is Dog In Apt',
            'Aweber Bike Rack Bldg',
            'Aweber Bike Rack Location',
            'Aweber Resident Category',
            'Last Changed Date'
    );

    const  AWEBER_UPDATES_LIST_AWEBER_MDS_SYNC_AUDIT_COL_NAMES = array(
                        'aweberSubscriberListName',
                        'updateAction',
                        'mdsBuilding',
                        'mdsFloorNumber',
                        'mdsAptLine',
                        'mdsResidentFirstName',
                        'mdsResidentLastName',
                        'aweberBuilding',
                        'aweberFloorNumber',
                        'aweberAptLine',
                        'aweberSubscriberName',
                        'subscriberEmailAddress',
                        'actionReason',
                        'aweberSubscriberStatus',
                        'aweberSubscribedAt',
                        'aweberUnsubscribedAt',
                        'aweberSubscriptionMethod',
                        'mdsToddlerRmMember',
                        'mdsYouthRmMember',
                        'mdsCeramicsMember',
                        'mdsWoodworkingMember',
                        'mdsGymMember',
                        'mdsGardenMember',
                        'mdsParkingLotLocation',
                        'mdsVehicleRegExpDaysLeft',
                        'mdsHomeownerInsExpDaysLeft',
                        'mdsStorageLkrClBldg',
                        'mdsStorageLkrNum',
                        'mdsStorageClFloorNum',
                        'mdsIsDogInApt',
                        'mdsBikeRackBldg',
                        'mdsBikeRackLocation',
                        'mdsResidentCategory',
                        'aweberToddlerRmMember',
                        'aweberYouthRmMember',
                        'aweberCeramicsMember',
                        'aweberWoodworkingMember',
                        'aweberGymMember',
                        'aweberGardenMember',
                        'aweberParkingLotLocation',
                        'aweberVehicleRegExpDaysLeft',
                        'aweberHomeownerInsExpDaysLeft',
                        'aweberStorageLkrClBldg',
                        'aweberStorageLkrNum',
                        'aweberStorageClFloorNum',
                        'aweberIsDogInApt',
                        'aweberBikeRackBldg',
                        'aweberBikeRackLocation',
                        'aweberResidentCategory',
                        'lastChangedDate'
                    );

    private $entityManager;
    private $phpExcel;
    private $appOutputDir;

    public function __construct (EntityManager $entityManager,  $phpExcel, $appOutputDir ) {

        $this->entityManager    = $entityManager;
        $this->phpExcel         = $phpExcel;
        $this->appOutputDir     = $appOutputDir;

    }

    public function getEntityManager() {
        return $this->entityManager;
    }


    /**
     * Run SQL query against the pennsouth_db.aweber_mds_sync_audit table to obtain a list of all inserts and updates
     *  of Aweber subscriber lists from MDS input.  Write the list to excel spreadsheet(s). Because of memory issues,
     *   if the number of rows written exceeds the limit defined in the class constant self::LIST_AWEBER_UPDATES_BATCH_SIZE
     *    then a second spreadsheet will be generated for each set of the defined limit.
      *   Write the spreadsheet to the /app_output directory under the project root directory.
      * See: http://stackoverflow.com/questions/39186017/creating-excel-file-from-array-using-php-and-symfony
      *   also: http://ourcodeworld.com/articles/read/50/how-to-create-a-excel-file-with-php-in-symfony-2-3
      * For usage examples of Font and Fill, see the comments in the code of PHPExcel:
      *    vendor/phpoffice/phpexcel/Classes/PHPExcel/Style/Font
      *    vendor/phpoffice/phpexcel/Classes/PHPExcel/Style/Fill
     *  Note: The technique of iterating over the result set and detaching each row is to help minimize memory usage.
     *   See Doctrine documentation of batch processing: See section 13.4 of the following page:
     *      http://doctrine-orm.readthedocs.io/projects/doctrine-orm/en/latest/reference/batch-processing.html
     * @return bool
     * @throws \Exception
     */
    public function createSpreadsheetAweberUpdatesList() {

        try {
            $query = $this->getEntityManager()->createQuery(
                'Select msa
                 from PennsouthMdsBundle:AweberMdsSyncAudit msa
                where (msa.updateAction = :update or msa.updateAction = :insert)
                order by msa.updateAction, msa.mdsBuilding, msa.mdsFloorNumber, msa.mdsAptLine'
            );
            $query->setParameters( array(
                'update' => 'update',
                'insert' => 'insert',
            ) );


            $iterableResult = $query->iterate();

            $title = 'Pennsouth Aweber Updates from MDS List Document';
            $description = 'List of updates to Pennsouth Aweber Subscriber Lists from MDS data. Both inserts and updates of subscribers.';
            $category      = 'List Management Reports';

            $phpExcelObject = $this->getPhpExcelObjectAndSetHeadings(self::AWEBER_UPDATES_LIST_HEADER_ARRAY, $title, $description, $category);

            $colLimit = count(self::AWEBER_UPDATES_LIST_AWEBER_MDS_SYNC_AUDIT_COL_NAMES);
            $phpExcelObject->setActiveSheetIndex(0);
            $rowCtr = 1;
            $fileWriteCtr = 0;
            foreach ($iterableResult as $mdsAweberSyncAuditRow) {

                    $mdsAweberSyncAuditRowAsArray = get_object_vars ( $mdsAweberSyncAuditRow[0] );


                         if (!is_null($phpExcelObject) and $phpExcelObject instanceof \PHPExcel) {


                             $rowCtr++;

                             for ($i = 0; $i < $colLimit; $i++) {
                                 $currentLetter = PHPExcel_Cell::stringFromColumnIndex($i);
                                 $cellId = $currentLetter . $rowCtr;

                                     $phpExcelObject->getActiveSheet()
                                         ->setCellValue($cellId, $mdsAweberSyncAuditRowAsArray[self::AWEBER_UPDATES_LIST_AWEBER_MDS_SYNC_AUDIT_COL_NAMES[$i]]);

                             }


                             $modulo = $rowCtr % self::LIST_AWEBER_UPDATES_BATCH_SIZE;
                             // $rowCtr > 2000
                             if ($modulo == 0) {
                                 $fileWriteCtr++;
                                 print("\n  \$modulo == 0 \n");
                                 $phpExcelObject->getActiveSheet()->setTitle('MDS->Aweber Updates Inserts');
                                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                                $phpExcelObject->setActiveSheetIndex(0);

                                // create the writer
                                $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel2007');
                                // The save method is documented in the official PHPExcel library
                                $writer->save($this->appOutputDir . '/' . self::LIST_AWEBERUPDATES_FILE_NAME_BASE . $fileWriteCtr . self::EXCEL_FILENAME_SUFFIX);

                                $phpExcelObject = null;


                                $phpExcelObject = $this->getPhpExcelObjectAndSetHeadings(self::AWEBER_UPDATES_LIST_HEADER_ARRAY, $title, $description, $category);
                                $phpExcelObject->setActiveSheetIndex(0);
                                $rowCtr = 1;

                                 }


                            // return TRUE;
                         }

                    //  return FALSE;

                    $this->getEntityManager()->detach($mdsAweberSyncAuditRow[0]);

            }

            $phpExcelObject->getActiveSheet()->setTitle('MDS->Aweber Updates Inserts');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $phpExcelObject->setActiveSheetIndex(0);

            // create the writer
            $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel2007');
            // The save method is documented in the official PHPExcel library
            $fileWriteCtr++;
            $writer->save($this->appOutputDir . '/' . self::LIST_AWEBERUPDATES_FILE_NAME_BASE . $fileWriteCtr . self::EXCEL_FILENAME_SUFFIX);
            // $writer->save($this->appOutputDir . '/' . self::LIST_AWEBER_UPDATES_FILE_NAME);
            return TRUE;

        }
        catch (\Exception $exception) {
            print("\n" . "Fatal Exception occurred in AweberMdsSyncAuditListCreator->generateAweberUpdateListsWithDetachedQueryResults()! ");
            print ("\n Exception->getMessage() : " . $exception->getMessage());
            print "Type: " . $exception->getCode(). "\n";
            print("\n" . "Exiting from program.");
            throw $exception;
        }
    }


    private function getPhpExcelObjectAndSetHeadings($headerArray, $title, $description, $category) {

        $phpExcelObject = $this->phpExcel->createPHPExcelObject();



       if ($phpExcelObject instanceof \PHPExcel) {

           $fileWriteCtr = 0;

           $phpExcelObject->getProperties()->setCreator("batch")
               ->setLastModifiedBy("Batch Process")
               ->setTitle($title)
               ->setSubject("Office 2005 XLSX Document")
               ->setDescription($description)
               ->setKeywords("office 2005 openxml php")
               ->setCategory($category);


         //  $phpExcelStyleColor = new PHPExcel_Style_Color('EAE9DE');

           $totalCols = count($headerArray)+1;

           $phpExcelSheet = $phpExcelObject->getActiveSheet();
           $phpExcelSheet->fromArray($headerArray, NULL);
           $first_letter = PHPExcel_Cell::stringFromColumnIndex(0);
           $last_letter = PHPExcel_Cell::stringFromColumnIndex($totalCols);
           $header_range = "{$first_letter}1:{$last_letter}1";
           $phpExcelSheet->getStyle($header_range)->getFont()
               ->setBold(true)
               ->setSize(12)
               ;

           $phpExcelSheet->getStyle($header_range)->getFill()->applyFromArray(
                                   array(
                                       'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                       'color' => array(
                                           'rgb' => 'EAE9DE'
                                       )
                                   )
                               );


          // print("\n setting autosize=true \n");

               foreach (range(0, $totalCols) as $col) {
                   $phpExcelObject->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
               }


           return $phpExcelObject;
       }

        return NULL;

    }

    /**
     * @return bool
     */
    public function createSpreadsheetAweberEmailAddressesNotInMds() {

        $aweberEmailsNotInMds = $this->getMdsSyncAuditAweberEmailsNotInMdsQueryDb();

        $title              = 'Email Addresses In Aweber.com and Not in MDS';
        $description        = 'List of Pennsouth residents email addresses in aweber.com but not in MDS.';
        $category           = 'List Management Reports';
        $spreadsheetTabName = 'Aweber Emails Not in MDS';

        $phpExcelObject = $this->getPhpExcelObjectAndSetHeadings(self::AWEBER_EMAILS_NOT_IN_MDS_HEADER_ARRAY, $title, $description, $category);



         if (!is_null($phpExcelObject) and $phpExcelObject instanceof \PHPExcel) {

             $fileWriteCtr = 0;


            // print("\n After setting autosize=true \n");

             $rowCtr = 1;

             $colLimit = count(self::AWEBER_EMAILS_NOT_IN_MDS_COL_NAMES);
             $phpExcelObject->setActiveSheetIndex(0);
             foreach ($aweberEmailsNotInMds as $emailsinAweberNotInMdsRow) {
                 $rowCtr++;


             //    foreach ( $colNamesByHeaderNameKeys as $key => $value ) {
             //        print ("\n key: " . $key . " value: " . $value . "\n");

                     for ($i = 0; $i < $colLimit; $i++) {
                         $currentLetter = PHPExcel_Cell::stringFromColumnIndex($i);
                         $cellId = $currentLetter . $rowCtr;
                       //  print ("\$cellId: " . $cellId . "\n");
                        // if (!$key == 'Last Changed Date') {
                             $phpExcelObject->getActiveSheet()
                                 ->setCellValue($cellId, $emailsinAweberNotInMdsRow[self::AWEBER_EMAILS_NOT_IN_MDS_COL_NAMES[$i]]);
                        // }
                     }

             // }

                 $modulo = $rowCtr % self::LIST_AWEBER_UPDATES_BATCH_SIZE;
                 // $rowCtr > 2000
                 if ($modulo == 0) {
                     $fileWriteCtr++;
                     $phpExcelObject->getActiveSheet()->setTitle($spreadsheetTabName);
                    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                    $phpExcelObject->setActiveSheetIndex(0);

                    // create the writer
                    $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel2007');
                    // The save method is documented in the official PHPExcel library
                    $writer->save($this->appOutputDir . '/' . self::LIST_AWEBER_EMAILS_NOT_IN_MDS_FILE_NAME_BASE . $fileWriteCtr . self::EXCEL_FILENAME_SUFFIX);

                    $phpExcelObject = $this->getPhpExcelObjectAndSetHeadings(self::AWEBER_EMAILS_NOT_IN_MDS_HEADER_ARRAY, $title, $description, $category);
                    $phpExcelObject->setActiveSheetIndex(0);

                    // break;
                 }


             }

             $phpExcelObject->getActiveSheet()->setTitle($spreadsheetTabName);
             // Set active sheet index to the first sheet, so Excel opens this as the first sheet
             $phpExcelObject->setActiveSheetIndex(0);

             // create the writer
             $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel2007');
             // The save method is documented in the official PHPExcel library
             $fileWriteCtr++;
             $writer->save($this->appOutputDir . '/' . self::LIST_AWEBER_EMAILS_NOT_IN_MDS_FILE_NAME_BASE . $fileWriteCtr . self::EXCEL_FILENAME_SUFFIX);
            // $writer->save($this->appOutputDir . '/' . self::LIST_AWEBER_UPDATES_FILE_NAME);


             return TRUE;
         }

     return FALSE;

    }

    /**
       *
     *     Executing this method with more than 2500 rows of data resulted in a fatal memory error: Fatal error: Allowed memory size of 134217728 bytes exhausted
     *     Would like to use the array $colNamesByHeaderNameKeys if possible... The two const arrays are not well designed because they are not directly associated
     *     with each other but they are in fact co-dependent.
       */
      public function generateAweberUpdatesListFailedWithMemoryIssues()
      {

          $colNamesByHeaderNameKeys = array (
                                 'Aweber Subscriber List' => 			'aweberSubscriberListName',
                                 'Update Action' => 					'updateAction',
                                 'MDS Pennsouth Building' =>			'mdsBuilding',
                                 'MDS Floor Number' => 					'mdsFloorNumber',
                                 'MDS Apt Line' => 						'mdsAptLine',
                                 'MDS Resident First Name' =>			'mdsResidentFirstName',
                                 'MDS Resident Last Name' =>				'mdsResidentLastName',
                                 'Aweber Builidng' => 					'aweberBuilding',
                                 'Aweber Floor Number' => 				'aweberFloorNumber',
                                 'Aweber Apt Line' => 					'aweberAptLine',
                                 'Aweber Subscriber Name' =>				'aweberSubscriberName',
                                 'Subscriber Email Address' => 			'subscriberEmailAddress',
                                 'Action Reason' => 						'actionReason',
                                 'Aweber Subscriber Status' => 			'aweberSubscriberStatus',
                                 'Aweber Subscribed At' => 				'aweberSubscribedAt',
                                 'Aweber Unsubscribed At' =>				'aweberUnsubscribedAt',
                                 'Aweber Subscription Method' => 		'aweberSubscriptionMethod',
                                 'MDS Toddler Rm Member' => 				'mdsToddlerRmMember',
                                 'MDS Youth Rm Member' => 				'mdsYouthRmMember',
                                 'MDS Ceramics Member' => 				'mdsCeramicsMember',
                                 'MDS Woodworking Member' =>				'mdsWoodworkingMember',
                                 'MDS Gym Member' => 					'mdsGymMember',
                                 'MDS Garden Member' => 					'mdsGardenMember',
                                 'MDS Parking Lot Location' =>  			'mdsParkingLotLocation',
                                 'MDS Vehicle Reg Exp Days Left' => 		'mdsVehicleRegExpDaysLeft',
                                 'MDS Homeowner Ins Exp Days Left' =>	'mdsHomeownerInsExpDaysLeft',
                                 'MDS Storage Lkr Cl Building' =>		'mdsStorageLkrClBldg',
                                 'MDS Storage Lkr Num' => 				'mdsStorageLkrNum',
                                 'MDS Storage Lkr Cl Fl Num' =>			'mdsStorageClFloorNum',
                                 'MDS Is Dog In Apt' => 					'mdsIsDogInApt',
                                 'MDS Bike Rack Bldg' => 				'mdsBikeRackBldg',
                                 'MDS Bike Rack Location' =>				'mdsBikeRackLocation',
                                 'MDS Resident Category' => 				'mdsResidentCategory',
                                 'Aweber Toddler Rm Member' =>			'aweberToddlerRmMember',
                                 'Aweber Youth Rm Member' =>				'aweberYouthRmMember',
                                 'Aweber Ceramics Member' =>				'aweberCeramicsMember',
                                 'Aweber Woodworking Member'  =>			'aweberWoodworkingMember',
                                 'Aweber Gym Member' => 					'aweberGymMember',
                                 'Aweber Garden Member' => 				'aweberGardenMember',
                                 'Aweber Parking Lot Location' =>		'aweberParkingLotLocation',
                                 'Aweber Vehicle Reg Exp Days Left' =>	'aweberVehicleRegExpDaysLeft',
                                 'Aweber Homeowner Ins Exp Days Left' => 'aweberHomeownerInsExpDaysLeft',
                                 'Aweber Storage Lkr Cl Building' =>		'aweberStorageLkrClBldg',
                                 'Aweber Storage Lkr Num' =>				'aweberStorageLkrNum',
                                 'Aweber Storage Lkr Cl Fl Num' =>		'aweberStorageClFloorNum',
                                 'Aweber Is Dog In Apt' => 				'aweberIsDogInApt',
                                 'Aweber Bike Rack Bldg' => 				'aweberBikeRackBldg',
                                 'Aweber Bike Rack Location' => 			'aweberBikeRackLocation',
                                 'Aweber Resident Category'=> 			'aweberResidentCategory',
                                 'Last Changed Date' =>					'lastChangedDate'
                         );

          $mdsSyncAuditUpdatesAndInserts = $this->getMdsSyncAuditUpdatesAndInserts();


          $phpExcelObject = $this->getPhpExcelObjectAndSetHeadings();

          //    $phpExcelObject = $this->phpExcel->createPHPExcelObject();



              if (!is_null($phpExcelObject) and $phpExcelObject instanceof \PHPExcel) {

                  $fileWriteCtr = 0;


                 // print("\n After setting autosize=true \n");

                  $rowCtr = 1;

                  $colLimit = count(self::AWEBER_UPDATES_LIST_AWEBER_MDS_SYNC_AUDIT_COL_NAMES);
                  $phpExcelObject->setActiveSheetIndex(0);
                  foreach ($mdsSyncAuditUpdatesAndInserts as $auditUpdateOrInsertRow) {
                      $rowCtr++;


                  //    foreach ( $colNamesByHeaderNameKeys as $key => $value ) {
                  //        print ("\n key: " . $key . " value: " . $value . "\n");

                          for ($i = 0; $i < $colLimit; $i++) {
                              $currentLetter = PHPExcel_Cell::stringFromColumnIndex($i);
                              $cellId = $currentLetter . $rowCtr;
                            //  print ("\$cellId: " . $cellId . "\n");
                             // if (!$key == 'Last Changed Date') {
                                  $phpExcelObject->getActiveSheet()
                                      ->setCellValue($cellId, $auditUpdateOrInsertRow[self::AWEBER_UPDATES_LIST_AWEBER_MDS_SYNC_AUDIT_COL_NAMES[$i]]);
                             // }
                          }

                  // }

                      $modulo = $rowCtr % self::LIST_AWEBER_UPDATES_BATCH_SIZE;
                      // $rowCtr > 2000
                      if ($modulo == 0) {
                          $fileWriteCtr++;
                          $phpExcelObject->getActiveSheet()->setTitle('MDS->Aweber Updates Inserts');
                         // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                         $phpExcelObject->setActiveSheetIndex(0);

                         // create the writer
                         $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel2007');
                         // The save method is documented in the official PHPExcel library
                         $writer->save($this->appOutputDir . '/' . self::LIST_AWEBERUPDATES_FILE_NAME_BASE . $fileWriteCtr . self::EXCEL_FILENAME_SUFFIX);

                         $phpExcelObject = $this->getPhpExcelObjectAndSetHeadings();
                         $phpExcelObject->setActiveSheetIndex(0);

                         // break;
                      }


                  }

                  $phpExcelObject->getActiveSheet()->setTitle('MDS->Aweber Updates Inserts');
                  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                  $phpExcelObject->setActiveSheetIndex(0);

                  // create the writer
                  $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel2007');
                  // The save method is documented in the official PHPExcel library
                  $fileWriteCtr++;
                  $writer->save($this->appOutputDir . '/' . self::LIST_AWEBERUPDATES_FILE_NAME_BASE . $fileWriteCtr . self::EXCEL_FILENAME_SUFFIX);
                 // $writer->save($this->appOutputDir . '/' . self::LIST_AWEBER_UPDATES_FILE_NAME);


                  return TRUE;
              }

          return FALSE;

      }


    /**
     *  This function is only invoked by the function generateAweberUpdatesListFailedWithMemoryIssues(), which is not used.
     *  todo - delete the two functions:
     *    -  generateAweberUpdatesListFailedWithMemoryIssues()
     *    -  getMdsSyncAuditUpdatesAndInserts()
     * @return array
     * @throws \Exception
     */
    private function getMdsSyncAuditUpdatesAndInserts() {

        try {
            $query = $this->getEntityManager()->createQuery(
                'Select msa
                 from PennsouthMdsBundle:AweberMdsSyncAudit msa
                where msa.updateAction is not NULL
                order by msa.updateAction, msa.mdsBuilding, msa.mdsFloorNumber, msa.mdsAptLine'
            );

          //  $mdsSyncAuditUpdatesAndInserts = $query->getResult();
            $mdsSyncAuditUpdatesAndInserts = $query->getArrayResult();


            return $mdsSyncAuditUpdatesAndInserts;

        }
        catch (\Exception $exception) {
            print("\n" . "Fatal Exception occurred in AweberMdsSyncAuditListCreator->getMdsSyncAuditUpdatesAndInserts! ");
            print ("\n Exception->getMessage() : " . $exception->getMessage());
            print "Type: " . $exception->getCode(). "\n";
            print("\n" . "Exiting from program.");
            throw $exception;
        }

    }

    /**
        *  This function reads the aweber_Mds_Sync_Audit table to obtain a list of email addresses that
        *    exist in Aweber but were not found in MDS. The data is captured at the time of the most
        *    recent run of the application with the option to report on the emails found in Aweber but not in MDS.
        *    The output of that run are inserts into the aweber_Mds_Sync_Audit table.
        *    The function being invoked here is for the purpose of generating a spreadsheet from this data.
        * @return array
        * @throws \Exception
        */
       private function getMdsSyncAuditAweberEmailsNotInMdsQueryDb() {

           try {
               $query = $this->getEntityManager()->createQuery(
                   'Select msa.aweberSubscriberListName, msa.subscriberEmailAddress, msa.aweberBuilding, msa.aweberFloorNumber, 
                          msa.aweberAptLine, msa.aweberSubscriberName, msa.actionReason, 
                          msa.aweberSubscriberStatus, msa.aweberSubscribedAt, msa.aweberUnsubscribedAt, msa.aweberSubscriptionMethod,
                          msa.lastChangedDate
                    from PennsouthMdsBundle:AweberMdsSyncAudit msa
                   where msa.updateAction = :updateAction
                   order by  msa.aweberBuilding, msa.aweberFloorNumber, msa.aweberAptLine, msa.aweberSubscriberName'
               );
               $query->setParameter( 'updateAction', 'reporting' );

               $mdsSyncAuditUpdatesAndInserts = $query->getResult();
               //$mdsSyncAuditUpdatesAndInserts = $query->getArrayResult();


               return $mdsSyncAuditUpdatesAndInserts;

           }
           catch (\Exception $exception) {
               print("\n" . "Fatal Exception occurred in AweberMdsSyncAuditListCreator->getMdsSyncAuditAweberEmailsNotInMdsQueryDb! ");
               print ("\n Exception->getMessage() : " . $exception->getMessage());
               print "Type: " . $exception->getCode(). "\n";
               print("\n" . "Exiting from program.");
               throw $exception;
           }

       }

}