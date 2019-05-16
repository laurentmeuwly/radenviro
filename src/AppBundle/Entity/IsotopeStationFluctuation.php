<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Legend
 *
 * @ORM\Table(name="isotope_station_fluctuation")
 * @ORM\Entity
 */
class IsotopeStationFluctuation
{
 
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Station", inversedBy="fluctuations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $station;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Nuclide", inversedBy="fluctuations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $nuclide;
    
    /**
     * @var float
     *
     * @ORM\Column(name="fluctuation_min", type="float", precision=10, scale=0, nullable=true)
     */
    private $fluctuationMin;
    
    /**
     * @var float
     *
     * @ORM\Column(name="fluctuation_max", type="float", precision=10, scale=0, nullable=true)
     */
    private $fluctuationMax;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active=false;
    
       
        
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Legend
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
     * @return Legend
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }
    
    /**
     * Set station
     *
     * @param LegendStation $station
     *
     * @return LegendStation
     */
    public function setStation($station = null)
    {
        $this->station = $station;
        
        return $this;
    }
    
    /**
     * Get station
     *
     * @return integer
     */
    public function getStation()
    {
        return $this->station;
    }
    
    /**
     * Set nuclide
     *
     * @param Nuclide $nuclide
     *
     * @return $this
     */
    public function setNuclide($nuclide = null)
    {
        $this->nuclide = $nuclide;
        
        return $this;
    }
    
    /**
     * Get nuclide
     *
     * @return Nuclide
     */
    public function getNuclide()
    {
        return $this->nuclide;
    }
    
    /**
     * Set fluctuationMin
     *
     * @param float $fluctuationMin
     *
     * @return $this
     */
    public function setFluctuationMin($fluctuationMin = null)
    {
        $this->fluctuationMin = $fluctuationMin;
        
        return $this;
    }
    
    /**
     * Get fluctuationMin
     *
     * @return float
     */
    public function getFluctuationMin()
    {
        return $this->fluctuationMin;
    }
    
    /**
     * Set fluctuationMax
     *
     * @param float $fluctuationMax
     *
     * @return $this
     */
    public function setFluctuationMax($fluctuationMax = null)
    {
        $this->fluctuationMax = $fluctuationMax;
        
        return $this;
    }
    
    /**
     * Get fluctuationMax
     *
     * @return float
     */
    public function getFluctuationMax()
    {
        return $this->fluctuationMax;
    }
    
    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Station
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
    
    
}
