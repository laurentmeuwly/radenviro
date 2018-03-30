<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Site
 *
 * @ORM\Table(name="site")
 * @ORM\Entity
 */
class Site
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
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
   
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SiteType", inversedBy="sites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $siteType;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=20, scale=15, nullable=false)
     */
    private $latitude = '0.000000000000000';

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=20, scale=15, nullable=false)
     */
    private $longitude = '0.000000000000000';

    /**
     * @var integer
     *
     * @ORM\Column(name="zoom", type="integer", nullable=false)
     */
    private $zoom = '15';

    /**
     * @var string
     *
     * @ORM\Column(name="nlatitude", type="decimal", precision=20, scale=15, nullable=false)
     */
    private $nlatitude = '0.000000000000000';

    /**
     * @var string
     *
     * @ORM\Column(name="slatitude", type="decimal", precision=20, scale=15, nullable=false)
     */
    private $slatitude = '0.000000000000000';

    /**
     * @var string
     *
     * @ORM\Column(name="elongitude", type="decimal", precision=20, scale=15, nullable=false)
     */
    private $elongitude = '0.000000000000000';

    /**
     * @var string
     *
     * @ORM\Column(name="wlongitude", type="decimal", precision=20, scale=15, nullable=false)
     */
    private $wlongitude = '0.000000000000000';

    /**
     * @ORM\ManyToMany(targetEntity="Station", inversedBy="sites")
     */
    private $stations;

    
    public function __construct()
    {
    	$this->stations = new ArrayCollection();
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
    
    public function setSiteType(SiteType $siteType)
    {
    	$this->siteType = $siteType;
    	return $this;
    }
    
    public function getSiteType()
    {
    	return $this->siteType;
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
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Site
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Site
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
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
     * Set position
     *
     * @param integer $position
     *
     * @return AutomaticNetwork
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
     * Set zoom
     *
     * @param integer $zoom
     *
     * @return Site
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
     * Set nlatitude
     *
     * @param string $nlatitude
     *
     * @return Site
     */
    public function setNlatitude($nlatitude)
    {
        $this->nlatitude = $nlatitude;

        return $this;
    }

    /**
     * Get nlatitude
     *
     * @return string
     */
    public function getNlatitude()
    {
        return $this->nlatitude;
    }

    /**
     * Set slatitude
     *
     * @param string $slatitude
     *
     * @return Site
     */
    public function setSlatitude($slatitude)
    {
        $this->slatitude = $slatitude;

        return $this;
    }

    /**
     * Get slatitude
     *
     * @return string
     */
    public function getSlatitude()
    {
        return $this->slatitude;
    }

    /**
     * Set elongitude
     *
     * @param string $elongitude
     *
     * @return Site
     */
    public function setElongitude($elongitude)
    {
        $this->elongitude = $elongitude;

        return $this;
    }

    /**
     * Get elongitude
     *
     * @return string
     */
    public function getElongitude()
    {
        return $this->elongitude;
    }

    /**
     * Set wlongitude
     *
     * @param string $wlongitude
     *
     * @return Site
     */
    public function setWlongitude($wlongitude)
    {
        $this->wlongitude = $wlongitude;

        return $this;
    }

    /**
     * Get wlongitude
     *
     * @return string
     */
    public function getWlongitude()
    {
        return $this->wlongitude;
    }
    
    public function getStations()
    {
    	return $this->stations;
    }
    
    public function setStations($stations)
    {
    	$this->stations = $stations;
    	return $this;
    }
    
    public function addStation($station)
    {
    	$station->addSite($this);
    	$this->station[] = $station;
    }
    
    public function removeStation($station)
    {
    	$this->station->removeElement($station);
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Site
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
     * @return Site
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
