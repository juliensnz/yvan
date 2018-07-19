<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem as FilesystemComponent;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use Exception;

class FileSystem
{
    /** @var string */
    private $type;

    /** @var FilesystemComponent */
    private $fileSystem;

    public function __construct(string $type, FilesystemComponent $fileSystem)
    {
        $this->type = $type;
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
        if ($this->type !== 'all') {
            try {
                $this->fileSystem->copy(sprintf('%s/%s.lock', $sourceFile, $this->type),
                    sprintf('%s/%s.lock', $destinationFile, $this->type));
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred with the copy of the directory.";
                return false;
            }
        } else {
            try {
                $this->fileSystem->copy(sprintf('%s/composer.lock', $sourceFile),
                    sprintf('%s/composer.lock', $destinationFile));
                $this->fileSystem->copy(sprintf('%s/yarn.lock', $sourceFile),
                    sprintf('%s/yarn.lock', $destinationFile));
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred with the copy of the directories.";
                return false;
            }
        }
    }
}
