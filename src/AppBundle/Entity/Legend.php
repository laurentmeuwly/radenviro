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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LegendRepository")
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
     * @var boolean
     *
     * @ORM\Column(name="show_description", type="boolean", nullable=false)
     */
    private $show_description = true;

    /**
     * @var string
     *
     * @ORM\Column(name="link_type", type="string", columnDefinition="enum('', '_self', '_parent', '_blank')")
     */
    private $link_type = '_blank';

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=6, nullable=false)
     * @XmonAssertColor\HexColor()
     */
    private $color = '#ffffff';
    
    
    /**
     * @var Station[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LegendStation", mappedBy="legend", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $stations;
    
    /**
     * @var Nuclid[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LegendNuclide", mappedBy="legend", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
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

    public function __toString()
    {
    	return (string)$this->getName() ?: 'n/a';
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
     * Set show_description
     *
     * @param boolean $show_description
     *
     * @return Legend
     */
    public function setShowDescription($show_description)
    {
    	$this->show_description = $show_description;
    
    	return $this;
    }
    
    /**
     * Get show_description
     *
     * @return boolean
     */
    public function getShowDescription()
    {
    	return $this->show_description;
    }

    /**
     * Set link_type
     *
     * @param boolean $link_type
     *
     * @return Legend
     */
    public function setLinkType($link_type)
    {
    	$this->link_type = $link_type;
    
    	return $this;
    }
    
    /**
     * Get link_type
     *
     * @return boolean
     */
    public function getLinkType()
    {
    	return $this->link_type;
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
     * @param LegendStation[] $legendStations
     */
    public function setStations($legendStations)
    {
    	//$this->stations->clear();
    	//$this->stations = new ArrayCollection($legendStations);
    	$this->stations = new ArrayCollection();
    	
    	foreach ($legendStations as $legendStation) {
    		$this->addStation($legendStation);
    	}
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
     * @param \AppBundle\Entity\LegendStation $legendStation
     *
     * @return Legend
     */
    public function addLegendStations(\AppBundle\Entity\LegendStation $legendStation)
    {
    	$legendStation->setLegend($this);
        $this->stations[] = $legendStation;

        return $this;
    }
    
    public function addStation($station)
    {
    	$station->setLegend($this);
    	$this->stations[] = $station;
    	return $this;	
    }
    
    
    /**
     * Return all nuclides associated to the legend.
     *
     * @return LegendNuclide[]
     */
    public function getNuclides()
    {
    	return $this->nuclides;
    }
    
    /**
     * Set all nuclides in the legend.
     *
     * @param LegendNuclide[] $legendNuclides
     */
    public function setNuclides($legendNuclides)
    {
    	$this->nuclides = new ArrayCollection();
    	 
    	foreach ($legendNuclides as $legendNuclide) {
    		$this->addNuclide($legendNuclide);
    	}
    }
    
    /**
     * @param LegendNuclide $legendNuclides
     */
    public function addLegendNuclides(LegendNuclide $legendNuclides)
    {
    	$legendNuclides->setLegend($this);
    
    	$this->$nuclides[] = $legendNuclides;
    }
    
    /**
     * @param LegendNuclide $nuclides
     *
     * @return $this
     */
   /* public function removeNuclides(LegendNuclide $nuclides)
    {
    	$this->nuclides->removeElement($nuclides);
    
    	return $this;
    }*/
    
    public function addNuclide($nuclide)
    {
    	$nuclide->setLegend($this);
    	$this->nuclides[] = $nuclide;
    	return $this;
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
