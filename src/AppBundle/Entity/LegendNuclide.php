<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LegendNuclide
 *
 * @ORM\Table(name="legend_nuclide", indexes={@ORM\Index(name="index_legends_nuclides_on_legend_id", columns={"legend_id"}), @ORM\Index(name="index_legends_nuclides_on_nuclide_id", columns={"nuclide_id"}), @ORM\Index(name="index_legends_nuclides_on_position", columns={"position"})})
 * @ORM\Entity
 */
class LegendNuclide
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Legend", inversedBy="nuclides")
     * @ORM\JoinColumn(nullable=false)
     */
    private $legend;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Nuclide")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nuclide;

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
     * @return LegendNuclide
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
     * Set nuclide
     *
     * @param integer $nuclide
     *
     * @return LegendNuclide
     */
    public function setNuclide($nuclide)
    {
        $this->nuclide = $nuclide;

        return $this;
    }

    /**
     * Get nuclide
     *
     * @return integer
     */
    public function getNuclide()
    {
        return $this->nuclide;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return LegendNuclide
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
