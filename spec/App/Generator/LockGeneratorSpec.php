<?php

namespace spec\App\Generator;

use App\Generator\LockGenerator;
use PhpSpec\ObjectBehavior;
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

    function it_generates_lock_composer_community_dev(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn)
    {
        $fileSystem->createDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $git->clone('pim-community-dev')->shouldBeCalled();
        $composer->install(LockGenerator::WORKDIR);
        $fileSystem->copyFile('../workdir/composer.lock', 'lock/pim-community-dev/composer.lock')->shouldBeCalled();
        $fileSystem->removeDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $this->generate('composer', 'akeneo/pim-community-dev');
    }

    function it_generates_lock_yarn_community_dev(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn)
    {
        $fileSystem->createDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $git->clone('pim-community-dev')->shouldBeCalled();
        $yarn->install(LockGenerator::WORKDIR);
        $fileSystem->copyFile('../workdir/yarn.lock', 'lock/pim-community-dev/yarn.lock')->shouldBeCalled();
        $fileSystem->removeDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $this->generate('yarn', 'akeneo/pim-community-dev');
    }

    function it_generates_lock_all_community_dev(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn)
    {
        $fileSystem->createDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $git->clone('pim-community-dev')->shouldBeCalled();
        $composer->install(LockGenerator::WORKDIR);
        $yarn->install(LockGenerator::WORKDIR);
        $fileSystem->copyFile('../workdir/composer.lock', 'lock/pim-community-dev/composer.lock')->shouldBeCalled();
        $fileSystem->copyFile('../workdir/yarn.lock', 'lock/pim-community-dev/yarn.lock')->shouldBeCalled();
        $fileSystem->removeDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $this->generate('all', 'akeneo/pim-community-dev');
    }

    function it_generates_lock_composer_enterprise_dev(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn)
    {
        $fileSystem->createDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $git->clone('pim-enterprise-dev')->shouldBeCalled();
        $composer->install(LockGenerator::WORKDIR);
        $fileSystem->copyFile('../workdir/composer.lock', 'lock/pim-enterprise-dev/composer.lock')->shouldBeCalled();
        $fileSystem->removeDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $this->generate('composer', 'akeneo/pim-enterprise-dev');
    }

    function it_generates_lock_yarn_enterprise_dev(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn)
    {
        $fileSystem->createDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $git->clone('pim-enterprise-dev')->shouldBeCalled();
        $yarn->install(LockGenerator::WORKDIR);
        $fileSystem->copyFile('../workdir/yarn.lock', 'lock/pim-enterprise-dev/yarn.lock')->shouldBeCalled();
        $fileSystem->removeDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $this->generate('yarn', 'akeneo/pim-enterprise-dev');
    }

    function it_generates_lock_all_enterprise_dev(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn)
    {
        $fileSystem->createDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $git->clone('pim-enterprise-dev')->shouldBeCalled();
        $composer->install(LockGenerator::WORKDIR);
        $yarn->install(LockGenerator::WORKDIR);
        $fileSystem->copyFile('../workdir/composer.lock', 'lock/pim-enterprise-dev/composer.lock')->shouldBeCalled();
        $fileSystem->copyFile('../workdir/yarn.lock', 'lock/pim-enterprise-dev/yarn.lock')->shouldBeCalled();
        $fileSystem->removeDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
        $this->generate('all', 'akeneo/pim-enterprise-dev');
    }
}
