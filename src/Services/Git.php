<?php

namespace App\Services;

use App\Helper\ProcessRunner;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Git
{
    /** @var string */
    private $repository;

    public function __construct(string $repository)
    {
        $this->repository = $repository;
    }

    public function cdWorkdir()
    {
        $cd = 'cd ../workdir && ';
        return $cd;
    }

    public function clone()
    {
        $clone = sprintf('git clone git@github.com:%s.git', $this->repository);

        $cmdClone = $this->cdWorkdir() . $clone;

        try {
            ProcessRunner::runCommand($cmdClone);
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred with the ProcessRunner : Clone";
            return false;
        }
    }
}
