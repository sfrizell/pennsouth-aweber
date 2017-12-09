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

//    private $pennsouthResidentsHavingEmailAddresses;

    /**
     * @param mixed $pennsouthResidentsHavingEmailAddresses
     */
/*    public function setPennsouthResidentsHavingEmailAddresses($pennsouthResidentsHavingEmailAddresses)
    {
        $this->pennsouthResidentsHavingEmailAddresses = $pennsouthResidentsHavingEmailAddresses;
    }*/

    public function __construct (EntityManager $entityManager ) {

        $this->entityManager = $entityManager;

    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    // see: http://stackoverflow.com/questions/19855251/symfony2-getdoctrine-outside-of-model-controller
    //  there is better solution is same linke above than is implemented here...
  //  protected $em;

/*    protected function configure()
      {
          $this->setName('Pennsouth:MdsBundle:update') ;
      }*/

/*    protected function execute(InputInterface $input, OutputInterface $output)
        {
            $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');




                  $query = $this->em->getDoctrine()->getManager->createQuery(
                      'Select pr 
                       from PennsouthMdsBundle:PennsouthResident pr 
                       where pr.email is not NULL'
                  );

                  $pennsouthResidents = $query->getResult();

                  $pennsouthResidentsArray = array ( $pennsouthResidents->getData() );

                  $countOfResidentsWithEmailAddresses = count($pennsouthResidentsArray);



                  print ("@@@@@@@@   pennsouthresidents count: " . $countOfResidentsWithEmailAddresses);
        }*/

        public function getPennsouthResidentsHavingEmailAddresses() {

          $query =  $this->getEntityManager()->createQuery(
                'Select pr 
                 from PennsouthMdsBundle:PennsouthResident pr 
                 where pr.emailAddress is not NULL');

            $pennsouthResidentsHavingEmailAddresses = $query->getResult();

            $count = count($pennsouthResidentsHavingEmailAddresses); // length function obtains number of elements in a collection of objects

            print ("\n" . "@@@@@@@@@@ pennsouthResidents with email addresses: " . $count . "\n");

          //  $this->setPennsouthResidentsHavingEmailAddresses(array($pennsouthResidentsHavingEmailAddresses));

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