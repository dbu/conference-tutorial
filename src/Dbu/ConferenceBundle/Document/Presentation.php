<?php

namespace Dbu\ConferenceBundle\Document;

use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;

/**
 * A presentation is a special type of page. Its parent is a room.
 *
 * @PHPCRODM\Document(referenceable=true)
 */
class Presentation extends Page
{
    /**
     * @var \DateTime
     * @PHPCRODM\Date
     *
     * Start time of the presentation
     */
    private $start;

    public function __construct()
    {
        parent::__construct();

        $this->start = new \DateTime();
    }

    /**
     * @param \DateTime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }
}
