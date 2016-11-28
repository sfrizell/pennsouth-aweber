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

class ParkingLotListCreator
{

    const PARKING_LOT_LIST_FILE_NAME = 'parking_lot_spaces.xlsx';

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
     * Run SQL query against the pennsouth_db.pennsouth_resident table to obtain a list of all distinct apartments
     *   that have assigned Pennsouth parking lot spaces. Obtain the list in order by decal_num. Write
     *   the list to an excel spreadsheet, identifying any gaps in the sequence of assigned values for decal_num.
     *   These gaps identify unfilled parking spaces.
     *   Write the spreadsheet to the /app_output directory under the project root directory.
     * See: http://stackoverflow.com/questions/39186017/creating-excel-file-from-array-using-php-and-symfony
     *   also: http://ourcodeworld.com/articles/read/50/how-to-create-a-excel-file-with-php-in-symfony-2-3
     * For usage examples of Font and Fill, see the comments in the code of PHPExcel:
     *    vendor/phpoffice/phpexcel/Classes/PHPExcel/Style/Font
     *    vendor/phpoffice/phpexcel/Classes/PHPExcel/Style/Fill
     */
    public function generateParkingLotList() {

        $residentsWithParkingSpaces = $this->getResidentsWithParkingSpaces();

        $phpExcelObject = $this->phpExcel->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("sfrizell")
            ->setLastModifiedBy("Batch Process")
            ->setTitle("Office 2005 XLSX Pennsouth Parking Lot List Document")
            ->setSubject("Office 2005 XLSX Test Document")
            ->setDescription("Parking Lot List identifying gaps in sequences of Pennsouth Upper and Lower Lot parking spaces.")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("List Management Reports");
        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Building')
            ->setCellValue('B1', 'Floor Number')
            ->setCellValue('C1', 'Apt Line')
            ->setCellValue('D1', 'Parking Lot Location')
            ->setCellValue('E1', 'Decal Number')
            ->setCellValue('F1', 'Gap');

        // set font of Header row to bold
        $phpExcelObject->getActiveSheet()
            ->getStyle('A1')->getFont()->applyFromArray(
                array(
                    'bold'  => TRUE,
                    'size'  => 12
                )
            );
        $phpExcelObject->getActiveSheet()
            ->getStyle('B1')->getFont()->applyFromArray(
                array(
                    'bold'  => TRUE,
                    'size'  => 12
                )
            );
        $phpExcelObject->getActiveSheet()
            ->getStyle('C1')->getFont()->applyFromArray(
                array(
                    'bold'  => TRUE,
                    'size'  => 12
                )
            );
        $phpExcelObject->getActiveSheet()
            ->getStyle('D1')->getFont()->applyFromArray(
                array(
                    'bold'  => TRUE,
                    'size'  => 12
                )
            );
        $phpExcelObject->getActiveSheet()
            ->getStyle('E1')->getFont()->applyFromArray(
                array(
                    'bold'  => TRUE,
                    'size'  => 12
                )
            );
        $phpExcelObject->getActiveSheet()
            ->getStyle('F1')->getFont()->applyFromArray(
                array(
                    'bold'  => TRUE,
                    'size'  => 12
                )
            );

        // set fill of Header row to light background color - #EAE9DE
               $phpExcelObject->getActiveSheet()
                   ->getStyle('A1')->getFill()->applyFromArray(
                       array(
                           'type'	   => PHPExcel_Style_Fill::FILL_SOLID,
                           'color'       => array(
                               'rgb' => 'EAE9DE'
                           )
                       )
                   );
               $phpExcelObject->getActiveSheet()
                   ->getStyle('B1')->getFill()->applyFromArray(
                       array(
                           'type'	   => PHPExcel_Style_Fill::FILL_SOLID,
                           'color'       => array(
                               'rgb' => 'EAE9DE'
                           )
                       )
                   );
               $phpExcelObject->getActiveSheet()
                   ->getStyle('C1')->getFill()->applyFromArray(
                       array(
                           'type'	   => PHPExcel_Style_Fill::FILL_SOLID,
                           'color'       => array(
                               'rgb' => 'EAE9DE'
                           )
                       )
                   );
               $phpExcelObject->getActiveSheet()
                   ->getStyle('D1')->getFill()->applyFromArray(
                       array(
                           'type'	   => PHPExcel_Style_Fill::FILL_SOLID,
                           'color'       => array(
                               'rgb' => 'EAE9DE'
                           )
                       )
                   );
               $phpExcelObject->getActiveSheet()
                   ->getStyle('E1')->getFill()->applyFromArray(
                       array(
                           'type'	   => PHPExcel_Style_Fill::FILL_SOLID,
                           'color'       => array(
                               'rgb' => 'EAE9DE'
                           )
                       )
                   );
               $phpExcelObject->getActiveSheet()
                   ->getStyle('F1')->getFill()->applyFromArray(
                       array(
                           'type'	   => PHPExcel_Style_Fill::FILL_SOLID,
                           'color'       => array(
                               'rgb' => 'EAE9DE'
                           )
                       )
                   );

        $prevDecalNum = null;
        $rowCtr = 1;
        foreach ( $residentsWithParkingSpaces as $resident ) {
            $rowCtr++;
            $gapMsg = "";
            if (!is_null($prevDecalNum) and !($resident['decalNum'] == 700)) {
                $gapCalc = $resident['decalNum'] - $prevDecalNum;
                if ($gapCalc > 1 ) {
                    $gapMsg = "Gap";
                }
            }
            $a = 'A' . $rowCtr;
            $b = 'B' . $rowCtr;
            $c = 'C' . $rowCtr;
            $d = 'D' . $rowCtr;
            $e = 'E' . $rowCtr;
            $f = 'F' . $rowCtr;
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue($a, $resident['building'] )
                ->setCellValue($b, $resident['floorNumber'])
                ->setCellValue($c, $resident['aptLine'])
                ->setCellValue($d, $resident['parkingLotLocation'])
                ->setCellValue($e, $resident['decalNum'])
                ->setCellValue($f, $gapMsg);

            $prevDecalNum = $resident['decalNum'];

        }

        $phpExcelObject->getActiveSheet()->setTitle('Parking Lot List');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

         // create the writer
         $writer = $this->phpExcel->createWriter($phpExcelObject, 'Excel2007');
         // The save method is documented in the official PHPExcel library
         $writer->save($this->appOutputDir . '/' . self::PARKING_LOT_LIST_FILE_NAME);

        return TRUE;

    }

    private function getResidentsWithParkingSpaces() {

        try {
            $query = $this->getEntityManager()->createQuery(
                'Select DISTINCT pr.building, pr.floorNumber, pr.aptLine,
                  pr.parkingLotLocation, pr.decalNum
                 from PennsouthMdsBundle:PennsouthResident pr
                where pr.decalNum is not NULL
                order by pr.decalNum'
            );

            $residentsWithParkingSpaces = $query->getResult();

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