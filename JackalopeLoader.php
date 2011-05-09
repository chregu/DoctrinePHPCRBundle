<?php

namespace Symfony\Bundle\DoctrinePHPCRBundle;

class JackalopeLoader
{
    protected $container;
    protected $session;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getSession()
    {
        if (!$this->session) {
            $this->session = $this->container->get('jackalope.session');
        }
        return $this->session;
    }

    /**
     * Setup the base structure for this importer if necessary.
     *
     * @return \PHPCR\NodeInterface
     * @throws todo.. findout which exceptions might be thrown.
     */
    public function initPath($path)
    {
        $node = $this->getSession()->getRootNode();
        $nodes = explode('/', trim($path, '/'));
        foreach ($nodes as $subpath) {
            $node = $node->hasNode($subpath) ? $node->getNode($subpath) : $node->addNode($subpath);
        }
        return $node;
    }

}
