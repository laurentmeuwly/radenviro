<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class LegendTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    
    /**
     * @return string
     */
    public function getName()
    {
    	return $this->name;
    }
    
    /**
     * @param  string
     * @return null
     */
    public function setName($name)
    {
    	$this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
    	return $this->description;
    }
    
    /**
     * @param  string
     * @return null
     */
    public function setDescription($description)
    {
    	$this->description = $description;
    }

    /**
     * @return string
     */
    public function getLink()
    {
    	return $this->link;
    }
    
    /**
     * @param  string
     * @return null
     */
    public function setLink($link)
    {
    	$this->link = $link;
    }
    
}
