<?php

namespace App\Service;

use App\Helper\ProcessRunner;
use App\Exception\InstallException;

class Composer
{
    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function install($installationFolder)
    {
        $cmdInstall = sprintf('cd %s && composer install --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs', $installationFolder);

        try {
            $this->processRunner->runCommand($cmdInstall);
        } catch (\Exception $exception) {
            throw new InstallException($exception->getMessage());
        }
    }
}
