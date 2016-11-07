<?php

namespace Pennsouth\MdsBundle\Entity;

/**
 * AptSize
 */
class AptSize
{
    /**
     * @var string
     */
    private $aptSizeDescription;

    /**
     * @var integer
     */
    private $bedroomCount;


    /**
     * Set aptSizeDescription
     *
     * @param string $aptSizeDescription
     *
     * @return AptSize
     */
    public function setAptSizeDescription($aptSizeDescription)
    {
        $this->aptSizeDescription = $aptSizeDescription;

        return $this;
    }

    /**
     * Get aptSizeDescription
     *
     * @return string
     */
    public function getAptSizeDescription()
    {
        return $this->aptSizeDescription;
    }

    /**
     * Get bedroomCount
     *
     * @return integer
     */
    public function getBedroomCount()
    {
        return $this->bedroomCount;
    }
}
