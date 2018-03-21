<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LegendStation
 *
 * @ORM\Table(name="legend_station", indexes={@ORM\Index(name="index_legends_stationss_on_legend_id", columns={"legend_id"}), @ORM\Index(name="index_legends_stations_on_station_id", columns={"station_id"}), @ORM\Index(name="index_legends_stations_on_position", columns={"position"})})
 * @ORM\Entity
 */
class LegendStation
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Legend", inversedBy="stations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $legend;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Station", inversedBy="legends")
     * @ORM\JoinColumn(nullable=false)
     */
    private $station;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position = '0';
    



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
     * Set legend
     *
     * @param integer $legend
     *
     * @return LegendStation
     */
    public function setLegend($legend)
    {
    	$this->legend = $legend;
    
    	return $this;
    }
    
    /**
     * Get legend
     *
     * @return Legend
     */
    public function getLegend()
    {
    	return $this->legend;
    }


    /**
     * Set station
     *
     * @param integer $station
     *
     * @return LegendStation
     */
    public function setStation($station)
    {
        $this->station = $station;

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
     * Set position
     *
     * @param integer $position
     *
     * @return LegendStation
     */
    public function setPosition($position)
    {
    	$this->position=$position;
    	return $this;
    }
    
    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
    	return $this->position;
    }
    
}
