<?php
/**
 * AptsWithNoResidentHavingEmailReportWriter.php
 * User: sfrizell
 * Date: 12/8/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Service;

use Doctrine\ORM\EntityManager;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Color;
use PHPExcel_Cell;
use Liuggio\ExcelBundle\Factory;
use PHPExcel_CachedObjectStorageFactory;
use PHPExcel_Settings;
use Doctrine\ORM\Query;
use PHPExcel;

class AptsWithNoResidentHavingEmailReportWriter
{
    const LIST_APTS_WITH_NO_EMAIL_ADDRESS_FILE_NAME                     = 'list_of_apts_with_no_email.xlsx';

    const APTS_WITH_NO_EMAIL_ADDRESSES_HEADER_ARRAY = array(
               'Building',
               'Floor Number',
               'Apt Line',
               'Apt Name',
                'Apt Surrendered'
       );

    const APTS_WITH_NO_EMAIL_ADDRESSES_COL_NAMES = array(
                   'building_id',
                   'floor_number',
                   'apt_line',
                   'apartment_name',
                   'apt_surrendered'
           );

    private $entityManager;
    private $phpExcel;
    private $appOutputDir;
    private $env;

     public function __construct (EntityManager $entityManager,  $phpExcel, $appOutputDir, $env ) {

         $this->entityManager    = $entityManager;
         $this->phpExcel         = $phpExcel;
         $this->appOutputDir     = $appOutputDir;
         $this->env             = $env;

     }

     public function getEntityManager() {
         return $this->entityManager;
     }


    /**
     * NOTE: Set page break whenever there is a break on buildingId.
     * @return bool
     */
    public function createSpreadsheetAptsWithNoEmailAddresses() {

        $apartmentsWithNoEmailAddresses = $this->getApartmentsWithNoEmailAddressQueryDb();

        $title              = 'Apts with no Email Address';
       $description        = 'List of Pennsouth apartments where no resident has provided an email address.';
       $category           = 'List Management Reports';
       $spreadsheetTabName = 'Apts With No Email Address';

       $phpExcelObject = $this->getPhpExcelObjectAndSetHeadings(self::APTS_WITH_NO_EMAIL_ADDRESSES_HEADER_ARRAY, $title, $description, $category);



            if (!is_null($phpExcelObject) and $phpExcelObject instanceof \PHPExcel) {

                $fileWriteCtr = 0;


                $rowCtr = 1;
                $breakRow = 1;

                $colLimit = count(self::APTS_WITH_NO_EMAIL_ADDRESSES_COL_NAMES);
                $phpExcelObject->setActiveSheetIndex(0);
                $prevBuildingId = "";
                foreach ($apartmentsWithNoEmailAddresses as $apartmentWithNoEmailAddressRow) {
                    $rowCtr++;

                    if ($prevBuildingId !== "" and $prevBuildingId !== $apartmentWithNoEmailAddressRow[self::APTS_WITH_NO_EMAIL_ADDRESSES_COL_NAMES[0]]) {
                        if ($rowCtr > 2) {
                            $breakRow = $rowCtr - 1;
                        }
                        else {
                            $breakRow = $rowCtr;
                        }
                        $phpExcelObject->getActiveSheet()->setBreak('A' . $breakRow, \PHPExcel_Worksheet::BREAK_ROW);
                    }
                    for ($i = 0; $i < $colLimit; $i++) {
                        $currentLetter = PHPExcel_Cell::stringFromColumnIndex($i);
                        $cellId = $currentLetter . $rowCtr;
                      //  print ("\$cellId: " . $cellId . "\n");
                       // if (!$key == 'Last Changed Date') {
                            $phpExcelObject->getActiveSheet()
                                ->setCellValue($cellId, $apartmentWithNoEmailAddressRow[self::APTS_WITH_NO_EMAIL_ADDRESSES_COL_NAMES[$i]]);
                       // }
                    }
                     $prevBuildingId =  $apartmentWithNoEmailAddressRow[self::APTS_WITH_NO_EMAIL_ADDRESSES_COL_NAMES[0]];

                // }



                }

                $phpExcelObject->getActiveSheet()->setTitle($spreadsheetTabName);
                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $phpExcelObject->setActiveSheetIndex(0);

                // create the writer
                $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel2007');
                // The save method is documented in the official PHPExcel library
                $fileWriteCtr++;
                $writer->save($this->appOutputDir . '/' . self::LIST_APTS_WITH_NO_EMAIL_ADDRESS_FILE_NAME);


                return TRUE;
            }

        return FALSE;

    }

    private function getPhpExcelObjectAndSetHeadings($headerArray, $title, $description, $category) {

        $phpExcelObject = $this->phpExcel->createPHPExcelObject();




       if ($phpExcelObject instanceof PHPExcel) {

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


               foreach (range(0, $totalCols) as $col) {
                   $phpExcelObject->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
               }


           return $phpExcelObject;
       }

        return NULL;

    }

    /**
     * This function avoids the use of Doctrine's DQL and just uses raw SQL.
     * @return mixed
     * @throws \Exception
     */
    private function getApartmentsWithNoEmailAddressQueryDb() {

          try {

              // $query = $this->getEntityManager()->createNativeQuery
              $query =
                  'select distinct apt.building_id, apt.floor_number, apt.apt_line, apt.apartment_name, pr.apt_surrendered
                  from 
                       pennsouth_apt as apt
                       inner join pennsouth_resident as pr
                  where
                      apt.apartment_id = pr.Pennsouth_apt_apartment_id
                  and  not exists (
                  select  \'x\'
                  from pennsouth_resident pr2 
                   where pr.pennsouth_apt_apartment_id = pr2.pennsouth_apt_apartment_id and
                   pr2.email_address <> :emailAddress1)
                   and  not exists (
                  select  \'x\'
                  from aweber_mds_sync_audit msa 
                   where pr.building = msa.aweber_building
                   and pr.floor_number = msa.aweber_floor_number
                   and pr.apt_line = msa.aweber_apt_line 
                   and msa.update_action = :updateAction
                   and msa.Aweber_Subscriber_Status = :status )
                   order by apt.building_id, apt.floor_number, apt.apt_line, apt.apartment_name ';



              $statement = $this->getEntityManager()->getConnection()->prepare($query);
                      // Set parameters
              $statement->bindValue( 'emailAddress1', '');
              $statement->bindValue( 'updateAction', 'reporting');
              $statement->bindValue( 'status', 'subscribed');
                  //    $statement->bindValue('status', 1);
              $statement->execute();

              $apartmentsWithNoEmailAddresses = $statement->fetchAll();

              return $apartmentsWithNoEmailAddresses;

          }
          catch (\Exception $exception) {
              print("\n" . "Fatal Exception occurred in ApartmentsWithNoResidentHavingEmailReportWriter->getApartmentsWithNoEmailAddressQueryDb! ");
              print ("\n Exception->getMessage() : " . $exception->getMessage());
              print "Type: " . $exception->getCode(). "\n";
              print("\n" . "Exiting from program.");
              throw $exception;
          }

      }

}