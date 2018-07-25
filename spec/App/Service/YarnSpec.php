<?php

namespace spec\App\Service;

use App\Service\Yarn;
use PhpSpec\ObjectBehavior;
use App\Helper\ProcessRunner;

class YarnSpec extends ObjectBehavior
{
    function let(ProcessRunner $processRunner)
    {
        $this->beConstructedWith($processRunner);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Yarn::class);
    }

    function it_installs_yarn($processRunner)
    {
        $cmdInstall = 'cd ../workdir && yarn install';
        $processRunner->runCommand($cmdInstall)->shouldBeCAlled();
        $this->install('../workdir');
    }

    function it_should_throw_an_yarn_install_exception($processRunner)
    {
        $cmdInstall = 'cd ../workdir && yarn install';
        $processRunner->runCommand($cmdInstall)->willThrow(new \Exception());
        $this->shouldThrow('App\Exception\InstallException')->during('install', ["../workdir"]);
    }
}
