<?php

namespace App\Service;


class ChangeDirectory
{

    private $path;

    public function __construct($repository)
    {
        if ($repository == "pim-community-dev"){
            $this->path = '../workdir/pim-community-dev';
        }
        else {
            $this->path = '../workdir/pim-community-dev';
        }
    }

    public function cdPimDirectory()
    {
        $cd = 'cd ';
        $directory = shell_exec($cd . $this->path .  " && ls");
        echo $directory;
    }
}