<?php

namespace App\Service;

use App\Helper\ProcessRunner;
use App\Exception\GitCloneException;

class Git
{
    public function clone($repository)
    {
        $repository = sprintf('git@github.com:akeneo/%s.git', $repository);

        try {
            ProcessRunner::runCommand(array('git', 'clone', $repository, '../workdir'));
        } catch (GitCloneException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
