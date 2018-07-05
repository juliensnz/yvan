<?php

namespace App\Generator;

use App\Service\ChangeDirectory;

class LockGenerator {

    public function generate(string $type, string $repository){

        $repositoryName = explode('/', $repository);

        //$clone = shell_exec("cd ../workdir && " . sprintf('git clone git@github.com:%s.git', $repository));

        //display folder test
        $directory = shell_exec("cd ../workdir/" . $repositoryName[1] . "&& ls"); echo $directory;


        if ($type == "all") {

            $installComposer = shell_exec("cd ../workdir/" . $repositoryName[1] . " && composer install  --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs");
            $installYarn = shell_exec("cd ../workdir/" . $repositoryName[1] . " && yarn install");

            $copyComposer = shell_exec("cd ../workdir/" . $repositoryName[1] . " && cp yarn.lock ../../public/" . $repository);
            $copyYarn = shell_exec("cd ../workdir/" . $repositoryName[1] . " && cp composer.lock ../../public/" . $repository);
        }

        else {
            //$install = shell_exec("cd ../workdir/" . $repositoryName[1] . " && " . $type . " install --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs");

            //$copy = shell_exec("cd ../workdir/" . $repositoryName[1] . " && cp " . $type . ".lock ../../public/" . $repository);
        }



        $change_directory = new ChangeDirectory($repositoryName[1]);
        $function_test = $change_directory->cdPimDirectory();


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