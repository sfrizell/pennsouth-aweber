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


    public function getListUpdateArrayCtr(){
        return $this->listUpdateArrayCtr;
    }

    public function getListInsertArrayCtr() {
        return $this->listInsertArrayCtr;
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

}