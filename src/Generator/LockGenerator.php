<?php

namespace App\Generator;

use Symfony\Component\Filesystem\Filesystem as FilesystemComponent;
use App\Service\FileSystem;
use App\Service\Git;
use App\Service\Composer;
use App\Service\Yarn;
use App\Exception\GitCloneException;
use App\Exception\InstallException;
use App\Exception\CopyFileException;

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

        $fileSystem->createDirectory($installationFolder);

        try {
            $git->clone($repositoryName[1]);
        } catch (GitCloneException $exception) {
        }

        try {
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
        } catch (InstallException $exception) {
        }

        try {
            if ($type !== 'all') {
                $fileSystem->copyFile(sprintf('%s/%s.lock', $installationFolder, $type),
                    sprintf('%s/%s.lock', $destinationFolder, $type));
            } else {
                $fileSystem->copyFile(sprintf('%s/composer.lock', $installationFolder),
                    sprintf('%s/composer.lock', $destinationFolder));
                $fileSystem->copyFile(sprintf('%s/yarn.lock', $installationFolder),
                    sprintf('%s/yarn.lock', $destinationFolder));
            }
            $install = true;
        } catch (CopyFileException $exception) {
            $install = false;
        } finally {
            $fileSystem->removeDirectory($installationFolder);
        }

        if ($install == false) {
            return 'The operation is unsuccessful';
        } else {
            return 'The operation is successful';
        }
    }
}
