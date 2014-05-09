<?php

namespace Dbu\ConferenceBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;

/**
 * For speakers, the body is the bio.
 *
 * @PHPCRODM\Document(referenceable=true)
 */
class Speaker extends Page
{
    /**
     * @PHPCRODM\Referrers(referringDocument="Dbu\ConferenceBundle\Document\Presentation", referencedBy="speakers")
     */
    private $presentations;

    public function __construct()
    {
        parent::__construct();

        $this->presentations= new ArrayCollection();
    }

    /**
     * @param string $fullname
     */
    public function setFullname($fullname)
    {
        $this->setTitle($fullname);
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->title;
    }

    /**
     * @return Presentation[]
     */
    public function getPresentations()
    {
        return $this->presentations;
    }
}
