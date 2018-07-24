<?php

namespace spec\App\Controller;

use App\Controller\LockController;
use PhpSpec\ObjectBehavior;
use App\Generator\LockGenerator;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

    function it_work(LockGenerator $lockGenerator)
    {
        $lockGenerator->generate(Argument::cetera(), Argument::cetera());
    }
}
