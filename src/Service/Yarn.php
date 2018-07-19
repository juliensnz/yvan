<?php

namespace App\Service;

use App\Helper\ProcessRunner;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Yarn
{
    /** @var string */
    public $installationFolder; //Useful ?

    public function install($installationFolder)
    {
        $cmdInstall = sprintf('cd %s && yarn install',
            $installationFolder);

        try {
            ProcessRunner::runCommand($cmdInstall);
        } catch (IOExceptionInterface $exception) {
            echo 'An error occurred with the ProcessRunner : Yarn';
            return false;
        }
    }
}
