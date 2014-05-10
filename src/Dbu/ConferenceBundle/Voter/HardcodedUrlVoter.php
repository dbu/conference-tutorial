<?php

namespace Dbu\ConferenceBundle\Voter;

use Knp\Menu\ItemInterface;
use Symfony\Cmf\Bundle\MenuBundle\Voter\VoterInterface;
use Symfony\Cmf\Bundle\RoutingBundle\Routing\DynamicRouter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Look up the current content and check if it is of the expected class. If so,
 * make the menu item at $url the active one.
 */
class HardcodedUrlVoter implements VoterInterface
{
    private $request;
    private $class;
    private $url;

    /**
     * @param string $class Fully qualified class name of the content class in
     *                      the request to highlight this url.
     * @param string $url   Part of the URL the menu item must have to be the
     *                      current item if the content has this class.
     */
    public function __construct($class, $url)
    {
        $this->class = $class;
        $this->url = $url;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function matchItem(ItemInterface $item = null)
    {
        if (! $this->request) {
            return null;
        }

        if ($this->request->attributes->has(DynamicRouter::CONTENT_KEY)
            && $this->request->attributes->get(DynamicRouter::CONTENT_KEY) instanceof $this->class
            && strpos($item->getUri(), $this->url) !== false
        ) {
            return true;
        }

        return null;
    }
}
