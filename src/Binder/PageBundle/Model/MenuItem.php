<?php

namespace Binder\PageBundle\Model;


class MenuItem
{
    /** @var string */
    private $label;

    /** @var string */
    private $url;

    /** @var MenuItem[] */
    private $children = [];

    public function __construct($label, $url = null)
    {
        $this->label = $label;
        $this->url = $url;

    }

    public function hasUrl()
    {
        return (bool) $this->url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return MenuItem[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function addChild(MenuItem $child)
    {
        $this->children[] = $child;
    }
}
