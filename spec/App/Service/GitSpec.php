<?php

namespace spec\App\Service;

use App\Service\Git;
use App\Helper\ProcessRunner;
use PhpSpec\ObjectBehavior;

class GitSpec extends ObjectBehavior
{
    function let(ProcessRunner $processRunner)
    {
        $this->beConstructedWith($processRunner);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Git::class);
    }

    function it_clones($processRunner)
    {
        $processRunner->runCommand([
            'git',
            'clone',
            'git@github.com:akeneo/pim-community-dev.git',
            '../workdir',
        ])->shouldBeCAlled();

        $this->clone('pim-community-dev');
    }

    function it_should_throw_an_git_clone_exception($processRunner)
    {
        $processRunner->runCommand([
            'git',
            'clone',
            'git@github.com:akeneo/pim-community-dev.git',
            '../workdir',
        ])->willThrow(new \Exception());

        $this->shouldThrow('App\Exception\GitCloneException')->during('clone', ['pim-community-dev']);
    }
}
