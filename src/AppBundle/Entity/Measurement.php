<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use APY\DataGridBundle\Grid\Mapping as GRID;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Measurement
 *
 * @ORM\Table(name="measurement", indexes={@ORM\Index(name="index_measurements_on_sample_id", columns={"sample_id"}), @ORM\Index(name="index_measurements_on_laboratory_id", columns={"laboratory_id"}), @ORM\Index(name="index_measurements_on_method_id", columns={"method_id"}), @ORM\Index(name="index_measurements_on_quantity_unit_id", columns={"quantity_unit_id"}), @ORM\Index(name="index_measurements_on_result_unit_id", columns={"result_unit_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeasurementRepository")
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
     * @var Sample
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sample", inversedBy="measurements")
     * @ORM\JoinColumn(nullable=false)
     * @GRID\Column(field="sample.id", title="sample.id")
     */
    private $sample;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Laboratory")
     * @ORM\JoinColumn(nullable=true)
     */
    private $laboratory;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Method")
     * @ORM\JoinColumn(nullable=true)
     */
    private $method;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\QuantityUnit")
     * @ORM\JoinColumn(nullable=true)
     */
    private $quantityUnit;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ResultUnit")
     * @ORM\JoinColumn(nullable=true)
     */
    private $resultUnit;
    
    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * Results of the measurement.
     *
     * @var Result[]
     * @ORM\OneToMany(targetEntity="Result", mappedBy="measurement", cascade={"remove"})
     **/
    private $results;

    
    public function __construct()
    {
    	$this->results = new ArrayCollection();
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
     * Set sample
     *
     * @param integer $sample
     *
     * @return Measurement
     */
    public function setSample($sample)
    {
        $this->sample = $sample;

        return $this;
    }

    /**
     * Get sample
     *
     * @return integer
     */
    public function getSample()
    {
        return $this->sample;
    }

    /**
     * Set laboratory
     *
     * @param integer $laboratory
     *
     * @return Measurement
     */
    public function setLaboratory($laboratory)
    {
        $this->laboratory = $laboratory;

        return $this;
    }

    /**
     * Get laboratory
     *
     * @return integer
     */
    public function getLaboratory()
    {
        return $this->laboratory;
    }

    /**
     * Set method
     *
     * @param integer $method
     *
     * @return Measurement
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return integer
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set quantityUnit
     *
     * @param integer $quantityUnit
     *
     * @return Measurement
     */
    public function setQuantityUnit($quantityUnit)
    {
        $this->quantityUnit = $quantityUnit;

        return $this;
    }

    /**
     * Get quantityUnit
     *
     * @return integer
     */
    public function getQuantityUnit()
    {
        return $this->quantityUnit;
    }

    /**
     * Set resultUnit
     *
     * @param integer $resultUnit
     *
     * @return Measurement
     */
    public function setResultUnit($resultUnit)
    {
        $this->resultUnit = $resultUnit;

        return $this;
    }

    /**
     * Get resultUnit
     *
     * @return integer
     */
    public function getResultUnit()
    {
        return $this->resultUnit;
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
    
    /**
     * Return all results associated to the measurement.
     *
     * @return Result[]
     */
    public function getResults()
    {
    	return $this->results;
    }
    
    /**
     * Set all results in the measurement.
     *
     * @param Result[] $results
     */
    /*public function setResults(ArrayCollection $results)
    {
    	$this->results = $results;
    }*/
}

