<?php

namespace spec\App\Controller;

use App\Controller\LockController;
use PhpSpec\ObjectBehavior;
use App\Generator\LockGenerator;
use Prophecy\Argument;

class LockControllerSpec extends ObjectBehavior
{

    function let(LockGenerator $lockGenerator)
    {
        $this->beConstructedWith($lockGenerator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LockController::class);
    }

    function it_locks(LockGenerator $lockGenerator)
    {
    }
}
