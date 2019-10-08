<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class SettingsTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $mobileMsg;


    /**
     * Set mobileMsg.
     *
     * @param string|null $mobileMsg
     *
     * @return Settings
     */
    public function setMobileMsg($mobileMsg = null)
    {
        $this->mobileMsg = $mobileMsg;

        return $this;
    }

    /**
     * Get mobileMsg.
     *
     * @return string|null
     */
    public function getMobileMsg()
    {
        return $this->mobileMsg;
    }
}
