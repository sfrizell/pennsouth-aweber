<?php

namespace Pennsouth\MdsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AptSize
 *
 * @ORM\Table(name="Apt_Size")
 * @ORM\Entity
 */
class AptSize
{
    /**
     * @var string
     *
     * @ORM\Column(name="apt_size_description", type="string", length=20, nullable=true)
     */
    private $aptSizeDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="apt_size_code", type="string", length=10)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $aptSizeCode;



    /**
     * Set aptSizeDescription
     *
     * @param string $aptSizeDescription
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
     * Get aptSizeCode
     *
     * @return string 
     */
    public function getAptSizeCode()
    {
        return $this->aptSizeCode;
    }
}
