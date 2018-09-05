<?php
/**
 * AweberSubscriberUpdateInsertLists.php
 * User: sfrizell
 * Date: 10/26/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\AweberEntity;


class AweberSubscriberUpdateInsertDeleteLists
{
    const INSERT = 'INSERT';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';

    private $aweberSubscriberInsertList = array(); // associative array of AweberSubscribers consisting of array of list name => AweberSubscriber object to be used to insert new subscribers into Aweber Subscriber list
    private $aweberSubscriberUpdateList = array(); // associative array of AweberSubscribers consisting of array of list name => AweberSubscriber object to be used to update existing subscribers in Aweber Subscriber list
    private $aweberSubscriberDeleteList = array(); // associative array of AweberSubscribers consisting of array of list name => AweberSubscriber object to be used to delete existing subscribers in Aweber Subscriber list

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

    /**
     * @return array
     */
    public function getAweberSubscriberDeleteList()
    {
        return $this->aweberSubscriberDeleteList;
    }

    /**
     * @param array $aweberSubscriberDeleteList
     */
    public function setAweberSubscriberDeleteList($aweberSubscriberDeleteList)
    {
        $this->aweberSubscriberDeleteList = $aweberSubscriberDeleteList;
    }


    public function isAweberSubscriberUpdateListEmpty() {

        if (is_null($this->aweberSubscriberUpdateList) or empty($this->aweberSubscriberUpdateList) ) {
            return true;
        }
        else {
            return false;
        }

    }

    public function isAweberSubscriberInsertListEmpty() {

        if (is_null($this->aweberSubscriberInsertList) or empty($this->aweberSubscriberInsertList) ) {
            return true;
        }
        else {
            return false;
        }

    }

    public function isAweberSubscriberDeleteListEmpty() {

        if (is_null($this->aweberSubscriberDeleteList) or empty($this->aweberSubscriberDeleteList)) {
            return true;
        }
        else {
            return false;
        }

    }

    public function isUpdateListAndInsertListEmpty() {
        if ($this->isAweberSubscriberUpdateListEmpty() and $this->isAweberSubscriberInsertListEmpty()) {
            return true;
        }
        else {
            return false;
        }
    }

    public function isUpdateAndInsertAndDeleteListsEmpty() {
            if ($this->isAweberSubscriberUpdateListEmpty() and $this->isAweberSubscriberInsertListEmpty()
                and $this->isAweberSubscriberDeleteListEmpty()) {
                return true;
            }
            else {
                return false;
            }
        }



}