<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem as FilesystemComponent;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class FileSystem
{
    /** @var FilesystemComponent */
    private $fileSystem;

    public function __construct(FilesystemComponent $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function removeDirectory($sourceFolder)
    {
        $this->fileSystem->remove($sourceFolder);
    }

    public function createDirectory($sourceFolder)
    {
        $this->fileSystem->mkdir($sourceFolder);
    }

    public function copyFile($sourceFile, $destinationFile)
    {
        try {
            $this->fileSystem->copy(sprintf('%s', $sourceFile),
                sprintf('%s', $destinationFile));
        } catch (FileNotFoundException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
