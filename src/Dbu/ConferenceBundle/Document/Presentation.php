<?php

namespace Dbu\ConferenceBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page;
use Symfony\Cmf\Bundle\SeoBundle\SeoAwareInterface;
use Symfony\Cmf\Bundle\SeoBundle\Model\SeoMetadataInterface;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;

/**
 * A presentation is a special type of page. Its parent is a room.
 *
 * @PHPCRODM\Document(referenceable=true)
 */
class Presentation extends Page implements SeoAwareInterface
{
    /**
     * @var \DateTime
     * @PHPCRODM\Date
     *
     * Start time of the presentation
     */
    private $start;

    /**
     * @var SeoMetadataInterface
     * @PHPCRODM\Child
     */
    private $seoMetadata;

    /**
     * @var Speaker[]|Collection
     * @PHPCRODM\ReferenceMany(targetDocument="Dbu\ConferenceBundle\Document\Speaker")
     */
    private $speakers;

    public function __construct()
    {
        parent::__construct();

        $this->start = new \DateTime();
        $this->speakers = new ArrayCollection();
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
        /**
     * @param Speaker[] $speakers
     */
    public function setSpeakers($speakers)
    {
        $this->speakers = $speakers;
    }

    /**
     * @return Speaker[]
     */
    public function getSpeakers()
    {
        return $this->speakers;
    }

    public function addSpeaker(Speaker $speaker)
    {
        $this->speakers->add($speaker);
    }

    public function removeSpeaker(Speaker $speaker)
    {
        $this->speakers->removeElement($speaker);
    }

    /**
     * {@inheritDoc}
     */
    public function getSeoMetadata()
    {
        return $this->seoMetadata;
    }

    /**
     * {@inheritDoc}
     */
    public function setSeoMetadata($metadata)
    {
        $this->seoMetadata = $metadata;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
