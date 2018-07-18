<?php

namespace App\Services;

use App\Helper\ProcessRunner;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Composer
{
    /** @var string */
    private $repository;

    public function __construct(string $repository)
    {
        $this->repository = $repository;
    }

    public function cdPimDirectory()
    {
        $cd = sprintf('cd ../workdir/%s &&', $this->repository);
        return $cd;
    }

    public function install()
    {
        $composerInstall = 'composer install --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs';
        $cmdInstall = sprintf('%s %s',$this->cdPimDirectory(), $composerInstall);

        try {
            ProcessRunner::runCommand($cmdInstall);
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred with the ProcessRunner : Composer";
            return false;
        }
    }
}
