<?php

namespace App\Service;

use App\Helper\ProcessRunner;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Git
{
    /** @var string */
    public $repository;

    public function clone($repository)
    {
        $repository = sprintf('git@github.com:akeneo/%s.git', $repository);

        try {
            ProcessRunner::runCommand(array('git','clone',$repository,'../workdir'));
        } catch (IOExceptionInterface $exception) {
            echo 'An error occurred with the ProcessRunner : Git Clone';
            return false;
        }
    }
}
