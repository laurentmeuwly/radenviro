<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;


/**
 * Sample
 *
 * @ORM\Table(name="sample", indexes={@ORM\Index(name="index_samples_on_samCoordinateSystem_and_samDate", columns={"samCoordinateSystem", "samDate"}), @ORM\Index(name="index_samples_on_bag_code_id", columns={"bag_code_id"}), @ORM\Index(name="index_samples_on_laboratory_id", columns={"laboratory_id"}), @ORM\Index(name="index_samples_on_type_id", columns={"type_id"}), @ORM\Index(name="index_samples_on_sample_type_id", columns={"sample_type_id"}), @ORM\Index(name="index_samples_on_quantity_unit_id", columns={"quantity_unit_id"}), @ORM\Index(name="index_samples_on_network_id", columns={"network_id"}), @ORM\Index(name="index_samples_on_station_id", columns={"station_id"})})
 * @ORM\Entity
 *
 */
class Sample
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
     * @ORM\Column(name="number", type="string", length=30, nullable=true)
     */
    private $number;

    /**
     * @var boolean
     *
     * @ORM\Column(name="inSitu", type="boolean", nullable=true)
     */
    private $insitu;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="samDate", type="datetime", nullable=true)
     */
    private $samdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="samEndDate", type="datetime", nullable=true)
     */
    private $samenddate;

    /**
     * @var string
     *
     * @ORM\Column(name="samCoordinateSystem", type="string", length=255, nullable=true)
     */
    private $samcoordinatesystem;

    /**
     * @var string
     *
     * @ORM\Column(name="samCoordinateUnit", type="string", length=255, nullable=true)
     */
    private $samcoordinateunit;

    /**
     * @var string
     *
     * @ORM\Column(name="samX", type="decimal", precision=6, scale=3, nullable=true)
     */
    private $samx;

    /**
     * @var string
     *
     * @ORM\Column(name="samY", type="decimal", precision=6, scale=3, nullable=true)
     */
    private $samy;

    /**
     * @var string
     *
     * @ORM\Column(name="samZip", type="string", length=5, nullable=true)
     */
    private $samzip;

    /**
     * @var string
     *
     * @ORM\Column(name="samLocality", type="string", length=80, nullable=true)
     */
    private $samlocality;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Canton")
     * @ORM\JoinColumn(nullable=true)
     */
    private $samcanton;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country")
     * @ORM\JoinColumn(nullable=true)
     */
    private $samcountry;

    /**
     * @var string
     *
     * @ORM\Column(name="samComment", type="text", length=65535, nullable=true)
     */
    private $samcomment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="oriSame", type="boolean", nullable=true)
     */
    private $orisame;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="oriDate", type="datetime", nullable=true)
     */
    private $oridate;

    /**
     * @var string
     *
     * @ORM\Column(name="oriCoordinateSystem", type="string", length=255, nullable=true)
     */
    private $oricoordinatesystem;

    /**
     * @var string
     *
     * @ORM\Column(name="oriCoordinateUnit", type="string", length=255, nullable=true)
     */
    private $oricoordinateunit;

    /**
     * @var string
     *
     * @ORM\Column(name="oriX", type="decimal", precision=6, scale=3, nullable=true)
     */
    private $orix;

    /**
     * @var string
     *
     * @ORM\Column(name="oriY", type="decimal", precision=6, scale=3, nullable=true)
     */
    private $oriy;

    /**
     * @var string
     *
     * @ORM\Column(name="oriZip", type="string", length=5, nullable=true)
     */
    private $orizip;

    /**
     * @var string
     *
     * @ORM\Column(name="oriLocality", type="string", length=80, nullable=true)
     */
    private $orilocality;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Canton")
     * @ORM\JoinColumn(nullable=true)
     */
    private $oricanton;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country")
     * @ORM\JoinColumn(nullable=true)
     */
    private $oricountry;

    /**
     * @var string
     *
     * @ORM\Column(name="oriComment", type="text", length=65535, nullable=true)
     */
    private $oricomment;

    /**
     * @var float
     *
     * @ORM\Column(name="doseRate", type="float", precision=10, scale=0, nullable=true)
     */
    private $doserate;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float", precision=10, scale=0, nullable=true)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="surface", type="float", precision=10, scale=0, nullable=true)
     */
    private $surface;

    /**
     * @var float
     *
     * @ORM\Column(name="grassYield", type="float", precision=10, scale=0, nullable=true)
     */
    private $grassyield;

    /**
     * @var string
     *
     * @ORM\Column(name="soilLayer", type="string", length=10, nullable=true)
     */
    private $soillayer;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BagCode")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bagCode;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Laboratory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $laboratory;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SampleType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sampleType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\QuantityUnit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quantityUnit;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Network")
     * @ORM\JoinColumn(nullable=false)
     * @GRID\Column(field="network.id", title="network.id")
     */
    private $network;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Station")
     * @ORM\JoinColumn(nullable=false)
     * @GRID\Column(field="station.id", title="station.id")
     */
    private $station;

    /**
     * @var string
     *
     * @ORM\Column(name="toRemoveNetwork", type="string", length=30, nullable=true)
     */
    private $toremovenetwork;

    /**
     * @var string
     *
     * @ORM\Column(name="toRemoveStation", type="string", length=30, nullable=true)
     */
    private $toremovestation;

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
     * Measurements of the sample.
     *
     * @var Measurement[]
     * @ORM\OneToMany(targetEntity="Measurement", mappedBy="sample")
     **/
    private $measurements;


    public function __construct()
    {
    	$this->measurements = new ArrayCollection();
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
     * Set number
     *
     * @param string $number
     *
     * @return Sample
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
     * Set insitu
     *
     * @param boolean $insitu
     *
     * @return Sample
     */
    public function setInsitu($insitu)
    {
        $this->insitu = $insitu;

        return $this;
    }

    /**
     * Get insitu
     *
     * @return boolean
     */
    public function getInsitu()
    {
        return $this->insitu;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Sample
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set samdate
     *
     * @param \DateTime $samdate
     *
     * @return Sample
     */
    public function setSamdate($samdate)
    {
        $this->samdate = $samdate;

        return $this;
    }

    /**
     * Get samdate
     *
     * @return \DateTime
     */
    public function getSamdate()
    {
        return $this->samdate;
    }

    /**
     * Set samenddate
     *
     * @param \DateTime $samenddate
     *
     * @return Sample
     */
    public function setSamenddate($samenddate)
    {
        $this->samenddate = $samenddate;

        return $this;
    }

    /**
     * Get samenddate
     *
     * @return \DateTime
     */
    public function getSamenddate()
    {
        return $this->samenddate;
    }

    /**
     * Set samcoordinatesystem
     *
     * @param string $samcoordinatesystem
     *
     * @return Sample
     */
    public function setSamcoordinatesystem($samcoordinatesystem)
    {
        $this->samcoordinatesystem = $samcoordinatesystem;

        return $this;
    }

    /**
     * Get samcoordinatesystem
     *
     * @return string
     */
    public function getSamcoordinatesystem()
    {
        return $this->samcoordinatesystem;
    }

    /**
     * Set samcoordinateunit
     *
     * @param string $samcoordinateunit
     *
     * @return Sample
     */
    public function setSamcoordinateunit($samcoordinateunit)
    {
        $this->samcoordinateunit = $samcoordinateunit;

        return $this;
    }

    /**
     * Get samcoordinateunit
     *
     * @return string
     */
    public function getSamcoordinateunit()
    {
        return $this->samcoordinateunit;
    }

    /**
     * Set samx
     *
     * @param string $samx
     *
     * @return Sample
     */
    public function setSamx($samx)
    {
        $this->samx = $samx;

        return $this;
    }

    /**
     * Get samx
     *
     * @return string
     */
    public function getSamx()
    {
        return $this->samx;
    }

    /**
     * Set samy
     *
     * @param string $samy
     *
     * @return Sample
     */
    public function setSamy($samy)
    {
        $this->samy = $samy;

        return $this;
    }

    /**
     * Get samy
     *
     * @return string
     */
    public function getSamy()
    {
        return $this->samy;
    }

    /**
     * Set samzip
     *
     * @param string $samzip
     *
     * @return Sample
     */
    public function setSamzip($samzip)
    {
        $this->samzip = $samzip;

        return $this;
    }

    /**
     * Get samzip
     *
     * @return string
     */
    public function getSamzip()
    {
        return $this->samzip;
    }

    /**
     * Set samlocality
     *
     * @param string $samlocality
     *
     * @return Sample
     */
    public function setSamlocality($samlocality)
    {
        $this->samlocality = $samlocality;

        return $this;
    }

    /**
     * Get samlocality
     *
     * @return string
     */
    public function getSamlocality()
    {
        return $this->samlocality;
    }

    /**
     * Set samcanton
     *
     * @param integer $samcanton
     *
     * @return Sample
     */
    public function setSamcanton($samcanton)
    {
        $this->samcanton = $samcanton;

        return $this;
    }

    /**
     * Get samcanton
     *
     * @return integer
     */
    public function getSamcanton()
    {
        return $this->samcanton;
    }

    /**
     * Set samcountry
     *
     * @param integer $samcountry
     *
     * @return Sample
     */
    public function setSamcountry($samcountry)
    {
        $this->samcountry = $samcountry;

        return $this;
    }

    /**
     * Get samcountry
     *
     * @return integer
     */
    public function getSamcountry()
    {
        return $this->samcountry;
    }

    /**
     * Set samcomment
     *
     * @param string $samcomment
     *
     * @return Sample
     */
    public function setSamcomment($samcomment)
    {
        $this->samcomment = $samcomment;

        return $this;
    }

    /**
     * Get samcomment
     *
     * @return string
     */
    public function getSamcomment()
    {
        return $this->samcomment;
    }

    /**
     * Set orisame
     *
     * @param boolean $orisame
     *
     * @return Sample
     */
    public function setOrisame($orisame)
    {
        $this->orisame = $orisame;

        return $this;
    }

    /**
     * Get orisame
     *
     * @return boolean
     */
    public function getOrisame()
    {
        return $this->orisame;
    }

    /**
     * Set oridate
     *
     * @param \DateTime $oridate
     *
     * @return Sample
     */
    public function setOridate($oridate)
    {
        $this->oridate = $oridate;

        return $this;
    }

    /**
     * Get oridate
     *
     * @return \DateTime
     */
    public function getOridate()
    {
        return $this->oridate;
    }

    /**
     * Set oricoordinatesystem
     *
     * @param string $oricoordinatesystem
     *
     * @return Sample
     */
    public function setOricoordinatesystem($oricoordinatesystem)
    {
        $this->oricoordinatesystem = $oricoordinatesystem;

        return $this;
    }

    /**
     * Get oricoordinatesystem
     *
     * @return string
     */
    public function getOricoordinatesystem()
    {
        return $this->oricoordinatesystem;
    }

    /**
     * Set oricoordinateunit
     *
     * @param string $oricoordinateunit
     *
     * @return Sample
     */
    public function setOricoordinateunit($oricoordinateunit)
    {
        $this->oricoordinateunit = $oricoordinateunit;

        return $this;
    }

    /**
     * Get oricoordinateunit
     *
     * @return string
     */
    public function getOricoordinateunit()
    {
        return $this->oricoordinateunit;
    }

    /**
     * Set orix
     *
     * @param string $orix
     *
     * @return Sample
     */
    public function setOrix($orix)
    {
        $this->orix = $orix;

        return $this;
    }

    /**
     * Get orix
     *
     * @return string
     */
    public function getOrix()
    {
        return $this->orix;
    }

    /**
     * Set oriy
     *
     * @param string $oriy
     *
     * @return Sample
     */
    public function setOriy($oriy)
    {
        $this->oriy = $oriy;

        return $this;
    }

    /**
     * Get oriy
     *
     * @return string
     */
    public function getOriy()
    {
        return $this->oriy;
    }

    /**
     * Set orizip
     *
     * @param string $orizip
     *
     * @return Sample
     */
    public function setOrizip($orizip)
    {
        $this->orizip = $orizip;

        return $this;
    }

    /**
     * Get orizip
     *
     * @return string
     */
    public function getOrizip()
    {
        return $this->orizip;
    }

    /**
     * Set orilocality
     *
     * @param string $orilocality
     *
     * @return Sample
     */
    public function setOrilocality($orilocality)
    {
        $this->orilocality = $orilocality;

        return $this;
    }

    /**
     * Get orilocality
     *
     * @return string
     */
    public function getOrilocality()
    {
        return $this->orilocality;
    }

    /**
     * Set oricanton
     *
     * @param integer $oricanton
     *
     * @return Sample
     */
    public function setOricantonId($oricanton)
    {
        $this->oricantonId = $oricanton;

        return $this;
    }

    /**
     * Get oricanton
     *
     * @return integer
     */
    public function getOricanton()
    {
        return $this->oricanton;
    }

    /**
     * Set oricountry
     *
     * @param integer $oricountry
     *
     * @return Sample
     */
    public function setOricountryId($oricountry)
    {
        $this->oricountry = $oricountry;

        return $this;
    }

    /**
     * Get oricountry
     *
     * @return integer
     */
    public function getOricountry()
    {
        return $this->oricountry;
    }

    /**
     * Set oricomment
     *
     * @param string $oricomment
     *
     * @return Sample
     */
    public function setOricomment($oricomment)
    {
        $this->oricomment = $oricomment;

        return $this;
    }

    /**
     * Get oricomment
     *
     * @return string
     */
    public function getOricomment()
    {
        return $this->oricomment;
    }

    /**
     * Set doserate
     *
     * @param float $doserate
     *
     * @return Sample
     */
    public function setDoserate($doserate)
    {
        $this->doserate = $doserate;

        return $this;
    }

    /**
     * Get doserate
     *
     * @return float
     */
    public function getDoserate()
    {
        return $this->doserate;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return Sample
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
     * Set surface
     *
     * @param float $surface
     *
     * @return Sample
     */
    public function setSurface($surface)
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * Get surface
     *
     * @return float
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     * Set grassyield
     *
     * @param float $grassyield
     *
     * @return Sample
     */
    public function setGrassyield($grassyield)
    {
        $this->grassyield = $grassyield;

        return $this;
    }

    /**
     * Get grassyield
     *
     * @return float
     */
    public function getGrassyield()
    {
        return $this->grassyield;
    }

    /**
     * Set soillayer
     *
     * @param string $soillayer
     *
     * @return Sample
     */
    public function setSoillayer($soillayer)
    {
        $this->soillayer = $soillayer;

        return $this;
    }

    /**
     * Get soillayer
     *
     * @return string
     */
    public function getSoillayer()
    {
        return $this->soillayer;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Sample
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set bagCode
     *
     * @param integer $bagCode
     *
     * @return Sample
     */
    public function setBagCode($bagCode)
    {
        $this->bagCode = $bagCode;

        return $this;
    }

    /**
     * Get bagCode
     *
     * @return integer
     */
    public function getBagCode()
    {
        return $this->bagCode;
    }

        
    /**
     * Set laboratory
     *
     * @param integer $laboratory
     *
     * @return Sample
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
     * Set type
     *
     * @param integer $type
     *
     * @return Sample
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sampleType
     *
     * @param integer $sampleType
     *
     * @return Sample
     */
    public function setSampleTypeId($sampleType)
    {
        $this->sampleType = $sampleType;

        return $this;
    }

    /**
     * Get sampleType
     *
     * @return integer
     */
    public function getSampleType()
    {
        return $this->sampleType;
    }

    /**
     * Set quantityUnit
     *
     * @param integer $quantityUnit
     *
     * @return Sample
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
     * Set network
     *
     * @param integer $network
     *
     * @return Sample
     */
    public function setNetwork($network)
    {
        $this->network = $network;

        return $this;
    }

    /**
     * Get network
     *
     * @return integer
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Set station
     *
     * @param integer $station
     *
     * @return Sample
     */
    public function setStation($station)
    {
        $this->station= $station;

        return $this;
    }

    /**
     * Get station
     *
     * @return integer
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * Set toremovenetwork
     *
     * @param string $toremovenetwork
     *
     * @return Sample
     */
    public function setToremovenetwork($toremovenetwork)
    {
        $this->toremovenetwork = $toremovenetwork;

        return $this;
    }

    /**
     * Get toremovenetwork
     *
     * @return string
     */
    public function getToremovenetwork()
    {
        return $this->toremovenetwork;
    }

    /**
     * Set toremovestation
     *
     * @param string $toremovestation
     *
     * @return Sample
     */
    public function setToremovestation($toremovestation)
    {
        $this->toremovestation = $toremovestation;

        return $this;
    }

    /**
     * Get toremovestation
     *
     * @return string
     */
    public function getToremovestation()
    {
        return $this->toremovestation;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Sample
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
     * @return Sample
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
     * Return all measurements associated to the sample.
     *
     * @return Measurement[]
     */
    public function getMeasurements()
    {
    	return $this->measurements;
    }
    
    /**
     * Set all measurements in the sample.
     *
     * @param Measurement[] $products
     */
    public function setMeasurements($measurements)
    {
    	$this->measurements->clear();
    	$this->measurements = new ArrayCollection($measurements);
    }
}
