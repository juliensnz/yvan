<?php

namespace spec\App\Service;

use Symfony\Component\Filesystem\Filesystem as FilesystemComponent;
use App\Service\FileSystem;
use PhpSpec\ObjectBehavior;

class FileSystemSpec extends ObjectBehavior
{
    function let(FilesystemComponent $fileSystem)
    {
        $this->beConstructedWith($fileSystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileSystem::class);
    }

    function it_creates_directory($fileSystem)
    {
        $fileSystem->mkdir('../workdir')->shouldBeCAlled();
        $this->createDirectory('../workdir');
    }

    function it_removes_directory($fileSystem)
    {
        $fileSystem->remove('../workdir')->shouldBeCAlled();
        $this->removeDirectory('../workdir');
    }

    function it_copies_file($fileSystem)
    {
        $fileSystem->copy('../workdir/composer.lock', 'lock/pim-community-dev/composer.lock')->shouldBeCAlled();
        $this->copyFile('../workdir/composer.lock', "lock/pim-community-dev/composer.lock");
    }

    function it_should_not_throw_an_copy_file_exception($fileSystem)
    {
        $fileSystem->copy('../workdir/composer.lock', 'lock/pim-community-dev/composer.lock')->willThrow(new \Exception());
        $this->shouldThrow('App\Exception\CopyFileException')->during('copyFile', [['../workdir/composer.lock'],['lock/pim-community-dev/composer.lock']]);
    }
}
