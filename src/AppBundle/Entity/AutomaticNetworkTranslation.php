<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class AutomaticNetworkTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", length=255, nullable=true)
     */
    private $url='';

    
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
    public function getUrl()
    {
    	return $this->url;
    }
    
    /**
     * @param  string
     * @return null
     */
    public function setUrl($url)
    {
    	$this->url = $url;
    }
    
}
