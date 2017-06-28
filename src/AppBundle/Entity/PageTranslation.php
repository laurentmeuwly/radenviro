<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class PageTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=65535, nullable=true)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=true)
     */
    private $content;

    
    /**
     * @return string
     */
    public function getTitle()
    {
    	return $this->title;
    }
    
    /**
     * @param  string
     * @return null
     */
    public function setTitle($title)
    {
    	$this->title = $title;
    }
    
    /**
     * @return string
     */
    public function getContent()
    {
    	return $this->content;
    }
    
    /**
     * @param  string
     * @return null
     */
    public function setContent($content)
    {
    	$this->content = $content;
    }
    
}