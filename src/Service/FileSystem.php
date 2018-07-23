<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem as FilesystemComponent;
use App\Exception\CopyFileException;

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
        } catch (\Exception $exception) {
            throw new CopyFileException();
        }
    }
}
