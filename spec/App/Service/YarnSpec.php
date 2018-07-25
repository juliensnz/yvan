<?php

namespace spec\App\Service;

use App\Service\Yarn;
use PhpSpec\ObjectBehavior;

class YarnSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Yarn::class);
    }
}
