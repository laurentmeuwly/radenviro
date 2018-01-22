<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * PredefinedNuclideList
 *
 * @ORM\Table(name="predefined_nuclide_list")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PredefinedNuclideListRepository")
 */
class PredefinedNuclideList
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var Nuclid[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PredefinedNuclideListNuclide", mappedBy="predefinedNuclideList"))
     */
    private $nuclides;
    
    /**
     * @var integer
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
    
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;
    
    
    public function __toString()
    {
    	return (string)$this->getName();
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
     * Set name
     *
     * @param string $name
     *
     * @return PredefinedNuclideList
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PredefinedNuclideList
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
     * @return PredefinedNuclideList
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
     * Constructor
     */
    public function __construct()
    {
        $this->nuclides = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add nuclide
     *
     * @param \AppBundle\Entity\PredefinedNuclideListNuclide $nuclide
     *
     * @return PredefinedNuclideList
     */
    public function addNuclide(\AppBundle\Entity\PredefinedNuclideListNuclide $nuclide)
    {
        $this->nuclides[] = $nuclide;

        return $this;
    }

    /**
     * Remove nuclide
     *
     * @param \AppBundle\Entity\PredefinedNuclideListNuclide $nuclide
     */
    public function removeNuclide(\AppBundle\Entity\PredefinedNuclideListNuclide $nuclide)
    {
        $this->nuclides->removeElement($nuclide);
    }

    /**
     * Get nuclides
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNuclides()
    {
        return $this->nuclides;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return PredefinedNuclideList
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
     * Set active
     *
     * @param boolean $active
     *
     * @return PredefinedNuclideList
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
}
