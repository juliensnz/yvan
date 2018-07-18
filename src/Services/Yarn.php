<?php

namespace App\Services;

use App\Helper\ProcessRunner;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Yarn
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
        $yarnInstall = 'yarn install';
        $cmdInstall = sprintf('%s %s',$this->cdPimDirectory(), $yarnInstall);

        try {
            ProcessRunner::runCommand($cmdInstall);
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred with the ProcessRunner : Yarn";
            return false;
        }
    }
}
