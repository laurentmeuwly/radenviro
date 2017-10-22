<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Xmon\ColorPickerTypeBundle\Validator\Constraints as XmonAssertColor;

/**
 * AutomaticNetwork
 *
 * @ORM\Table(name="automatic_network")
 * @ORM\Entity
 */
class AutomaticNetwork
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
     * @ORM\Column(name="color", type="string", length=255, nullable=false)
     * @XmonAssertColor\HexColor()
     */
    private $color = '#ffffff';
    
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
     * Stations of the network.
     *
     * @var AutomaticNetworkStation[]
     * @ORM\OneToMany(targetEntity="AutomaticNetworkStation", mappedBy="automaticNetwork")
     **/
    private $automaticNetworkStations;
    
    private $totalStations;
    
    
    public function __construct() {
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

    /**
     * Set color
     *
     * @param string $color
     *
     * @return AutomaticNetwork
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return AutomaticNetwork
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
     * @return AutomaticNetwork
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
    /**
     * Return all stations associated to the network.
     *
     * @return AutomaticNetworkStation[]
     */
    public function getAutomaticNetworkStations()
    {
    	return $this->automaticNetworkStations;
    }
    
    /**
     * Set all stations in the network.
     *
     * @param AutomaticNetworkStation[] $automaticNetworkStations
     */
    public function setAutomaticNetworkStations($automaticNetworkStations)
    {
    	$this->automaticNetworkStations->clear();
    	$this->automaticNetworkStations = new ArrayCollection($automaticNetworkStations);
    }
    
    /**
     * Count stations associated to legend.
     *
     * @return integer
     */
    public function getTotalStations(){
    	return $this->getAutomaticNetworkStations()->count();
    }
}
