<?php
/**
 * AweberCredentialsPopulator.php
 * User: sfrizell
 * Date: 1/6/17
 *  Function: Obtain Aweber credentials stored in database.
 */

namespace Pennsouth\MdsBundle\AweberEntity;

use Doctrine\ORM\EntityManager;

class AweberCredentialsPopulator
{
    const CONSUMER_KEY_COL_NAME     = "consumer_key";
    const CONSUMER_SECRET_COL_NAME  = "consumer_secret";
    const ACCESS_TOKEN_COL_NAME     = "access_token";
    const ACCESS_SECRET_COL_NAME    = "access_secret";

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @var string
     */
    private $consumerSecret;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $accessSecret;

    /**
     * @return string
     */
    public function getConsumerKey()
    {
        return $this->consumerKey;
    }

    /**
     * @param string $consumerKey
     */
    public function setConsumerKey($consumerKey)
    {
        $this->consumerKey = $consumerKey;
    }

    /**
     * @return string
     */
    public function getConsumerSecret()
    {
        return $this->consumerSecret;
    }

    /**
     * @param string $consumerSecret
     */
    public function setConsumerSecret($consumerSecret)
    {
        $this->consumerSecret = $consumerSecret;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAccessSecret()
    {
        return $this->accessSecret;
    }

    /**
     * @param string $accessSecret
     */
    public function setAccessSecret($accessSecret)
    {
        $this->accessSecret = $accessSecret;
    }


    public function populateAweberCredentials() {

        $aweberCredentialsRows = $this->getAweberCredentialsRowFromDb();

        if (!is_null($aweberCredentialsRows)) { // should only be one row returned
            foreach ($aweberCredentialsRows as $row) {
                $this->setConsumerKey($row[self::CONSUMER_KEY_COL_NAME]);
                $this->setConsumerSecret($row[self::CONSUMER_SECRET_COL_NAME]);
                $this->setAccessToken($row[self::ACCESS_TOKEN_COL_NAME]);
                $this->setAccessSecret($row[self::ACCESS_SECRET_COL_NAME]);
            }
        }


    }

    private function getAweberCredentialsRowFromDb() {

        try {
            $query = 'select consumer_key, consumer_secret, access_token, access_secret
                      from aweber_credentials';

            $statement = $this->getEntityManager()->getConnection()->prepare($query);

            $statement->execute();

            $aweberCredentialsRow = $statement->fetchAll();

            return $aweberCredentialsRow;


        }
        catch (\Exception $exception) {
            print("\n" . "Fatal Exception occurred in AweberCredentialsPopulator->getAweberCredentialsRowFromDb! ");
            print ("\n Exception->getMessage() : " . $exception->getMessage());
            print "Error Code: " . $exception->getCode(). "\n";
            print("\n" . "Exiting from program.");
            throw $exception;
        }
    }

}