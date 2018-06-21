<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\JoinColumn(nullable=true)
     */
    private $legend;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Nuclide", inversedBy="legends")
     * @ORM\JoinColumn(nullable=true)
     */
    private $nuclide;

    /**
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position = '0';
    

    public function __toString()
    {
    	return (string)$this->getNuclide();
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
     * Set legend
     *
     * @param Legend $legend
     *
     * @return $this
     */
    public function setLegend(Legend $legend)
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
     * @param Nuclide $nuclide
     *
     * @return $this
     */
    public function setNuclide($nuclide = null)
    {
        $this->nuclide = $nuclide;

        return $this;
    }

    /**
     * Get nuclide
     *
     * @return Nuclide
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
     * @return $this
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
