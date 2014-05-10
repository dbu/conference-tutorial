<?php

namespace Dbu\ConferenceBundle\Document;

use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;

/**
 * Conference rooms are a special type of page
 *
 * @PHPCRODM\Document(referenceable=true)
 */
class Room extends Page
{
    /**
     * @var string
     * @PHPCRODM\String
     *
     * A short description how to find the room.
     */
    private $description;

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
