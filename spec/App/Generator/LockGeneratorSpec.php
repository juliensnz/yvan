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

    function it_generates_lock(FileSystem $fileSystem, Git $git, Composer $composer, Yarn $yarn)
    {
        $repository = ['akeneo/pim-community-dev', 'akeneo/pim-enterprise-dev'];
        $repositoryClone = ['pim-community-dev', 'pim-enterprise-dev'];
        $type = ['composer', 'yarn', 'all'];

        $fileSystem->createDirectory(LockGenerator::WORKDIR)->shouldBeCalled();

        for ($j = 0; $j <= 1; $j++) {

            $git->clone($repositoryClone[$j])->shouldBeCalled();

            for ($i = 0; $i <= 2; $i++) {
                if ($type[$i] == 'composer') {
                    $composer->install(LockGenerator::WORKDIR);
                    $fileSystem->copyFile(sprintf('../workdir/%s.lock', $type[$i]),
                        sprintf('lock/%s/composer.lock', $repositoryClone[$j]))->shouldBeCalled();
                }
                if ($type[$i] == 'yarn') {
                    $yarn->install(LockGenerator::WORKDIR);
                    $fileSystem->copyFile(sprintf('../workdir/%s.lock', $type[$i]),
                        sprintf('lock/%s/%s.lock', $repositoryClone[$j], $type[$i]))->shouldBeCalled();
                }
                if ($type[$i] == 'all') {
                    $composer->install(LockGenerator::WORKDIR);
                    $yarn->install(LockGenerator::WORKDIR);
                    $fileSystem->copyFile('../workdir/composer.lock',
                        sprintf('lock/%s/composer.lock', $repositoryClone[$j]))->shouldBeCalled();
                    $fileSystem->copyFile('../workdir/yarn.lock',
                        sprintf('lock/%s/yarn.lock', $repositoryClone[$j]))->shouldBeCalled();
                }

                $fileSystem->removeDirectory(LockGenerator::WORKDIR)->shouldBeCalled();
                $this->generate($type[$i], $repository[$j]);
            }
        }
    }
}
