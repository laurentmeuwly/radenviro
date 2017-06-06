<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="site")
 * @ORM\Entity
 */
class Site
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
     * @ORM\Column(name="name_de", type="text", length=65535, nullable=true)
     */
    private $nameDe;

    /**
     * @var string
     *
     * @ORM\Column(name="name_fr", type="text", length=65535, nullable=true)
     */
    private $nameFr;

    /**
     * @var string
     *
     * @ORM\Column(name="name_it", type="text", length=65535, nullable=true)
     */
    private $nameIt;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="text", length=65535, nullable=true)
     */
    private $nameEn;

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
     * @ORM\Column(name="description_de", type="text", length=65535, nullable=true)
     */
    private $descriptionDe;

    /**
     * @var string
     *
     * @ORM\Column(name="description_fr", type="text", length=65535, nullable=true)
     */
    private $descriptionFr;

    /**
     * @var string
     *
     * @ORM\Column(name="description_it", type="text", length=65535, nullable=true)
     */
    private $descriptionIt;

    /**
     * @var string
     *
     * @ORM\Column(name="description_en", type="text", length=65535, nullable=true)
     */
    private $descriptionEn;

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
     * Set nameDe
     *
     * @param string $nameDe
     *
     * @return Site
     */
    public function setNameDe($nameDe)
    {
        $this->nameDe = $nameDe;

        return $this;
    }

    /**
     * Get nameDe
     *
     * @return string
     */
    public function getNameDe()
    {
        return $this->nameDe;
    }

    /**
     * Set nameFr
     *
     * @param string $nameFr
     *
     * @return Site
     */
    public function setNameFr($nameFr)
    {
        $this->nameFr = $nameFr;

        return $this;
    }

    /**
     * Get nameFr
     *
     * @return string
     */
    public function getNameFr()
    {
        return $this->nameFr;
    }

    /**
     * Set nameIt
     *
     * @param string $nameIt
     *
     * @return Site
     */
    public function setNameIt($nameIt)
    {
        $this->nameIt = $nameIt;

        return $this;
    }

    /**
     * Get nameIt
     *
     * @return string
     */
    public function getNameIt()
    {
        return $this->nameIt;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     *
     * @return Site
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    /**
     * Get nameEn
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->nameEn;
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
     * @return Site
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
     * Set descriptionDe
     *
     * @param string $descriptionDe
     *
     * @return Site
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
     * Set descriptionFr
     *
     * @param string $descriptionFr
     *
     * @return Site
     */
    public function setDescriptionFr($descriptionFr)
    {
        $this->descriptionFr = $descriptionFr;

        return $this;
    }

    /**
     * Get descriptionFr
     *
     * @return string
     */
    public function getDescriptionFr()
    {
        return $this->descriptionFr;
    }

    /**
     * Set descriptionIt
     *
     * @param string $descriptionIt
     *
     * @return Site
     */
    public function setDescriptionIt($descriptionIt)
    {
        $this->descriptionIt = $descriptionIt;

        return $this;
    }

    /**
     * Get descriptionIt
     *
     * @return string
     */
    public function getDescriptionIt()
    {
        return $this->descriptionIt;
    }

    /**
     * Set descriptionEn
     *
     * @param string $descriptionEn
     *
     * @return Site
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->descriptionEn = $descriptionEn;

        return $this;
    }

    /**
     * Get descriptionEn
     *
     * @return string
     */
    public function getDescriptionEn()
    {
        return $this->descriptionEn;
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
