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

    function it_should_not_throw_an_copy_file_exception()
    {
        $this->shouldThrow('App\Exception\CopyFileException')->during('copyFile', [['../workdir/composer.lock'],["lock/pim-community-dev/composer.lock"]]);
    }
}
