<?php

namespace Dbu\ConferenceBundle\Twig\Extension;

use Dbu\ConferenceBundle\Document\Speaker;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class ConferenceExtension extends \Twig_Extension
{
    /**
     * @var RouterInterface
     */
    private $routeGenerator;

    /**
     * @var string
     */
    private $speakersPath;

    public function __construct(UrlGeneratorInterface $routeGenerator, $speakersPath)
    {
        $this->routeGenerator = $routeGenerator;
        $this->speakersPath = $speakersPath;
    }
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('speaker_path', array($this, 'createSpeakerPath'))
        );
    }

    public function createSpeakerPath(Speaker $speaker)
    {
        return $this->routeGenerator->generate($this->speakersPath) . '#' . $speaker->getName();
    }

    public function getName()
    {
        return 'conference_extension';
    }
}
