<?php

namespace Pennsouth\MdsBundle\AweberEntity;
/**
 * AweberSubscriber.php
 * User: sfrizell
 * Date: 9/29/16
 *  Function:
 */
class AweberSubscriber
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $pennSouthBuilding;

    /**
     * @var integer
     */
    private $floorNumber;

    /**
     * @var string
     */
    private $apartment;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $subscriptionMethod;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string - Date/Time
     */
    private $unsubscribedAt;

    /**
     * @var string - Date/Time
     */
    private $subscribedAt;

    /**
     * @var array
     */
    private $customFields = array();

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPennSouthBuilding()
    {
        return $this->pennSouthBuilding;
    }

    /**
     * @param string $pennSouthBuilding
     */
    public function setPennSouthBuilding($pennSouthBuilding)
    {
        $this->pennSouthBuilding = $pennSouthBuilding;
    }

    /**
     * @return int
     */
    public function getFloorNumber()
    {
        return $this->floorNumber;
    }

    /**
     * @param int $floorNumber
     */
    public function setFloorNumber($floorNumber)
    {
        $this->floorNumber = $floorNumber;
    }

    /**
     * @return string
     */
    public function getApartment()
    {
        return $this->apartment;
    }

    /**
     * @param string $apartment
     */
    public function setApartment($apartment)
    {
        $this->apartment = $apartment;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSubscriptionMethod()
    {
        return $this->subscriptionMethod;
    }

    /**
     * @param string $subscriptionMethod
     */
    public function setSubscriptionMethod($subscriptionMethod)
    {
        $this->subscriptionMethod = $subscriptionMethod;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getUnsubscribedAt()
    {
        return $this->unsubscribedAt;
    }

    /**
     * @param string $unsubscribedAt
     */
    public function setUnsubscribedAt($unsubscribedAt)
    {
        $this->unsubscribedAt = $unsubscribedAt;
    }

    /**
     * @return string
     */
    public function getSubscribedAt()
    {
        return $this->subscribedAt;
    }

    /**
     * @param string $subscribedAt
     */
    public function setSubscribedAt($subscribedAt)
    {
        $this->subscribedAt = $subscribedAt;
    }

    /**
     * @return array
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @param array $customFields
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
    }




}