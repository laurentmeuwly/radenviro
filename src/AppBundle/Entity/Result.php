<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 *
 * @ORM\Table(name="result", indexes={@ORM\Index(name="index_results_on_measurement_id", columns={"measurement_id"}), @ORM\Index(name="index_results_on_nuclide_id", columns={"nuclide_id"})})
 * @ORM\Entity
 */
class Result
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
     * @var boolean
     *
     * @ORM\Column(name="limited", type="boolean", nullable=false)
     */
    private $limited = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=true)
     */
    private $value;

    /**
     * @var float
     *
     * @ORM\Column(name="error", type="float", precision=10, scale=0, nullable=true)
     */
    private $error;

    /**
     * @var integer
     *
     * @ORM\Column(name="measurement_id", type="integer", nullable=true)
     */
    private $measurementId;

    /**
     * @var integer
     *
     * @ORM\Column(name="nuclide_id", type="integer", nullable=true)
     */
    private $nuclideId;

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
     * Set limited
     *
     * @param boolean $limited
     *
     * @return Result
     */
    public function setLimited($limited)
    {
        $this->limited = $limited;

        return $this;
    }

    /**
     * Get limited
     *
     * @return boolean
     */
    public function getLimited()
    {
        return $this->limited;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return Result
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set error
     *
     * @param float $error
     *
     * @return Result
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return float
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set measurementId
     *
     * @param integer $measurementId
     *
     * @return Result
     */
    public function setMeasurementId($measurementId)
    {
        $this->measurementId = $measurementId;

        return $this;
    }

    /**
     * Get measurementId
     *
     * @return integer
     */
    public function getMeasurementId()
    {
        return $this->measurementId;
    }

    /**
     * Set nuclideId
     *
     * @param integer $nuclideId
     *
     * @return Result
     */
    public function setNuclideId($nuclideId)
    {
        $this->nuclideId = $nuclideId;

        return $this;
    }

    /**
     * Get nuclideId
     *
     * @return integer
     */
    public function getNuclideId()
    {
        return $this->nuclideId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Result
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
     * @return Result
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
