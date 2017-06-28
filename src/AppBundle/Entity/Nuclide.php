<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Nuclide
 *
 * @ORM\Table(name="nuclide")
 * @ORM\Entity
 */
class Nuclide
{
	use ORMBehaviors\Translatable\Translatable;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10, nullable=true)
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="z", type="integer", nullable=true)
     */
    private $z;

    /**
     * @var integer
     *
     * @ORM\Column(name="a", type="bigint", nullable=true)
     */
    private $a;

    /**
     * @var string
     *
     * @ORM\Column(name="decayMode", type="string", length=40, nullable=true)
     */
    private $decaymode;

    /**
     * @var string
     *
     * @ORM\Column(name="halfLife", type="string", length=20, nullable=true)
     */
    private $halflife;

    /**
     * @var float
     *
     * @ORM\Column(name="seconds", type="float", precision=10, scale=0, nullable=true)
     */
    private $seconds;

    /**
     * @var string
     *
     * @ORM\Column(name="name_de", type="string", length=80, nullable=true)
     */
    private $nameDe;

    /**
     * @var string
     *
     * @ORM\Column(name="name_fr", type="string", length=80, nullable=true)
     */
    private $nameFr;

    /**
     * @var string
     *
     * @ORM\Column(name="name_it", type="string", length=80, nullable=true)
     */
    private $nameIt;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=80, nullable=true)
     */
    private $nameEn;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hidden", type="boolean", nullable=true)
     */
    private $hidden;

    /**
     * @var integer
     *
     * @ORM\Column(name="element_id", type="integer", nullable=false)
     */
    private $elementId;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Nuclide
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set z
     *
     * @param integer $z
     *
     * @return Nuclide
     */
    public function setZ($z)
    {
        $this->z = $z;

        return $this;
    }

    /**
     * Get z
     *
     * @return integer
     */
    public function getZ()
    {
        return $this->z;
    }

    /**
     * Set a
     *
     * @param integer $a
     *
     * @return Nuclide
     */
    public function setA($a)
    {
        $this->a = $a;

        return $this;
    }

    /**
     * Get a
     *
     * @return integer
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Set decaymode
     *
     * @param string $decaymode
     *
     * @return Nuclide
     */
    public function setDecaymode($decaymode)
    {
        $this->decaymode = $decaymode;

        return $this;
    }

    /**
     * Get decaymode
     *
     * @return string
     */
    public function getDecaymode()
    {
        return $this->decaymode;
    }

    /**
     * Set halflife
     *
     * @param string $halflife
     *
     * @return Nuclide
     */
    public function setHalflife($halflife)
    {
        $this->halflife = $halflife;

        return $this;
    }

    /**
     * Get halflife
     *
     * @return string
     */
    public function getHalflife()
    {
        return $this->halflife;
    }

    /**
     * Set seconds
     *
     * @param float $seconds
     *
     * @return Nuclide
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;

        return $this;
    }

    /**
     * Get seconds
     *
     * @return float
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * Set nameDe
     *
     * @param string $nameDe
     *
     * @return Nuclide
     */
    public function setNameDe($nameDe)
    {
        $this->nameDe = $nameDe;

        return $this;
    }

    /**
     * Get nameDe
     *
     * @return string
     */
    public function getNameDe()
    {
        return $this->nameDe;
    }

    /**
     * Set nameFr
     *
     * @param string $nameFr
     *
     * @return Nuclide
     */
    public function setNameFr($nameFr)
    {
        $this->nameFr = $nameFr;

        return $this;
    }

    /**
     * Get nameFr
     *
     * @return string
     */
    public function getNameFr()
    {
        return $this->nameFr;
    }

    /**
     * Set nameIt
     *
     * @param string $nameIt
     *
     * @return Nuclide
     */
    public function setNameIt($nameIt)
    {
        $this->nameIt = $nameIt;

        return $this;
    }

    /**
     * Get nameIt
     *
     * @return string
     */
    public function getNameIt()
    {
        return $this->nameIt;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     *
     * @return Nuclide
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    /**
     * Get nameEn
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     *
     * @return Nuclide
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set elementId
     *
     * @param integer $elementId
     *
     * @return Nuclide
     */
    public function setElementId($elementId)
    {
        $this->elementId = $elementId;

        return $this;
    }

    /**
     * Get elementId
     *
     * @return integer
     */
    public function getElementId()
    {
        return $this->elementId;
    }
}
