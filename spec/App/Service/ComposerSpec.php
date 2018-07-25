<?php

namespace spec\App\Service;

use App\Service\Composer;
use PhpSpec\ObjectBehavior;

class ComposerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Composer::class);
    }
}
