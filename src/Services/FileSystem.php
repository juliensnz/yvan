<?php

namespace App\Services;

use Symfony\Component\Filesystem\Filesystem as FilesystemComponent;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class FileSystem
{
    /** @var string */
    private $repository;

    /** @var string */
    private $type;

    /** @var FilesystemComponent */
    private $fileSystem;

    public function __construct(string $type, string $repository)
    {
        $this->type = $type;
        $this->repository = $repository;
        $this->fileSystem = new FilesystemComponent();
    }

    public function rmDirectory()
    {
        try {
            $this->fileSystem->remove('../workdir/' . $this->repository);
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while deleting the directory";
            return false;
        }
    }

    public function copyFile()
    {
        if ($this->type !== 'all') {
            try {
                $this->fileSystem->copy(sprintf('../workdir/%s/%s.lock', $this->repository, $this->type),
                    sprintf('lock/%s/%s.lock', $this->repository, $this->type));
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred with the copy of the directory.";
                return false;
            }
        } else {
            try {
                $this->fileSystem->copy(sprintf('../workdir/%s/composer.lock', $this->repository),
                    sprintf('lock/%s/composer.lock', $this->repository));
                $this->fileSystem->copy(sprintf('../workdir/%s/yarn.lock', $this->repository),
                    sprintf('lock/%s/yarn.lock', $this->repository));
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred with the copy of the directories.";
                return false;
            }
        }
    }
}
