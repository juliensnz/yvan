<?php

namespace App\Generator;

use App\Service\ChangeDirectory;
use App\Service\CloneDirectory;
use App\Service\ActionInstall;
use App\Service\RemoveDirectory;
use App\Service\CopyLock;
use App\Helper\ProcessRunner;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class LockGenerator
{

    public function generate(string $type, string $repository)
    {

        $repositoryName = explode('/', $repository);

        $remove_directory = new RemoveDirectory($repositoryName[1]);
        $change_directory = new ChangeDirectory($repositoryName[1]);
        $clone_directory = new CloneDirectory($repository);
        $action_install = new ActionInstall($type);
        $copy_lock = new CopyLock($type, $repositoryName[1]);

        $remove_directory->rmDirectory();

        $execute =
                $change_directory->cdWork() .
                $clone_directory->clonePimDirectory() .
                $change_directory->cdPimDirectory() .
                $action_install->install();


        try {
            ProcessRunner::runCommand($execute);
        }
        catch (IOExceptionInterface $exception) {
            echo "An error occurred with the ProcessRunner runCommand";
            return false;
        }

        $copy_lock->copy();

    }
}