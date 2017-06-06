<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LegendNuclide
 *
 * @ORM\Table(name="legend_nuclide", indexes={@ORM\Index(name="index_legends_nuclides_on_legend_id", columns={"legend_id"}), @ORM\Index(name="index_legends_nuclides_on_nuclide_id", columns={"nuclide_id"}), @ORM\Index(name="index_legends_nuclides_on_sorting", columns={"sorting"})})
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
     * @var integer
     *
     * @ORM\Column(name="legend_id", type="integer", nullable=true)
     */
    private $legendId;

    /**
     * @var integer
     *
     * @ORM\Column(name="nuclide_id", type="integer", nullable=true)
     */
    private $nuclideId;

    /**
     * @var integer
     *
     * @ORM\Column(name="sorting", type="integer", nullable=false)
     */
    private $sorting = '0';



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
     * Set legendId
     *
     * @param integer $legendId
     *
     * @return LegendNuclide
     */
    public function setLegendId($legendId)
    {
        $this->legendId = $legendId;

        return $this;
    }

    /**
     * Get legendId
     *
     * @return integer
     */
    public function getLegendId()
    {
        return $this->legendId;
    }

    /**
     * Set nuclideId
     *
     * @param integer $nuclideId
     *
     * @return LegendNuclide
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
     * Set sorting
     *
     * @param integer $sorting
     *
     * @return LegendNuclide
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;

        return $this;
    }

    /**
     * Get sorting
     *
     * @return integer
     */
    public function getSorting()
    {
        return $this->sorting;
    }
}
