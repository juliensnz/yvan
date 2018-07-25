<?php

namespace App\Service;

use App\Helper\ProcessRunner;
use App\Exception\GitCloneException;

class Git
{
    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function clone($repository)
    {
        $repository = sprintf('git@github.com:akeneo/%s.git', $repository);

        try {
            $this->processRunner->runCommand(array('git', 'clone', $repository, '../workdir'));
        } catch (\Exception $exception) {
            throw new GitCloneException();
        }
    }
}
