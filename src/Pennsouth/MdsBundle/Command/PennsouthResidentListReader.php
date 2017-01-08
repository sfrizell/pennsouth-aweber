<?php
/**
 * PennsouthResidentListReader.php
 * User: sfrizell
 * Date: 10/7/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\Command;

use Doctrine\DBAL\Query\QueryException;
use Pennsouth\MdsBundle\Entity\PennsouthResident;

//use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Doctrine\ORM\EntityManager;
//use Symfony\Component\HttpKernel\HttpKernelInterface;
//use Symfony\Component\DependencyInjection\ContainerAware;
//use Doctrine\Bundle\DoctrineBundle\Registry;


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

    try {
       // print("\n ------- 4.1.1 -----------\n");

       $query = $this->getentityManager()->createQuery(
            'Select pr 
             from PennsouthMdsBundle:PennsouthResident pr 
             where pr.emailAddress is not NULL');
        /*
                    $query = $this->getentityManager()->createQuery(
                                  'Select pr.building, pr.floorNumber, pr.aptLine, pr.lastName, pr.firstName, pr.emailAddress,
                                    pr.mdsResidentCategory, pr.daytimePhone, pr.eveningPhone, pr.cellPhone, pr.fax, pr.officePhone,
                                    pr.personId, pr.toddlerRoomMember, pr.youthRoomMember, pr.ceramicsMember,
                                    pr.woodworkingMember, pr.gymMember, pr.gardenMember, pr.decalNum, pr.parkingLotLocation,
                                    pr.vehicleRegExpDate, pr.vehicleRegIntervalRemaining, pr.vehicleModel, pr.vehicleLicensePlateNum,
                                    pr.homeownerInsExpDate, pr.homeownerInsIntervalRemaining, pr.birthDate, pr.moveInDate,
                                    pr.storageLockerClosetBldgNum, pr.storageLockerNum, pr.storageClosetFloorNum,
                                    pr.dogTagNum, pr.isDogInApt, pr.bikeRackLocation, pr.bikeRackRoom, pr.bikeRackBldg, pr.lastChangedDate
                                   from PennsouthMdsBundle:PennsouthResident pr
                                   where pr.emailAddress is not NULL');
                    */

                    // Looks like a memory issue. When this is run on Rose Hosting, if there are too many columns in the query, the program stops on the getResult call...
         /*           $query = $this->getentityManager()->createQuery(
                                             'Select pr.building, pr.floorNumber, pr.aptLine, pr.lastName, pr.firstName, pr.emailAddress,
                                               pr.mdsResidentCategory, pr.daytimePhone, pr.eveningPhone, pr.cellPhone, pr.fax, pr.officePhone,
                                               pr.personId, pr.toddlerRoomMember, pr.youthRoomMember, pr.ceramicsMember,
                                               pr.woodworkingMember, pr.gymMember, pr.gardenMember,  pr.vehicleRegExpDate
                                              from PennsouthMdsBundle:PennsouthResident pr
                                              where pr.emailAddress is not NULL');*/

          //  print("\n ------- 4.1.2 -----------\n");

            $pennsouthResidentsHavingEmailAddresses = $query->getResult();
          //  print("\n ------- 4.1.3 -----------\n");

            $count = count($pennsouthResidentsHavingEmailAddresses); // length function obtains number of elements in a collection of objects

            print ("\n" . "PennsouthResidents with email addresses: " . $count . "\n");

            //print("\n Exiting! \n");
            //exit(0);

            return $pennsouthResidentsHavingEmailAddresses;
        }
        catch (QueryException $exception) {
            print("\n QueryException in PennsouthResidentListReader->getPennsouthResidentsHavingEmailAddresses(): exception->getMessage(): " . $exception->getMessage() . "\n");
            throw $exception;
        }
        catch (\Exception $exception) {
            print("\n Exception in PennsouthResidentListReader->getPennsouthResidentsHavingEmailAddresses(): exception->getMessage(): " . $exception->getMessage() . "\n");
            throw $exception;
        }

    }

       public function getPennsouthResidentsHavingEmailAddressAssociativeArray() {

            $pennsouthResidents = $this->getPennsouthResidentsHavingEmailAddresses();

            $residentsWithEmailAddressesArray = array();

            foreach ($pennsouthResidents as $resident ) {

                if ($resident instanceof PennsouthResident) { // if statement added for clarity and code hint...

                    $emailAddress = $resident->getEmailAddress();
                    $residentsWithEmailAddressesArray [$emailAddress] = $resident;
                }
                else {
                    print("\n Fatal Error in PennsouthResidentListReder->getPennsouthResidentsHavingEmailAddressAssociativeArray()!! \$resident not instance of PennsouthResident! \n");
                    print("\n throwing Exception.");
                    throw new \Exception("Fatal Error in PennsouthResidentListReder->getPennsouthResidentsHavingEmailAddressAssociativeArray()!! \$resident not instance of PennsouthResident!");
                }

               // print("\n" . "emailAddress: " . $emailAddress . "\n");
            }

            return $residentsWithEmailAddressesArray;

        }



}