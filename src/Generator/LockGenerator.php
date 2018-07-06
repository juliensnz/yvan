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
        $copy_lock = new CopyLock($type, $repository);

        $shellExec = shell_exec($change_directory->cdWork()
            . $clone_directory->clonePimDirectory()
            . $change_directory->cdPimDirectory()
            . $action_install->install()
            . $copy_lock->copy());




        //Display var

        $action_lock = "cp " . $type . ".lock"; $action_install = $type . " install";

        if ($type == "all") {
            $action_install1 = "composer install"; $action_install2 = "yarn install";
            $action_lock1 = "cp composer.lock"; $action_lock2 = "cp yarn.lock";}

        echo "\n" . "Command :" . "\n";
        $SSH_key = "git@github.com:" . $repository . ".git"; $action_clone = "git clone " . $SSH_key;

        if ($type == "all") {$commands = array($action_clone, $action_install1, $action_install2, $action_lock1, $action_lock2);}
        else {$commands = array($action_clone, $action_install, $action_lock);}
        foreach ($commands as $command ) {echo $command; echo "\n";}


    }
}