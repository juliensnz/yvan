<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class CopyLock
{

    private $repository;
    private $type;

    public function __construct($type, $repository)
    {
        $this->type = $type;
        $this->repository = $repository;
    }



    public function copy()
    {
        $fileSystem = new Filesystem();

        if ($this->type !== "all") {

            try {
                $fileSystem->copy('../workdir/' . $this->repository . '/' . $this->type . '.lock', 'lock/' . $this->repository . '/' . $this->type . '.lock');
            }
            catch (IOExceptionInterface $exception) {
                echo "An error occurred with the copy of the directory.";
                return false;
            }
        }

        else {
            try {
                $fileSystem->copy('../workdir/' . $this->repository . '/composer.lock', 'lock/' . $this->repository . '/composer.lock');
                $fileSystem->copy('../workdir/' . $this->repository . '/yarn.lock', 'lock/' . $this->repository . '/yarn.lock');
            }
            catch (IOExceptionInterface $exception) {
                echo "An error occurred with the copy of the directories.";
                return false;
            }
        }
    }
}