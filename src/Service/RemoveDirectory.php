<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class RemoveDirectory
{

    private $path;

    public function __construct($repository)
    {
        $this->path = $repository;
    }

    public function rmDirectory()
    {
        $fileSystem = new Filesystem();

        try {
            $fileSystem->remove('../workdir/' . $this->path);
        }
        catch (IOExceptionInterface $exception) {
            echo "An error occurred while deleting the directory";
            return false;
        }
    }
    
}