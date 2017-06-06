<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity
 */
class Page
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
     * @ORM\Column(name="code", type="string", length=32, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="content_de", type="text", length=65535, nullable=true)
     */
    private $contentDe;

    /**
     * @var string
     *
     * @ORM\Column(name="content_fr", type="text", length=65535, nullable=true)
     */
    private $contentFr;

    /**
     * @var string
     *
     * @ORM\Column(name="content_it", type="text", length=65535, nullable=true)
     */
    private $contentIt;

    /**
     * @var string
     *
     * @ORM\Column(name="content_en", type="text", length=65535, nullable=true)
     */
    private $contentEn;

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
     * @ORM\Column(name="title_de", type="text", length=65535, nullable=true)
     */
    private $titleDe;

    /**
     * @var string
     *
     * @ORM\Column(name="title_fr", type="text", length=65535, nullable=true)
     */
    private $titleFr;

    /**
     * @var string
     *
     * @ORM\Column(name="title_it", type="text", length=65535, nullable=true)
     */
    private $titleIt;

    /**
     * @var string
     *
     * @ORM\Column(name="title_en", type="text", length=65535, nullable=true)
     */
    private $titleEn;



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
     * @return Page
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
     * Set contentDe
     *
     * @param string $contentDe
     *
     * @return Page
     */
    public function setContentDe($contentDe)
    {
        $this->contentDe = $contentDe;

        return $this;
    }

    /**
     * Get contentDe
     *
     * @return string
     */
    public function getContentDe()
    {
        return $this->contentDe;
    }

    /**
     * Set contentFr
     *
     * @param string $contentFr
     *
     * @return Page
     */
    public function setContentFr($contentFr)
    {
        $this->contentFr = $contentFr;

        return $this;
    }

    /**
     * Get contentFr
     *
     * @return string
     */
    public function getContentFr()
    {
        return $this->contentFr;
    }

    /**
     * Set contentIt
     *
     * @param string $contentIt
     *
     * @return Page
     */
    public function setContentIt($contentIt)
    {
        $this->contentIt = $contentIt;

        return $this;
    }

    /**
     * Get contentIt
     *
     * @return string
     */
    public function getContentIt()
    {
        return $this->contentIt;
    }

    /**
     * Set contentEn
     *
     * @param string $contentEn
     *
     * @return Page
     */
    public function setContentEn($contentEn)
    {
        $this->contentEn = $contentEn;

        return $this;
    }

    /**
     * Get contentEn
     *
     * @return string
     */
    public function getContentEn()
    {
        return $this->contentEn;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Page
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
     * @return Page
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
     * Set titleDe
     *
     * @param string $titleDe
     *
     * @return Page
     */
    public function setTitleDe($titleDe)
    {
        $this->titleDe = $titleDe;

        return $this;
    }

    /**
     * Get titleDe
     *
     * @return string
     */
    public function getTitleDe()
    {
        return $this->titleDe;
    }

    /**
     * Set titleFr
     *
     * @param string $titleFr
     *
     * @return Page
     */
    public function setTitleFr($titleFr)
    {
        $this->titleFr = $titleFr;

        return $this;
    }

    /**
     * Get titleFr
     *
     * @return string
     */
    public function getTitleFr()
    {
        return $this->titleFr;
    }

    /**
     * Set titleIt
     *
     * @param string $titleIt
     *
     * @return Page
     */
    public function setTitleIt($titleIt)
    {
        $this->titleIt = $titleIt;

        return $this;
    }

    /**
     * Get titleIt
     *
     * @return string
     */
    public function getTitleIt()
    {
        return $this->titleIt;
    }

    /**
     * Set titleEn
     *
     * @param string $titleEn
     *
     * @return Page
     */
    public function setTitleEn($titleEn)
    {
        $this->titleEn = $titleEn;

        return $this;
    }

    /**
     * Get titleEn
     *
     * @return string
     */
    public function getTitleEn()
    {
        return $this->titleEn;
    }
}
