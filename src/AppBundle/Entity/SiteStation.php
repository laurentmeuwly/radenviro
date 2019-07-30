<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteStation
 *
 * @ORM\Table(name="site_station", indexes={@ORM\Index(name="index_sites_stationss_on_site_id", columns={"site_id"}), @ORM\Index(name="index_sites_stations_on_station_id", columns={"station_id"})})
 * @ORM\Entity
 */
class SiteStation
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Site", inversedBy="stations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $site;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Station", inversedBy="sites")
     * @ORM\JoinColumn(nullable=true)
     */
    private $station;


    public function __toString()
    {
    	return (string)$this->getStation();
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
     * Set site
     *
     * @param Site $site
     *
     * @return SiteStation
     */
    public function setSite($site = null)
    {
    	$this->site = $site;
    	return $this;
    }
    
    /**
     * Get site
     *
     * @return Site
     */
    public function getSite()
    {
    	return $this->site;
    }


    /**
     * Set station
     *
     * @param Station $station
     *
     * @return SiteStation
     */
    public function setStation($station = null)
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

    
}
