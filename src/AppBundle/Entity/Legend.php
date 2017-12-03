<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Xmon\ColorPickerTypeBundle\Validator\Constraints as XmonAssertColor;

/**
 * Legend
 *
 * @ORM\Table(name="legend", indexes={@ORM\Index(name="index_legends_on_active", columns={"active"})})
 * @ORM\Entity
 */
class Legend
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
     * @var integer
     * 
     * @ORM\Column(name="sorting", type="integer")
     */
    private $sorting;
    
    /**
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = true;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=6, nullable=false)
     * @XmonAssertColor\HexColor()
     */
    private $color = '#ffffff';
    
    
    /**
     * @var Station[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LegendStation", mappedBy="legend", fetch="EXTRA_LAZY")
     */
    private $stations;
    
    /**
     * @var Nuclid[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LegendNuclide", mappedBy="legend"))
     */
    private $nuclides;
    
    
    private $totalStations;
    
    private $totalNuclides;


    public function __construct() {
    	$this->stations = new ArrayCollection();
    	$this->nuclides = new ArrayCollection();
    }
    
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
     * Set sorting
     *
     * @param integer $sorting
     *
     * @return Legend
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;

        return $this;
    }

    /**
     * Get sorting
     *
     * @return integer
     */
    public function getSorting()
    {
        return $this->sorting;
    }
    
    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Legend
     */
    public function setPosition($position)
    {
    	$this->position=$position;
    	return $this;
    }
    
    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
    	return $this->position;
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Legend
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
     * Set color
     *
     * @param string $color
     *
     * @return Legend
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
    
    public function getStations()
    {
    	return $this->stations;
    }
    
    /**
     * Set all stations in the legend.
     *
     * @param Station[] $stations
     */
    public function setStations($stations)
    {
    	$this->stations->clear();
    	$this->stations = new ArrayCollection($stations);
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
     * Add station
     *
     * @param \AppBundle\Entity\Station $station
     *
     * @return Legend
     */
    public function addStation(\AppBundle\Entity\Station $station)
    {
        $this->stations[] = $station;

        return $this;
    }
    
    /**
     * Remove station
     *
     * @param \AppBundle\Entity\Station $station
     */
    public function removeStation(\AppBundle\Entity\Station $station)
    {
    	$this->stations->removeElement($station);
    }
    
    
    /**
     * Return all nuclides associated to the legend.
     *
     * @return Nuclide[]
     */
    public function getNuclides()
    {
    	return $this->nuclides;
    }
    
    /**
     * Set all nuclides in the legend.
     *
     * @param Nuclide[] $nuclides
     */
    public function setNuclides($nuclides)
    {
    	$this->nuclides->clear();
    	$this->nuclides = new ArrayCollection($nuclides);
    }
    
     
    
    /**
     * Count stations associated to legend.
     *
     * @return integer
     */
    public function getTotalStations(){
    	return $this->getStations()->count();
    }
    
    /**
     * Count nuclides associated to legend.
     *
     * @return integer
     */
    public function getTotalNuclides(){
    	return $this->getNuclides()->count();
    }
}
