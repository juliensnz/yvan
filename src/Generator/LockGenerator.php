<?php

namespace App\Generator;

use App\Service\FileSystem;
use App\Service\Git;
use App\Service\Composer;
use App\Service\Yarn;

use Symfony\Component\Filesystem\Filesystem as FilesystemComponent;


class LockGenerator
{
    public function generate(string $type, string $repository)
    {
        $repositoryName = explode('/', $repository);

        $fileSystemComponent = new FilesystemComponent();

        $installationFolder = '../workdir';
        $destinationFolder = sprintf('lock/%s', $repositoryName[1]);

        $fileSystem = new FileSystem($fileSystemComponent);
        $git = new Git();
        $composer = new Composer();
        $yarn = new Yarn();

        try {
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

            if ($type !== 'all') {
                $fileSystem->copyFile(sprintf('%s/%s.lock', $installationFolder, $type),
                    sprintf('%s/%s.lock', $destinationFolder, $type));
            } else {
                $fileSystem->copyFile(sprintf('%s/composer.lock', $installationFolder),
                    sprintf('%s/composer.lock', $destinationFolder));
                $fileSystem->copyFile(sprintf('%s/yarn.lock', $installationFolder),
                    sprintf('%s/yarn.lock', $destinationFolder));
            }

            $fileSystem->removeDirectory($installationFolder);
            return sprintf('The operation the %s repository is successfull', $repository);

        } catch (\Exception $exception) {
            $fileSystem->removeDirectory($installationFolder);
            return $exception->getMessage();
        }
    }
}
