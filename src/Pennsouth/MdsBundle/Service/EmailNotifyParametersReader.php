<?php
/**
 * EmailNotifyParametersReader.php
 * User: sfrizell
 * Date: 1/7/17
 *  Function:
 */

namespace Pennsouth\MdsBundle\Service;

use Doctrine\DBAL\Query\QueryException;
use Doctrine\ORM\EntityManager;

class EmailNotifyParametersReader
{

    private $entityManager;


    public function __construct (EntityManager $entityManager ) {

        $this->entityManager = $entityManager;

    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function getEmailNotifyParameters($reportOrProcessName) {

        try {
            $query = $this->getentityManager()->createQuery(
                'Select enp 
              from PennsouthMdsBundle:EmailNotifyParameters enp 
              where enp.reportOrProcessName =:reportOrProcessName'
            )->setParameter('reportOrProcessName', $reportOrProcessName)
            ;
            $emailNotifyParametersRows = $query->getResult();

            return $emailNotifyParametersRows;
        }
        catch (QueryException $exception) {
            print("\n QueryException in EmailNotifyParametersReader->getEmailNotifyParameters(): exception->getMessage(): " . $exception->getMessage() . "\n");
            throw $exception;
        }
        catch (\Exception $exception) {
            print("\n Exception in EmailNotifyParametersReader->getEmailNotifyParameters(): exception->getMessage(): " . $exception->getMessage() . "\n");
            throw $exception;
        }


    }

}