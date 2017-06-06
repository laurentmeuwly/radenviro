<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AutomaticNetwork
 *
 * @ORM\Table(name="automatic_network")
 * @ORM\Entity
 */
class AutomaticNetwork
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
     * @ORM\Column(name="name_de", type="string", length=100, nullable=true)
     */
    private $nameDe;

    /**
     * @var string
     *
     * @ORM\Column(name="name_fr", type="string", length=100, nullable=true)
     */
    private $nameFr;

    /**
     * @var string
     *
     * @ORM\Column(name="name_it", type="string", length=100, nullable=true)
     */
    private $nameIt;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=100, nullable=true)
     */
    private $nameEn;

    /**
     * @var string
     *
     * @ORM\Column(name="url_de", type="string", length=255, nullable=true)
     */
    private $urlDe;

    /**
     * @var string
     *
     * @ORM\Column(name="url_fr", type="string", length=255, nullable=true)
     */
    private $urlFr;

    /**
     * @var string
     *
     * @ORM\Column(name="url_it", type="string", length=255, nullable=true)
     */
    private $urlIt;

    /**
     * @var string
     *
     * @ORM\Column(name="url_en", type="string", length=255, nullable=true)
     */
    private $urlEn;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=false)
     */
    private $color = '#ffffff';

    /**
     * @var integer
     *
     * @ORM\Column(name="sorting", type="integer", nullable=true)
     */
    private $sorting = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="hidden", type="boolean", nullable=true)
     */
    private $hidden = '0';

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
     * @return AutomaticNetwork
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
     * @return AutomaticNetwork
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
     * @return AutomaticNetwork
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
     * @return AutomaticNetwork
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
     * Set urlDe
     *
     * @param string $urlDe
     *
     * @return AutomaticNetwork
     */
    public function setUrlDe($urlDe)
    {
        $this->urlDe = $urlDe;

        return $this;
    }

    /**
     * Get urlDe
     *
     * @return string
     */
    public function getUrlDe()
    {
        return $this->urlDe;
    }

    /**
     * Set urlFr
     *
     * @param string $urlFr
     *
     * @return AutomaticNetwork
     */
    public function setUrlFr($urlFr)
    {
        $this->urlFr = $urlFr;

        return $this;
    }

    /**
     * Get urlFr
     *
     * @return string
     */
    public function getUrlFr()
    {
        return $this->urlFr;
    }

    /**
     * Set urlIt
     *
     * @param string $urlIt
     *
     * @return AutomaticNetwork
     */
    public function setUrlIt($urlIt)
    {
        $this->urlIt = $urlIt;

        return $this;
    }

    /**
     * Get urlIt
     *
     * @return string
     */
    public function getUrlIt()
    {
        return $this->urlIt;
    }

    /**
     * Set urlEn
     *
     * @param string $urlEn
     *
     * @return AutomaticNetwork
     */
    public function setUrlEn($urlEn)
    {
        $this->urlEn = $urlEn;

        return $this;
    }

    /**
     * Get urlEn
     *
     * @return string
     */
    public function getUrlEn()
    {
        return $this->urlEn;
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
     * Set sorting
     *
     * @param integer $sorting
     *
     * @return AutomaticNetwork
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
     * Set hidden
     *
     * @param boolean $hidden
     *
     * @return AutomaticNetwork
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
     * @return AutomaticNetwork
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
}
