<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PredefinedNuclideListNuclide
 *
 * @ORM\Table(name="predefined_nuclide_list_nuclide")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PredefinedNuclideListNuclideRepository")
 */
class PredefinedNuclideListNuclide
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PredefinedNuclideList", inversedBy="nuclides")
     * @ORM\JoinColumn(nullable=false)
     */
    private $predefinedNuclideList;
    
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
    
    public function __toString()
    {
    	return (string)('['.$this->getPredefinedNuclideList()->getId().'] '. $this->getNuclide()->getName());
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return PredefinedNuclideListNuclide
     */
    public function setPosition($position)
    {
        $this->position = $position;

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

    /**
     * Set predefinedNuclideList
     *
     * @param \AppBundle\Entity\PredefinedNuclideList $predefinedNuclideList
     *
     * @return PredefinedNuclideListNuclide
     */
    public function setPredefinedNuclideList(\AppBundle\Entity\PredefinedNuclideList $predefinedNuclideList)
    {
        $this->predefinedNuclideList = $predefinedNuclideList;

        return $this;
    }

    /**
     * Get predefinedNuclideList
     *
     * @return \AppBundle\Entity\PredefinedNuclideList
     */
    public function getPredefinedNuclideList()
    {
        return $this->predefinedNuclideList;
    }

    /**
     * Set nuclide
     *
     * @param \AppBundle\Entity\Nuclide $nuclide
     *
     * @return PredefinedNuclideListNuclide
     */
    public function setNuclide(\AppBundle\Entity\Nuclide $nuclide)
    {
        $this->nuclide = $nuclide;

        return $this;
    }

    /**
     * Get nuclide
     *
     * @return \AppBundle\Entity\Nuclide
     */
    public function getNuclide()
    {
        return $this->nuclide;
    }
}
