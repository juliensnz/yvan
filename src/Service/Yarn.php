<?php

namespace App\Service;

use App\Helper\ProcessRunner;
use App\Exception\InstallException;

class Yarn
{
    public function install($installationFolder)
    {
        $cmdInstall = sprintf('cd %s && yarn install', $installationFolder);

        try {
            ProcessRunner::runCommand($cmdInstall);
        } catch (InstallException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
