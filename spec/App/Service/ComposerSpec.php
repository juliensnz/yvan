<?php

namespace spec\App\Service;

use App\Service\Composer;
use PhpSpec\ObjectBehavior;
use App\Helper\ProcessRunner;

class ComposerSpec extends ObjectBehavior
{
    function let(ProcessRunner $processRunner)
    {
        $this->beConstructedWith($processRunner);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Composer::class);
    }

    function it_installs_composer($processRunner)
    {
        $cmdInstall = 'cd ../workdir && composer install --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs';
        $processRunner->runCommand($cmdInstall)->shouldBeCAlled();
        $this->install('../workdir');
    }

    function it_should_throw_an_composer_install_exception($processRunner)
    {
        $cmdInstall = 'cd ../workdir && composer install --no-scripts --no-autoloader --no-progress --no-suggest --ignore-platform-reqs';
        $processRunner->runCommand($cmdInstall)->willThrow(new \Exception());
        $this->shouldThrow('App\Exception\InstallException')->during('install', ["../workdir"]);
    }
}
