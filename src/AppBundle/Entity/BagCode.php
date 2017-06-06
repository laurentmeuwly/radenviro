<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BagCode
 *
 * @ORM\Table(name="bag_code", uniqueConstraints={@ORM\UniqueConstraint(name="index_bag_codes_on_version_and_code", columns={"version", "code"})})
 * @ORM\Entity
 */
class BagCode
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
     * @ORM\Column(name="version", type="string", length=8, nullable=true)
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=8, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="description_de", type="string", length=255, nullable=true)
     */
    private $descriptionDe;

    /**
     * @var string
     *
     * @ORM\Column(name="description_fr", type="string", length=255, nullable=true)
     */
    private $descriptionFr;

    /**
     * @var string
     *
     * @ORM\Column(name="description_it", type="string", length=255, nullable=true)
     */
    private $descriptionIt;

    /**
     * @var string
     *
     * @ORM\Column(name="description_en", type="string", length=255, nullable=true)
     */
    private $descriptionEn;

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
     * Set version
     *
     * @param string $version
     *
     * @return BagCode
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return BagCode
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
     * Set descriptionDe
     *
     * @param string $descriptionDe
     *
     * @return BagCode
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
     * @return BagCode
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
     * @return BagCode
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
     * @return BagCode
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return BagCode
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
     * @return BagCode
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
