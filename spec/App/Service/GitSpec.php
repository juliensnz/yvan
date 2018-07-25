<?php

namespace spec\App\Service;

use App\Service\Git;
use PhpSpec\ObjectBehavior;

class GitSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Git::class);
    }

    function it_clones()
    {
        $this->clone('pim-community-dev');
    }

    function it_should_not_throw_an_git_clone_exception()
    {
        $this->shouldThrow('App\Exception\GitCloneException')->during('clone', ["pim-community-dev"]);
    }
}
