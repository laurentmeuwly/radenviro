<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MapZoom
 *
 * @ORM\Table(name="map_zoom")
 * @ORM\Entity
 */
class MapZoom
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return MapZoom
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return MapZoom
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
     * @return MapZoom
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
     * Set zoom
     *
     * @param integer $zoom
     *
     * @return MapZoom
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MapZoom
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MapZoom
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
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
     * Set nlatitude
     *
     * @param string $nlatitude
     *
     * @return MapZoom
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
     * @return MapZoom
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
     * @return MapZoom
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
     * @return MapZoom
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
