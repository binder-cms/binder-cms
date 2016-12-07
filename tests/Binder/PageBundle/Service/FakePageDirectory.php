<?php

namespace Tests\Binder\PageBundle\Service;


use Binder\PageBundle\Service\PageDirectory;
use Symfony\Component\Finder\SplFileInfo;

class FakePageDirectory extends PageDirectory
{
    public $filepaths = [];

    protected function validatePath($path)
    {
        // skip validation
    }

    public function scanFiles()
    {
        return array_map(function ($filepath) {
            $relativePath = $this->path;
            $relativePathname = $this->path . DIRECTORY_SEPARATOR . $filepath;
            return new SplFileInfo($filepath, $relativePath, $relativePathname);
        }, $this->filepaths);
    }
}
