<?php
/**
 * PennsouthResidentListReader.php
 * User: sfrizell
 * Date: 10/7/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Command;

use Pennsouth\MdsBundle\Entity\PennsouthResident;

//use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\Bundle\DoctrineBundle\Registry;
//extends ContainerAwareCommand


class PennsouthResidentListReader
{

    private $entityManager;


    public function __construct (EntityManager $entityManager ) {

        $this->entityManager = $entityManager;

    }

    public function getEntityManager() {
        return $this->entityManager;
    }


        public function getPennsouthResidentsHavingEmailAddresses() {

          $query =  $this->getEntityManager()->createQuery(
                'Select pr 
                 from PennsouthMdsBundle:PennsouthResident pr 
                 where pr.emailAddress is not NULL');

            $pennsouthResidentsHavingEmailAddresses = $query->getResult();

            $count = count($pennsouthResidentsHavingEmailAddresses); // length function obtains number of elements in a collection of objects

            print ("\n" . "PennsouthResidents with email addresses: " . $count . "\n");

            return $pennsouthResidentsHavingEmailAddresses;

        }

       public function getPennsouthResidentsHavingEmailAddressAssociativeArray() {

            $pennsouthResidents = $this->getPennsouthResidentsHavingEmailAddresses();

            $residentsWithEmailAddressesArray = array();

            foreach ($pennsouthResidents as $resident ) {

                $emailAddress = $resident->getEmailAddress();
                $residentsWithEmailAddressesArray [$emailAddress] = $resident;

               // print("\n" . "emailAddress: " . $emailAddress . "\n");
            }

            return $residentsWithEmailAddressesArray;

        }



}