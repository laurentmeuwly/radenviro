<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class StationTypeTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    
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
    
}
