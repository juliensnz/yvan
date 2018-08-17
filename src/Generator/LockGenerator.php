<?php

namespace App\Generator;

use App\Exception\CopyFileException;
use App\Exception\GitCloneException;
use App\Exception\InstallException;
use App\Service\Composer;
use App\Service\FileSystem;
use App\Service\Git;
use App\Service\Yarn;
use Symfony\Component\Console\Output\OutputInterface;

class LockGenerator
{
    private $fileSystem;
    private $git;
    private $composer;
    private $yarn;

    public function __construct(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn, string $rootdir)
    {
        $this->fileSystem = $fileSystem;
        $this->git = $git;
        $this->composer = $composer;
        $this->yarn = $yarn;
        $this->rootdir = $rootdir;
    }

    public function generate(OutputInterface $output, string $type, string $repository)
    {
        $workdir = sprintf('%s/../workdir', $this->rootdir);
        $destinationFolder = sprintf('%s/../public/lock/%s', $this->rootdir, $repository);

        $this->fileSystem->removeDirectory($workdir);
        $this->fileSystem->createDirectory($workdir);

        $cloneSection = $output->section();
        $cloneSection->writeln(sprintf('<info>Clone "%s"</info>', $repository));
        try {
            $this->git->clone($repository, $workdir);
        } catch (GitCloneException $exception) {
            $cloneSection->writeln(sprintf('<error>Error while cloning "%s": %s</error>', $repository, $exception->getMessage()));

            return;
        }
        $cloneSection->overwrite(sprintf('<info>Clone "%s"</info> [done]', $repository));

        $lockSection = $output->section();

        if (in_array($type, ['all', 'yarn'])) {
            $lockSection->writeln('<info>Generate yarn lock</info>');
            try {
                $this->yarn->install($workdir);
            } catch (InstallException $exception) {
                $lockSection->writeln(sprintf('<error>Error while genrating yarn lock: %s</error>', $exception->getMessage()));

                return;
            }
            $lockSection->overwrite('<info>Generate yarn lock</info> [done]');
        }

        if (in_array($type, ['all', 'composer'])) {
            $lockSection->writeln('<info>Generate composer lock</info>');
            try {
                $this->composer->install($workdir);
            } catch (InstallException $exception) {
                $lockSection->writeln(sprintf('<error>Error while genrating composer lock: %s</error>', $exception->getMessage()));

                return;
            }
            $lockSection->overwrite('<info>Generate composer lock</info> [done]');
        }

        $moveSection = $output->section();
        $moveSection->writeln('<info>Copy lock file(s) in public folder</info>');
        try {
            if ($type !== 'all') {
                $this->fileSystem->copyFile(
                    sprintf('%s/%s.lock', $workdir, $type),
                    sprintf('%s/%s.lock', $destinationFolder, $type)
                );
            } else {
                $this->fileSystem->copyFile(
                    sprintf('%s/composer.lock', $workdir),
                    sprintf('%s/composer.lock', $destinationFolder)
                );
                $this->fileSystem->copyFile(
                    sprintf('%s/yarn.lock', $workdir),
                    sprintf('%s/yarn.lock', $destinationFolder)
                );
            }
            $install = true;
        } catch (CopyFileException $exception) {
            $moveSection->writeln(sprintf('<error>Error while moving lock file to public folder: %s</error>', $exception->getMessage()));

            return;
        }
        $moveSection->overwrite('<info>Copy lock file(s) in public folder</info> [done]');
    }
}
