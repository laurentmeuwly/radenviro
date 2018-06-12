<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Station
 *
 * @ORM\Table(name="station")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StationRepository")
 */
class Station
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
     * @ORM\Column(name="code", type="string", length=30, nullable=true)
     */
    private $code;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active=false;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\StationType")
     * @ORM\JoinColumn(nullable=true)
     * 
     */
    private $stationType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Network")
     * 
     */
    private $network;

    /**
     * @var integer
     *
     * @ORM\Column(name="zoom", type="integer", nullable=true)
     */
    private $zoom = '75';

    /**
     * @var integer
     *
     * @ORM\Column(name="default_zoom", type="integer", nullable=true)
     */
    private $defaultZoom = '64';

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude = '0';
    
    /**
     * @ORM\ManyToMany(targetEntity="Site", mappedBy="stations")
     */
    private $sites;
    
    /**
     * @var Legend[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LegendStation", mappedBy="station", fetch="EXTRA_LAZY")
     */
    private $legends;
    
    /**
     * @var Sample[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sample", mappedBy="station", cascade={"remove"})
     */
    private $samples;
    
    
    public function __construct()
    {
    	$this->sites = new ArrayCollection();
    	$this->samples = new ArrayCollection();
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
    	return (string)($this->getName() . " (" . $this->getCode() . ")");
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
     * @return Station
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

    /**
     * Set stationType
     *
     * @param integer $stationType
     *
     * @return Station
     */
    public function setStationType($stationType)
    {
        $this->stationType = $stationType;

        return $this;
    }

    /**
     * Get stationType
     *
     * @return integer
     */
    public function getStationType()
    {
        return $this->stationType;
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
     * Set network
     *
     * @param integer $network
     *
     * @return Station
     */
    public function setNetwork($network)
    {
        $this->network = $network;

        return $this;
    }

    /**
     * Get network
     *
     * @return integer
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Set zoom
     *
     * @param integer $zoom
     *
     * @return Station
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Get zoom
     *
     * @return integer
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * Set defaultZoom
     *
     * @param integer $defaultZoom
     *
     * @return Station
     */
    public function setDefaultZoom($defaultZoom)
    {
        $this->defaultZoom = $defaultZoom;

        return $this;
    }

    /**
     * Get defaultZoom
     *
     * @return integer
     */
    public function getDefaultZoom()
    {
        return $this->defaultZoom;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Station
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Station
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    /**
     *
     * @return bool
     */
    public function hasCoordinates()
    {
    	return $this->getLatitude()!=0 && $this->getLongitude()!=0;
    }
    
    
    public function getSites()
    {
    	return $this->sites;
    }
    
    public function setSites($sites)
    {
    	$this->sites = $sites;
    	return $this;
    }
    
    public function addSite($site)
    {
    	$this->site[] = $site;
    }
    
    public function removeSite($site)
    {
    	$this->site->removeElement($site);
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
    	$this->legends->clear();
    	$this->legends = new ArrayCollection($legends);
    }
    

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Station
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
     * @return Station
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    
}
