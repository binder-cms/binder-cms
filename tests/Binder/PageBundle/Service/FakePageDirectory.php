<?php

namespace Tests\Binder\PageBundle\Service;


use Binder\PageBundle\Service\PageDirectory;
use Symfony\Component\Finder\SplFileInfo;

class FakePageDirectory extends PageDirectory
{
    /**
     * A list of fake template filepaths. These should be relative paths,
     * relative to the PageDirectory rootpath.
     *
     * @var string[]
     */
    public $filepaths = [];

    protected function validatePath($path)
    {
        // skip validation
    }

    public function scanFiles()
    {
        return array_map(function ($relativePathname) {
            $relativePath = $this->path;
            $fullpath = $this->path . DIRECTORY_SEPARATOR . $relativePathname;
            return new SplFileInfo($fullpath, $relativePath, $relativePathname);
        }, $this->filepaths);
    }
}
