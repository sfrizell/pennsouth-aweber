<?php
/**
 * ParkingLotListCreator.php
 * User: sfrizell
 * Date: 11/27/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Command;

use Doctrine\ORM\EntityManager;
use Pennsouth\MdsBundle\Entity\PennsouthResident;
use PHPExcel_Style_Fill;
use PHPExcel;
use PHPExcel_Cell;

class ParkingLotListCreator
{

    const PARKING_LOT_LIST_FILE_NAME = 'parking_lot_spaces.xlsx';
    const PARKING_LOT_LIST_BATCH_SIZE = 2000;
    const OBJECT1_COLS_NUM = 14;

    const PARKING_LOT_LIST_HEADER_ARRAY = array(
                'Building',
                'Floor Number',
                'Apt Line',
                'Parking Lot',
                'Decal Num',
                'Gap',
                'Car Reg. Expiration Date (MDS)',
                'Days Until Car Reg. Expires',
                'Car Reg. Exp. Countdown Interval',
                'Make/Model',
                'License Plate',
                'Shareholder1 Last Name',
                'Shareholder1 First Name',
                'Shareholder1 Email',
                'Shareholder1 Cell',
                'Shareholder1 Home Phone',
                'Resident Category',
                'Shareholder2 Last Name',
                'Shareholder2 First Name',
                'Shareholder2 Email',
                'Shareholder2 Cell',
                'Shareholder2 Home Phone'
       );

       const PARKING_LOT_LIST_COL_NAMES = array(
                    'building',
                    'floor_number',
                    'apt_line',
                    'parking_lot_location',
                    'decal_num',
                    'gap',
                    'vehicle_reg_exp_date',
                    'vehicle_reg_exp_countdown',
                    'vehicle_reg_interval_remaining',
                    'vehicle_model',
                    'vehicle_license_plate_num',
                    'last_name',
                    'first_name',
                    'email_address',
                    'cell_phone',
                    'evening_phone',
                    'mds_resident_category2',
                    'last_name2',
                    'first_name2',
                    'email_address2',
                    'cell_phone2',
                    'evening_phone2'
           );

    private $entityManager;
    private $phpExcel;
    private $appOutputDir;
    private $env;

    public function __construct (EntityManager $entityManager,  $phpExcel, $appOutputDir, $env ) {

        $this->entityManager    = $entityManager;
        $this->phpExcel         = $phpExcel;
        $this->appOutputDir     = $appOutputDir;
        $this->env              = $env;

    }

    public function getEntityManager() {
        return $this->entityManager;
    }


    /**
     *   * Run SQL query against the pennsouth_db.pennsouth_resident table to obtain a list of all distinct apartments
     *   that have assigned Pennsouth parking lot spaces. Obtain the list in order by decal_num. Write
     *   the list to an excel spreadsheet, identifying any gaps in the sequence of assigned values for decal_num.
     *   These gaps identify unfilled parking spaces.
     *   Write the spreadsheet to the /app_output directory under the project root directory.
     * See: http://stackoverflow.com/questions/39186017/creating-excel-file-from-array-using-php-and-symfony
     *   also: http://ourcodeworld.com/articles/read/50/how-to-create-a-excel-file-with-php-in-symfony-2-3
     * For usage examples of Font and Fill, see the comments in the code of PHPExcel:
     *    vendor/phpoffice/phpexcel/Classes/PHPExcel/Style/Font
     *    vendor/phpoffice/phpexcel/Classes/PHPExcel/Style/Fill
     *
     * @return bool
     */
    public function generateParkingLotList() {

        $residentsWithParkingSpaces = $this->getResidentsWithParkingSpaces();

        $title              = 'Pennsouth Parking Lot List';
        $description        = 'List of Parking Lot Spaces Assigned to Pennsouth Residents';
        $category           = 'List Management Reports';
        $spreadsheetTabName = 'Parking Lot List';

        $phpExcelObject = $this->getPhpExcelObjectAndSetHeadings(self::PARKING_LOT_LIST_HEADER_ARRAY, $title, $description, $category);

        if (!is_null($phpExcelObject) and $phpExcelObject instanceof PHPExcel) {

            $fileWriteCtr = 0;


           // print("\n After setting autosize=true \n");

            $rowCtr = 1;

            $getDecalNum = 'getDecalNum';
            $colLimit = count(self::PARKING_LOT_LIST_COL_NAMES);
            $phpExcelObject->setActiveSheetIndex(0);
            $prevDecalNum = null;
            $prevBuilding = null;
            $prevFloorNum = null;
            $prevAptLine = null;
            foreach ($residentsWithParkingSpaces as $row) {

                $gapMsg = '';
                  if (!is_null($prevDecalNum) and !($row['decal_num'] == 700)) {
                      $gapCalc = $row['decal_num'] - $prevDecalNum;
                      if ($gapCalc > 1) {
                          $gapMsg = "Gap";
                      }
                  }

            //    foreach ( $colNamesByHeaderNameKeys as $key => $value ) {
            //        print ("\n key: " . $key . " value: " . $value . "\n");

                // $row[0]->getName();

                    if ( is_null($prevBuilding) or
                          $row['building']      !== $prevBuilding   or
                          $row['floor_number']  !== $prevFloorNum   or
                          $row['apt_line']      !== $prevAptLine
                        ) {

                        $rowCtr++;
                        for ($i = 0; $i < $colLimit; $i++) {
                            $currentLetter = PHPExcel_Cell::stringFromColumnIndex($i);
                            $cellId = $currentLetter . $rowCtr;
                            //  print ("\$cellId: " . $cellId . "\n");
                            // if (!$key == 'Last Changed Date') {

                            //   $phpExcelObject->getActiveSheet()
                            //       ->setCellValue($cellId, $row[self::PARKING_LOT_LIST_COL_NAMES[$i]]);
                            $fieldName = 'get' . self::PARKING_LOT_LIST_COL_NAMES[$i] . '()';
                            if (self::PARKING_LOT_LIST_COL_NAMES[$i] == 'gap') {
                                $phpExcelObject->getActiveSheet()
                                    ->setCellValue($cellId, $gapMsg);
                            } else {
                                $phpExcelObject->getActiveSheet()
                                    ->setCellValue($cellId, $row[self::PARKING_LOT_LIST_COL_NAMES[$i]]);
                            }
                            // }
                        }
                    }

                    $prevDecalNum   = $row['decal_num'];
                    $prevBuilding   = $row['building'];
                    $prevFloorNum   = $row['floor_number'];
                    $prevAptLine    = $row['apt_line'];

            // }



            }

            $phpExcelObject->getActiveSheet()->setTitle($spreadsheetTabName);
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $phpExcelObject->setActiveSheetIndex(0);

            // create the writer
            $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel2007');
            // The save method is documented in the official PHPExcel library
            $fileWriteCtr++;
            $writer->save($this->appOutputDir . '/' . self::PARKING_LOT_LIST_FILE_NAME);

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
     * Use raw SQL rather than Doctrine DQL
     * @return array
     * @throws \Exception
     */
    private function getResidentsWithParkingSpaces() {


        /*
         * Following DQL doesn't work because of LEFT JOIN - don't know how to use custom join with Doctrine
         *                 'SELECT  distinct pr.building, pr.floorNumber, pr.aptLine, pr.mdsResidentCategory as mds_resident_category1,
                             pr.parkingLotLocation, \'\' as gap, pr.decalNum, pr.vehicleRegExpDate, pr.vehicleRegIntervalRemaining,
                             pr.vehicleModel, pr.vehicleLicensePlateNum,
                             pr.firstName, pr.lastName, pr.emailAddress, pr.cellPhone, pr.eveningPhone,
                             pr2.mdsResidentCategory, pr2.firstName, pr2.lastName, pr2.emailAddress,
                              pr2.cellPhone, pr2.eveningPhone
                          FROM PennsouthMdsBundle:PennsouthResident  pr
                             LEFT JOIN
                              PennsouthMdsBundle:PennsouthResident  pr2
                          ON
                             pr.building = pr2.building
                          and pr.floorNumber = pr2.floorNumber
                          and pr.aptLine	= pr2.aptLine
                          and pr.pennsouthResidentId < pr2.pennsouthResidentId
                          and pr.mdsResidentCategory = pr2.mdsResidentCategory
                          and concat(pr.firstName, pr.lastName) <> concat(pr2.firstName, pr2.lastName)
                          WHERE
                             pr.decalNum is not null and pr.mdsResidentCategory = :mdsResidentCategory
                                 order by pr.decalNum'
         *
         */

        try {
            /*
                       $query = $this->getEntityManager()->createQuery(
                'Select DISTINCT pr.building, pr.floorNumber, pr.aptLine,
                  pr.parkingLotLocation, pr.decalNum
                 from PennsouthMdsBundle:PennsouthResident pr
                where pr.decalNum is not NULL
                order by pr.decalNum'
            );

             */
            if ($this->env == SyncAweberMdsCommand::ENVIRONMENT_PROD) {
                $query =
                    'SELECT  distinct pr.building, pr.floor_number, pr.apt_line, pr.mds_resident_category as mds_resident_category1,
                    pr.parking_lot_location, \'\' gap, cast(pr.decal_num as unsigned) decal_num, pr.vehicle_reg_exp_date, pr.vehicle_reg_exp_countdown,
                    pr.vehicle_reg_interval_remaining, pr.vehicle_model, pr.vehicle_license_plate_num,
                    pr.last_name, pr.first_name, pr.email_address, pr.cell_phone, pr.evening_phone, 
                    pr2.mds_resident_category as mds_resident_category2, pr2.last_name last_name2, pr2.first_name first_name2, 
                    pr2.email_address email_address2, pr2.cell_phone cell_phone2, pr2.evening_phone evening_phone2
                 FROM pennsouth_resident as pr
                    LEFT JOIN
                     pennsouth_resident as pr2
                 ON
                    pr.building = pr2.building
                 and pr.floor_number = pr2.floor_number
                 and pr.apt_line	= pr2.apt_line
                 and pr.pennsouth_resident_id < pr2.pennsouth_resident_id
                 and pr.mds_resident_category = pr2.mds_resident_category
                 and concat(pr.first_name, pr.last_name) <> concat(pr2.first_name, pr2.last_name)
                 WHERE
                    pr.decal_num is not null and pr.mds_resident_category = :mdsResidentCategory
                 order by cast(pr.decal_num as unsigned), pr2.mds_resident_category desc ';
            }
            else {
                $query =
                    'SELECT  distinct pr.building, pr.floor_number, pr.apt_line, pr.mds_resident_category as mds_resident_category1,
                    pr.parking_lot_location, \'\' gap, cast(pr.decal_num as unsigned) decal_num, pr.vehicle_reg_exp_date, pr.vehicle_reg_exp_countdown,
                    pr.vehicle_reg_interval_remaining, pr.vehicle_model, pr.vehicle_license_plate_num,
                    pr.last_name, pr.first_name, pr.email_address, pr.cell_phone, pr.evening_phone, 
                    pr2.mds_resident_category as mds_resident_category2, pr2.last_name last_name2, pr2.first_name first_name2, 
                    pr2.email_address email_address2, pr2.cell_phone cell_phone2, pr2.evening_phone evening_phone2
                     FROM pennsouth_db.pennsouth_resident as pr
                        LEFT JOIN
                         pennsouth_db.pennsouth_resident as pr2
                     ON
                        pr.building = pr2.building
                     and pr.floor_number = pr2.floor_number
                     and pr.apt_line	= pr2.apt_line
                     and pr.pennsouth_resident_id < pr2.pennsouth_resident_id
                     and pr.mds_resident_category = pr2.mds_resident_category
                     and concat(pr.first_name, pr.last_name) <> concat(pr2.first_name, pr2.last_name)
                     WHERE
                        pr.decal_num is not null and pr.mds_resident_category = :mdsResidentCategory
                     order by cast(pr.decal_num as unsigned), pr2.mds_resident_category desc ';
            }
            
            $statement = $this->getEntityManager()->getConnection()->prepare($query);
            // Set parameters
            $statement->bindValue( 'mdsResidentCategory', 'SHAREHOLDER');

            $statement->execute();

            $residentsWithParkingSpaces = $statement->fetchAll();

            return $residentsWithParkingSpaces;
        }
        catch (\Exception $exception) {
            print("\n" . "Fatal Exception occurred in ParkingLotListCreator->getResidentsWithParkingSpaces! ");
            print ("\n Exception->getMessage() : " . $exception->getMessage());
            print "Type: " . $exception->getCode(). "\n";
            print("\n" . "Exiting from program.");
            throw $exception;
        }

    }


}