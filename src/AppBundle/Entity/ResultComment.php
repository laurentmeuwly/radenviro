<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ResultComment
 *
 * @ORM\Table(name="result_comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultCommentRepository")
 */
class ResultComment
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFrom", type="date")
     */
    private $dateFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTo", type="date")
     */
    private $dateTo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="station", type="string", length=255, nullable=true)
     */
    private $station;

    /**
     * @var string|null
     *
     * @ORM\Column(name="network", type="string", length=255, nullable=true)
     */
    private $network;

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
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active=false;

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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateFrom.
     *
     * @param \DateTime $dateFrom
     *
     * @return ResultComment
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom.
     *
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo.
     *
     * @param \DateTime $dateTo
     *
     * @return ResultComment
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo.
     *
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set station.
     *
     * @param string|null $station
     *
     * @return ResultComment
     */
    public function setStation($station = null)
    {
        $this->station = $station;

        return $this;
    }

    /**
     * Get station.
     *
     * @return string|null
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * Set network.
     *
     * @param string|null $network
     *
     * @return ResultComment
     */
    public function setNetwork($network = null)
    {
        $this->network = $network;

        return $this;
    }

    /**
     * Get network.
     *
     * @return string|null
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return NetworkCategory
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
     * @return NetworkCategory
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
     * @return NetworkCategory
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
