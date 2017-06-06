<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Measurement
 *
 * @ORM\Table(name="measurement", indexes={@ORM\Index(name="index_measurements_on_sample_id", columns={"sample_id"}), @ORM\Index(name="index_measurements_on_laboratory_id", columns={"laboratory_id"}), @ORM\Index(name="index_measurements_on_method_id", columns={"method_id"}), @ORM\Index(name="index_measurements_on_quantity_units_id", columns={"quantity_units_id"}), @ORM\Index(name="index_measurements_on_result_units_id", columns={"result_units_id"})})
 * @ORM\Entity
 */
class Measurement
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
     * @var \DateTime
     *
     * @ORM\Column(name="referenceDate", type="datetime", nullable=true)
     */
    private $referencedate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=30, nullable=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="preparation", type="text", length=65535, nullable=true)
     */
    private $preparation;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float", precision=10, scale=0, nullable=true)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="freshDryRatio", type="float", precision=10, scale=0, nullable=true)
     */
    private $freshdryratio;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", length=65535, nullable=true)
     */
    private $comments;

    /**
     * @var boolean
     *
     * @ORM\Column(name="resultsFresh", type="boolean", nullable=true)
     */
    private $resultsfresh;

    /**
     * @var integer
     *
     * @ORM\Column(name="sample_id", type="integer", nullable=true)
     */
    private $sampleId;

    /**
     * @var integer
     *
     * @ORM\Column(name="laboratory_id", type="integer", nullable=true)
     */
    private $laboratoryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="method_id", type="integer", nullable=true)
     */
    private $methodId;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity_units_id", type="integer", nullable=true)
     */
    private $quantityUnitsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="result_units_id", type="integer", nullable=true)
     */
    private $resultUnitsId;

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
     * Set referencedate
     *
     * @param \DateTime $referencedate
     *
     * @return Measurement
     */
    public function setReferencedate($referencedate)
    {
        $this->referencedate = $referencedate;

        return $this;
    }

    /**
     * Get referencedate
     *
     * @return \DateTime
     */
    public function getReferencedate()
    {
        return $this->referencedate;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Measurement
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Measurement
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set preparation
     *
     * @param string $preparation
     *
     * @return Measurement
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * Get preparation
     *
     * @return string
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return Measurement
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set freshdryratio
     *
     * @param float $freshdryratio
     *
     * @return Measurement
     */
    public function setFreshdryratio($freshdryratio)
    {
        $this->freshdryratio = $freshdryratio;

        return $this;
    }

    /**
     * Get freshdryratio
     *
     * @return float
     */
    public function getFreshdryratio()
    {
        return $this->freshdryratio;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Measurement
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set resultsfresh
     *
     * @param boolean $resultsfresh
     *
     * @return Measurement
     */
    public function setResultsfresh($resultsfresh)
    {
        $this->resultsfresh = $resultsfresh;

        return $this;
    }

    /**
     * Get resultsfresh
     *
     * @return boolean
     */
    public function getResultsfresh()
    {
        return $this->resultsfresh;
    }

    /**
     * Set sampleId
     *
     * @param integer $sampleId
     *
     * @return Measurement
     */
    public function setSampleId($sampleId)
    {
        $this->sampleId = $sampleId;

        return $this;
    }

    /**
     * Get sampleId
     *
     * @return integer
     */
    public function getSampleId()
    {
        return $this->sampleId;
    }

    /**
     * Set laboratoryId
     *
     * @param integer $laboratoryId
     *
     * @return Measurement
     */
    public function setLaboratoryId($laboratoryId)
    {
        $this->laboratoryId = $laboratoryId;

        return $this;
    }

    /**
     * Get laboratoryId
     *
     * @return integer
     */
    public function getLaboratoryId()
    {
        return $this->laboratoryId;
    }

    /**
     * Set methodId
     *
     * @param integer $methodId
     *
     * @return Measurement
     */
    public function setMethodId($methodId)
    {
        $this->methodId = $methodId;

        return $this;
    }

    /**
     * Get methodId
     *
     * @return integer
     */
    public function getMethodId()
    {
        return $this->methodId;
    }

    /**
     * Set quantityUnitsId
     *
     * @param integer $quantityUnitsId
     *
     * @return Measurement
     */
    public function setQuantityUnitsId($quantityUnitsId)
    {
        $this->quantityUnitsId = $quantityUnitsId;

        return $this;
    }

    /**
     * Get quantityUnitsId
     *
     * @return integer
     */
    public function getQuantityUnitsId()
    {
        return $this->quantityUnitsId;
    }

    /**
     * Set resultUnitsId
     *
     * @param integer $resultUnitsId
     *
     * @return Measurement
     */
    public function setResultUnitsId($resultUnitsId)
    {
        $this->resultUnitsId = $resultUnitsId;

        return $this;
    }

    /**
     * Get resultUnitsId
     *
     * @return integer
     */
    public function getResultUnitsId()
    {
        return $this->resultUnitsId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Measurement
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
     * @return Measurement
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
