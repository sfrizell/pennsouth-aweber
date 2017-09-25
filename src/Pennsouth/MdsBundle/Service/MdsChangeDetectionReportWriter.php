<?php
/**
 * MdsChangeDetectionReportWriter.php
 * User: sfrizell
 * Date: 6/9/2017
 *  Function:
 */

namespace Pennsouth\MdsBundle\Service;

use Doctrine\ORM\EntityManager;


class MdsChangeDetectionReportWriter
{

    const MDS_CHANGE_DETECTION_REPORT_FILE_NAME = 'mds_change_detection_report';
    const MDS_CHANGE_DETECTION_REPORT_FILE_SUFFIX = '.csv';


    const MDS_CHANGE_DETECTION_REPORT_HEADER_ARRAY = array(
                        'From Date',
                        'Person-Id',
                        'Email Address',
                        'Last Name',
                        'First Name',
                        'Apartment-Id',
                        'Building',
                        'Floor Number',
                        'Apt Line',
                        'MDS Resident Category',
                        'Insert Date',
                        'Change Type',
                        'Before Value',
                        'Current Value'
               );

/*        const MDS_CHANGE_DETECTION_REPORT_COL_NAMES = array(
                        'change_from_date',
                        'person_id',
                        'email_address',
                        'last_name',
                        'first_name',
                        'apartment_id',
                         'building',
                         'floor_number',
                         'apt_line',
                         'mds_resident_category',
                         'insert_date',
                         'change_type',
                         'before_value',
                         'current_value'
                );*/


    private $entityManager;
    private $phpExcel;
    private $appOutputDir;
    private $env;

    public function __construct (EntityManager $entityManager,  $phpExcel = null, $appOutputDir, $env ) {

        $this->entityManager    = $entityManager;
        $this->phpExcel         = $phpExcel;
        $this->appOutputDir     = $appOutputDir;
        $this->env              = $env;

    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
       *
       * @return bool
       */
      public function createMdsChangeDetectionReport() {

          $mdsChangeDetectionReportRows = $this->getMdsChangeDetectionReportRows();

          $fileDate = date('Ymd'); // current date in format YYYYMMDD

          $file = fopen($this->appOutputDir . "/" . self::MDS_CHANGE_DETECTION_REPORT_FILE_NAME . "-" . $fileDate . self::MDS_CHANGE_DETECTION_REPORT_FILE_SUFFIX, "w");

          fputcsv($file, self::MDS_CHANGE_DETECTION_REPORT_HEADER_ARRAY);


          foreach($mdsChangeDetectionReportRows as $row){
              fputcsv($file, $row);

          }
          fclose($file);

          $updateStatus = $this->updateDetectChangeDateParameterTable();

          return TRUE;

      }

    /**
     *
     */
      private function updateDetectChangeDateParameterTable() {

          try {
              $updateStatement = 'update detect_change_date_parameter set begin_date = curdate(), last_changed_date = curdate() where detect_change_date_parameter_id = 1';
              $updateStatus = $this->getEntityManager()->getConnection()->executeUpdate($updateStatement);
              return $updateStatus;
          }
          catch (\Exception $exception) {
              print("\n" . "Fatal Exception occurred in MdsChangedDetectionReportWriter->updateDetectChangeDateParameterTable! ");
              print ("\n Exception->getMessage() : " . $exception->getMessage());
              print "Type: " . $exception->getCode(). "\n";
              print("\n" . "Exiting from program.");
              throw $exception;
          }


      }

    private function getMdsChangeDetectionReportRows() {

        try {

            $query =
                      'SELECT cdp.begin_date change_from_date, cl.person_id, cl.email_address, cl.last_name, cl.first_name, cl.apartment_id,
                          cl.building, cl.floor_number, cl.apt_line, cl.mds_resident_category, cl.insert_date, cl.change_type,
                          cl.before_value, cl.current_value
                         FROM 
                                detect_change_date_parameter cdp
                                join
                                resident_change_log cl
                                on cdp.detect_change_date_parameter_id = 1
                        where 
                                cl.change_type <> :initialLoad 
                        and		cl.insert_date > cdp.begin_date
                        order by cl.change_type, cl.building, cl.floor_number, cl.apt_line; ';



                $statement = $this->getEntityManager()->getConnection()->prepare($query);
                // Set parameters
                $statement->bindValue( 'initialLoad', 'InitialLoad');

                $statement->execute();

                $mdsChangeDetectionReportRows = $statement->fetchAll();

                return $mdsChangeDetectionReportRows;
        }
        catch (\Exception $exception) {
            print("\n" . "Fatal Exception occurred in MdsChangedDetectionReportWriter->getMdsChangeDetectionReportRows! ");
            print ("\n Exception->getMessage() : " . $exception->getMessage());
            print "Type: " . $exception->getCode(). "\n";
            print("\n" . "Exiting from program.");
            throw $exception;
        }

    }


}