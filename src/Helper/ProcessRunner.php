<?php

namespace App\Helper;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessRunner
{
    /**
     * Run a terminal command
     */
    public function runCommand($command, $timeout = 0.0)
    {
        $process = new Process($command);
        $process->setTimeout($timeout);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    /**
     * Run a terminal command asynchronously
     */
    public function runAsyncCommand($command)
    {
        $pid = pcntl_fork();
        switch($pid) {
            // fork errror
            case -1 :
                return false;

            // this code runs in child process
            case 0 :
                // obtain a new process group
                posix_setsid();
                // exec the command
                exec($command);
                break;

            // return the child pid in father
            default:
                return $pid;
        }
    }
}
