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

    public function clone(string $repository, string $destination)
    {
        $repository = sprintf('git@github.com:akeneo/%s.git', $repository);

        try {
            $this->processRunner->runCommand(['git', 'clone', '--depth=50', '--branch=master', $repository, $destination]);
        } catch (\Exception $exception) {
            throw new GitCloneException($exception->getMessage());
        }
    }
}
