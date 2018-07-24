<?php

namespace spec\App\Generator;

use App\Generator\LockGenerator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\Service\Composer;
use App\Service\FileSystem;
use App\Service\Git;
use App\Service\Yarn;

class LockGeneratorSpec extends ObjectBehavior
{

    function let(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn)
    {
        $this->beConstructedWith($fileSystem, $git, $composer, $yarn);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LockGenerator::class);
    }

    function it_generates_lock()
    {
    }
}
