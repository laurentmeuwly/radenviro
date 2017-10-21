<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * AutomaticNetworkStation
 *
 * @ORM\Table(name="automatic_network_station", indexes={@ORM\Index(name="index_automatic_network_stations_on_automatic_network_id", columns={"automatic_network_id"})})
 * @ORM\Entity
 */
class AutomaticNetworkStation
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
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = '0';

    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AutomaticNetwork")
     * 
     */
    private $automaticNetwork;

    

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
    
    public function setPosition($position)
    {
    	$this->position = $position;
    }
    
    public function getPosition()
    {
    	return $this->position;
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
     * Set descriptionDe
     *
     * @param string $descriptionDe
     *
     * @return AutomaticNetworkStation
     */
    public function setDescriptionDe($descriptionDe)
    {
        $this->descriptionDe = $descriptionDe;

        return $this;
    }

    /**
     * Get descriptionDe
     *
     * @return string
     */
    public function getDescriptionDe()
    {
        return $this->descriptionDe;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return AutomaticNetworkStation
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
     * @return AutomaticNetworkStation
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
     * @return AutomaticNetworkStation
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
     * Set automaticNetwork
     *
     * @param integer $automaticNetwork
     *
     * @return AutomaticNetworkStation
     */
    public function setAutomaticNetwork($automaticNetwork)
    {
        $this->automaticNetwork = $automaticNetwork;

        return $this;
    }

    /**
     * Get automaticNetwork
     *
     * @return integer
     */
    public function getAutomaticNetwork()
    {
        return $this->automaticNetwork;
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
     * @return AutomaticNetworkStation
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
     * @return AutomaticNetworkStation
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
