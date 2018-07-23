<?php

namespace App\Exception;

use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Exception thrown when there is a problem with Git clone.
 */
class GitCloneException extends ProcessFailedException
{
}
