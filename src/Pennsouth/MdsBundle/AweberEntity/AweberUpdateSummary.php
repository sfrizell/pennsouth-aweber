<?php
/**
 * AweberUpdateSummary.php
 * User: sfrizell
 * Date: 11/14/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\AweberEntity;


class AweberUpdateSummary
{

    private $listUpdateArrayCtr = array();
    private $listInsertArrayCtr = array();
    private $listDeleteArrayCtr = array();


    public function getListUpdateArrayCtr(){
        return $this->listUpdateArrayCtr;
    }

    public function getListInsertArrayCtr() {
        return $this->listInsertArrayCtr;
    }

    /**
     * @return array
     */
    public function getListDeleteArrayCtr()
    {
        return $this->listDeleteArrayCtr;
    }


    public function incrementListInsertArrayCtr($listName) {
        $this->listInsertArrayCtr[$listName] = $this->listInsertArrayCtr[$listName] + 1;
       // print("\n listInsertArrayCtr: " . $this->listInsertArrayCtr[$listName]);
       // return $this;
    }

    public function initializeListInsertArrayCtr($listName) {
        print("\n AweberUpdateSummary->initializeListInsertArrayCtr invoked.");
        $this->listInsertArrayCtr[$listName] = 0;
       // return $this;
    }

    public function incrementListUpdateArrayCtr($listName) {
        $this->listUpdateArrayCtr[$listName] = $this->listUpdateArrayCtr[$listName] + 1;
       // print("\n listUpdateArrayCtr: " . $this->listUpdateArrayCtr[$listName]);
        return $this;
    }

    public function initializeListUpdateArrayCtr($listName) {
        print("\n AweberUpdateSummary->initializeListUpdateArrayCtr invoked.");
        $this->listUpdateArrayCtr[$listName] = 0;
        //return $this;
    }

    public function incrementListDeleteArrayCtr($listName) {
        $this->listDeleteArrayCtr[$listName] = $this->listDeleteArrayCtr[$listName] + 1;
        return $this;
    }

    public function initializeListDeleteArrayCtr($listName) {
        print("\n AweberUpdateSummary->initializeListDeleteArrayCtr invoked.");
        $this->listDeleteArrayCtr[$listName] = 0;
    }

}