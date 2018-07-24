<?php

namespace App\Generator;

use App\Service\FileSystem;
use App\Service\Git;
use App\Service\Composer;
use App\Service\Yarn;
use App\Exception\GitCloneException;
use App\Exception\InstallException;
use App\Exception\CopyFileException;

class LockGenerator
{
    public const WORKDIR = '../workdir';

    private $fileSystem;
    private $git;
    private $composer;
    private $yarn;

    public function __construct(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn)
    {
        $this->fileSystem = $fileSystem;
        $this->git = $git;
        $this->composer = $composer;
        $this->yarn = $yarn;
    }

    public function generate(string $type, string $repository)
    {
        $repositoryName = explode('/', $repository);

        $destinationFolder = sprintf('lock/%s', $repositoryName[1]);

        $this->fileSystem->createDirectory(self::WORKDIR);

        try {
            $this->git->clone($repositoryName[1]);
        } catch (GitCloneException $exception) {
        }

        try {
            switch ($type) {
                case 'composer':
                    $this->composer->install(self::WORKDIR);
                    break;
                case 'yarn':
                    $this->yarn->install(self::WORKDIR);
                    break;
                case 'all':
                    $this->composer->install(self::WORKDIR);
                    $this->yarn->install(self::WORKDIR);
                    break;
            }
        } catch (InstallException $exception) {
        }

        try {
            if ($type !== 'all') {
                $this->fileSystem->copyFile(sprintf('%s/%s.lock', self::WORKDIR, $type),
                    sprintf('%s/%s.lock', $destinationFolder, $type));
            } else {
                $this->fileSystem->copyFile(sprintf('%s/composer.lock', self::WORKDIR),
                    sprintf('%s/composer.lock', $destinationFolder));
                $this->fileSystem->copyFile(sprintf('%s/yarn.lock', self::WORKDIR),
                    sprintf('%s/yarn.lock', $destinationFolder));
            }
            $install = true;
        } catch (CopyFileException $exception) {
            $install = false;
        } finally {
            $this->fileSystem->removeDirectory(self::WORKDIR);
        }

        if ($install == false) {
            return 'The operation is unsuccessful';
        } else {
            return 'The operation is successful';
        }
    }
}
