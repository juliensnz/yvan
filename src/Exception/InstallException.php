<?php

namespace App\Exception;

use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Exception thrown when there is a problem with a yarn or composer installation.
 */
class InstallException extends ProcessFailedException
{
}
