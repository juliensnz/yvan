<?php

namespace App\Generator;

use App\Service\ChangeDirectory;
use App\Service\CloneDirectory;
use App\Service\ActionInstall;
use App\Service\CopyLock;

class LockGenerator {

    public function generate(string $type, string $repository){

        $repositoryName = explode('/', $repository);

        $change_directory = new ChangeDirectory($repositoryName[1]);
        $clone_directory = new CloneDirectory($repository);
        $action_install = new ActionInstall($type);
        $copy_lock = new CopyLock($type, $repositoryName[1]);

        $shellExec = shell_exec($change_directory->cdWork()
            . $clone_directory->clonePimDirectory()
            . $change_directory->cdPimDirectory()
            . $action_install->install()
            . $copy_lock->copy());

    }
}