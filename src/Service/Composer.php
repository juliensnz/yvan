<?php

namespace App\Service;

use App\Helper\ProcessRunner;
use App\Exception\InstallException;

class Composer
{
    public function install($installationFolder)
    {
        $cmdInstall = sprintf('cd %s && composer install --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs', $installationFolder);

        try {
            ProcessRunner::runCommand($cmdInstall);
        } catch (InstallException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
