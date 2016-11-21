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



    public function insertIntoListUpdateArrayCtr($key, $value) {
        $this->listUpdateArrayCtr[$key] = $value;
    }

    public function getListUpdateArrayCtr(){
        return $this->listUpdateArrayCtr;
    }

    public function insertIntoListInsertArrayCtr($key, $value) {
        $this->listInsertArrayCtr[$key] = $value;
    }

    public function getListInsertArrayCtr() {
        return $this->listInsertArrayCtr;
    }

    public function incrementListInsertArrayCtr($listName) {
        $this->listInsertArrayCtr[$listName]++;
    }

    public function initializeListInsertArrayCtr($listName) {
        $this->listInsertArrayCtr[$listName] = 0;
    }

    public function incrementListUpdateArrayCtr($listName) {
        $this->listUpdateArrayCtr[$listName]++;
    }

    public function initializeListUpdateArrayCtr($listName) {
        $this->listInsertArrayCtr[$listName] = 0;
    }

}