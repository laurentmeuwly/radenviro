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
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Element")
     *
     */
    private $element;
    
    /**
     * @var PredefinedNuclideList[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PredefinedNuclideListNuclide", mappedBy="nuclide", fetch="EXTRA_LAZY")
     */
    private $predefinedNuclideLists;
    
    /**
     * @var Legend[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LegendNuclide", mappedBy="nuclide", fetch="EXTRA_LAZY")
     */
    private $legends;
    

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
    	if (!method_exists(self::getTranslationEntityClass(), $method)) {
    		$method = 'get' . ucfirst($method);
    	}
    
    	return $this->proxyCurrentLocaleTranslation($method, $args);
    }

    public function __toString()
    {
    	return (string) $this->getName();
    }
    
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
     * Set active
     *
     * @param boolean $active
     *
     * @return AutomaticNetwork
     */
    public function setActive($active)
    {
    	$this->active = $active;
    
    	return $this;
    }
    
    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
    	return $this->active;
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
     * Set element
     *
     * @param integer $element
     *
     * @return Nuclide
     */
    public function setElement($element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get element
     *
     * @return integer
     */
    public function getElement()
    {
        return $this->element;
    }
    
    public function getLegends()
    {
    	return $this->legends;
    }
    
    /**
     * Set all legends in the station.
     *
     * @param Legend[] $legends
     */
    public function setLegends($legends)
    {
    	//$this->legends->clear();
    	$this->legends = $legends;//new ArrayCollection($legends);
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Nuclide
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Nuclide
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
