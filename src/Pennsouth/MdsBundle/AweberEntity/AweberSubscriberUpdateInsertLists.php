<?php
/**
 * AweberSubscriberUpdateInsertLists.php
 * User: sfrizell
 * Date: 10/26/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\AweberEntity;


class AweberSubscriberUpdateInsertLists
{
    const INSERT = 'INSERT';
    const UPDATE = 'UPDATE';

    private $aweberSubscriberInsertList = array(); // associative array of AweberSubscriber list name => AweberSubscriber objects to be used to update Aweber Subscriber list
    private $aweberSubscriberUpdateList = array(); // associative array of AweberSubscriber list name => AweberSubscriber objects to be used to update Aweber Subscriber list

    /**
     * @return array
     */
    public function getAweberSubscriberInsertList()
    {
        return $this->aweberSubscriberInsertList;
    }

    /**
     * @param array $aweberSubscriberInsertList
     */
    public function setAweberSubscriberInsertList($aweberSubscriberInsertList)
    {
        $this->aweberSubscriberInsertList = $aweberSubscriberInsertList;
    }

    /**
     * @return array
     */
    public function getAweberSubscriberUpdateList()
    {
        return $this->aweberSubscriberUpdateList;
    }

    /**
     * @param array $aweberSubscriberUpdateList
     */
    public function setAweberSubscriberUpdateList($aweberSubscriberUpdateList)
    {
        $this->aweberSubscriberUpdateList = $aweberSubscriberUpdateList;
    }



}