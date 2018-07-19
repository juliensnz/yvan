<?php

namespace App\Generator;

use App\Exception\ComposerException;
use App\Service\FileSystem;
use App\Service\Git;
use App\Service\Composer;
use App\Service\Yarn;

use Symfony\Component\Filesystem\Filesystem as FilesystemComponent;


class LockGenerator
{
    /** @var string */
    public $installationFolder;

    /** @var string */
    public $destinationFolder;

    public function generate(string $type, string $repository)
    {
        $repositoryName = explode('/', $repository);

        $fileSystemComponent = new FilesystemComponent();

        $installationFolder = sprintf('../workdir');
        $destinationFolder = sprintf('lock/%s', $repositoryName[1]);

        $fileSystem = new FileSystem($type, $fileSystemComponent);
        $git = new Git();
        $composer = new Composer();
        $yarn = new Yarn();

        $fileSystem->createDirectory($installationFolder);
        $git->clone($repositoryName[1]);

        switch ($type) {
            case 'composer':
                $composer->install($installationFolder);
                break;
            case 'yarn':
                $yarn->install($installationFolder);
                break;
            case 'all':
                $composer->install($installationFolder);
                $yarn->install($installationFolder);
                break;
        }

        $fileSystem->copyFile($installationFolder, $destinationFolder);
        $fileSystem->removeDirectory($installationFolder);

        return sprintf('The operation the %s repository is successfull', $repository);
    }
}
