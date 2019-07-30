<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class ResultCommentTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    
    /**
     * @return string
     */
    public function getComment()
    {
    	return $this->comment;
    }
    
    /**
     * @param  string
     * @return null
     */
    public function setComment($comment)
    {
    	$this->comment = $comment;
    }
    
}