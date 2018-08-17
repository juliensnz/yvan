<?php

namespace App\Service;

use App\Helper\ProcessRunner;
use App\Exception\InstallException;

class Yarn
{
    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function install($installationFolder)
    {
        $cmdInstall = sprintf('cd %s && yarn install', $installationFolder);

        try {
            $this->processRunner->runCommand($cmdInstall);
        } catch (\Exception $exception) {
            throw new InstallException($exception->getMessage());
        }
    }
}
