<?php

namespace Binder\PageBundle\Service;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Filesystem abstraction layer around the directory where user pages are
 * stored.
 */
class PageDirectory
{
    /**
     * @var string The full path to the user page directory.
     */
    protected $path;

    /**
     * @param string $path
     * @throws \InvalidArgumentException if $path does not exist
     */
    public function __construct($path)
    {
        $this->path = rtrim($path, DIRECTORY_SEPARATOR);
        $this->validatePath($this->path);
    }

    protected function validatePath($path)
    {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException("No such directory {$path}");
        }
    }

    /**
     * @return string The full path of the user page directory.
     */
    public function __toString()
    {
        return $this->path;
    }

    /**
     * @return string The name of the user page directory.
     */
    public function getBasename()
    {
        return basename($this->path);
    }

    /**
     * @return SplFileInfo[]|Finder
     */
    public function scanFiles()
    {
        $finder = new Finder();
        $finder->files()->in($this->path)->depth(0);
        return $finder;
    }
}
