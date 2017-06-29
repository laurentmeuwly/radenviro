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
     *
     * @ORM\Column(name="sorting", type="integer", nullable=true)
     */
    private $sorting = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="site_type_id", type="integer", nullable=true)
     */
    private $siteTypeId;

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
     * @ORM\Column(name="hidden", type="boolean", nullable=true)
     */
    private $hidden = '0';

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
     * @return Site
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
     * Set siteTypeId
     *
     * @param integer $siteTypeId
     *
     * @return Site
     */
    public function setSiteTypeId($siteTypeId)
    {
        $this->siteTypeId = $siteTypeId;

        return $this;
    }

    /**
     * Get siteTypeId
     *
     * @return integer
     */
    public function getSiteTypeId()
    {
        return $this->siteTypeId;
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
     * Set hidden
     *
     * @param boolean $hidden
     *
     * @return Site
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
}
