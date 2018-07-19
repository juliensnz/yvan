<?php

namespace App\Service;

use App\Helper\ProcessRunner;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Composer
{
    /** @var string */
    public $installationFolder; //Useful ?

    public function install($installationFolder)
    {
        $cmdInstall = sprintf('cd %s && composer install --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs',
            $installationFolder);

        try {
            ProcessRunner::runCommand($cmdInstall);
        } catch (IOExceptionInterface $exception) {
            echo 'An error occurred with the ProcessRunner : Composer';
            return false;
        }
    }
}
