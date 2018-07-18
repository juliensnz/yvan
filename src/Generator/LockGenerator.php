<?php

namespace App\Generator;

use App\Services\FileSystem;
use App\Services\Git;
use App\Services\Composer;
use App\Services\Yarn;

class LockGenerator
{
    public function generate(string $type, string $repository)
    {
        $repositoryName = explode('/', $repository);

        $fileSystem = new FileSystem($type, $repositoryName[1]);
        $git = new Git($repository);
        $composer = new Composer($repositoryName[1]);
        $yarn = new Yarn($repositoryName[1]);

        $git->clone();

        switch ($type) {
            case "composer":
                $composer->install();
                break;
            case "yarn":
                $yarn->install();
                break;
            case "all":
                $composer->install();
                $yarn->install();
                break;
        }

        $fileSystem->copyFile();
        $fileSystem->rmDirectory();
    }
}
